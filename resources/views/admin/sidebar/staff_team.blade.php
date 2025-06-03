<!DOCTYPE html>
<html>

<head>
    @include('admin.css')

    <style>
        .dev_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 60px;
        }

        .cards_box {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: row;
            flex-wrap: wrap;
            margin: 0 10px;
        }

        h2 {
            display: flex;
            justify-content: center;
            margin-bottom: 60px;
            margin-top: 40px;
            font-size: 64px !important;
        }

        /* From Uiverse.io by narmesh_sah */
        .profile-card {
            position: relative;
            width: 320px;
            background: rgba(255, 255, 255, 0.9);
            -webkit-backdrop-filter: blur(48px);
            backdrop-filter: blur(48px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 12px 12px 12px -20px rgba(0, 0, 0, 0.3);
            transform: perspective(1000px) scale(0.8);
            /*adjust the scale to view properly*/
            transform-style: preserve-3d;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: #f0f2f5;
            margin: 0 auto 1rem;
            overflow: hidden;
            border: 3px solid white;
            box-shadow: 0px 0px 6px rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-image img {
            width: 150px;
            height: 150px;
        }

        .profile-image::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 96px;
            background-color: #7d988a;
            border-radius: 20px 20px 0 0;
            z-index: -1;
        }

        .profile-info {
            text-align: left;
            margin-bottom: 1.5rem;
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 0.25rem;
            text-transform: capitalize;
            text-align: center;
        }

        .profile-title {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
        }

        .social-links {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .social-links p {
            text-align: center;
            margin: auto;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: #f0f2f5;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .social-btn:hover {
            background: #e4e6e9;
            transform: translateY(-6px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .social-btn img {
            width: 20px;
            height: 20px;
            fill: #1a1a1a;
            transition: all 0.2s ease;
        }

        .cta-button {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 10px;
            background: #7d988a;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition:
                transform 0.2s,
                background 0.2s;
            text-align: center;
        }

        .cta-button:hover {
            background: #4d5d54;
            transform: translateY(-2px);
        }

        .stats {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-weight: 600;
            color: #1a1a1a;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #666;
        }

        .btns {
            gap: 10px;
        }

        a {
            text-decoration: none !important;
            color: white !important;
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

                @if($permissions->staff_team)

                <!-- From Uiverse.io by itsavicreation -->
                <h2 class="h1">Staff Team</h2>

                @if($permissions->add_user_type)
                <div class="text-center mt-4 mb-4">
                    <a href="{{ url('add_user_type') }}" class="btn btn-lg bg-success">اضافة صلاحيات المستخدمين</a>
                </div>
                @endif

                @foreach ($user as $users)

                <div class="cards_box">

                    @php
                    $hasMissingSignature = $users->permissions->whereNull('signature')->count() > 0;
                    $hasMissingVacation = $users->vacations->whereNull('signature')->count() > 0;
                    $hasMissingdeduction = $users->deductions->whereNull('signature_objection_admin')->count() > 0;
                    @endphp

                    <div class="profile-card {{ $hasMissingSignature ? 'alert-border' : '' }} {{ $hasMissingVacation ? 'alert-border' : '' }} {{ $hasMissingdeduction ? 'alert-border' : '' }}">
                        @if($hasMissingSignature)
                        <div class="alert-icon fa-regular fa-bell"></div>
                        @endif

                        @if($hasMissingVacation)
                        <div class="alert-icon fa-regular fa-bell"></div>
                        @endif

                        @if($hasMissingdeduction)
                        <div class="alert-icon fa-regular fa-bell"></div>
                        @endif

                        <div class="profile-image">
                            <img src="{{ $users->image ? asset('staff_img/' . $users->image) : asset('staff_img/1.png') }}"
                                class="staff-image"
                                alt="صورة {{ $users->name }}"
                                title="{{ $users->name }}">
                        </div>
                        <div class="profile-info">
                            <p class="profile-name">{{ $users->name }}</p>
                            <div class="profile-title text-danger">{{ $users->usertype }}</div>



                            <div class="profile-title 
        @if($users->lastShift)
            @if($users->lastShift->status == 'داخل الشيفت')
                text-success
            @elseif($users->lastShift->status == 'انتهى الشيفت')
                text-secondary
            @else
                text-muted
            @endif
        @endif
    ">
                                @if($users->lastShift)
                                @if($users->lastShift->status == 'داخل الشيفت')
                                On shift
                                @elseif($users->lastShift->status == 'انتهى الشيفت')
                                off-duty
                                @else
                                {{ $users->lastShift->status }}
                                @endif
                                @else
                                not logged on shifts
                                @endif
                            </div>







                        </div>
                        <div class="social-links">
                            <p class="text-dark">Tel: {{ $users->phone }}</p>
                        </div>
                        <div class="d-flex btns">
                            @if($permissions->update_staff)
                            <a class="cta-button" href="{{ url('update_staff', $users->id) }}">Update</a>
                            @endif

                            @if($permissions->details_staff)
                            <a class="cta-button bg-info {{ $hasMissingSignature ? 'alert-button' : '' }} " href="{{ url('details_staff', $users->id) }}">Details</a>
                            @endif

                            @if($permissions->delete_staff)
                            <a class="cta-button bg-danger" onclick="confirmation(event)" href="{{ url('delete_staff', $users->id) }}">Delete</a>
                            @endif
                        </div>
                    </div>


                    @endforeach


                    <div class="dev_deg">
                        {{ $user->links() }}
                    </div>



                </div>

            </div>
        </div>
    </div>
    </div>
    <!-- JavaScript files-->
    @include('admin.js')
    </div>

    <script>
        function confirmation(event) {
            event.preventDefault(); // نوقف تنفيذ الرابط الافتراضي
            let urlToRedirect = event.currentTarget.getAttribute('href'); // نجيب الرابط

            if (confirm('هل أنت متأكد من حذف هذا الحساب؟')) {
                // لو وافق المستخدم على الحذف
                window.location.href = urlToRedirect; // نروح للرابط (يتم الحذف)
            }
            // لو ضغط الغاء، مفيش حاجة تحصل
        }
    </script>
    @else
    <h2 class="text-danger text-center">! لا تملك صلاحيات للدخول لهذه الصفحة</h2>
    @endif
</body>

</html>