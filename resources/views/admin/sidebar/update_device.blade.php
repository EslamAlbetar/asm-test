<!DOCTYPE html>
<html>

<head>
    @include('admin.css')

    <style>
        /* التصميم العام */
        .page-content {
            padding: 2rem;
            background-color: #f8fafc;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .container-fluid {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        h1 {
            color: #2d3748;
            font-size: 1.8rem;
            margin-bottom: 2rem;
            font-weight: 600;
            text-align: center;
            position: relative;
            padding-bottom: 0.75rem;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #4f46e5, #8b5cf6);
            border-radius: 3px;
        }

        /* تصميم النموذج */
        .dev_deg {
            background-color: white;
            border-radius: 12px;
            padding: 0;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .input_deg {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        label {
            color: #4a5568;
            font-size: 0.95rem;
            font-weight: 500;
            margin-left: 0.5rem;
        }

        input[type="text"],
        input[type="file"],
        select {
            padding: 0.85rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        input[type="text"]:focus,
        select:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.15);
            background-color: white;
        }

        /* تصميم الأزرار */
        .btn-sub {
            padding: 0.85rem 1.75rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-success {
            background-color: #10b981;
            color: white;
        }

        .btn-success:hover {
            background-color: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .btn-danger {
            background-color: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background-color: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        /* تصميم مجموعة الأزرار */
        form>div:last-child {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            justify-content: flex-end;
        }

        /* تصميم القائمة المنسدلة */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%234a5568' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 12px;
            padding-right: 2.5rem;
        }

        /* تصميم متجاوب */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 1.5rem;
            }

            form>div:last-child {
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

                @if($permissions->update_device)

                <h1>Update Device </h1>
                <div class="dev_deg">
                    <form action="{{url('edit_device', $devices->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="input_deg">
                            <label class="">Device Name</label>
                            <input type="text" name="device_name" value="{{$devices->device_name}}">
                        </div>

                        <div class="input_deg">
                            <label class="">Device Model</label>
                            <input type="text" name="device_model" value="{{$devices->device_model}}">
                        </div>

                        <div class="input_deg">
                            <label class="">Device Serial</label>
                            <input type="text" name="device_serial" value="{{$devices->device_serial}}">
                        </div>

                        <div class="input_deg">
                            <label class="">Device Status</label>
                            <select require name="device_get_status">
                                @php
                                $status = strtolower($devices->device_get_status); // نخليها lowercase للمقارنة
                                @endphp

                                @if($status !== 'new' && $status !== 'used')
                                <option value="{{ $devices->device_get_status }}" selected>{{ $devices->device_get_status }}</option>
                                @endif

                                <option value="new" {{ $status === 'new' ? 'selected' : '' }}>New</option>
                                <option value="used" {{ $status === 'used' ? 'selected' : '' }}>Used</option>
                            </select>
                        </div>

                        <div class="input_deg">
                            <label class="">Price Device</label>
                            <input type="text" name="price_device" value="{{$devices->price_device}}">
                        </div>

                        <div class="input_deg">
                            <label class="">Device Image</label>
                            <input type="file" name="device_image" value="{{$devices->device_image}}">
                        </div>


                        <div>
                            <input class="btn btn-success btn-sub" type="submit" value="Confirm Device">
                            <a class="btn btn-danger btn-sub" type="submit" href="{{url('/center_devices')}}">Cancel</a>

                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- JavaScript files-->
        @include('admin.js')
    </div>

    @else
    <h2 class="text-danger text-center">! لا تملك صلاحيات للدخول لهذه الصفحة</h2>
    @endif
</body>

</html>