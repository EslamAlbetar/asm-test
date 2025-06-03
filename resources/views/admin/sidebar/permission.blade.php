<!DOCTYPE html>
<html>

<head>
    @include('admin.css')

    <style>
        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out forwards;
        }

        .fade-out {
            animation: fadeOut 0.3s ease-in-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        /* تنسيق المودال الرئيسي */
        #vacationModal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-out;
        }

        #vacationModal:not(.hidden) {
            opacity: 1;
            visibility: visible;
        }

        /* تنسيق محتوى المودال */
        #vacationModal>div {
            width: 90%;
            max-width: 500px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            position: relative;
            transform: translateY(20px);
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        #vacationModal:not(.hidden)>div {
            transform: translateY(0);
        }

        /* تنسيق العنوان */
        #vacationModal h2 {
            color: #2d3748;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 600;
        }

        /* تنسيق حقول الإدخال */
        #vacationForm input,
        #vacationForm select,
        #vacationForm textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            margin-top: 0.25rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background-color: #f8fafc;
        }

        #vacationForm input:focus,
        #vacationForm select:focus,
        #vacationForm textarea:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
            background-color: white;
        }

        #vacationForm input:read-only {
            background-color: #edf2f7;
            cursor: not-allowed;
        }

        /* تنسيق التسميات */
        #vacationForm label {
            display: block;
            color: #4a5568;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        /* تنسيق زر الإرسال */
        #vacationForm button[type="submit"] {
            background: #38a169;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 1rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        #vacationForm button[type="submit"]:hover {
            background: #2f855a;
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* تنسيق زر الإغلاق */
        #closeModal {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #a0aec0;
            transition: color 0.2s ease;
            padding: 0.25rem;
            line-height: 1;
        }

        #closeModal:hover {
            color: #718096;
        }

        /* تنسيق الـ Spinner */
        #spinner {
            margin-left: 0.5rem;
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: translateY(-50%) rotate(0deg);
            }

            to {
                transform: translateY(-50%) rotate(360deg);
            }
        }

        /* تنسيق للشاشات الصغيرة */
        @media (max-width: 640px) {
            #vacationModal>div {
                width: 95%;
                padding: 1.5rem;
            }

            #vacationModal h2 {
                font-size: 1.3rem;
            }

            #vacationForm input,
            #vacationForm select,
            #vacationForm textarea {
                padding: 0.65rem 0.9rem;
            }
        }
    </style>

    <style>
        /* تنسيق عام للصفحة */
        body {
            background-color: #f8fafc;
        }

        /* تنسيق الحاوية الرئيسية */
        .container {
            width: 80%;
            max-width: 1200px;
            margin: 5rem auto 2rem;
            /* هامش علوي كبير 5rem */
            padding: 2rem;
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* تنسيق العنوان الرئيسي */
        .text-2xl {
            color: #2d3748;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
            text-align: center;
        }

        .text-2xl::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: #4299e1;
            border-radius: 3px;
        }

        /* تنسيق الجدول الرئيسي */
        .min-w-full {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* تنسيق رأس الجدول */
        .bg-gray-100 {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        }

        .bg-gray-100 th {
            font-weight: 600;
            color: #4a5568;
            padding: 0.75rem 1rem;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #e2e8f0;
        }

        /* تنسيق خلايا الجدول */
        tbody tr {
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background-color: #f8fafc !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        tbody td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #edf2f7;
            color: #4a5568;
            font-size: 0.875rem;
        }

        /* تنسيق الصفوف الزوجية والفردية */
        tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* تنسيق حالة الإجازة */
        .text-yellow-600 {
            background-color: #fffaf0;
            color: #b7791f;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            display: inline-block;
            border: 1px solid #f6ad55;
        }

        .text-green-600 {
            background-color: #f0fff4;
            color: #276749;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            display: inline-block;
            border: 1px solid #68d391;
        }

        .text-red-600 {
            background-color: #fff5f5;
            color: #9b2c2c;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            display: inline-block;
            border: 1px solid #fc8181;
        }

        /* تنسيق الخلية الفارغة */
        .text-gray-500 {
            padding: 1rem;
            text-align: center;
            font-style: italic;
            color: #a0aec0;
        }

        /* تنسيق للشاشات الصغيرة */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                margin: 3rem auto 1rem;
                padding: 1rem;
            }

            .overflow-x-auto {
                border: 1px solid #e2e8f0;
                border-radius: 0.5rem;
            }

            th,
            td {
                padding: 0.5rem !important;
                font-size: 0.75rem !important;
            }

            .text-2xl {
                font-size: 1.25rem;
            }
        }

        .vacation-btn {
            background-color: rgb(229, 118, 70);
            margin-top: 15px;
            color: white;
            padding: 15px 40px;
            font-size: 20px;
            font-weight: bold;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            letter-spacing: 1px;
        }

        .vacation-btn:hover {
            background-color: rgb(229, 118, 70);
            /* لون أغمق عند التحويم */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .vacation-btn:active {
            transform: scale(0.98);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>

    <style>
        /* تنسيق مودال التأكيد */
        #confirmCancelModal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease-out;
        }

        #confirmCancelModal:not(.hidden) {
            opacity: 1;
            visibility: visible;
        }

        #modalContent {
            background: white;
            width: 90%;
            max-width: 400px;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transform: translateY(20px);
            transition: transform 0.3s ease, opacity 0.3s ease;
            text-align: center;
        }

        #confirmCancelModal:not(.hidden) #modalContent {
            transform: translateY(0);
        }

        #confirmCancelModal h3 {
            color: #2d3748;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        #confirmCancelModal p {
            color: #4a5568;
            font-size: 1rem;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        #confirmCancelModal .button-group {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        #confirmCancelBtn {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(239, 68, 68, 0.3);
        }

        #confirmCancelBtn:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(239, 68, 68, 0.4);
        }

        #confirmCancelBtn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none !important;
        }

        #confirmCancelModal button[onclick="closeCancelModal()"] {
            background: #f1f5f9;
            color: #64748b;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        #confirmCancelModal button[onclick="closeCancelModal()"]:hover {
            background: #e2e8f0;
            transform: translateY(-1px);
        }

        /* تأثيرات الحركة */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(20px);
            }
        }

        .back-btn {
            background-color: rgb(142, 142, 142);
            margin-top: 15px;
            color: white;
            padding: 15px 40px;
            font-size: 20px;
            font-weight: bold;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            letter-spacing: 1px;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            width: 7%;

            &:hover {
                text-decoration: none;
                color: white;
                background-color: rgb(108, 108, 108);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
                transform: translateY(-2px);
            }
        }
    </style>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <div class="page-content min-h-screen bg-gray-100 py-10 px-4">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">

            @php
            $permissionsPage = \App\Models\AuthedPage::where('user_id', auth()->id())->first();
            @endphp

            @if($permissionsPage->permission)
            <!-- Button -->
            <div class="text-center mb-6">
                <button id="openModal" class="vacation-btn">
                    طلب اذن عمل
                </button>
            </div>


            <!-- Modal -->
            <div id="vacationModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex justify-center items-center hidden z-50 transition-all duration-300">
                <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-2xl relative">
                    <h2 class="text-dark">طلب إذن عمل</h2>

                    <form id="vacationForm">
                        @csrf
                        <!-- Full Name -->
                        <div class="mb-4">
                            <label class="">الاسم كامل</label>
                            <input type="text" value="{{ auth()->user()->name }} {{ auth()->user()->last_name }}" readonly
                                class="w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-3 shadow-sm focus:outline-none">
                        </div>


                        <!-- Number of Days -->
                        <div class="mb-4">
                            <label class="">وقت الاذن</label>
                            <select name="start_end_per" required
                                class="w-full border border-gray-300 rounded-lg py-2 px-3 bg-white shadow-sm focus:outline-none">
                                <option value="">اختر وقت الاذن</option>
                                <option value="بداية الشيفت">بداية الشيفت</option>
                                <option value="نهاية الشيفت">نهاية الشيفت</option>
                            </select>
                        </div>

                        <!-- Number of Days -->
                        <div class="mb-4">
                            <label class="">عدد ساعات الاذن</label>
                            <select name="time_per" required
                                class="w-full border border-gray-300 rounded-lg py-2 px-3 bg-white shadow-sm focus:outline-none">
                                <option value="">اختر عدد ساعات الاذن</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>

                        <!-- Reason -->
                        <div class="mb-4">
                            <label class="">سبب الإذن</label>
                            <textarea name="reason_per" rows="4" required
                                placeholder="اكتب سبب طلب الإذن"
                                class="w-full border border-gray-300 rounded-lg py-2 px-3 shadow-sm focus:outline-none"></textarea>

                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-center">
                            <button type="submit"
                                class="bg-green-500 text-white font-semibold px-6 py-2 rounded-lg hover:bg-green-600 transition relative">
                                ارسال
                                <span id="spinner" class="hidden absolute right-3 top-1/2 transform -translate-y-1/2">
                                    <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8v8H4z"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </form>

                    <!-- Close Button -->
                    <button id="closeModal"
                        class="absolute top-2 right-3 text-gray-400 hover:text-gray-700 font-bold">
                        &times;
                    </button>
                </div>
            </div>





            <div class="container mx-auto px-4 py-10 mt-5">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <h2 class="text-2xl font-bold mb-6 text-center">طلبات الاذونات</h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="py-3 px-4 border-b text-center">#</th>
                                <th class="py-3 px-4 border-b text-center">الاسم</th>
                                <th class="py-3 px-4 border-b text-center">وقت الإذن</th>
                                <th class="py-3 px-4 border-b text-center">عدد الساعات</th>
                                <th class="py-3 px-4 border-b text-center">السبب</th>
                                <th class="py-3 px-4 border-b text-center">الحالة</th>
                                <th class="py-3 px-4 border-b text-center">رد المدير</th>
                                <th class="py-3 px-4 border-b text-center">تاريخ التقديم</th>
                                <th class="py-3 px-4 border-b text-center">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($permissions as $index => $perm)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $index + 1 }}</td>
                                <td class="py-3 px-4">{{ $perm->user->name ?? 'غير معروف' }} {{ $perm->user->last_name ?? '' }}</td>
                                <td class="py-3 px-4">{{ $perm->start_end_per }}</td>
                                <td class="py-3 px-4">{{ $perm->time_per }}</td>
                                <td class="py-3 px-4">{{ $perm->reason_per }}</td>
                                <td class="py-3 px-4">
                                    @if($perm->status_per == 'pending')
                                    <span class="text-yellow-600 font-semibold">قيد المراجعة</span>
                                    @elseif($perm->status_per == 'Approved')
                                    <span class="text-green-600 font-semibold">تمت الموافقة</span>
                                    @elseif($perm->status_per == 'Rejected')
                                    <span class="text-red-600 font-semibold">مرفوض</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">{{ $perm->reason_admin ?? 'لم يتم الرد بعد' }}</td>
                                <td class="py-3 px-4">{{ $perm->created_at->format('Y-m-d H:i') }}</td>
                                <td class="py-3 px-4">
                                    @if($perm->status_per == 'pending')
                                    <button onclick="showCancelModal({{ $perm->id }}, this)"
                                        class="text-red-600 hover:text-red-800 font-bold px-3 py-1 rounded hover:bg-red-50 transition">
                                        إلغاء
                                    </button>
                                    @else
                                    <span class="text-gray-500">تم الرد</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="py-4 text-gray-500">لا توجد طلبات إذن حالياً</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="text-center mb-6">
                <a href="{{ url('/profile_user') }}" class="back-btn">
                    رجوع
                </a>
            </div>


            <!-- Modal تأكيد الإلغاء -->
            <div id="confirmCancelModal" class="hidden">
                <div class="" id="modalContent">
                    <h3 class="">تأكيد إلغاء الطلب</h3>
                    <p class="">هل أنت متأكد أنك تريد إلغاء طلب الإجازة؟</p>
                    <div class="button-group">
                        <button id="confirmCancelBtn" class="">
                            نعم، إلغاء
                        </button>
                        <button onclick="closeCancelModal()" class="">
                            إلغاء
                        </button>
                    </div>
                </div>
            </div>



        </div>
    </div>

    <!-- JavaScript files-->
    @include('admin.js')
    </div>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // تهيئة Toastr
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-left",
            "timeOut": "5000"
        };

        // متغيرات عامة
        let selectedPermissionId = null;
        let selectedButton = null;

        // ======== إدارة المودال ======== //

        // فتح مودال طلب الإذن
        document.getElementById('openModal')?.addEventListener('click', function() {
            document.getElementById('vacationModal').classList.remove('hidden');
        });

        // إغلاق مودال طلب الإذن
        document.getElementById('closeModal')?.addEventListener('click', function() {
            document.getElementById('vacationModal').classList.add('hidden');
        });

        // إغلاق المودال عند النقر خارج المحتوى
        window.addEventListener('click', function(e) {
            if (e.target === document.getElementById('vacationModal')) {
                document.getElementById('vacationModal').classList.add('hidden');
            }
            if (e.target === document.getElementById('confirmCancelModal')) {
                closeCancelModal();
            }
        });

        // ======== إرسال طلب إذن جديد ======== //
        document.getElementById('vacationForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = this;
            const submitBtn = form.querySelector('button[type="submit"]');
            const spinner = document.getElementById('spinner');

            // إظهار سبنر وتعطيل الزر
            spinner.classList.remove('hidden');
            submitBtn.disabled = true;

            try {
                const formData = new FormData(form);

                const response = await fetch("{{ route('permission.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'فشل في إرسال الطلب');
                }

                if (data.success) {
                    toastr.success(data.message || 'تم إرسال طلب الإذن بنجاح');
                    form.reset();
                    document.getElementById('vacationModal').classList.add('hidden');
                    await fetchPermissions(); // جلب البيانات الجديدة
                } else {
                    toastr.error(data.message || 'حدث خطأ أثناء الإرسال');
                }
            } catch (error) {
                console.error('Error:', error);
                toastr.error(error.message || 'حدث خطأ غير متوقع');
            } finally {
                spinner.classList.add('hidden');
                submitBtn.disabled = false;
            }
        });

        // ======== إدارة طلبات الإذن ======== //

        // جلب جميع طلبات الإذن
        async function fetchPermissions() {
            try {
                const response = await fetch('/permission');
                const data = await response.json();

                if (data.success && data.permissions) {
                    renderPermissions(data.permissions);
                }
            } catch (error) {
                console.error('Error fetching permissions:', error);
            }
        }

        // عرض طلبات الإذن في الجدول
        function renderPermissions(permissions) {
            const tbody = document.querySelector('table tbody');

            if (permissions.length === 0) {
                tbody.innerHTML = `
            <tr>
                <td colspan="8" class="py-4 text-gray-500">لا توجد طلبات إذن حالياً</td>
            </tr>
        `;
                return;
            }

            let html = '';
            permissions.forEach((perm, index) => {
                let statusText = '';
                if (perm.status_per === 'pending') {
                    statusText = '<span class="text-yellow-600 font-semibold">قيد المراجعة</span>';
                } else if (perm.status_per === 'approved') {
                    statusText = '<span class="text-green-600 font-semibold">تمت الموافقة</span>';
                } else {
                    statusText = '<span class="text-red-600 font-semibold">مرفوض</span>';
                }

                let actionBtn = '';
                if (perm.status_per === 'pending') {
                    actionBtn = `
                <button onclick="showCancelModal(${perm.id}, this)"
                    class="text-red-600 hover:text-red-800 font-bold px-3 py-1 rounded hover:bg-red-50 transition">
                    إلغاء
                </button>
            `;
                }

                html += `
            <tr class="border-t hover:bg-gray-50">
                <td class="py-3 px-4">${index + 1}</td>
                <td class="py-3 px-4">${perm.user.name || 'غير معروف'} ${perm.user.last_name || ''}</td>
                <td class="py-3 px-4">${perm.start_end_per}</td>
                <td class="py-3 px-4">${perm.time_per} ساعة</td>
                <td class="py-3 px-4">${perm.reason_per}</td>
                <td class="py-3 px-4">${statusText}</td>
                <td class="py-3 px-4">${new Date(perm.created_at).toLocaleString()}</td>
                <td class="py-3 px-4">${actionBtn}</td>
            </tr>
        `;
            });

            tbody.innerHTML = html;
        }

        // ======== إدارة مودال التأكيد ======== //

        // فتح مودال تأكيد الإلغاء
        function showCancelModal(id, button) {
            selectedPermissionId = id;
            selectedButton = button;
            document.getElementById('confirmCancelModal').classList.remove('hidden');
        }

        // إغلاق مودال تأكيد الإلغاء
        function closeCancelModal() {
            document.getElementById('confirmCancelModal').classList.add('hidden');
        }

        // تأكيد حذف طلب الإذن
        document.getElementById('confirmCancelBtn')?.addEventListener('click', async function() {
            if (!selectedPermissionId) return;

            const confirmBtn = this;
            const cancelBtn = document.querySelector('#confirmCancelModal button[onclick="closeCancelModal()"]');

            // إظهار سبنر وتعطيل الأزرار
            confirmBtn.disabled = true;
            cancelBtn.disabled = true;
            confirmBtn.innerHTML = `
        <span class="flex items-center justify-center">
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
            جاري الإلغاء...
        </span>
    `;

            try {
                const response = await fetch(`/permission/${selectedPermissionId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'فشل في الإلغاء');
                }

                if (data.success) {
                    toastr.success(data.message || 'تم إلغاء الطلب بنجاح');
                    selectedButton.closest('tr').remove();

                    // إذا لم يعد هناك صفوف، نعرض رسالة "لا توجد طلبات"
                    const tbody = document.querySelector('table tbody');
                    if (tbody.querySelectorAll('tr').length === 0) {
                        tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="py-4 text-gray-500">لا توجد طلبات إذن حالياً</td>
                    </tr>
                `;
                    }
                } else {
                    toastr.error(data.message || 'فشل في إلغاء الطلب');
                }
            } catch (error) {
                console.error('Error:', error);
                toastr.error(error.message || 'حدث خطأ أثناء الإلغاء');
            } finally {
                closeCancelModal();
                confirmBtn.disabled = false;
                cancelBtn.disabled = false;
                confirmBtn.textContent = 'نعم، إلغاء';
            }
        });

        // جلب البيانات عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            fetchPermissions();
        });
    </script>

    @else
    <h2 class="text-danger text-center">! لا تملك صلاحيات للدخول لهذه الصفحة</h2>
    @endif

</body>

</html>