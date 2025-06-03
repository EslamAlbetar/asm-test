<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')

    <style>
        /* تنسيقات مربع البطاقات */
        .cards_box {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
            padding: 0 15px;
        }

        /* تنسيقات البطاقة */
        .card {
            width: 100%;
            background: linear-gradient(135deg, #ffffff 0%, #f9f9f9 100%);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15),
                0 0 10px rgba(255, 215, 0, 0.3);
            border: 1px solid rgba(255, 215, 0, 0.2);
        }

        .card__img {
            height: 100px;
            background: linear-gradient(45deg, #2c3e50, #4ca1af);
            position: relative;
            overflow: hidden;
        }

        .card__img::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg,
                    rgba(255, 255, 255, 0.1) 0%,
                    rgba(255, 255, 255, 0.3) 50%,
                    rgba(255, 255, 255, 0.1) 100%);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .card__avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 3px solid white;
            position: absolute;
            top: 65px;
            left: 50%;
            transform: translateX(-50%);
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
            background: white;
            z-index: 2;
        }

        .card__avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card__content {
            padding: 50px 15px 15px;
            text-align: center;
            position: relative;
            display: flex;
            flex-direction: column;
            height: calc(100% - 100px);
        }

        .card__title {
            font-size: clamp(1.2rem, 4vw, 1.5rem);
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card__phone {
            font-size: clamp(0.9rem, 3vw, 1.1rem);
            color: #4ca1af;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .card__subtitle {
            font-size: clamp(0.8rem, 3vw, 0.95rem);
            line-height: 1.5;
            color: #7f8c8d;
            margin-bottom: 15px;
        }

        .card__wrapper {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: auto;
            flex-wrap: wrap;
        }

        .card__wrapper a {
            padding: 6px 15px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            font-size: clamp(0.7rem, 3vw, 0.9rem);
        }

        .card__wrapper a:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* تأثيرات التوهج عند التحويم */
        .card:hover .card__img {
            background: linear-gradient(45deg, #4CA1AF, #2C3E50);
        }

        /* تنسيقات زر الإضافة */
        .text-center .btn-danger {
            background: linear-gradient(45deg, #e74c3c, #c0392b);
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 3px 12px rgba(231, 76, 60, 0.3);
            transition: all 0.3s ease;
            padding: 8px 20px;
            font-size: clamp(0.9rem, 3vw, 1rem);
            margin: 15px auto;
            display: inline-block;
        }

        .text-center .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(231, 76, 60, 0.4);
        }

        /* استجابة الشاشة للجوال الصغير */
        @media (max-width: 400px) {
            .cards_box {
                grid-template-columns: 1fr;
            }

            .card__img {
                height: 90px;
            }

            .card__avatar {
                width: 60px;
                height: 60px;
                top: 60px;
            }

            .card__content {
                padding: 45px 10px 10px;
            }

            .card__wrapper {
                gap: 8px;
            }

            .card__wrapper a {
                padding: 5px 12px;
            }
        }

        /* استجابة الشاشة للأجهزة اللوحية */
        @media (min-width: 768px) and (max-width: 1024px) {
            .cards_box {
                grid-template-columns: repeat(2, 1fr);
                gap: 25px;
            }
        }

        /* استجابة الشاشة للشاشات الكبيرة */
        @media (min-width: 1025px) {
            .cards_box {
                grid-template-columns: repeat(3, 1fr);
                gap: 30px;
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
                <!-- زر الإضافة -->

                @if($permissions->center_devices)
                <div class="text-center">
                    <a href="{{url('add_device')}}" class="btn btn-danger mb-4 px-5 py-3 rounded">Add Device</a>
                </div>
                @endif

                <div class="search-container">
                    <form method="GET" action="{{ url()->current() }}" class="search-form">
                        <input
                            type="text"
                            name="search"
                            placeholder="Search by Device name or Model or Serial number..."
                            class="search-input">
                        <button type="submit" class="search-btn">
                            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            Search
                        </button>
                    </form>
                </div>

                <!-- عرض الكروت -->
                <div class="cards_box">
                    @foreach ($devices as $device)
                    <div class="card">
                        <div class="card__img"></div>

                        <!-- الصورة الرمزية -->
                        <div class="card__avatar">
                            <img src="{{url('staff_img/3.jpg')}}" alt="Device Image">
                        </div>

                        <div class="card__content">
                            <div class="card__title">{{ $device->device_name }}</div>
                            <div class="card__subtitle mt-2 text-secondary">Last Maintenance: <span class="text-primary"> {{ $device->last_maintenance_date }} ({{ $device->last_maintenance_price }})
                                </span>
                            </div>

                            <div class="card__subtitle mt-2 mb-3 text-dark">
                                Total Price with Maintenance:
                                <span class="text-success">{{ number_format($device->total_final_price, 2) }} EGP</span>
                            </div>

                            <div class="card__wrapper">
                                <a class="btn btn-success text-white" href="{{url('device_details', $device->id)}}">Details</a>
                                <a class="btn btn-danger text-white" onclick="confirmation(event)" href="{{url('delete_device', $device->id)}}">Delete</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>

        @include('admin.js')
        <script>
            function confirmation(event) {
                event.preventDefault(); // يمنع التحويل التلقائي

                const url = event.currentTarget.getAttribute('href'); // يجيب اللينك

                if (confirm('هل أنت متأكد أنك تريد حذف هذا الجهاز؟')) {
                    // لو وافق، يحول على اللينك
                    window.location.href = url;
                }
            }
        </script>
    </div>
    @else
    <div class="no-data">
        <p style="margin: 0; font-size: 18px;">لا تملك صلاحية الوصول للصفحة</p>
    </div>
    @endif
</body>

</html>