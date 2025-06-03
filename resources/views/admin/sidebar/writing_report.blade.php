<!DOCTYPE html>
<html>

<head>
    @include('admin.css')

    <style>
        /* تنسيق عام للصفحة */
        .page-content {
            background-color: #f9f9f9;
            padding: 20px 10px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        /* عنوان الصفحة */
        .page-header h1 {
            font-size: clamp(22px, 5vw, 28px);
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        /* تنسيق الفورم */
        .forms {
            margin-top: 15px;
            background-color: #fff;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        /* العناصر داخل الفورم */
        .forms .form-label {
            font-weight: 600;
            color: #444;
            font-size: clamp(14px, 2vw, 16px);
            margin-bottom: 5px;
        }

        .forms .form-select,
        .forms .form-control,
        .forms .btn {
            border-radius: 8px;
            padding: 8px 12px;
            font-size: clamp(14px, 2vw, 16px);
            width: 100%;
        }

        /* زر الفلترة */
        .forms .btn-primary {
            font-size: clamp(16px, 2.5vw, 18px);
            padding: 8px 20px;
            background-color: #007bff;
            border: none;
            font-weight: bold;
            margin-top: 10px;
        }

        .forms .btn-primary:hover {
            background-color: #0056b3;
        }

        /* تنسيق الجدول */
        .dev_deg {
            overflow-x: auto;
            margin-top: 25px;
            -webkit-overflow-scrolling: touch;
        }

        .dev_deg table {
            width: 100%;
            min-width: 600px;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .dev_deg th,
        .dev_deg td {
            padding: 10px 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
            font-size: clamp(12px, 2vw, 14px);
        }

        .dev_deg th {
            background-color: #f0f0f0;
            font-weight: bold;
            color: #333;
            white-space: nowrap;
        }

        /* صفوف الجدول بالتناوب */
        .dev_deg tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* تنسيق البادجز */
        .badge {
            margin: 0 2px;
            font-size: clamp(10px, 2vw, 12px);
            padding: 4px 8px;
            border-radius: 20px;
            display: inline-block;
        }

        /* أزرار داخل الجدول */
        .btn {
            font-size: clamp(12px, 2vw, 14px);
            transition: 0.3s ease;
            padding: 6px 10px;
            margin: 2px;
            white-space: nowrap;
        }

        .btn:hover {
            transform: scale(1.03);
        }

        /* زر الطباعة */
        .btn-success {
            background-color: #28a745;
            border: none;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        /* زر التعديل */
        .btn-warning {
            background-color: #ffc107;
            border: none;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        /* زر كتابة التقرير */
        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        /* روابط الصفحات */
        .pagination {
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .pagination .page-item {
            margin: 3px;
        }

        .pagination .page-link {
            color: #007bff;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: clamp(12px, 2vw, 14px);
        }

        .pagination .active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        /* استجابة الشاشة للجوال */
        @media (max-width: 576px) {
            .page-content {
                padding: 15px 5px;
            }

            .forms {
                padding: 12px;
            }

            .forms .row>div {
                margin-bottom: 10px;
            }

            .dev_deg th,
            .dev_deg td {
                padding: 8px 2px;
                width: 120% !important;
            }

            .btn {
                padding: 5px 8px;
                margin: 2px 1px;
            }
        }

        /* استجابة الشاشة للأجهزة اللوحية */
        @media (min-width: 577px) and (max-width: 992px) {
            .forms {
                padding: 18px;
            }

            .forms .row>div {
                margin-bottom: 12px;
            }
        }

        /* استجابة الشاشة للشاشات الكبيرة */
        @media (min-width: 993px) {
            .page-content {
                padding: 30px 20px;
            }

            .forms {
                padding: 25px;
            }

            .forms .row>div {
                margin-bottom: 15px;
            }
        }
    </style>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <div class="page-content">
        <div class="page-header">
            @php
            $permissions = \App\Models\AuthedPage::where('user_id', auth()->id())->first();
            @endphp

            <div class="container-fluid">
                @if($permissions->writing_report)


                <h1>Reports Patients</h1>

                <form class="forms" method="GET" action="{{ url()->current() }}" class="mb-3 row g-2 align-items-end">
                    <div class="col-auto">
                        <label for="report" class="form-label">Select Status Filter:</label>
                        <select name="report" id="report" class="form-select" onchange="this.form.submit()">
                            <option value="not_complete" {{ request('report', 'not_complete') == 'not_complete' ? 'selected' : '' }}>Not Complete</option>
                            <option value="complete" {{ request('report') == 'complete' ? 'selected' : '' }}>Complete</option>
                        </select>
                    </div>

                    <div class="col-auto">
                        <label for="year" class="form-label">Select Year Filter:</label>
                        <select name="year" id="year" class="form-select">
                            <option value="">Select Year</option>
                            @foreach($years as $y)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-auto">
                        <label for="quarter" class="form-label">Select Quarter Filter:</label>
                        <select name="quarter" id="quarter" class="form-select">
                            <option value="">Select Quarter</option>
                            <option value="1" {{ request('quarter') == '1' ? 'selected' : '' }}>Months 1 - 3</option>
                            <option value="2" {{ request('quarter') == '2' ? 'selected' : '' }}>Months 4 - 6</option>
                            <option value="3" {{ request('quarter') == '3' ? 'selected' : '' }}>Months 7 - 9</option>
                            <option value="4" {{ request('quarter') == '4' ? 'selected' : '' }}>Months 10 - 12</option>
                        </select>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-lg">Filter</button>
                    </div>
                </form>

                <div class="dev_deg">

                    <table>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Positions</th>
                            <th>Date / Time</th>
                            <th>Status Reports</th>
                            <th>Update</th>
                        </tr>

                        @foreach($patients as $patient)
                        <tr>
                            <td>{{ $loop->iteration + ($patients->currentPage() - 1) * $patients->perPage() }}</td>

                            <td>{{$patient->full_name}}</td>
                            <td class="text-capitalize">
                                ({{ $patient->category_name ?? 'غير محدد' }})

                                @forelse($patient->position_names as $posi)
                                <span class="badge bg-info text-dark">{{ $posi }}</span>
                                @empty
                                <span class="text-muted">غير محدد</span>
                                @endforelse

                            </td>

                            <td>{{ $patient->created_at->format('Y/m/d - h:i A') }}</td>

                            @if($patient->report === 'complete')
                            <td class="bg-success text-center">
                                <a href="{{ route('print.report', $patient->id) }}" class="btn btn-success shadow-sm px-4 py-2 rounded">
                                    🖨️ Print PDF
                                </a>
                            </td>
                            @else
                            <td class="bg-danger text-center">
                                @php
                                $permissions = \App\Models\AuthedPage::where('user_id', auth()->id())->first();
                                @endphp
                                @if($permissions->write_report_now)
                                <a href="{{ url('write_report_now', $patient->id) }}" class="btn btn-danger shadow-sm px-4 py-2 rounded">
                                    ✍️ Write Now
                                </a>
                                @endif
                            </td>
                            @endif

                            @if($patient->report === 'complete')
                            <td class="bg-success text-center">
                                <a href="{{ url('update_write_report', $patient->id) }}" class="btn btn-warning shadow-sm px-4 py-2 rounded">
                                    Update
                                </a>
                            </td>
                            @else
                            <td class="bg-danger text-light text-center">
                                Not written
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </table>

                </div>
                <!-- روابط الصفحات -->
                <div class="mt-4 d-flex justify-center dev_deg">
                    {{ $patients->links() }}
                </div>

            </div>

            @else
            <h2 class="text-danger text-center">! لا تملك صلاحيات للدخول لهذه الصفحة</h2>
            @endif

        </div>
        <!-- JavaScript files-->
        @include('admin.js')
    </div>
</body>

</html>