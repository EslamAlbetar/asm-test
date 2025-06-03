<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>تقرير يومي - {{ $center->first_name }}{{ $center->second_name}}</title>
    <style>
        body {
            margin: 20px;
            color: #333;
            background: #fff;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-family: 'Cairo', sans-serif;
            color: #2c3e50;
            font-size: 32px;
            margin-bottom: 5px;
        }

        .header h2 {
            color: #4a6fdc;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .report-date {
            font-size: 16px;
            color: #555;
            margin-top: 10px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h3 {
            text-align: center;
            background-color: #4a6fdc;
            color: white;
            padding: 8px 0;
            margin-bottom: 15px;
            border-radius: 8px;
            font-size: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table thead {
            background: #f1f5ff;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        .total-row td {
            font-weight: bold;
            background-color: #e8f0ff;
        }

        .no-data {
            text-align: center;
            padding: 15px;
            background: #f8d7da;
            color: #721c24;
            border-radius: 8px;
        }

        .summary-box {
            border: 2px solid #4a6fdc;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
            background: #f1f5ff;
        }

        .summary-box h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .summary-value {
            font-weight: bold;
        }

        .net-profit {
            background: #e0f7e9;
            padding: 10px;
            border-radius: 8px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 40px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>

</head>

<body>
    <div class="header">
        @php
        $permissions = \App\Models\AuthedPage::where('user_id', auth()->id())->first();
        @endphp


        @if($permissions->profit)



        <h1>{{ $center->first_name }} {{ $center->second_name}}</h1>
        <h2>تقرير يومي</h2>
        <div class="report-date">تاريخ التقرير: {{ \Carbon\Carbon::parse($carbonDate)->format('Y-m-d') }}</div>
    </div>

    <!-- قسم المرضى -->
    <div class="section">
        <h3>المدخلات (المرضى)</h3>
        @if(count($patients) > 0)
        <table>
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>الهاتف</th>
                    <th>العنوان</th>
                    <th>الفئة</th>
                    <th>المبلغ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->full_name ?? 'غير مسجل' }}</td>
                    <td>{{ $patient->phone ?? 'غير مسجل'}}</td>
                    <td>{{ $patient->address ?? 'غير مسجل'}}</td>
                    <td>{{ $patient->categoryData->name ?? 'غير محدد' }}</td>
                    <td>{{ number_format($patient->finalPrice, 2) }} EGP</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="4">الإجمالي</td>
                    <td>{{ number_format($totalPatientsIncome, 2) }} EGP</td>
                </tr>
            </tbody>
        </table>
        @else
        <div class="no-data">لا يوجد مرضى اليوم</div>
        @endif
    </div>

    <!-- قسم التبرعات -->
    <div class="section">
        <h3>المدخلات (التبرعات)</h3>
        @if(count($donations) > 0)
        <table>
            <thead>
                <tr>
                    <th>اسم المتبرع</th>
                    <th>الهاتف</th>
                    <th>العنوان</th>
                    <th>المبلغ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donations as $donation)
                <tr>
                    <td>{{ $donation->name ?? 'غير مسجل' }}</td>
                    <td>{{ $donation->phone ?? 'غير مسجل'}}</td>
                    <td>{{ $donation->address ?? 'غير مسجل'}}</td>
                    <td>{{ number_format($donation->amount, 2) }} EGP</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3">الإجمالي</td>
                    <td>
                        {{ number_format($donations->sum(function($donation) {
        return is_numeric(optional($donation)->amount) ? (float) $donation->amount : 0;
    }), 2) }} EGP
                    </td>
                </tr>

            </tbody>
        </table>
        @else
        <div class="no-data">لا يوجد تبرعات اليوم</div>
        @endif
    </div>

    <!-- قسم المصروفات -->
    <div class="section">
        <h3>المخرجات (الفواتير)</h3>
        @if(count($items) > 0)
        <table>
            <thead>
                <tr>
                    <th>اسم الصنف</th>
                    <th>القسم</th>
                    <th>الكمية</th>
                    <th>السعر الإجمالي</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->name ?? 'غير محدد' }}</td>
                    <td>{{ $item->category ?? 'غير محدد' }}</td>
                    <td>{{ $item->required_quantity ?? 'غير محدد' }}</td>
                    <td>{{ $item->price }} EGP</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3">الإجمالي</td>
                    <td>{{ number_format($items->sum(function($item) {
                        return is_numeric($item->price) ? (float) $item->price : 0;
                    }), 2) }} EGP</td>
                </tr>
            </tbody>
        </table>
        @else
        <div class="no-data">لا توجد فواتير اليوم</div>
        @endif
    </div>

    <!-- ملخص الأرباح -->
    <div class="summary-box">
        <h3>ملخص الأرباح اليومية</h3>

        <div class="summary-item">
            <span>مدخلات المرضى:</span>
            <span class="summary-value">{{ number_format($totalPatientsIncome, 2) }} EGP</span>
        </div>

        <div class="summary-item">
            <span>مدخلات التبرعات:</span>
            <span class="summary-value">{{ number_format($totalDonations, 2) }} EGP</span>
        </div>

        <hr style="border-top: 1px dashed #ccc; margin: 10px 0;">


        <div class="summary-item">
            <span><strong>إجمالي المدخلات:</strong></span>
            <span class="summary-value"><strong>{{ number_format((float)$totalInputs, 2) }} EGP</strong></span>
        </div>

        <div class="summary-item">
            <span><strong>إجمالي المخرجات:</strong></span>
            <span class="summary-value"><strong>{{ number_format((float)$totalPayments, 2) }} EGP</strong>
            </span>
        </div>

        <div class="summary-item net-profit" style="margin-top: 10px;">
            <span><strong>صافي الأرباح:</strong></span>
            <span class="summary-value {{ $netProfit < 0 ? 'negative' : '' }}">
                <strong>{{ number_format((float)$netProfit, 2) }} EGP</strong>
            </span>
        </div>
    </div>

    <div class="footer" style="margin-top: 30px;">
        تم إنشاء التقرير في {{ \Carbon\Carbon::now()->format('Y-m-d || A H:i') }} | &copy; {{ date('Y') }} {{ $center->second_name}} {{ $center->first_name }}
    </div>
    @else
    <div class="no-data">
        <p style="margin: 0; font-size: 18px;">لا توجد بيانات يومية متاحة لهذا الشهر</p>
    </div>
    @endif
</body>



</html>