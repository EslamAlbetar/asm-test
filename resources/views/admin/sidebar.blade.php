@php
$permissions = \App\Models\AuthedPage::where('user_id', auth()->id())->first();
@endphp

<!-- Sidebar Navigation-->
<nav id="sidebar" class="sidebarBox">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar">
            <img id="previewImage" src="{{ Auth::user()->image ? asset('staff_img/' . Auth::user()->image) : 'staff_img/1.png' }}"
                class="preview-image" alt="صورة المستخدم">

        </div>
        <div class="title">
            <h1 class="h5 text-capitalize">{{ auth()->user()->name }}</h1>
            <p class="parColor">
                {{ auth()->user()->usertype }}
            </p>


            @if($permissions->shift_start)
            @php
            $activeShift = auth()->user()->shifts()
            ->where('status', 'داخل الشيفت')
            ->latest()
            ->first();
            @endphp

            @if($activeShift)
            <!-- حالة وجود شيفت نشط - عرض العداد وزر الإنهاء -->
            <div id="shiftTimer" class="mt-2" style="text-align: center; font-size: 1.2rem;">
                <span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span>:<span id="milliseconds">00</span>
            </div>

            <form id="endShiftForm" class="mt-2">
                @csrf
                <button type="button" class="btn btn-danger btn-sm" style="width: 100%;" onclick="confirmEndShift()">
                    إنهاء الشيفت
                </button>
            </form>

            <script>
                // بدء العداد من 00:00:00:00
                function updateTimer() {
                    // استخدم التوقيت بصيغة ISO 8601 عشان JavaScript يفهمه
                    const serverStartTime = new Date('{{ \Carbon\Carbon::parse($activeShift->started_at)->toIso8601String() }}');
                    const now = new Date();

                    const diff = now - serverStartTime;

                    const hours = Math.floor(diff / (1000 * 60 * 60));
                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                    const milliseconds = Math.floor((diff % 1000) / 10);

                    if (document.getElementById('hours')) {
                        document.getElementById('hours').textContent = String(hours).padStart(2, '0');
                        document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
                        document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
                        document.getElementById('milliseconds').textContent = String(milliseconds).padStart(2, '0');
                    }
                }

                updateTimer();
                const timerInterval = setInterval(updateTimer, 10);

                function confirmEndShift() {
                    if (confirm('هل أنت متأكد من إنهاء الشيفت الحالي؟')) {
                        endShift();
                    }
                }

                function endShift() {
                    clearInterval(timerInterval);

                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route("shift.end") }}', {
                        method: 'POST',
                        body: formData
                    }).then(response => {
                        if (response.ok) {
                            window.location.reload();
                        } else {
                            console.error("فشل في إنهاء الشيفت");
                        }
                    }).catch(err => {
                        console.error("خطأ في الاتصال:", err);
                    });
                }
            </script>
            @else
            <!-- حالة عدم وجود شيفت نشط - عرض زر البدء -->
            <form id="startShiftForm" class="mt-2">
                @csrf
                <button type="button" class="btn btn-success btn-sm" style="width: 100%;" onclick="startShift()">
                    بداية الشيفت
                </button>
            </form>

            <script>
                function startShift() {
                    if (confirm('هل أنت متأكد من بدء الشيفت الجديد؟')) {
                        fetch('{{ route("shift.start") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        }).then(response => {
                            if (response.ok) {
                                window.location.reload();
                            }
                        });
                    }
                }
            </script>
            @endif
            @endif
        </div>
    </div>

    <!-- Sidebar Navidation Menus-->
    <span class="heading"></span>

    <ul class="list-unstyled">

        @if($permissions->admin_dashboard)
        <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ url('/admin/dashboard') }}">
                <i class="icon-home"></i> Home
            </a>
        </li>
        @endif


        @if($permissions->view_category)
        <li class="{{ Request::is('view_category') ? 'active' : '' }}"><a href="{{url('view_category')}}">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                All Categories
            </a></li>
        @endif

        @if($permissions->add_patient_admin)
        <li class="{{ Request::is('add_patient_admin') ? 'active' : '' }}"><a href="{{url('add_patient_admin')}}"> <i class="fa fa-address-book-o" aria-hidden="true"></i>Add Patient</a></li>
        @endif

        @php
        // تحديد الـ CSS class حسب العدد
        $wlColorClass = '';
        if ($waitingListCount <= 5) $wlColorClass='badge-green' ;
            elseif ($waitingListCount <=10) $wlColorClass='badge-blue' ;
            elseif ($waitingListCount <=15) $wlColorClass='badge-purple' ;
            elseif ($waitingListCount <=20) $wlColorClass='badge-orange' ;
            else $wlColorClass='badge-red' ;
            @endphp

            @if($permissions->waiting_list_admin)
            <li class="{{ Request::is('waiting_list_admin') ? 'active' : '' }}">
                <a href="{{ url('waiting_list_admin') }}">
                    <i class="fa fa-list" aria-hidden="true"></i>
                    Waiting List
                    @if(isset($waitingListCount) && $waitingListCount > 0)
                    <span id="waiting-count" class="glow-badge {{ $wlColorClass }}">
                        {{ $waitingListCount }}
                    </span>
                    @endif
                </a>
            </li>
            @endif

            @if($permissions->total_patients_admin)
            <li class="{{ Request::is('total_patients_admin') ? 'active' : '' }}"><a href="{{url('/total_patients_admin')}}"> <i class="fa-regular fa-address-book"></i>All Patients</a></li>
            @endif

            @if($permissions->writing_report)
            <li class="{{ Request::is('writing_report') ? 'active' : '' }}"><a href="{{url('writing_report')}}"> <i class="fa-regular fa-file-word" aria-hidden="true"></i>Writing reports </a></li>
            @endif

            @if($permissions->center_devices)
            <li class="{{ Request::is('center_devices') ? 'active' : '' }}"><a href="{{url('center_devices')}}"> <i class="fa fa-star" aria-hidden="true"></i>Center devices </a></li>
            @endif

            @if($permissions->donations_admin)
            <li class="{{ Request::is('donations_admin') ? 'active' : '' }}"><a href="{{url('donations_admin')}}"> <i class="fa fa-donate" aria-hidden="true"></i>
                    Donations </a></li>
            @endif

            @if($permissions->staff_team)
            <li class="{{ Request::is('staff_team') ? 'active' : '' }}">
                <a href="{{url('staff_team')}}">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    Staff Team
                    @if($hasUnsignedPermissions)
                    <span class="notification-badge">!</span>
                    @endif
                    @if($hasUnsignedVacations)
                    <span class="notification-badge">!</span>
                    @endif
                    @if($hasUnsigneddeductions)
                    <span class="notification-badge">!</span>
                    @endif
                </a>
            </li>
            @endif

            @if($permissions->bills_admin)
            <li class="{{ Request::is('bills_admin') ? 'active' : '' }}"><a href="{{url('bills_admin')}}"><i class="fa-solid fa-receipt" aria-hidden="true"></i>New Bills</a></li>
            @endif

            @if($permissions->all_bills)
            <li class="{{ Request::is('all_bills') ? 'active' : '' }}"><a href="{{url('all_bills')}}"><i class="fa-solid fa-clipboard-list" aria-hidden="true"></i>All Bills</a></li>
            @endif

            @if($permissions->total_items_admin)
            <li class="{{ Request::is('total_items_admin') ? 'active' : '' }}"><a href="{{url('total_items_admin')}}"><i class="fa-solid fa-sitemap" aria-hidden="true"></i>Total items</a></li>
            @endif

            @if($permissions->parteners)
            <li class="{{ Request::is('parteners') ? 'active' : '' }}"><a href="{{url('parteners')}}"><i class="fa-regular fa-handshake" aria-hidden="true"></i>Parteners</a></li>
            @endif

            @if($permissions->profit)
            <li class="{{ Request::is('profit') ? 'active' : '' }}"><a href="{{url('profit')}}"><i class="fa fa-money" aria-hidden="true"></i>Profits</a></li>
            @endif

            @if($permissions->financial_accounting)
            <li class="{{ Request::is('financial_accounting') ? 'active' : '' }}"><a href="{{url('financial_accounting')}}"><i class="fa-solid fa-calculator" aria-hidden="true"></i>Financial Accounting</a></li>
            @endif

            <hr>
            @if($permissions->profile_user)
            <li class="{{ Request::is('profile_user') ? 'active' : '' }}"><a href="{{url('profile_user')}}"><i class="fa fa-user" aria-hidden="true"></i>Profile User</a></li>
            @endif

    </ul>

</nav>
<!-- Sidebar Navigation end-->