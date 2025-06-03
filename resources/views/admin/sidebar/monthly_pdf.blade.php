<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تقرير شهري - {{ $monthName ?? 'غير محدد' }} {{ $year ?? 'غير محدد' }}</title>
    <style>
        body {
            margin: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 26px;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .header h2 {
            font-size: 20px;
            font-weight: normal;
            color: #34495e;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px 15px;
            text-align: center;
            font-size: 14px;
        }

        th {
            background-color: #2980b9;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .summary {
            padding: 20px;
            border-radius: 10px;
            width: 60%;
            margin: 40px auto 20px;
            text-align: center;
        }

        .summary h4 {
            font-size: 10px;
            margin-bottom: 15px;
            color: #ecf0f1;
        }

        .summary p {
            margin: 6px 0;
            font-size: 14px;
        }



        .positive {
            color: #2ecc71;
            font-weight: bold;
        }

        .negative {
            color: #e74c3c;
            font-weight: bold;
        }

        .no-data {
            margin-top: 40px;
            font-size: 16px;
            color: #e74c3c;
            font-weight: bold;
            text-align: center;
        }

        .footer {
            text-align: left;
            margin-top: 50px;
            color: #7f8c8d;
            font-size: 12px;
            border-top: 1px solid #eee;
            padding-top: 10px;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <div style="text-align: center; margin-bottom: 40px;">

        @php
        $permissions = \App\Models\AuthedPage::where('user_id', auth()->id())->first();
        @endphp

        @if($permissions->profit)
        <h1>تقرير شهر {{ $monthName }} لعام {{ $year }}</h1>
        <p style="color: #7f8c8d; font-size: 16px;">عدد الأيام التي تحتوي على بيانات: {{ count($days) }}</p>
    </div>

    @if(count($days) > 0)
    <table>
        <thead>
            <tr>
                <th>اليوم</th>
                <th>التاريخ</th>
                <th>المدخلات (EGP)</th>
                <th>المخرجات (EGP)</th>
                <th>صافي الربح (EGP)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($days as $day)
            <tr>
                <td>{{ $day['day_name'] }}</td>
                <td class="date">{{ $day['date'] }}</td>
                <td class="currency">{{ number_format($day['inputs'], 2) }}</td>
                <td class="currency">{{ number_format($day['payments'], 2) }}</td>
                <td class="{{ $day['net_profit'] >= 0 ? 'positive' : 'negative' }}">
                    {{ number_format($day['net_profit'], 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="salaries-table" style="margin-bottom: 30px; padding: 15px; border-radius: 10px;">
        <h4 style="color: #333;">الرواتب الشهرية للموظفين:</h4>
        <table style="width: 100%; border-collapse: collapse; text-align: center; font-size: 14px;">
            <thead>
                <tr style="background-color: #ddd;">
                    <th style="padding: 8px; border: 1px solid #ccc;">اسم الموظف</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">صافي الراتب الشهري (EGP)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($monthData['salaries'] as $salary)
                <tr>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $salary['employee_name'] }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ number_format($salary['net_salary'], 2) }} EGP</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="summary">
        <h2 style="color: black; margin-top: 0;">إجمالي الشهر:</h2>
        <p>المدخلات: <span class="currency">{{ number_format($monthData['total_inputs'], 2) }}</span> EGP</p>
        <p>المدفوعات: <span class="currency">{{ number_format($monthData['total_payments'], 2) }}</span> EGP</p>
        <p>صافي الربح: <span class="{{ $monthData['net_profit'] >= 0 ? 'positive' : 'negative' }}">
                {{ number_format($monthData['net_profit'], 2) }} EGP
            </span></p>
    </div>

    <div class="partners-table" style="margin-top: 30px;  padding: 15px; border-radius: 10px;">
        <h4 style="color: #333;">توزيع الأرباح على الشركاء:</h4>
        <table style="width: 100%; border-collapse: collapse; text-align: center; font-size: 14px;">
            <thead>
                <tr style="background-color: #ddd;">
                    <th style="padding: 8px; border: 1px solid #ccc;">اسم الشريك</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">النسبة %</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">الحصة الشهرية (EGP)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($monthData['partners'] as $partener)
                <tr>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $partener['name'] }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ number_format($partener['percentage'], 2) }}%</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ number_format($partener['share'], 2) }} EGP</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p style="font-size: 12px; color: #888; margin-top: 10px;">
            ملحوظه: يجب تحديث البيانات من صفحات الشركاء والماليات للحصول على نتائج دقيقة عن ارباح الشركاء.
        </p>
    </div>

    @else
    <div class="no-data">
        <p style="margin: 0; font-size: 18px;">لا توجد بيانات يومية متاحة لهذا الشهر</p>
    </div>
    @endif

    <!-- تذييل الصفحة -->
    <div style="text-align: center; margin-top: 50px; color: #7f8c8d; font-size: 12px; border-top: 1px solid #eee; padding-top: 10px;">
    تم إنشاء التقرير في {{ \Carbon\Carbon::now()->format('Y-m-d || A H:i') }} | &copy; {{ date('Y') }} {{ $center->second_name}} {{ $center->first_name }}
    </div>
    @else
    <div class="no-data">
        <p style="margin: 0; font-size: 18px;">لا توجد بيانات يومية متاحة لهذا الشهر</p>
    </div>
    @endif
</body>

</html>