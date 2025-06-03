<!DOCTYPE html>
<html>

<head>
    @include('admin.css')

    <style>
        .device-details-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* عنوان الصفحة */
        .device-details-container h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
            font-weight: 600;
        }

        /* تنسيق كل عنصر بيانات */
        .dev_deg {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input_deg {
            display: flex;
            flex-direction: column;
            padding: 15px;
            background: #f8fafc;
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
            transition: all 0.3s ease;
            width: 100%;
        }

        .input_deg:hover {
            background: #f1f5f9;
            transform: translateY(-2px);
        }

        .input_deg label:first-child {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 100%;
        }

        .input_deg label.text-primary {
            font-size: 1.1rem;
            color: #1e40af !important;
            font-weight: 600;
            width: 100%;

        }

        /* تنسيق الأزرار */
        .dev_deg>div:last-child {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            justify-content: center;
        }

        .btn-sub {
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border: none;
            min-width: 180px;
            text-align: center;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white !important;
            display: flex;
            justify-content: center;
        }

        .btn-sub:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        /* تأثيرات للقيم المالية */
        .input_deg label.text-primary[style*="color:var(--bs-primary)"] {
            font-size: 1.2rem;
            color: #065f46 !important;
        }

        /* تنسيق صورة الجهاز */
        .input_deg:has(label.text-primary:contains(".jpg")) {
            align-items: center;
        }

        .input_deg:has(label.text-primary:contains(".jpg")) label.text-primary {
            display: inline-block;
            padding: 10px;
            background: #f1f5f9;
            border-radius: 8px;
        }

        /* للشاشات الصغيرة */
        @media (max-width: 768px) {
            .device-details-container {
                padding: 20px;
                margin: 15px;
            }

            .dev_deg>div:last-child {
                flex-direction: column;
            }

            .btn-sub {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">

            @php
            $permissions = \App\Models\AuthedPage::where('user_id', auth()->id())->first();
            @endphp

            @if($permissions->center_devices)
                <div class="device-details-container">
                    <h1>Details Device </h1>
                    <div class="dev_deg">

                        <div class="input_deg">
                            <label class="">Device Name & (Type)</label>
                            <label class="text-primary">{{$device->device_name}}</label>
                        </div>

                        <div class="input_deg">
                            <label class="">Device Model</label>
                            <label class="text-primary">{{$device->device_model}}</label>
                        </div>

                        <div class="input_deg">
                            <label class="">Device Serial</label>
                            <label class="text-primary">{{$device->device_serial}}</label>
                        </div>

                        <div class="input_deg">
                            <label class="">Device Status</label>
                            <label class="text-primary">{{$device->device_get_status}}</label>
                        </div>

                        <div class="input_deg">
                            <label class="">Purchase Date</label>
                            <label class="text-primary">{{$device->purchase_date}}</label>
                        </div>

                        <div class="input_deg">
                            <label class="">Price Device</label>
                            <label class="text-primary">{{$device->price_device}} EGP</label>
                        </div>


                        <div class="input_deg">
                            <label class="">Last Maintenance</label>
                            <label class="text-primary">{{ $lastMaintenanceDate }}</label>
                        </div>

                        <div class="input_deg">
                            <label class="">Price Maintenance</label>
                            <label class="text-primary">{{ $lastMaintenancePrice }}</label>
                        </div>

                        <div class="input_deg">
                            <label class="">Total Final Price</label>
                            <label class="text-primary">{{ number_format($totalFinalPrice,) }} EGP</label>
                        </div>


                        <div class="input_deg">
                            <label class="">Device Image</label>
                            <label class="text-primary">{{$device->device_image ?? " لم يتم تحميل صورة للجهاز"}}</label>
                        </div>



                        <div>
                            <a class="btn btn-success btn-sub" type="submit" href="{{url('update_device', $device->id)}}">Update Device</a>
                            <a class="btn btn-warning btn-sub" type="submit" href="{{url('/center_devices')}}">Back</a>

                        </div>


                    </div>
                </div>
            </div>
            <!-- JavaScript files-->
            @include('admin.js')
        </div>


        @else
        <div class="no-data">
            <p style="margin: 0; font-size: 18px;">لا توجد بيانات يومية متاحة لهذا الشهر</p>
        </div>
        @endif
</body>

</html>