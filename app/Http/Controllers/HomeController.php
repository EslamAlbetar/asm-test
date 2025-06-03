<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\centerDetails;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    // توجيىة الأدمن عند تسجيل الدخول الى صفحة الادمن
    public function index()
    {
        // عدد المتبرعين
        $donorsCount = \App\Models\Donations::count();
        $PartCount = \App\Models\Partener::count();
        $billCount = \App\Models\Bill::count();
        $patCount = \App\Models\AllPatient::count();
        $userCount = \App\Models\User::count();
        $itemCount = \App\Models\AddItem::count();
        $devCount = \App\Models\Device::count();
        $employeeCount = \App\Models\User::where('usertype', '!=', 'user')->count();

        // مجموع التبرعات
        $totalDonations = \App\Models\Donations::sum('amount');
        $totalBills = \App\Models\Bill::sum('price');
        $totalItems = \App\Models\AddItem::sum('quantity');

        // نسبة تقديرية مثلا 70% كتمثيل للبار، ممكن تعدلها لو عندك حد أقصى
        $donationProgress = $totalDonations > 0 ? min(100, ($totalDonations / 10000) * 100) : 0;
        $billProgress = $totalBills > 0 ? min(100, ($totalBills / 10000) * 100) : 0;


        // حساب صافي الربح اليومي لآخر 30 يومًا
        $profits = DB::table('donations')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at)')
            ->get();


        $labels = $profits->pluck('date')->toArray();
        $data = $profits->pluck('total')->toArray();

        return view('admin.index', compact(
            'donorsCount',
            'totalDonations',
            'donationProgress',
            'PartCount',
            'billCount',
            'patCount',
            'userCount',
            'totalBills',
            'billProgress',
            'itemCount',
            'totalItems',
            'devCount',
            'employeeCount',
            'labels',
            'data'
        ));
    }

    public function updateName(Request $request)
    {
        $center = CenterDetails::firstOrFail(); // سيظهر خطأ 404 إذا لم يوجد سجل

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'second_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ]);

        try {
            $center->update($validated);

            return response()->json([
                'success' => true,
                'data' => $center,
                'message' => 'تم تحديث البيانات بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في تحديث البيانات: ' . $e->getMessage()
            ], 500);
        }
    }
}
