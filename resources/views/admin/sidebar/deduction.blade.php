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
        #objectionModal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: none;
            /* تغيير من hidden إلى none */
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 1000;
            opacity: 0;
            transition: all 0.3s ease-out;
        }

        #objectionModal.show {
            display: flex;
            opacity: 1;
        }

        /* تنسيق محتوى المودال */
        #objectionModal .modal-content {
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

        #objectionModal.show .modal-content {
            transform: translateY(0);
        }

        /* تنسيق العنوان */
        #objectionModal h2 {
            color: #2d3748;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 600;
        }

        /* تنسيق حقول الإدخال */
        #objectionForm input,
        #objectionForm select,
        #objectionForm textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            margin-top: 0.25rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background-color: #f8fafc;
        }

        #objectionForm input:focus,
        #objectionForm select:focus,
        #objectionForm textarea:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
            background-color: white;
        }

        #objectionForm input:read-only {
            background-color: #edf2f7;
            cursor: not-allowed;
        }

        /* تنسيق التسميات */
        #objectionForm label {
            display: block;
            color: #4a5568;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        /* تنسيق زر الإرسال */
        #objectionForm button[type="submit"] {
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

        #objectionForm button[type="submit"]:hover {
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
            #objectionModal .modal-content {
                width: 95%;
                padding: 1.5rem;
            }

            #objectionModal h2 {
                font-size: 1.3rem;
            }

            #objectionForm input,
            #objectionForm select,
            #objectionForm textarea {
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

        .objection-btn {
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

        .objection-btn:hover {
            background-color: rgb(229, 118, 70);
            /* لون أغمق عند التحويم */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .objection-btn:active {
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
            display: none;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 1000;
            opacity: 0;
            transition: all 0.3s ease-out;
        }

        #confirmCancelModal.show {
            display: flex;
            opacity: 1;
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

        #confirmCancelModal.show #modalContent {
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
        }

        .back-btn:hover {
            text-decoration: none;
            color: white;
            background-color: rgb(108, 108, 108);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
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
            $permissions = \App\Models\AuthedPage::where('user_id', auth()->id())->first();
            @endphp


            @if($permissions->deduction)
            <!-- Modal -->
            <!-- اعتراض على الخصم -->
            <div id="objectionModal">
                <div class="modal-content">
                    <button id="closeModal" onclick="closeObjectionModal()">&times;</button>
                    <h2>طلب اعتراض على الخصم</h2>
                    <form id="objectionForm" method="POST" action="{{ route('objection.submit') }}">
                    @csrf
                        <input type="hidden" name="objection_ded" value="Approved">
                        <input type="hidden" name="deduction_id" id="deduction_id">
                        <div class="form-group">
                            <label for="objection_reason">سبب الاعتراض</label>
                            <textarea name="objection_reason" id="objection_reason" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-footer">
                            <div class="spinner-border text-warning d-none" role="status" id="objectionSpinner">
                                <span class="visually-hidden">جاري الإرسال...</span>
                            </div>
                            <button type="button" class="btn btn-secondary" onclick="closeObjectionModal()">إلغاء</button>
                            <button type="submit" class="btn btn-warning">إرسال الاعتراض</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="container mx-auto px-4 py-10 mt-5">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <h2 class="text-2xl font-bold mb-6 text-center">جدول الخصومات</h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="py-3 px-4 border-b text-center">#</th>
                                <th class="py-3 px-4 border-b text-center">الاسم</th>
                                <th class="py-3 px-4 border-b text-center">مبلغ الخصم</th>
                                <th class="py-3 px-4 border-b text-center">السبب</th>
                                <th class="py-3 px-4 border-b text-center">توقيع المسؤول</th>
                                <th class="py-3 px-4 border-b text-center">ارسال اعتراض</th>
                                <th class="py-3 px-4 border-b text-center">سبب الاعتراض</th>
                                <th class="py-3 px-4 border-b text-center">حالة الاعتراض</th>
                                <th class="py-3 px-4 border-b text-center">الرد على الاعتراض</th>
                                <th class="py-3 px-4 border-b text-center">توقيع المسؤول</th>
                                <th class="py-3 px-4 border-b text-center">الغاء الاعتراض</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($deduction as $index => $ded)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $index + 1 }}</td>
                                <td class="py-3 px-4">{{ $ded->user->name ?? 'غير معروف' }} {{ $ded->user->last_name ?? '' }}</td>
                                <td class="py-3 px-4">{{ $ded->amount_ded }}</td>
                                <td class="py-3 px-4">{{ $ded->reason_ded }}</td>
                                <td class="py-3 px-4">{{ $ded->signature_ded }}</td>

                                <td class="py-3 px-4">
                                    @if ($ded->objection_ded == null)
                                    <button class="btn btn-sm btn-outline-warning objection-btn"
                                        data-id="{{ $ded->id }}"
                                        onclick="openObjectionModal({{ $ded->id }})">
                                        اعتراض
                                    </button>
                                    @else
                                    تم ارسال الاعتراض
                                    @endif
                                </td>

                                <td class="py-3 px-4">{{ $ded->objection_reason }}</td>

                                <td class="py-3 px-4">
                                    @if($ded->objection_status == 'pending')
                                    <span class="text-yellow-600 font-semibold">قيد المراجعة</span>
                                    @elseif($ded->objection_status == 'Approved')
                                    <span class="text-green-600 font-semibold">تمت الموافقة</span>
                                    @elseif($ded->objection_status == 'Rejected')
                                    <span class="text-red-600 font-semibold">مرفوض</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">{{ $ded->reason_admin_objection }}</td>
                                <td class="py-3 px-4">{{ $ded->signature_objection_admin }}</td>
                                <td class="py-3 px-4">
                                    @if($ded->objection_status == 'pending')
                                    <button onclick="showCancelModal({{ $ded->id }})"
                                        class="text-red-600 hover:text-red-800 font-bold px-3 py-1 rounded hover:bg-red-50 transition">
                                        إلغاء
                                    </button>
                                    @endif
                                    @if($ded->objection_status == 'Approved')
                                    <span class="text-green-600 font-semibold">تمت الموافقة</span>
                                    @endif
                                    @if($ded->objection_status == 'Rejected')
                                    <span class="text-red-600 font-semibold">مرفوض</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="py-4 text-gray-500">لا توجد خصومات هذا الشهر</td>
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
            <div id="confirmCancelModal">
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // وظائف المودال الرئيسي
        function openObjectionModal(deductionId) {
            document.getElementById("deduction_id").value = deductionId;
            document.getElementById("objection_reason").value = "";
            document.getElementById("objectionModal").classList.add("show");
        }

        function closeObjectionModal() {
            document.getElementById("objectionModal").classList.remove("show");
        }

        // وظائف مودال الإلغاء
        let currentCancelId = null;

        function showCancelModal(id) {
            currentCancelId = id;
            document.getElementById("confirmCancelModal").classList.add("show");
        }

        function closeCancelModal() {
            currentCancelId = null;
            document.getElementById("confirmCancelModal").classList.remove("show");
        }

        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // إرسال الاعتراض
        document.getElementById("objectionForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const form = this;
            const spinner = document.getElementById("objectionSpinner");
            const submitBtn = form.querySelector('button[type="submit"]');
            const formData = new FormData(form);

            spinner.classList.remove("d-none");
            submitBtn.disabled = true;

            axios.post(form.action, formData)
                .then(response => {
                    if (response.data.success) {
                        toastr.success("تم إرسال الاعتراض بنجاح");
                        closeObjectionModal();
                        updateTableAfterSubmit(formData.get('deduction_id'), formData.get("objection_reason"));
                    } else {
                        toastr.error(response.data.message || "حدث خطأ أثناء الإرسال");
                    }
                })
                .catch(error => {
                    toastr.error("فشل في إرسال الاعتراض");
                    console.error(error);
                })
                .finally(() => {
                    spinner.classList.add("d-none");
                    submitBtn.disabled = false;
                });
        });

        function updateTableAfterSubmit(deductionId, objectionReason) {
            const row = document.querySelector(`.objection-btn[data-id="${deductionId}"]`).closest("tr");
            if (row) {
                row.querySelector("td:nth-child(7)").innerHTML = 'تم ارسال الاعتراض';
                row.querySelector("td:nth-child(8)").textContent = objectionReason;
                row.querySelector("td:nth-child(9)").innerHTML = '<span class="text-yellow-600 font-semibold">قيد المراجعة</span>';
            }
        }

        // تأكيد الإلغاء
        document.getElementById("confirmCancelBtn").addEventListener("click", function() {
            if (!currentCancelId) return;

            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> جاري الإلغاء...';

            axios.post("{{ route('objection.cancel') }}", {
                    deduction_id: currentCancelId,
                    _token: '{{ csrf_token() }}'
                })
                .then(response => {
                    if (response.data.success) {
                        toastr.success("تم إلغاء الاعتراض بنجاح");
                        updateTableAfterCancel(currentCancelId);
                    } else {
                        toastr.error(response.data.message || "فشل في الإلغاء");
                    }
                    closeCancelModal();
                })
                .catch(error => {
                    toastr.error("حدث خطأ أثناء الإلغاء");
                    console.error(error);
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.textContent = "نعم، إلغاء";
                });
        });

        function updateTableAfterCancel(deductionId) {
            const row = document.querySelector(`.objection-btn[data-id="${deductionId}"]`)?.closest("tr");
            if (row) {
                row.querySelector("td:nth-child(7)").innerHTML = `
                    <button class="btn btn-sm btn-outline-warning objection-btn"
                        data-id="${deductionId}"
                        onclick="openObjectionModal(${deductionId})">
                        اعتراض
                    </button>
                `;
                row.querySelector("td:nth-child(8)").textContent = "";
                row.querySelector("td:nth-child(9)").textContent = "";
            }
        }

        // إغلاق المودال عند النقر خارج المحتوى
        document.addEventListener('click', function(event) {
            const objectionModal = document.getElementById('objectionModal');
            const confirmCancelModal = document.getElementById('confirmCancelModal');

            if (event.target === objectionModal) {
                closeObjectionModal();
            }

            if (event.target === confirmCancelModal) {
                closeCancelModal();
            }
        });
    </script>

    @else
    <div class="no-data">
        <p style="margin: 0; font-size: 18px;">لا توجد بيانات يومية متاحة لهذا الشهر</p>
    </div>
    @endif

</body>

</html>