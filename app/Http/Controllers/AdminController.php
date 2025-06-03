<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Bill;

use App\Models\centerDetails;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;


use App\Models\Location;

use App\Models\Patient;
use App\Models\User;

use App\Models\AllPatient;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\Device;
use App\Models\Newbill;
use App\Models\TotalItems;

use App\Models\AddItem;
use App\Models\Category;
use App\Models\deduction;
use App\Models\Donations;
use App\Models\Partener;
use App\Models\Permission;
use App\Models\PositionName;
use App\Models\SalaryCalculator;
use App\Models\Shift;
use App\Models\Situation;
use App\Models\Usertype;
use App\Models\vacation;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use TCPDF;
use TCPDF_FONTS;

class AdminController extends Controller
{

    // عرض صفحة اضافة مريض جديد
    public function add_patient_admin()
    {
        $center = centerDetails::first();

        $user = User::find(Auth::user()->id);
        // احضار جميع البيانات من قاعدة البيانات
        $categories = Category::with(['positions.situations'])->get(); // خلي بالك لازم تكون عامل العلاقة دي في الموديل
        $positions = PositionName::all();
        $situations = Situation::all();

        $dataLoc = Location::all();

        return view('admin.sidebar.add_patients_admin', compact('dataLoc', 'user', 'center', 'categories', 'positions', 'situations'));
    }

    // اضافة مريض جديد
    public function upload_patient_admin(Request $request)
    {
        // انشاء مريض جديد
        $data = new Patient;

        // اضافة البيانات
        $data->id_user = $request->id_user;
        $data->full_name = $request->name ? $request->name : "لم يتم تسجيل الاسم";
        $data->phone = $request->phone ? $request->phone : "لم يتم تسجيل رقم الهاتف";
        $data->address = $request->address ? $request->address : "لم يتم تسجيل العنوان";
        $data->age = $request->age ? $request->age : "لم يتم تسجيل العمر";
        $data->gender = $request->gender ? $request->gender : "لم يتم تسجيل الجنس";
        $data->dr_name = $request->doctor ? $request->doctor : "لم يتم تسجيل اسم الطبيب";
        $data->category = ($request->category);
        $data->positions = json_encode($request->positions); // List of position_ids
        $data->situations = json_encode($request->situations); // List of situation_ids
        $data->complaint = $request->complaint ? $request->complaint : "لم يتم تسجيل شكوى";
        $data->location = $request->location;
        $data->price = $request->price;
        $data->discount = $request->discount ? $request->discount : "0";
        $data->finalPrice = $request->finalPrice;
        $data->payment = $request->payment ? $request->payment : "لم يتم تحديد طريقة الدفع";
        $data->comments = $request->comments ? $request->comments : "لا توجد ملاحظات";
        $data->image = $request->image ? $request->image : "لم يتم تحميل صورة الروشتة";

        // اضافة الصورة
        if ($request->image) {
            $image = $request->image;
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('Rochetes'), $image_name);
            $data->image = $image_name;
        }

        // حفظ البيانات
        $data->save();

        // حفظ الوظائف المرتبطة
        $data->positions()->attach($request->position);

        // ارجاع الى الصفحة السابقة
        return redirect()->back()->with('success', 'تم إضافة المريض بنجاح');
    }

    // قائمة انتظار المرضى
    public function waiting_list_admin()
    {
        $center = centerDetails::first();

        if (Auth::id()) {
            $user = Auth::user();

            // إحضار المرضى مع علاقاتهم
            $patients = Patient::with(['positions', 'categoryData', 'locationData'])->paginate(10);

            return view('admin.sidebar.waiting_list', compact('patients', 'user', 'center'));
        }
    }

    public function completeAjax($id)
    {
        $patient = Patient::with('positions')->find($id); // خد العلاقات كمان

        if (!$patient) {
            return redirect()->back()->with('error', 'المريض غير موجود');
        }

        $new_patient = AllPatient::create([
            'id_user' => $patient->id_user,
            'full_name' => $patient->full_name,
            'phone' => $patient->phone,
            'address' => $patient->address,
            'age' => $patient->age,
            'gender' => $patient->gender,
            'dr_name' => $patient->dr_name,
            'category' => $patient->category,
            'positions' => $patient->positions,
            'situations' => $patient->situations,
            'complaint' => $patient->complaint,
            'location' => $patient->location,
            'price' => $patient->price,
            'discount' => $patient->discount,
            'finalPrice' => $patient->finalPrice,
            'payment' => $patient->payment,
            'comments' => $patient->comments,
            'image' => $patient->image,
            'status' => 'completed',
        ]);

        // ✅ نقل العلاقات
        $positions = $patient->positions()->pluck('id')->toArray();
        $new_patient->positions()->sync($positions);

        // ✅ حذف المريض القديم
        $patient->delete();

        return response()->json(['status' => 'success', 'message' => 'تم نقل المريض بنجاح']);
    }

    public function completePatient($id)
    {
        $data = Patient::find($id);
        $data->status = 'completed';
        $data->save();
        return redirect('/total_patients');
    }

    public function waitingListCount()
    {
        return response()->json(['count' => Patient::count()]);
    }


    public function total_patients_admin(Request $request)
    {

        $center = centerDetails::first();

        if (Auth::id()) {
            $user = Auth::user();
            $query = AllPatient::with(['positions', 'locationData']);

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('full_name', 'LIKE', "%$search%")
                        ->orWhere('phone', 'LIKE', "%$search%");
                });
            }

            $patients = $query->paginate(10);
        }

        return view('admin.sidebar.total_patients', compact('patients', 'user', 'center'));
    }


    public function update_patient_list_admin($id)
    {
        $center = centerDetails::first();

        // بيانات المريض الحالي
        $data = AllPatient::find($id);

        // احضار جميع البيانات من قاعدة البيانات
        $categories = Category::with(['positions.situations'])->get(); // خلي بالك لازم تكون عامل العلاقة دي في الموديل
        $dataPos = PositionName::all();
        $dataSit = Situation::all();
        $dataLoc = Location::all();

        return view('admin.sidebar.update_patient_list_admin', compact('data', 'dataPos', 'dataLoc', 'dataSit', 'categories', 'center'));
    }




    public function edit_patient_list_admin(Request $request, $id)
    {
        $data = AllPatient::find($id);
        if (!$data) {
            return back()->withErrors(['msg' => 'Patient not found.']);
        }

        $data->id_user = $request->id_user ?? $data->id_user;
        $data->full_name = $request->name ?? $data->full_name;
        $data->phone = $request->phone ?? $data->phone;
        $data->address = $request->address ?? $data->address;
        $data->age = $request->age ?? $data->age;
        $data->gender = $request->gender ?? $data->gender;
        $data->dr_name = $request->doctor ?? $data->dr_name;
        $data->category = $request->category ?? $data->category;
        $data->positions = json_encode($request->positions); // List of position_ids
        $data->situations = json_encode($request->situations); // List of situation_ids
        $data->complaint = $request->complaint ?? $data->complaint;
        $data->location = $request->location ?? $data->location;
        $data->price = $request->price ?? $data->price;
        $data->discount = $request->discount ?? $data->discount;
        $data->finalPrice = $request->finalPrice ?? $data->finalPrice;
        $data->payment = $request->payment ?? $data->payment;
        $data->comments = $request->comments ?? $data->comments;

        if ($request->hasFile('image')) {
            $image_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('Rochetes'), $image_name);
            $data->image = $image_name;
        }

        $data->save();

        return redirect('/total_patients_admin')->with('success', 'تم حفظ التعديلات بنجاح');
    }


    // جلب المواقع
    public function getLocations()
    {
        $locations = Location::all();
        return response()->json($locations);
    }

    public function getPositions($categoryId)
    {
        $positions = \App\Models\PositionName::where('category_id', $categoryId)->get();
        return response()->json($positions);
    }

    public function getSituations($positionId)
    {
        return \App\Models\Situation::where('position_id', $positionId)->get();
    }


    public function getPrice($situationId)
    {
        $situation = \App\Models\Situation::find($situationId);
        return response()->json(['price' => $situation->price]);
    }



    public function update_waiting_list_admin($id)
    {
        $data = Patient::find($id);
        $dataLoc = Location::all();
        $dataPos = PositionName::all();
        $dataSit = Situation::all();
        $dataCat = Category::all();
        return view('admin.sidebar.update_waiting_list_admin', compact('data', 'dataPos', 'dataLoc', 'dataCat', 'dataSit'));
    }

    public function edit_waiting_list_admin(Request $request, $id)
    {
        $data = Patient::find($id);

        // تعديل البيانات
        $data->full_name = $request->name;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->age = $request->age;
        $data->gender = $request->gender;
        $data->dr_name = $request->doctor;
        $data->category = ($request->category);

        $data->positions = json_encode($request->positions);
        // List of position_ids
        $data->situations = json_encode($request->situations); // List of situation_ids

        $data->complaint = $request->complaint;
        $data->location = $request->location;
        $data->payment = $request->payment;
        $data->price = $request->price;
        $data->discount = $request->discount;
        $data->finalPrice = $request->finalPrice;
        $data->comments = $request->comments;
        $data->image = $request->image;

        // إذا كانت صورة جديدة موجودة
        if ($request->hasFile('image')) {
            // حفظ الصورة الجديدة
            $image_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('Rochetes'), $image_name);

            // حذف الصورة القديمة من التخزين (إذا كانت موجودة)
            if ($data->image && file_exists(public_path('Rochetes/' . $data->image))) {
                unlink(public_path('Rochetes/' . $data->image));
            }

            // تعيين الصورة الجديدة
            $data->image = $image_name;
        }
        // حفظ البيانات
        $data->save();

        // ارجاع الى الصفحة السابقة
        return redirect('/waiting_list_admin');
    }






    public function delete_waiting_patient_admin($id)
    {
        $data = Patient::find($id);
        $data->delete();
        return redirect('/waiting_list_admin');
    }







    public function delete_patient_admin($id)
    {
        $data = AllPatient::find($id);
        $data->delete();
        return redirect('/total_patients_admin');
    }



    // صفحة قائمة الموظفين
    public function staff_team()
    {
        $user = User::with('lastShift', 'permissions')->paginate(8);

        return view('admin.sidebar.staff_team', compact('user'));
    }



    public function user_info($id)
    {
        $center = centerDetails::first();

        $user = User::all();

        return view('admin.sidebar', compact('user', 'center'));
    }



    public function details_staff($id)
    {
        $salaryCalculator = SalaryCalculator::where('id_user', $id)->first();
        $user = User::with(['shifts', 'permissions', 'vacations'])->findOrFail($id);

        // حساب ساعات العمل للشهر الحالي
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $totalSeconds = DB::table('shifts')
            ->where('id_user', $id)
            ->whereBetween('started_at', [$startOfMonth, $endOfMonth])
            ->whereNotNull('time')
            ->select(DB::raw("COALESCE(SUM(
                CASE 
                    WHEN `time` REGEXP '^[0-9]{2}:[0-9]{2}:[0-9]{2}$' 
                    THEN TIME_TO_SEC(`time`)
                    ELSE 0 
                END
            ), 0) as total_seconds"))
            ->value('total_seconds');

        // نحول الثواني إلى ساعات عشرية
        $totalHours = round($totalSeconds / 3600, 2);

        // نحول الثواني إلى H:i:s
        $formattedWorkTime = gmdate('H:i:s', (int) $totalSeconds);

        $monthlySalary = $totalHours * ($salaryCalculator->hourly_shift ?? 0);

        $shifts = $user->shifts()->orderBy('started_at', 'desc')->paginate(10);
        $permissions = $user->permissions()->orderBy('created_at', 'desc')->paginate(10);
        $vacations = $user->vacations()->orderBy('created_at', 'desc')->paginate(10);
        $deductions = $user->deductions()->orderBy('created_at', 'desc')->paginate(10);

        $availableMonths = $user->shifts()
            ->select(DB::raw("DATE_FORMAT(started_at, '%Y-%m') as month"))
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->pluck('month');

        // الحسابات الإضافية
        if ($salaryCalculator) {
            $expectedHours = $salaryCalculator->hourly_shift * $salaryCalculator->gools_day;

            $hours = floor($expectedHours);
            $minutes = ($expectedHours - $hours) * 60;
            $seconds = ($minutes - floor($minutes)) * 60;

            $expectedHoursFormatted = sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);

            // سعر الساعة
            $hourPrice = 0;
            if ($expectedHours > 0) {
                $hourPrice = round($salaryCalculator->base_salary / $expectedHours, 2);
            }
        } else {
            $expectedHours = 0;
            $expectedHoursFormatted = '0:00:00';
            $hourPrice = 0;
        }


        return view('admin.sidebar.details_staff', compact(
            'user',
            'shifts',
            'availableMonths',
            'permissions',
            'vacations',
            'salaryCalculator',
            'totalHours',
            'monthlySalary',
            'formattedWorkTime',
            'deductions',
            'expectedHoursFormatted',
            'expectedHours',
            'hourPrice'

        ));
    }

    // خاص بتقارير الموظفين
    public function filterStaffData(Request $request, $id)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m'
        ]);

        $yearMonth = $request->month;
        [$year, $month] = explode('-', $yearMonth);

        return redirect()->route('staff.details', [$id, 'month' => $yearMonth]);
    }

    public function generateStaffReport($id, $month = null)
    {
        $user = User::findOrFail($id);
        $salaryCalculator = SalaryCalculator::where('id_user', $id)->first();

        if (!$month) {
            $month = now()->format('Y-m');
        }

        [$year, $monthNum] = explode('-', $month);
        $monthName = date('F', mktime(0, 0, 0, $monthNum, 1));

        // حساب البيانات
        $startDate = "$year-$monthNum-01";
        $endDate = date('Y-m-t', strtotime($startDate));

        // ساعات العمل
        $totalSeconds = DB::table('shifts')
            ->where('id_user', $id)
            ->whereBetween('started_at', [$startDate, $endDate])
            ->whereNotNull('time')
            ->select(DB::raw("COALESCE(SUM(
            CASE 
                WHEN `time` REGEXP '^[0-9]{2}:[0-9]{2}:[0-9]{2}$' 
                THEN TIME_TO_SEC(`time`)
                ELSE 0 
            END
        ), 0) as total_seconds"))
            ->value('total_seconds');

        $formattedWorkTime = gmdate('H:i:s', (int) $totalSeconds);
        $totalHours = $totalSeconds / 3600;

        // حساب الساعات المستحقة
        $expectedHours = $salaryCalculator ? ($salaryCalculator->hourly_shift * $salaryCalculator->gools_day) : 0;
        $hours = floor($expectedHours);
        $minutes = ($expectedHours - $hours) * 60;
        $seconds = ($minutes - floor($minutes)) * 60;
        $expectedHoursFormatted = sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);

        // حساب الفرق بين الساعات المستحقة والعمل الفعلي
        $hoursDifference = $totalHours - $expectedHours;
        $achieved = $hoursDifference >= 0;

        // حساب الفرق بالثواني أولاً
        $totalDifferenceSeconds = abs($hoursDifference) * 3600; // تحويل الفرق من ساعات إلى ثواني

        // ثم تحويل الثواني إلى ساعات، دقائق، ثواني
        $diffHours = floor($totalDifferenceSeconds / 3600);
        $remainingSeconds = $totalDifferenceSeconds % 3600;
        $diffMinutes = floor($remainingSeconds / 60);
        $diffSeconds = $remainingSeconds % 60;

        // تنسيق النتيجة
        $diffFormatted = sprintf('%d:%02d:%02d', $diffHours, $diffMinutes, $diffSeconds);

        // الأذونات
        $permissions = $user->permissions()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get(['status_per', 'created_at']);

        // الإجازات
        $vacations = $user->vacations()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get(['status_vac', 'created_at']);

        // الخصومات (جلب جميع الخصومات سواء Approved أو Rejected)
        $deductions = $user->deductions()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get(['status_ded', 'amount_ded', 'created_at']);

        // حساب إجمالي الخصومات (فقط التي تمت الموافقة عليها)
        $totalDeductions = $deductions->where('status_ded', 'Approved')->sum('amount_ded');
        $netSalary = $salaryCalculator ? ($salaryCalculator->base_salary - $totalDeductions) : 0;

        // إنشاء PDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // إعداد المستند
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Company');
        $pdf->SetTitle('تقرير أداء الموظف - ' . $user->name);
        $pdf->SetSubject('تقرير شهري');
        $pdf->SetKeywords('TCPDF, PDF, تقرير, موظف');

        // هوامش الصفحة
        $pdf->SetMargins(10, 15, 10);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);

        // إعداد الخط
        $pdf->setRTL(true);
        $pdf->SetFont('aealarabiya', '', 11);

        // إضافة صفحة جديدة
        $pdf->AddPage();

        // هيدر التقرير
        $pdf->SetFillColor(52, 73, 94); // لون أزرق غامق
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('aealarabiya', 'B', 16);
        $pdf->Cell(0, 15, 'تقرير أداء الموظف', 0, 1, 'C', 1);

        $pdf->SetFillColor(231, 76, 60); // لون أحمر
        $pdf->SetFont('aealarabiya', 'B', 14);
        $pdf->Cell(0, 10, 'لشهر ' . $monthName . ' ' . $year, 0, 1, 'C', 1);
        $pdf->Ln(15);

        // معلومات الموظف
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('aealarabiya', 'B', 14);
        $pdf->Cell(0, 8, 'معلومات الموظف', 0, 1, 'R');
        $pdf->SetLineStyle(array('width' => 0.5, 'color' => array(52, 73, 94)));
        $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
        $pdf->Ln(5);

        $pdf->SetFont('aealarabiya', 'B', 12);
        $pdf->Cell(40, 7, 'اسم الموظف:', 0, 0, 'R');
        $pdf->SetFont('aealarabiya', '', 12);
        $pdf->Cell(0, 7, $user->name, 0, 1, 'L');

        $pdf->SetFont('aealarabiya', 'B', 12);
        $pdf->Cell(40, 7, 'الصلاحية:', 0, 0, 'R');
        $pdf->SetFont('aealarabiya', '', 12);
        $pdf->Cell(0, 7, $user->usertype ?? 'غير محدد', 0, 1, 'L');
        $pdf->Ln(10);

        // جدول ساعات العمل
        $pdf->SetFont('aealarabiya', 'B', 14);
        $pdf->Cell(0, 8, 'ملخص ساعات العمل', 0, 1, 'R');
        $pdf->SetLineStyle(array('width' => 0.5, 'color' => array(52, 73, 94)));
        $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
        $pdf->Ln(5);

        $html = '
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 10px;
            }
            th {
                background-color: #34495e;
                color: white;
                font-weight: bold;
                text-align: center;
                padding: 8px;
                border: 1px solid #ddd;
                font-size: 12px;
            }
            td {
                padding: 8px;
                border: 1px solid #ddd;
                text-align: center;
                font-size: 12px;
            }
            .achieved {
                color: #27ae60;
                font-weight: bold;
            }
            .not-achieved {
                color: #e74c3c;
                font-weight: bold;
            }
            .highlight {
                background-color: #f9f9f9;
            }
        </style>
        
        <table>
            <tr>
                <th width="50%">البند</th>
                <th width="50%">القيمة</th>
            </tr>
            <tr class="highlight">
                <td>إجمالي ساعات العمل</td>
                <td>' . $formattedWorkTime . '</td>
            </tr>
            <tr>
                <td>الساعات المستحقة</td>
                <td>' . $expectedHoursFormatted . '</td>
            </tr>
            <tr class="highlight">
                <td>حالة تحقيق الساعات</td>
                <td class="' . ($achieved ? 'achieved' : 'not-achieved') . '">' .
            ($achieved ?
                'تم تحقيق الهدف ( ' . $diffFormatted . '+)' :
                'لم يتم تحقيق الهدف ( ' . $diffFormatted . '-)') .
            '</td>
            </tr>
        </table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Ln(10);

        // جداول البيانات الأخرى
        $this->generateStyledTable($pdf, 'طلبات الإذن', $permissions, ['الحالة', 'التاريخ'], ['status_per', 'created_at']);
        $this->generateStyledTable($pdf, 'طلبات الإجازة', $vacations, ['الحالة', 'التاريخ'], ['status_vac', 'created_at']);

        // جدول الخصومات المعدل حسب الطلب
        $this->generateDeductionsTable($pdf, $deductions);

        // ملخص الراتب
        $pdf->SetFont('aealarabiya', 'B', 14);
        $pdf->Cell(0, 50, 'ملخص الراتب', 0, 1, 'R');
        $pdf->SetLineStyle(array('width' => 0.5, 'color' => array(52, 73, 94)));
        $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
        $pdf->Ln(5);

        $salaryHtml = '
        <table>
            <tr>
                <th width="50%">البند</th>
                <th width="50%">المبلغ (جنيه)</th>
            </tr>
            <tr class="highlight">
                <td>الراتب الأساسي</td>
                <td>' . ($salaryCalculator ? number_format($salaryCalculator->base_salary, 2) : '0.00') . '</td>
            </tr>
            <tr>
                <td>إجمالي الخصومات (المطبقة فقط)</td>
                <td>' . number_format($totalDeductions, 2) . '</td>
            </tr>
            <tr class="highlight" style="background-color: #f2f2f2;">
                <td><strong>الراتب الصافي</strong></td>
                <td><strong>' . number_format($netSalary, 2) . '</strong></td>
            </tr>
        </table>';

        $pdf->writeHTML($salaryHtml, true, false, true, false, '');

        // تذييل الصفحة
        $pdf->SetY(-15);
        $pdf->SetFont('aealarabiya', 'I', 8);
        $pdf->Cell(0, 10, 'تم إنشاء التقرير في ' . date('Y-m-d H:i:s'), 0, 0, 'C');

        return $pdf->Output('تقرير_' . $user->name . '_' . $monthName . '_' . $year . '.pdf', 'I');
    }

    private function generateDeductionsTable($pdf, $deductions)
    {
        $pdf->SetFont('aealarabiya', 'B', 14);
        $pdf->Cell(0, 8, 'الخصومات', 0, 1, 'R');
        $pdf->SetLineStyle(array('width' => 0.5, 'color' => array(52, 73, 94)));
        $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
        $pdf->Ln(5);

        if ($deductions->count() > 0) {
            $html = '
            <style>
                .data-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 10px;
                }
                .data-table th {
                    background-color: #3498db;
                    color: white;
                    font-weight: bold;
                    text-align: center;
                    padding: 8px;
                    border: 1px solid #ddd;
                    font-size: 12px;
                }
                .data-table td {
                    padding: 8px;
                    border: 1px solid #ddd;
                    text-align: center;
                    font-size: 12px;
                }
                .data-table tr:nth-child(even) {
                    background-color: #f2f2f2;
                }
                .no-data {
                    text-align: center;
                    font-style: italic;
                    color: #7f8c8d;
                }
                .approved {
                    color: #27ae60;
                    font-weight: bold;
                }
                .rejected {
                    color: #e74c3c;
                    font-weight: bold;
                }
            </style>
            
            <table class="data-table">
                <tr>
                    <th width="30%">الحالة</th>
                    <th width="30%">المبلغ</th>
                    <th width="40%">التاريخ</th>
                </tr>';

            foreach ($deductions as $deduction) {
                $status = $deduction->status_ded;
                $statusText = ($status == 'Approved') ? 'تم تطبيق الخصم' : 'تم رفع الخصم';
                $statusClass = ($status == 'Approved') ? 'approved' : 'rejected';

                $html .= '<tr>';
                $html .= '<td class="' . $statusClass . '">' . $statusText . '</td>';
                $html .= '<td>' . number_format($deduction->amount_ded, 2) . '</td>';
                $html .= '<td>' . \Carbon\Carbon::parse($deduction->created_at)->format('Y-m-d') . '</td>';
                $html .= '</tr>';
            }

            $html .= '</table>';
        } else {
            $html = '<p class="no-data">لا توجد بيانات خصومات لهذا الشهر</p>';
        }

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Ln(10);
    }

    private function generateStyledTable($pdf, $title, $data, $headers, $columns)
    {
        $pdf->SetFont('aealarabiya', 'B', 14);
        $pdf->Cell(0, 8, $title, 0, 1, 'R');
        $pdf->SetLineStyle(array('width' => 0.5, 'color' => array(52, 73, 94)));
        $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
        $pdf->Ln(5);

        if ($data->count() > 0) {
            $html = '
            <style>
                .data-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 10px;
                }
                .data-table th {
                    background-color: #3498db;
                    color: white;
                    font-weight: bold;
                    text-align: center;
                    padding: 8px;
                    border: 1px solid #ddd;
                    font-size: 12px;
                }
                .data-table td {
                    padding: 8px;
                    border: 1px solid #ddd;
                    text-align: center;
                    font-size: 12px;
                }
                .data-table tr:nth-child(even) {
                    background-color: #f2f2f2;
                }
                .no-data {
                    text-align: center;
                    font-style: italic;
                    color: #7f8c8d;
                }
            </style>
            
            <table class="data-table">
                <tr>';

            foreach ($headers as $header) {
                $html .= '<th>' . $header . '</th>';
            }

            $html .= '</tr>';

            foreach ($data as $index => $item) {
                $html .= '<tr>';
                foreach ($columns as $column) {
                    $value = $item->{$column};
                    if ($column == 'created_at') {
                        $value = \Carbon\Carbon::parse($value)->format('Y-m-d');
                    } elseif ($column == 'amount_ded') {
                        $value = number_format($value, 2);
                    }
                    $html .= '<td>' . $value . '</td>';
                }
                $html .= '</tr>';
            }

            $html .= '</table>';
        } else {
            $html = '<p class="no-data">لا توجد بيانات ' . strtolower($title) . ' لهذا الشهر</p>';
        }

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Ln(10);
    }


    public function updateSalary(Request $request, $id_user)
    {
        $request->validate([
            'base_salary' => 'required|numeric|min:0',
            'hourly_shift' => 'required',
            'gools_day' => 'required'
        ]);

        $user = User::findOrFail($id_user);

        $calculator = SalaryCalculator::updateOrCreate(
            ['id_user' => $id_user],
            $request->only(['base_salary', 'hourly_shift', 'gools_day'])
        );

        return redirect()->back()->with('success', 'تم حفظ إعدادات الراتب بنجاح');
    }





    // الرد على الاذن للادمن
    public function reply_per(Request $request)
    {
        try {
            $validated = $request->validate([
                'permission_id' => 'required|exists:permissions,id',
                'status_per' => 'required|in:Approved,Rejected',
                'reason_admin' => 'required|string|max:1000',
                'signature' => 'required|string|max:255'
            ]);

            $permission = Permission::findOrFail($request->permission_id);
            $permission->update($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم تحديث الطلب بنجاح',
                    'permission' => [
                        'id' => $permission->id,
                        'status_per' => $permission->status_per,
                        'reason_admin' => $permission->reason_admin,
                        'signature' => $permission->signature
                    ]
                ], 200, [], JSON_UNESCAPED_UNICODE); // إضافة JSON_UNESCAPED_UNICODE للحفاظ على الأحرف العربية
            }
            return back()->with('success', 'تم التحديث بنجاح');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }


    // الرد على الاجازة للادمن
    public function reply_vacation(Request $request)
    {
        try {
            $validated = $request->validate([
                'vacation_id' => 'required|exists:vacations,id',
                'status_vac' => 'required|in:Approved,Rejected',
                'reason_admin' => 'required|string|max:1000',
                'signature' => 'required|string|max:255'
            ]);

            $vacation = Vacation::findOrFail($request->vacation_id);
            $vacation->update($validated);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم تحديث الطلب بنجاح',
                    'vacation' => [
                        'id' => $vacation->id,
                        'status_vac' => $vacation->status_vac,
                        'reason_admin' => $vacation->reason_admin,
                        'signature' => $vacation->signature
                    ]
                ], 200, [], JSON_UNESCAPED_UNICODE); // إضافة JSON_UNESCAPED_UNICODE للحفاظ على الأحرف العربية
            }
            return back()->with('success', 'تم التحديث بنجاح');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: ' . $e->getMessage()
            ], 500);
        }
    }


    public function generatePdf($id, $month)
    {
        $user = User::findOrFail($id);

        $shifts = $user->shifts()
            ->whereRaw("DATE_FORMAT(started_at, '%Y-%m') = ?", [$month])
            ->orderBy('started_at', 'asc')
            ->get();

        $monthName = \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y');

        // إنشاء مستند PDF جديد
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // إعداد المستند
        $pdf->SetCreator('نظام إدارة الشيفتات');
        $pdf->SetAuthor('شركتك');
        $pdf->SetTitle('تقرير ساعات العمل - ' . $user->name);
        $pdf->SetSubject('تقرير شهري');

        // إضافة صفحة
        $pdf->AddPage();

        // المحتوى HTML
        $html = view('admin.sidebar.shift_pdf', [
            'user' => $user,
            'shifts' => $shifts,
            'month' => $monthName
        ])->render();

        // كتابة المحتوى
        $pdf->writeHTML($html, true, false, true, false, '');

        // إخراج الملف
        $pdf->Output("shifts_{$user->name}_{$month}.pdf", 'I');
    }


    //حذف حساب الموظف 
    public function delete_staff($id)
    {
        $data = User::find($id);
        $data->delete();
        return redirect()->back();
    }


    public function update_staff($id)
    {
        $data = User::find($id);
        $usertypes = Usertype::all(); // جلب كل أنواع المستخدمين

        return view('admin.sidebar.update_staff', compact('data', 'usertypes'));
    }

    public function edit_staff_team(Request $request, $id)
    {

        $data = User::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->usertype = $request->usertype;
        $data->color_code = $request->color_code; // ← مهم

        $data->save();

        return redirect()->back();
    }

    // قائمة الأجهزة
    public function center_devices()
    {
        $center = centerDetails::first();

        $query = Device::query();

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('device_name', 'like', "%{$search}%")
                    ->orWhere('device_model', 'like', "%{$search}%")
                    ->orWhere('device_serial', 'like', "%{$search}%");
            });
        }

        $devices = $query->get();

        // نحضر بيانات الصيانة والسعر لكل جهاز
        foreach ($devices as $device) {
            // آخر عملية صيانة
            $lastItem = AddItem::where('total_items_id', $device->total_item_id)->latest()->first();
            $device->last_maintenance_date = $lastItem ? $lastItem->item_name : 'none';
            $device->last_maintenance_price = $lastItem ? $lastItem->total_price . ' EGP' : '0 EGP';

            // جمع السعر الكلي = (total_price * quantity)
            $items = AddItem::where('total_items_id', $device->total_item_id)->get();
            $totalPriceWithQty = $items->sum(function ($item) {
                $price = is_numeric($item->total_price) ? (float) str_replace([',', ' EGP'], '', $item->total_price) : 0;
                $qty = is_numeric($item->quantity) ? (int) $item->quantity : 0;
                return $price * $qty;
            });

            $device->total_final_price = $totalPriceWithQty;
        }

        return view('admin.sidebar.center_devices', compact('devices', 'center'));
    }


    // اضافة جهاز
    public function add_device()
    {
        $center = centerDetails::first();

        return view('admin.sidebar.add_device', compact('center'));
    }

    // اضافة جهاز
    public function add_devices(Request $request)
    {

        // 1. احفظ الاسم في جدول total_items
        $item = new TotalItems();
        $item->name_category = $request->device_name;
        $item->save();

        // 2. احفظ الجهاز في جدول devices
        $device = new Device();
        $device->device_name = $request->device_name;
        $device->device_model = $request->device_model;
        $device->device_serial = $request->device_serial;
        $device->device_get_status = $request->device_get_status;
        $device->purchase_date = $request->purchase_date;
        $device->price_device = $request->price_device;
        $device->device_image = $request->device_image;

        // اربطه بـ total_items
        $device->total_item_id = $item->id;

        $device->save();


        // 3. احفظ نسخة مبسطة في جدول add_items
        $addItem = new AddItem();
        $addItem->item_name = $request->device_name;
        $addItem->total_price = $request->price_device;
        $addItem->quantity = 1;
        $addItem->total_items_id = $item->id;
        $addItem->save();

        // 3. احفظ نسخة مبسطة في جدول add_items
        $bill = new Bill();
        $bill->id_user = Auth::user()->name . ' ' . '[ID: ' . Auth::user()->id . ']';
        $bill->name = $request->device_name;
        $bill->type = 'شراء';
        $bill->required_quantity = 1;
        $bill->category = $request->device_name;
        $bill->price = (float) str_replace(',', '', $request->price_device);
        $bill->discount = 0;
        $bill->total_items_id = $item->id;
        $bill->save();

        return redirect('/center_devices');
    }



    public function delete_device($id)
    {
        $device = Device::find($id);
    
        if (!$device) {
            return redirect()->back()->with('error', 'الجهاز غير موجود');
        }
    
        // حذف TotalItems المرتبط
        $item = TotalItems::find($device->total_item_id);
        if ($item) {
            $item->delete();
        }
    
        // حذف Bill المرتبط
        $bill = Bill::find($device->total_item_id);
        if ($bill) {
            $bill->delete();
        }
    
        // حذف الجهاز نفسه بعد حذف العناصر المرتبطة
        $device->delete();
    
        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
    



    public function device_details($id)
    {
        $center = centerDetails::first();

        // استرجاع الجهاز
        $device = Device::findOrFail($id);

        // نجيب آخر item مرتبط بنفس الـ total_item_id
        $lastItem = AddItem::where('total_items_id', $device->total_item_id)
            ->latest()
            ->first();

        // نحضر البيانات المطلوبة
        $lastMaintenanceDate = $lastItem ? $lastItem->created_at->format('Y-m-d') : 'none';
        $lastMaintenancePrice = $lastItem ? $lastItem->total_price . ' EGP' : '0 EGP';

        // نجمع أسعار كل العناصر يدويًا بعد تحويلها لأرقام
        $items = AddItem::where('total_items_id', $device->total_item_id)->get();
        $itemsTotalPrice = 0;

        foreach ($items as $item) {
            $itemsTotalPrice += floatval(str_replace([',', ' EGP'], '', $item->total_price));
        }

        // نحول سعر الجهاز ونحسب الإجمالي
        $totalPrice =  $itemsTotalPrice;

        // نجمع الـ total_price * quantity لكل العناصر في الجدول
        $totalPriceWithQty = $items->sum(function ($item) {
            $price = is_numeric($item->total_price) ? (float) str_replace([',', ' EGP'], '', $item->total_price) : 0;
            $qty = is_numeric($item->quantity) ? (int) $item->quantity : 0;
            return $price * $qty;
        });

        $totalFinalPrice = $totalPriceWithQty;
        // إرجاع الـ view مع جميع البيانات
        return view('admin.sidebar.device_details', compact(
            'device',
            'lastMaintenanceDate',
            'lastMaintenancePrice',
            'totalPrice',
            'totalPriceWithQty',
            'totalFinalPrice',
            'center'
        ));
    }



    public function update_device($id)
    {
        $devices = Device::find($id);

        return view('admin.sidebar.update_device', compact('devices'));
    }


    public function edit_device(Request $request, $id)
    {
        // 1. عدل بيانات الجهاز
        $device = Device::findOrFail($id);
        $device->device_name = $request->device_name;
        $device->device_model = $request->device_model;
        $device->device_serial = $request->device_serial;
        $device->device_get_status = $request->device_get_status;
        $device->price_device = $request->price_device;
        $device->save();

        // 2. عدل بيانات total_items المرتبط بالجهاز
        $item = TotalItems::find($device->total_item_id);
        if ($item) {
            $item->name_category = $request->device_name;
            $item->save();
        }

        // 3. عدل بيانات add_items المرتبط بنفس total_item_id
        $addItem = AddItem::where('total_items_id', $device->total_item_id)->first();
        if ($addItem) {
            $addItem->item_name = $request->device_name;
            $addItem->total_price = $request->price_device;
            $addItem->save();
        }

        // 3. عدل بيانات all_bills المرتبط بنفس total_item_id
        $addItem = Bill::where('total_items_id', $device->total_item_id)->first();
        if ($addItem) {
            $addItem->name = $request->device_name;
            $addItem->price = $request->price_device;
            $addItem->save();
        }

        return redirect('/center_devices')->with('success', 'تم تعديل الجهاز بنجاح');
    }



    public function writing_report(Request $request)
    {
        $center = centerDetails::first();

        $reportStatus = $request->query('report', 'not_complete'); // default to not_complete

        $patients = AllPatient::when($reportStatus === 'complete', function ($query) {
            return $query->where('report', 'complete');
        })
            ->when($reportStatus === 'not_complete', function ($query) {
                return $query->where('report', '!=', 'complete');
            });

        // فلترة حسب السنة
        $year = $request->query('year');
        if ($year) {
            $patients = $patients->whereYear('created_at', $year);
        }

        // فلترة حسب الربع السنوي
        $quarter = $request->query('quarter');
        if ($quarter) {
            $quarters = [
                '1' => [1, 3],
                '2' => [4, 6],
                '3' => [7, 9],
                '4' => [10, 12],
            ];
            if (isset($quarters[$quarter])) {
                [$start, $end] = $quarters[$quarter];
                $patients = $patients->whereMonth('created_at', '>=', $start)
                    ->whereMonth('created_at', '<=', $end);
            }
        }

        // جلب السنوات الموجودة في البيانات
        $years = AllPatient::selectRaw('YEAR(created_at) as year')->distinct()->pluck('year');

        $patients = $patients->paginate(10)->appends($request->query());

        return view('admin.sidebar.writing_report', compact('patients', 'reportStatus', 'years', 'year', 'quarter', 'center'));
    }


    public function write_report_now($id)
    {
        $center = centerDetails::first();

        $patient = AllPatient::find($id);
        return view('admin.sidebar.write_report_now', compact('patient', 'center'));
    }




    public function generate($id)
    {
        $patient = AllPatient::findOrFail($id);

        // إذا كانت الحالة "not complete"، سيقوم بإظهار رسالة تحذير
        if ($patient->report !== 'complete') {
            return redirect()->back()->with('error', 'Report not completed yet.');
        }

        // تحميل التقرير كـ PDF
        $pdf = PDF::loadView('admin.reports.pdf', compact('patient'));
        return $pdf->download('report_' . $patient->full_name . '.pdf');
    }

    public function confirmReport(Request $request, $id)
    {
        $patient = AllPatient::findOrFail($id);

        $patient->report = 'complete';
        $patient->report_details = $request->report_text;
        $patient->doctor_signature = $request->signature;
        $patient->save();

        return redirect('/writing_report');
    }


    public function update_write_report($id)
    {
        $patient = AllPatient::find($id);
        return view('admin.reports.update_write_report', compact('patient'));
    }


    public function edit_write_report(Request $request, $id)
    {
        $patient = AllPatient::find($id);

        $patient->report = 'complete';
        $patient->report_details = $request->report_text;
        $patient->doctor_signature = $request->signature;
        $patient->save();

        return redirect('/writing_report');
    }


    public function bills_admin()
    {
        $center = centerDetails::first();

        $newbills = Newbill::all();

        return view('admin.sidebar.bills_admin', compact('newbills', 'center'));
    }

    public function continue_bill($id)
    {
        $center = centerDetails::first();

        $newbills = Newbill::find($id);
        $bill = Bill::all();
        $categories = \App\Models\TotalItems::all();

        return view('admin.sidebar.continue_bill', compact('newbills', 'bill', 'categories', 'center'));
    }


    public function add_new_bill()
    {
        $center = centerDetails::first();

        $user = User::find(Auth::user()->id);

        $bills = Newbill::all();

        return view('admin.sidebar.add_new_bill', compact('bills', 'user', 'center'));
    }

    public function upload_bill(Request $request)
    {
        // تأكد من أن الاستجابة ستكون JSON دائماً
        if (!$request->wantsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => 'يجب أن يكون الطلب من نوع JSON'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'bill_type' => 'required|string|max:255',
            'bill_name' => 'required|string|max:255',
            'required_qty' => 'required|integer|min:1',
            'price_bill' => 'required|numeric|min:0',
            'comments_bill' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $data = new Newbill();
            $data->id_user = $request->id_user;
            $data->bill_name = $request->bill_name;
            $data->bill_type = $request->bill_type;
            $data->required_qty = $request->required_qty;
            $data->price_bill = $request->price_bill;
            $data->comments_bill = $request->comments_bill ?? null;
            $data->save();

            return response()->json([
                'status' => 'success',
                'message' => 'تم حفظ الفاتورة بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء الحفظ: ' . $e->getMessage()
            ], 500);
        }
    }









    public function continueBillSubmit(Request $request)
    {
        // التحقق من البيانات المطلوبة
        $request->validate([
            'id_user' => 'required',
            'name' => 'required',
            'type' => 'required',
            'total_items_id' => 'required', // تغيير من category إلى total_items_id
            'price' => 'required|numeric',
            'required_quantity' => 'required|numeric'
        ]);

        // حساب السعر بعد الخصم
        $discount = $request->discount ?? 0;
        $price = $request->price;
        $quantity = $request->required_quantity;

        $discountedPrice = $price - ($price * ($discount / 100));
        $totalPrice = $discountedPrice * $quantity;

        // حفظ الفاتورة في جدول bills
        $bill = new \App\Models\Bill();
        $bill->id_user = $request->id_user;
        $bill->name = $request->name;
        $bill->type = $request->type;
        $bill->required_quantity = $quantity;

        // هنا نضيف الـ category بناءً على total_items_id
        $category = \App\Models\TotalItems::find($request->total_items_id);
        $bill->category = $category ? $category->name_category : 'غير محدد'; // استخدام name_category بدلاً من item_name

        $bill->supplier = $request->supplier ?? 'لم يتم تحديد المورد';
        $bill->price = $totalPrice;
        $bill->discount = $discount;
        $bill->expiration_date = $request->expiration_date ?? 'لم يتم تحديد تاريخ الانتهاء';
        $bill->comments_bill = $request->comments_bill ?? 'لا توجد ملاحظات';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/bills'), $imageName);
            $bill->image = $imageName;
        }

        $bill->save();

        // حفظ عنصر جديد مرتبط بالكتيجوري المحددة
        $item = new \App\Models\AddItem();
        $item->total_items_id = $request->total_items_id; // استخدام total_items_id مباشرة
        $item->item_name = $request->name;
        $item->total_price = $totalPrice;
        $item->quantity = $quantity;
        $item->save();

        // حذف من جدول new_bill
        \App\Models\NewBill::where('id_user', $request->id_user)
            ->where('bill_name', $request->name)
            ->delete();

        return redirect('/bills_admin')->with('success', 'تم الحفظ في الفواتير وإضافة عنصر للكاتيجوري.');
    }


    public function all_bills()
    {
        $center = centerDetails::first();

        $data = Bill::all();
        return view('admin.sidebar.all_bills', compact('data', 'center'));
    }

    // طباعة الفاتورة
    public function printInvoice($id)
    {
        $invoice = Bill::findOrFail($id);
        $center = centerDetails::first();

        $price = is_numeric($invoice->price) ? (float)$invoice->price : 0;
        $discount = is_numeric($invoice->discount) ? (float)$invoice->discount : 0;
        $total = $price - ($price * ($discount / 100));

        // تحميل مكتبة TCPDF Fonts
        require_once base_path('vendor/tecnickcom/tcpdf/tcpdf.php');
        require_once base_path('vendor/tecnickcom/tcpdf/include/tcpdf_fonts.php');

        // إعداد PDF بحجم A5
        $pdf = new \TCPDF('P', 'mm', 'A5', true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle('Invoice #' . $invoice->id);
        $pdf->SetSubject('Invoice');

        $pdf->SetMargins(10, 10, 10);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(5);

        $pdf->AddPage();

        // تحميل الخط
        $fontPath = public_path('fonts/NotoSansArabic.ttf');
        $fontname = \TCPDF_FONTS::addTTFfont($fontPath, 'TrueTypeUnicode', '', 96);
        if (!$fontname) {
            abort(500, 'خطأ في تحميل الخط');
        }

        $pdf->SetFont($fontname, '', 14);

        // المحتوى
        $html = view('admin.sidebar.invoice_pdf', compact('invoice', 'total', 'center'))->render();

        $pdf->writeHTML($html, true, false, true, false, '');

        // إخراج الفاتورة
        $pdf->Output('invoice_' . $invoice->id . '.pdf', 'I');
    }



    public function delete_invoice($id)
    {
        $data = Bill::find($id);
        $data->delete();
        return redirect('/all_bills');
    }


    public function update_invoice($id)
    {
        $center = centerDetails::first();

        $data = Bill::find($id);
        $categories = \App\Models\TotalItems::all();

        return view('admin.sidebar.update_invoice', compact('data', 'categories', 'center'));
    }


    public function edit_invoice(Request $request, $id)
    {
        $bill = Bill::findOrFail($id);

        $newData = $request->only([
            'name',
            'type',
            'required_quantity',
            'supplier',
            'category',
            'price',
            'discount',
            'expiration_date',
            'comments_bill',
            'total_items_id'
        ]);

        // التعامل مع الصورة إن وُجدت
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/bills'), $imageName);
            $newData['image'] = $imageName;
        }

        // تحديث الفاتورة فقط إذا البيانات اتغيرت
        $billChanged = false;
        foreach ($newData as $key => $value) {
            if ($bill->$key != $value) {
                $bill->$key = $value;
                $billChanged = true;
            }
        }

        if ($billChanged) {
            $bill->save();
        }

        // تحديث add_items المرتبط بالـ bill
        if ($bill->total_items_id) {
            $addItems = AddItem::where('total_items_id', $bill->total_items_id)->get();
            foreach ($addItems as $item) {
                $updateData = [];

                if ($item->item_name != $request->name) {
                    $item->item_name = $request->name;
                }

                if ($item->total_price != $request->price) {
                    $item->total_price = $request->price;
                }

                if ($item->quantity != $request->required_quantity) {
                    $item->quantity = $request->required_quantity;
                }

                if ($item->category != $request->category) {
                    $item->category = $request->category;
                }

                $item->updated_at = now();
                $item->save(); // حفظ التحديثات
            }
        }

        return redirect()->back()->with('success', 'تم تحديث الفاتورة والبنود المرتبطة بنجاح.');
    }




    // دالة مساعدة لرفع الصور
    private function uploadImage($image)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/bills'), $imageName);
        return $imageName;
    }










    public function total_items_admin()
    {
        $search = request('search');

        $categories = TotalItems::query();
        $items = AddItem::query();

        if ($search) {
            $categories->where('name_category', 'like', "%{$search}%");
            $items->where('item_name', 'like', "%{$search}%");
        }

        $categories = $categories->get();
        $items = $items->get();

        $addItems = AddItem::visible()->get();

        // ✅ Manual Pagination لكل 15 كارد
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;
        $currentItems = $categories->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedCategories = new LengthAwarePaginator(
            $currentItems,
            $categories->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        if ($categories->isEmpty() && $items->isEmpty()) {
            return view('admin.sidebar.add_category_items');
        }

        return view('admin.sidebar.total_itemsadmin', [
            'categories' => $paginatedCategories,
            'items' => $items,
            'addItems' => $addItems
        ]);
    }


    // فرز العناصر في total_items
    public function updateQuantity(Request $request)
    {
        $item = AddItem::findOrFail($request->item_id);
        $item->quantity = $request->quantity;
        $item->save();
        return response()->json(['success' => true]);
    }

    public function delete(Request $request)
    {
        $item = AddItem::findOrFail($request->item_id);
        $item->delete(); // أو $item->update(['is_hidden' => 1]); لو مش عايز تحذف فعليًا
        return response()->json(['deleted' => true]);
    }


    public function updateCategoryTotalItem(Request $request, $id)
    {
        $category = TotalItems::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'الفئة غير موجودة']);
        }

        $category->name_category = $request->name_category; // لازم تكون نفس اسم الحقل اللي جاي من الفورم
        $category->save();

        return response()->json(['success' => true, 'message' => 'تم تعديل الفئة بنجاح']);
    }

    public function destroyCategoryTotalItem($id)
    {
        $category = TotalItems::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الفئة بنجاح'
        ]);
    }






    public function add_category_page()
    {
        $center = centerDetails::first();

        return view('admin.sidebar.add_category_items', compact('center'));
    }

    public function add_category_items(Request $request)
    {
        $category = new TotalItems();
        $category->name_category = $request->name_category;
        $category->save();

        // لو الطلب AJAX
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'تمت الإضافة بنجاح',
            ]);
        }

        return redirect('/total_items_admin')->with('success', 'تم إضافة الفئة بنجاح');
    }



    public function add_item($id)
    {
        $category = TotalItems::find($id);
        $items = AddItem::where('total_items_id', $id)->get(); // Assuming foreign key

        return view('admin.sidebar.add_item', compact('category', 'items'));
    }

    public function update_item(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $item = AddItem::findOrFail($id);
            $item->item_name = $request->item_name;
            $item->quantity = $request->quantity;
            $item->total_price = $request->total_price;
            $item->save();

            // 2. تعديل كل الأجهزة المرتبطة بـ total_item_id في جدول devices
            Device::where('total_item_id', $item->total_items_id)
                ->update(['price_device' => $request->total_price]);

            return response()->json([
                'success' => true,
                'updated_item' => $item,
                'message' => 'تم تحديث العنصر بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء التحديث: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete_item($id)
    {
        try {
            $item = AddItem::findOrFail($id);
            $item->delete();

            // إرجاع استجابة بدون محتوى (204)
            return response()->noContent();

            // أو إرجاع استجابة JSON بسيطة
            // return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء الحذف: ' . $e->getMessage()
            ], 500);
        }
    }













    public function view_category()
    {
        $center = centerDetails::first();


        $categories = Category::with(['positions.situations'])->get(); // خلي بالك لازم تكون عامل العلاقة دي في الموديل
        $locations = Location::all();


        if ($categories->isEmpty()) {
            return view('admin.sidebar.add_category_position', compact('center'));
        }

        return view('admin.sidebar.category', compact('categories', 'locations', 'center'));
    }


    // عرض صفحة إضافة فئة
    public function view_add_category_position()
    {
        return view('admin.sidebar.add_category_position');
    }


    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $category = Category::findOrFail($id);
            $category->name = $request->name;
            $category->save();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الفئة بنجاح',
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث الفئة: ' . $e->getMessage()
            ], 500);
        }
    }

    // دالة حذف الفئة
    public function deleteCategory(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الفئة بنجاح',
                'category_id' => $id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف الفئة: ' . $e->getMessage()
            ], 500);
        }
    }


    // إضافة فئة جديدة

    public function add_category_position(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        // إذا كان الطلب من نوع AJAX أو يتوقع JSON
        if ($request->wantsJson()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'تمت إضافة الفئة الجديدة!',
            ]);
        }

        // غير ذلك إعادة التوجيه التقليدية
        return redirect('/view_category')->with('success', 'تم إضافة الفئة بنجاح');
    }





    public function add_pos_situ($id)
    {
        $center = centerDetails::first();
        $positions = PositionName::all();

        $category = Category::findOrFail($id);

        return view('admin.sidebar.add_pos_situ', [
            'category' => $category,
            'positions' => $positions,
            'center' => $center
        ]);
    }






    public function add_position_success_ajax(Request $request, $categoryId)
    {
        $validated = $request->validate([
            'position_name' => 'required|string|max:255'
        ]);

        $category = Category::findOrFail($categoryId);

        $position = new PositionName();
        $position->position_name = $validated['position_name'];
        $position->category_id = $category->id;
        $position->category_name = $category->name; // لو عايز تخزن الاسم كمان
        $position->save();

        return response()->json([
            'status' => 'success',
            'position' => $position
        ]);
    }

    public function add_situation(Request $request, $id)
    {
        $request->validate([
            'situation_name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $position = PositionName::findOrFail($id);

        $situation = $position->situations()->create([
            'situation_name' => $request->situation_name,
            'price' => $request->price,
        ]);

        // نرجع JSON فيه بيانات الحالة
        return response()->json([
            'status' => 'success',
            'situation' => [
                'id' => $situation->id,
                'situation_name' => $situation->situation_name,
                'price' => $situation->price,
            ]
        ]);
    }


    public function delete_position($id)
    {
        $position = PositionName::findOrFail($id);
        $position->delete();
        return response()->json(['status' => 'success']);
    }


    public function delete_situation($id)
    {
        $situation = Situation::find($id);
        if ($situation) {
            $situation->delete();
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error'], 404);
    }


    public function delete_cetegory_pos($id)
    {
        try {
            $position = PositionName::findOrFail($id);

            $position->delete();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update_position(Request $request, $id)
    {
        $position = PositionName::findOrFail($id);
        $position->position_name = $request->position_name;
        $position->save();

        return response()->json([
            'status' => 'success',
            'message' => 'تم تحديث اسم الفئة بنجاح',
            'position_name' => $position->position_name,
            'id' => $position->id,
        ]);
    }



    public function update_situation(Request $request, $id)
    {
        $request->validate([
            'situation_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $situation = Situation::find($id);

        if (!$situation) {
            return response()->json([
                'success' => false,
                'message' => 'الوضع غير موجود'
            ], 404);
        }

        $situation->update([
            'situation_name' => $request->situation_name,
            'price' => $request->price,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم التحديث بنجاح',
            'id' => $situation->id,
            'name' => $situation->situation_name,
            'price' => $situation->price,
        ]);
    }





    public function add_location(Request $request)
    {
        $validated = $request->validate([
            'location_name' => 'required|string|max:255',
        ]);

        $location = Location::create([
            'location_name' => $validated['location_name'],
        ]);

        return response()->json([
            'status' => 'success',
            'location' => $location,
        ]);
    }

    // حذف بيانات موقع التصوير
    public function delete_location($id)
    {
        $location = Location::find($id);

        if (!$location) {
            return response()->json([
                'status' => 'error',
                'message' => 'الموقع غير موجود',
            ]);
        }

        $location->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'تم الحذف بنجاح',
        ]);
    }

    // تعديل بيانات موقع التصوير
    public function update_location(Request $request, $id)
    {
        $request->validate([
            'location_name' => 'required|string|max:255',
        ]);

        $location = Location::findOrFail($id);
        $location->update([
            'location_name' => $request->location_name,
        ]);

        return response()->json([
            'status' => 'success',
            'location' => $location,
        ]);
    }



    public function donations_admin()
    {
        $center = centerDetails::first();

        return view('admin.sidebar.donations_admin', compact('center'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'age' => 'nullable|integer',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'amount' => 'required|numeric',
            'reason' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);

        // تعيين قيمة افتراضية "لا يوجد" للحقول الفارغة
        $data = [
            'name' => $validated['name'] ?? 'لا يوجد',
            'age' => $validated['age'] ?? 'لا يوجد',
            'address' => $validated['address'] ?? 'لا يوجد',
            'phone' => $validated['phone'] ?? 'لا يوجد',
            'amount' => $validated['amount'],
            'reason' => $validated['reason'] ?? 'لا يوجد',
            'date' => $validated['date'],
        ];


        $donation = Donations::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Donation added successfully',
            'donation' => $donation
        ]);
    }

    public function edit($id)
    {
        $donation = Donations::findOrFail($id);
        return response()->json($donation);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'amount' => 'required|numeric',
            'reason' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $donation = Donations::findOrFail($id);
        $donation->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Donation updated successfully',
            'donation' => $donation
        ]);
    }

    public function destroy($id)
    {
        $donation = Donations::findOrFail($id);
        $donation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Donation deleted successfully'
        ]);
    }

    public function list()
    {
        $donations = Donations::orderBy('created_at', 'desc')->get();
        return response()->json($donations);
    }


    // بداية شيفت جديد
    public function startShift()
    {
        $user = Auth::user();



        $day = now()->translatedFormat('l'); // الحصول على اسم اليوم باللغة العربية

        // إنشاء شيفت جديد
        Shift::create([
            'id_user' => $user->id,
            'day' => $day,
            'status' => 'داخل الشيفت',
            'started_at' => now(),
        ]);

        return redirect()->back();
    }

    // إنهاء الشيفت
    public function endShift()
    {
        $user = Auth::user();

        $shift = Shift::where('id_user', $user->id)
            ->where('status', 'داخل الشيفت')
            ->latest()
            ->first();

        if ($shift) {
            $startTime = Carbon::parse($shift->started_at);
            $endTime = now();

            // تأكد إن وقت الانتهاء بعد وقت البداية
            if ($endTime->lessThan($startTime)) {
                return response()->json(['error' => 'وقت الانتهاء أصغر من وقت البداية'], 400);
            }

            // حساب الفرق بين الوقتين
            $diff = $startTime->diff($endTime);

            // تنسيق الوقت hh:mm:ss
            $formattedTime = sprintf('%02d:%02d:%02d', $diff->h + ($diff->days * 24), $diff->i, $diff->s);

            $shift->update([
                'status' => 'انتهى الشيفت',
                'ended_at' => $endTime,
                'time' => $formattedTime,
            ]);

            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['error' => 'لا يوجد شيفت نشط'], 404);
        }
    }



    // التحقق من حالة الشيفت
    public function checkShiftStatus()
    {
        $user = Auth::user();



        $activeShift = Shift::where('id_user', Auth::id())
            ->where('status', 'داخل الشيفت')
            ->latest()
            ->first();

        return response()->json(['hasActiveShift' => $activeShift]);
    }



    public function profile_user()
    {
        $center = centerDetails::first();

        return view('admin.sidebar.profile_user', compact('center'));
    }

    public function vacation()
    {
        // نجيب الإجازات الخاصة بالمستخدم الحالي فقط
        $vacations = \App\Models\Vacation::with('user')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('admin.sidebar.vacation', compact('vacations'));
    }


    public function storeVacation(Request $request)
    {
        try {
            \Log::info('Request data:', $request->all());

            $validated = $request->validate([
                'num_vac' => 'required|integer|between:1,5',
                'reason_vac' => 'required|string|max:1000',
            ]);

            $vacationData = [
                'user_id' => auth()->id(),
                'num_vac' => $validated['num_vac'],
                'reason_vac' => $validated['reason_vac'],
                'status_vac' => 'pending',
            ];

            \Log::info('Creating vacation with:', $vacationData);

            $vacation = \App\Models\Vacation::create($vacationData);

            return response()->json([
                'success' => true,
                'message' => 'تم إرسال طلب الإجازة بنجاح!',
                'vacation' => $vacation
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in storeVacation: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حفظ البيانات: ' . $e->getMessage()
            ], 500);
        }
    }


    public function destroyVacation($id)
    {
        try {
            $vacation = Vacation::findOrFail($id);

            // تصحيح typo من stauts_vac إلى status_vac
            if ($vacation->status_vac !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يمكن إلغاء طلب تمت مراجعته مسبقاً'
                ], 403);
            }

            $vacation->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم إلغاء طلب الإجازة بنجاح'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'طلب الإجازة غير موجود'
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Error deleting vacation: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء محاولة الإلغاء'
            ], 500);
        }
    }



    public function permission()
    {
        $permissions = \App\Models\Permission::with('user')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        return view('admin.sidebar.permission', compact('permissions'));
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'start_end_per' => 'required|in:بداية الشيفت,نهاية الشيفت',
            'time_per' => 'required|in:1,2,3',
            'reason_per' => 'required|string|max:1000',
        ]);

        Permission::create([
            'user_id' => Auth::id(),
            'start_end_per' => $request->start_end_per,
            'time_per' => $request->time_per,
            'reason_per' => $request->reason_per,
            'status_per' => 'pending', // تأكد من أن العمود موجود في الجدول
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال طلب الإذن بنجاح'
        ]);
    }

    public function destroyPermission($id)
    {
        $permission = Permission::findOrFail($id);

        if ($permission->status_per !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكن إلغاء طلب تمت مراجعته مسبقاً'
            ], 403);
        }

        $permission->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم إلغاء طلب الإذن بنجاح'
        ]);
    }




    public function deduction()
    {
        $deduction = \App\Models\Deduction::with('user')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        return view('admin.sidebar.deduction', compact('deduction'));
    }

    public function storeDeduction(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount_ded' => 'required|numeric',
            'reason_ded' => 'required|string|max:1000',
            'signature_ded' => 'required|string|max:1000',
        ]);

        Deduction::create([
            'user_id' => $request->user_id,
            'amount_ded' => $request->amount_ded,
            'reason_ded' => $request->reason_ded,
            'signature_ded' => $request->signature_ded,
            'status_ded' => 'Approved',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تقديم الطلب بنجاح'
        ]);
    }


    public function destroyDeduction($id)
    {
        $deduction = deduction::findOrFail($id);

        if ($deduction->status_ded !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكن إلغاء طلب تمت مراجعته مسبقاً'
            ], 403);
        }

        $deduction->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم إلغاء طلب الإذن بنجاح'
        ]);
    }

    public function submitObjection(Request $request)
    {
        $request->validate([
            'deduction_id' => 'required|exists:deductions,id',
            'objection_reason' => 'required|string|max:1000',
        ]);

        $deduction = Deduction::findOrFail($request->deduction_id);

        // التحقق من عدم وجود اعتراض سابق
        if ($deduction->objection_ded) {
            return response()->json([
                'success' => false,
                'message' => 'تم تقديم اعتراض مسبقاً على هذا الخصم'
            ], 400);
        }

        $deduction->update([
            'objection_ded' => 'Approved',
            'objection_reason' => $request->objection_reason,
            'objection_status' => 'pending',
            'objection_date' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال الاعتراض بنجاح'
        ]);
    }

    public function cancelObjection(Request $request)
    {
        $request->validate([
            'deduction_id' => 'required|exists:deductions,id',
        ]);

        $deduction = Deduction::findOrFail($request->deduction_id);

        // التحقق من وجود اعتراض
        if (!$deduction->objection_ded) {
            return response()->json([
                'success' => false,
                'message' => 'لا يوجد اعتراض لإلغائه'
            ], 400);
        }

        $deduction->update([
            'objection_ded' => null,
            'objection_reason' => null,
            'objection_status' => null,
            'reason_admin_objection' => null,
            'signature_objection_admin' => null,
            'objection_date' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إلغاء الاعتراض بنجاح'
        ]);
    }

    public function reply_objection(Request $request)
    {
        $request->validate([
            'deduction_id' => 'required|exists:deductions,id',
            'objection_status' => 'required|string|in:pending,Approved,Rejected',
            'reason_admin_objection' => 'required|string|max:1000',
            'status_ded' => 'required|string|in:Approved,Rejected',
            'signature_objection_admin' => 'required|string|max:255',
        ]);

        $deduction = Deduction::findOrFail($request->deduction_id);

        $deduction->update([
            'objection_status' => $request->objection_status,
            'reason_admin_objection' => $request->reason_admin_objection,
            'status_ded' => $request->status_ded,
            'signature_objection_admin' => $request->signature_objection_admin,
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث حالة الاعتراض بنجاح',
            'data' => $deduction
        ]);
    }


    public function add_user_type()
    {
        return view('admin.sidebar.add_user_type');
    }

    public function index_usertype()
    {
        return response()->json(Usertype::all());
    }

    public function store_usertype(Request $request)
    {
        $validated = $request->validate([
            'name_usertype' => 'required|string|max:255',
            'color_code' => 'required|string|size:7'
        ]);

        $usertype = Usertype::create($validated);

        return response()->json($usertype, 201);
    }

    public function update_usertype(Request $request, Usertype $usertype)
    {
        $validated = $request->validate([
            'name_usertype' => 'sometimes|string|max:255',
            'color_code' => 'sometimes|string|size:7'
        ]);

        $usertype->update($validated);

        return response()->json($usertype);
    }

    public function destroy_usertype(Usertype $usertype)
    {
        $usertype->delete();
        return response()->json(null, 204);
    }

    // صفحة الشركاء
    public function parteners()
    {
        $registeredPartnerIds = Partener::pluck('user_id')->toArray();
        $users = User::whereNotIn('id', $registeredPartnerIds)->get();

        $outputs = DB::table('financial_accounting')->sum('outputs') ?? 0;
        $inputs = DB::table('financial_accounting')->sum('inputs') ?? 0;

        $parteners = Partener::with('user')->get();
        $myPartener = Partener::where('user_id', auth()->id())->first();

        return view('admin.sidebar.parteners', [
            'users' => $users,
            'outputs' => $outputs,
            'inputs' => $inputs,
            'parteners' => $parteners,
            'myPartener' => $myPartener
        ]);
    }

    public function updateProfits()
    {
        try {
            $outputs = DB::table('financial_accounting')->sum('outputs') ?? 0;
            $inputs = DB::table('financial_accounting')->sum('inputs') ?? 0;
            $total = $inputs - $outputs;

            $parteners = Partener::all();

            foreach ($parteners as $partner) {
                $profit = $total * ($partner->percentage / 100);
                $partner->update(['total_profits_you' => $profit]);
            }

            return redirect()->back()
                ->with('success', 'تم تحديث الأرباح بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء التحديث');
        }
    }


    public function store_partener(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'age' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'job' => 'nullable|string|max:255',
            'amount' => 'required|numeric',
            'percentage' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            // التحقق من النسبة
            $totalUsedPercentage = Partener::sum('percentage') + $request->percentage;
            if ($totalUsedPercentage > 100) {
                return response()->json([
                    'success' => false,
                    'message' => 'عذراً! النسبة الإجمالية تتجاوز 100%'
                ], 422);
            }

            // حساب الأرباح
            $grossProfit = DB::table('financial_accounting')->sum('gross_profit');
            $totalProfit = ($request->percentage / 100) * $grossProfit;
            $user = User::findOrFail($request->user_id);

            // إنشاء الشريك
            Partener::create([
                'id_user' => auth()->id(), // المستخدم اللي أضاف
                'user_id' => $request->user_id, // الشريك
                'name_partener' => $user->name, // هنا هنخزن اسم الشريك
                'age' => $request->age,
                'address' => $request->address,
                'phone' => $request->phone,
                'job' => $request->job,
                'amount' => $request->amount,
                'percentage' => $request->percentage,
                'total_profits_you' => $totalProfit,
            ]);


            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم إضافة الشريك بنجاح'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Partner Store Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء الحفظ: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy_partener($id)
    {
        $partner = Partener::findOrFail($id);
        $partner->delete();

        return redirect()->back()
            ->with('success', 'تم حذف الشريك بنجاح');
    }



    // صفحة المالية
    public function financial_accounting()
    {
        $data = \App\Models\FinancialAccounting::first();
        return view('admin.sidebar.financial_accounting', compact('data'));
    }

    // دالة التحديث التلقائي للبيانات
    public function refresh_financial_data()
    {
        try {
            // حساب المدخلات
            $inputs = \App\Models\AllPatient::sum('price') + \App\Models\Donations::sum('amount'); // تأكد من أن الموديل اسمه Donation وليس Donations

            // حساب صافي الرواتب
            $netSalaries = \App\Models\SalaryCalculator::sum('base_salary') -
                \App\Models\Deduction::where('status_ded', 'Approved')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('amount_ded');

            $netSalaries = max($netSalaries, 0); // تجنب القيم السالبة

            // حساب المصروفات الأخرى
            $otherOutputs = \App\Models\Bill::whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('price');

            $outputs = $netSalaries + $otherOutputs;
            $gross = $inputs - $outputs;

            // حفظ البيانات
            $financialData = \App\Models\FinancialAccounting::updateOrCreate(
                ['id' => 1],
                [
                    'inputs' => $inputs ?? 0,
                    'outputs' => $outputs ?? 0,
                    'gross_profit' => $gross ?? 0,
                    'updated_at' => now()
                ]
            );

            return response()->json([
                'inputs' => (float)($financialData->inputs ?? 0),
                'outputs' => (float)($financialData->outputs ?? 0),
                'gross_profit' => (float)($financialData->gross_profit ?? 0),
            ]);
        } catch (\Exception $e) {
            \Log::error('Financial Error: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ: ' . $e->getMessage()], 500);
        }
    }
}
