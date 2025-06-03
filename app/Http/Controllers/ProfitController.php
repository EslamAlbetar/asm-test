<?php

namespace App\Http\Controllers;

use App\Models\centerDetails;
use App\Models\Donations;
use App\Models\Bill;
use App\Models\AllPatient;
use App\Models\Partener;
use App\Models\SalaryCalculator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use TCPDF;
use Carbon\CarbonPeriod;


class ProfitController extends Controller
{

    public function index()
    {
        return view('admin.sidebar.profit');
    }

    public function fetchProfitData(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');

        // لو مفيش فلتر، هات آخر شهر موجود
        $latestDate = DB::table('all_patients')
            ->select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month'))
            ->orderByDesc('created_at')
            ->first();

        if (!$year || !$month) {
            $year = $latestDate->year;
            $month = $latestDate->month;
        }

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $days = [];
        $current = $startDate->copy();

        while ($current <= $endDate) {
            // جلب المدخلات (سعر المرضى بعد =)
            $inputs = AllPatient::whereDate('created_at', $current)
                ->sum('finalPrice'); // هنا التعديل الأساسي

            // جلب التبرعات
            $donations = Donations::whereDate('created_at', $current)->sum('amount');

            // جمع المدخلات والتبرعات
            $totalInputs = $inputs + $donations;

            // المدفوعات
            $payments = Bill::whereDate('created_at', $current)->sum('price');

            if ($totalInputs > 0 || $payments > 0) {
                $days[] = [
                    'date' => $current->toDateString(),
                    'day_name' => $current->translatedFormat('l'),
                    'inputs' => $totalInputs,
                    'payments' => $payments,
                    'net_profit' => $totalInputs - $payments,
                ];
            }

            $current->addDay();
        }

        return response()->json([
            'month' => $startDate->translatedFormat('F'),
            'month_number' => $startDate->month,
            'year' => $startDate->year,
            'days' => $days,
            'days_count' => count($days),
            'net_profit' => array_sum(array_column($days, 'net_profit')),
        ]);
    }

    public function getAvailableYearsMonths()
    {
        $dates = AllPatient::select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month'))
            ->union(
                Donations::select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month'))
            )
            ->union(
                Bill::select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month'))
            )
            ->distinct()
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return response()->json($dates);
    }

    public function exportPdf(Request $request)
    {
        $center = centerDetails::first();
        $date = $request->input('date');
        $carbonDate = Carbon::parse($date);

        // جلب البيانات حسب التاريخ
        $patients = AllPatient::whereDate('created_at', $date)->get()->map(function ($p) {
            $p->date = Carbon::parse($p->created_at)->toDateString();
            // تحويل finalPrice إلى قيمة رقمية إذا لزم الأمر
            $p->finalPrice = is_numeric($p->finalPrice) ? (float)$p->finalPrice : 0;
            return $p;
        });

        $donations = Donations::whereDate('created_at', $date)->get();
        $items = Bill::with('totalItem')->whereDate('created_at', $date)->get();

        // استخدام finalPrice بدلاً من final_price
        $totalPatientsIncome = $patients->sum('finalPrice');

        $totalDonations = $donations->sum(function ($d) {
            return is_numeric($d->amount) ? (float)$d->amount : 0;
        });

        $totalInputs = $totalPatientsIncome + $totalDonations;

        $totalPayments = $items->sum(function ($i) {
            return is_numeric($i->price) ? (float)$i->price : 0;
        });

        $netProfit = $totalInputs - $totalPayments;

        $html = view('admin.sidebar.daily_pdf', compact(
            'carbonDate',
            'patients',
            'donations',
            'items',
            'totalPatientsIncome',
            'totalDonations',
            'totalInputs',
            'totalPayments',
            'netProfit',
            'center'
        ))->render();

        $pdf = new TCPDF();
        $pdf->SetFont('freeserif', '', 12);
        $pdf->SetRTL(true);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        return $pdf->Output("daily_report_{$carbonDate->format('Y_m_d')}.pdf", 'I');
    }

    public function getMonthData(Carbon $date)
    {
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        // جلب بيانات المرضى مع التأكد من تحويل finalPrice إلى رقم
        $patients = AllPatient::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get()
            ->map(function ($p) {
                $p->date = Carbon::parse($p->created_at)->toDateString();
                $p->finalPrice = is_numeric($p->finalPrice) ? (float)$p->finalPrice : 0;
                return $p;
            });

        // جلب التبرعات
        $donations = Donations::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get()
            ->map(function ($d) {
                $d->date = Carbon::parse($d->created_at)->toDateString();
                $d->amount = is_numeric($d->amount) ? (float)$d->amount : 0;
                return $d;
            });

        // جلب المدفوعات
        $items = Bill::with('totalItem')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get()
            ->map(function ($i) {
                $i->date = Carbon::parse($i->created_at)->toDateString();
                $i->price = is_numeric($i->price) ? (float)$i->price : 0;
                return $i;
            });

        // حساب صافي الرواتب الشهرية للموظفين
        $salaryData = SalaryCalculator::with('user')->get()->map(function ($salary) use ($startOfMonth, $endOfMonth) {
            $user = $salary->user;

            // جلب الخصومات المعتمدة
            $approvedDeductions = $user->deductions()
                ->where('status_ded', 'Approved')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('amount_ded');

            $netSalary = $salary->base_salary - (is_numeric($approvedDeductions) ? $approvedDeductions : 0);

            return [
                'employee_name' => $user->name,
                'net_salary' => round($netSalary, 2)
            ];
        });

        // حساب إجمالي الرواتب لجميع الموظفين
        $totalSalaries = $salaryData->sum('net_salary');

        $daysData = [];
        $period = CarbonPeriod::create($startOfMonth, $endOfMonth);

        foreach ($period as $day) {
            $dayStr = $day->format('Y-m-d');

            // استخدام finalPrice بدلاً من final_price
            $totalPatientsIncome = $patients->where('date', $dayStr)->sum('finalPrice');
            $totalDonations = $donations->where('date', $dayStr)->sum('amount');
            $totalItemPayments = $items->where('date', $dayStr)->sum('price');

            $totalInputs = $totalPatientsIncome + $totalDonations;
            $totalPayments = $totalItemPayments; // لا تشمل الرواتب اليومية لأنها تحسب شهريًا فقط
            $netProfit = $totalInputs - $totalPayments;

            if ($totalInputs > 0 || $totalPayments > 0) {
                $daysData[] = [
                    'date' => $dayStr,
                    'day_name' => $day->translatedFormat('l'),
                    'inputs' => $totalInputs,
                    'payments' => $totalPayments,
                    'net_profit' => $netProfit
                ];
            }
        }

        $totalMonthIncome = collect($daysData)->sum('inputs');
        $totalItemsPayments = collect($daysData)->sum('payments');

        // إضافة صافي الرواتب إلى إجمالي المدفوعات
        $totalMonthPayments = $totalItemsPayments + $totalSalaries;

        $totalMonthNetProfit = $totalMonthIncome - $totalMonthPayments;

        // توزيع الأرباح على الشركاء
        $partners = Partener::all()->map(function ($partner) use ($totalMonthNetProfit) {
            $percentage = is_numeric($partner->percentage) ? $partner->percentage : 0;
            return [
                'name' => $partner->name_partener,
                'percentage' => $percentage,
                'share' => round(($totalMonthNetProfit * $percentage) / 100, 2)
            ];
        });

        return [
            'month' => $date->translatedFormat('F'),
            'year' => $date->year,
            'days_count' => count($daysData),
            'net_profit' => $totalMonthNetProfit,
            'days' => $daysData,
            'total_inputs' => $totalMonthIncome,
            'total_payments' => $totalMonthPayments, // تشمل الرواتب
            'partners' => $partners,
            'salaries' => $salaryData,
            'total_salaries' => $totalSalaries // يمكن استخدامها في الجدول أو الطباعة
        ];
    }

    public function exportMonthlyPdf(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $date = Carbon::create($year, $month, 1);
        $monthData = $this->getMonthData($date);

        // تحقق من وجود بيانات قبل إنشاء التقرير
        if ($monthData['days_count'] === 0) {
            return response()->json(['error' => 'لا توجد بيانات لهذا الشهر'], 404);
        }

        $html = view('admin.sidebar.monthly_pdf', [
            'monthName' => $monthData['month'],
            'year' => $year,
            'days' => $monthData['days'],
            'monthData' => $monthData,
            'totalInputs' => $monthData['total_inputs'],
            'totalPayments' => $monthData['total_payments'],
            'totalSalaries' => $monthData['total_salaries'],
            'netProfit' => $monthData['net_profit'],
            'partners' => $monthData['partners'],
            'salariesDetails' => $monthData['salaries']
        ])->render();

        $pdf = new TCPDF();
        $pdf->SetFont('freeserif', '', 12);
        $pdf->SetRTL(true);
        $pdf->AddPage();
        $pdf->writeHTML($html);

        $fileName = "monthly_report_{$year}_{$month}.pdf";
        return $pdf->Output($fileName, 'I');
    }

    public function exportYearlyPdf(Request $request)
    {
        $year = $request->input('year', date('Y'));

        // بيانات كل شهر
        $monthsData = [];
        $totalInputs = 0;
        $totalPayments = 0;
        $totalSalaries = 0;
        $totalNetProfit = 0;
        $hasData = false;

        for ($month = 1; $month <= 12; $month++) {
            $date = Carbon::create($year, $month, 1);
            $monthData = $this->getMonthData($date);

            if ($monthData['days_count'] > 0) {
                $hasData = true;
                $monthsData[] = [
                    'month_name' => $monthData['month'],
                    'month_number' => $month,
                    'inputs' => $monthData['total_inputs'],
                    'payments' => $monthData['total_payments'],
                    'net_profit' => $monthData['net_profit'],
                    'salaries' => $monthData['total_salaries'],
                    'salaries_details' => $monthData['salaries'],
                    'partners' => $monthData['partners'],
                    'days_count' => $monthData['days_count']
                ];

                $totalInputs += $monthData['total_inputs'];
                $totalPayments += $monthData['total_payments'];
                $totalSalaries += $monthData['total_salaries'];
                $totalNetProfit += $monthData['net_profit'];
            }
        }

        // تحقق من وجود بيانات قبل إنشاء التقرير
        if (!$hasData) {
            return response()->json(['error' => 'لا توجد بيانات لهذه السنة'], 404);
        }

        // حساب توزيع الأرباح السنوية على الشركاء
        $yearlyPartners = Partener::all()->map(function ($partner) use ($totalNetProfit) {
            $percentage = is_numeric($partner->percentage) ? $partner->percentage : 0;
            return [
                'name' => $partner->name_partener,
                'percentage' => $percentage,
                'share' => round(($totalNetProfit * $percentage) / 100, 2)
            ];
        });

        $html = view('admin.sidebar.yearly_pdf', [
            'year' => $year,
            'months' => $monthsData,
            'totalInputs' => $totalInputs,
            'totalPayments' => $totalPayments,
            'totalSalaries' => $totalSalaries,
            'netProfit' => $totalNetProfit,
            'yearlyPartners' => $yearlyPartners
        ])->render();

        $pdf = new TCPDF();
        $pdf->SetFont('freeserif', '', 12);
        $pdf->SetRTL(true);
        $pdf->AddPage();
        $pdf->writeHTML($html);

        $fileName = "yearly_report_{$year}.pdf";
        return $pdf->Output($fileName, 'I');
    }
}
