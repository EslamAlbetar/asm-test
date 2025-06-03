<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تقرير سنوي {{ $year }}</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
        }

        h1,
        h2,
        h3,
        h4 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .positive {
            color: #27ae60;
        }

        .negative {
            color: #c0392b;
        }

        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    @php
    $permissions = \App\Models\AuthedPage::where('user_id', auth()->id())->first();
    @endphp

    @if($permissions->profit)
    <div style="text-align: center; margin-bottom: 20px;">
        <h1>تقرير سنوي {{ $year }}</h1>
    </div>

    @if(count($months) > 0)
    <table border="1" cellpadding="6" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>الشهر</th>
                <th>المدخلات</th>
                <th>الرواتب</th>
                <th>المدفوعات</th>
                <th>صافي الربح</th>
                <th>عدد الأيام</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($months as $month)
            <tr>
                <td>{{ $month['month_name'] }}</td>
                <td>{{ number_format($month['inputs'], 2) }}</td>
                <td>{{ number_format($month['salaries'], 2) }}</td>
                <td>{{ number_format($month['payments'], 2) }}</td>
                <td>{{ number_format($month['net_profit'], 2) }}</td>
                <td>{{ $month['days_count'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <h3>تفاصيل الرواتب لكل شهر</h3>
    @foreach ($months as $month)
    <h4>{{ $month['month_name'] }}</h4>
    <table border="1" cellpadding="6" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>اسم الموظف</th>
                <th>صافي الراتب</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($month['salaries_details'] as $salary)
            <tr>
                <td>{{ $salary['employee_name'] }}</td>
                <td>{{ number_format($salary['net_salary'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach

    <hr>

    <h3>أرباح الشركاء لكل شهر</h3>
    @foreach ($months as $month)
    <h4>{{ $month['month_name'] }}</h4>
    <table border="1" cellpadding="6" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>اسم الشريك</th>
                <th>النسبة (%)</th>
                <th>نصيبه من الأرباح</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($month['partners'] as $partener)
            <tr>
                <td>{{ $partener['name'] }}</td>
                <td>{{ $partener['percentage'] }}</td>
                <td>{{ number_format($partener['share'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach

    <hr>

    <h3>الإجماليات للسنة</h3>
    <ul>
        <li><strong>إجمالي المدخلات:</strong> {{ number_format($totalInputs, 2) }}</li>
        <li><strong>إجمالي الرواتب:</strong> {{ number_format($totalSalaries, 2) }}</li>
        <li><strong>إجمالي المدفوعات:</strong> {{ number_format($totalPayments, 2) }}</li>
        <li><strong>صافي الربح السنوي:</strong> {{ number_format($netProfit, 2) }}</li>
    </ul>

    
    <!-- تذييل الصفحة -->
    <div style="text-align: center; margin-top: 50px; color: #7f8c8d; font-size: 12px; border-top: 1px solid #eee; padding-top: 10px;">
    تم إنشاء التقرير في {{ \Carbon\Carbon::now()->format('Y-m-d || A H:i') }} | &copy; {{ date('Y') }} {{ $center->second_name}} {{ $center->first_name }}
    </div>
    
    @else
    <div style="text-align: center; padding: 20px; color: #7f8c8d;">
        لا توجد بيانات متاحة لهذه السنة
    </div>
    @endif

    @else
    <h2 class="text-danger text-center">! لا تملك صلاحيات للدخول لهذه الصفحة</h2>
    @endif

</body>

</html>