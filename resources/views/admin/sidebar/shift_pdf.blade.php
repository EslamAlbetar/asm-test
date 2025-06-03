<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>تقرير ساعات العمل</title>
    <style>
        body {
            font-family: 'aealarabiya', sans-serif;
            direction: rtl;
            text-align: right;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #3490dc;
        }

        .header h1 {
            color: #2d3748;
            font-size: 20px;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 12px;
        }

        th {
            background-color: #f0f7ff;
            color: #2d3748;
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }

        td {
            padding: 6px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 11px;
        }

        .badge-active {
            background-color: #dbeafe;
            color: #1d4ed8;
        }

        .badge-completed {
            background-color: #dcfce7;
            color: #166534;
        }

        .badge-unknown {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        .footer {
            margin-top: 20px;
            font-size: 10px;
            color: #666;
            text-align: left;
        }
    </style>

    <!-- تنسيق العربي والانجليزي -->
    <style>
        .mixed-direction {
            unicode-bidi: bidi-override;
            font-size: 18px;
            font-weight: 700;
        }

        .english-text {
            direction: ltr;
            display: inline-block;
        }

        .arabic-text {
            direction: rtl;
            display: inline-block;
        }
    </style>


</head>

<body>
    <div class="header">

        @php
        $permissions = \App\Models\AuthedPage::where('user_id', auth()->id())->first();
        @endphp

        @if($permissions->shift_admin)
        <h1>تقرير ساعات العمل للموظف</h1>
        <p style="text-align: center;">
            <span style="display: none">ش</span>
            <span class="mixed-direction">
                @if(preg_match('/[A-Za-z]/', $user->name))
                <span class="english-text">{{ $user->name }}</span>
                @else
                <span class="arabic-text">{{ $user->name }}</span>
                @endif
            </span>
        </p>
        <p style="text-align: center; english-text"> الشهر : {{ $month }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="15%">اليوم</th>
                <th width="25%">وقت البداية</th>
                <th width="25%">وقت النهاية</th>
                <th width="15%">المدة</th>
                <th width="20%">الحالة</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shifts as $shift)
            <tr>
                <td>{{ $shift->day }}</td>
                <td>{{ $shift->started_at ? \Carbon\Carbon::parse($shift->started_at)->format('Y-m-d H:i') : '-' }}</td>
                <td>{{ $shift->ended_at ? \Carbon\Carbon::parse($shift->ended_at)->format('Y-m-d H:i') : '-' }}</td>
                <td>{{ $shift->time ?? '-' }}</td>
                <td>
                    @if($shift->status == 'داخل الشيفت')
                    <span class="badge badge-active">{{ $shift->status }}</span>
                    @elseif($shift->status == 'انتهى الشيفت')
                    <span class="badge badge-completed">{{ $shift->status }}</span>
                    @else
                    <span class="badge badge-unknown">{{ $shift->status ?? 'غير معروف' }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        تم إنشاء التقرير في: {{ now()->format('Y-m-d H:i') }}
    </div>

    @else
    <h2 class="text-danger text-center">! لا تملك صلاحيات للدخول لهذه الصفحة</h2>
    @endif
</body>

</html>