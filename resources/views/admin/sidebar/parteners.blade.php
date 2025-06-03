<!DOCTYPE html>
<html>

<head>
    @include('admin.css')

    <!-- تنسيق المودال الرئيسي  -->
    <style>
            /* تصميم شبكي حديث */
#partnerModal .modal-dialog {
    max-width: 800px;
    margin: 1rem auto;
}

#partnerModal .modal-content {
    border: none;
    border-radius: 0;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    background: #fff;
    padding: 20px;
}

#partnerModal .modal-header {
    background: #fff;
    color: #2c3e50;
    border-bottom: 2px solid #f1f1f1;
    padding: 1rem;
    text-align: center;
}

#partnerModal .modal-title {
    font-weight: 700;
    font-size: 1.5rem;
    width: 100%;
}

#partnerModal .btn-close {
    position: absolute;
    left: 20px;
    top: 20px;
    opacity: 0.7;
}

#partnerModal .modal-body {
    padding: 1rem 0;
}

#partnerForm {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

#partnerForm .mb-3 {
    margin-bottom: 0 !important;
    padding: 10px;
    background: #f9f9f9;
    border-radius: 5px;
    border: 1px solid #eee;
}

#partnerForm .form-label {
    font-weight: 600;
    color: #34495e;
    font-size: 0.9rem;
    margin-bottom: 5px;
    display: block;
}

#partnerForm .form-control,
#partnerForm .form-select {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 0.6rem;
    font-size: 0.9rem;
    width: 100%;
    background: #fff;
}

#partnerForm .form-control:focus,
#partnerForm .form-select:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
    outline: none;
}

/* العناصر التي يجب أن تأخذ عرض كامل */
#remainingInfo,
#errorMsg,
#spinner,
.d-grid {
    grid-column: span 2;
}

#remainingInfo {
    background: #f8f9fa;
    padding: 8px;
    text-align: center;
    font-size: 0.85rem;
    border-radius: 4px;
    margin-top: 5px;
}

#errorMsg {
    background: #fde8e8;
    color: #e74c3c;
    padding: 8px;
    text-align: center;
    font-size: 0.85rem;
    border-radius: 4px;
    margin-top: 5px;
}

#spinner {
    margin: 10px auto;
    color: #3498db;
    width: 1.5rem;
    height: 1.5rem;
}

.d-grid {
    margin-top: 10px;
}

#partnerForm .btn-primary {
    background: #3498db;
    border: none;
    border-radius: 4px;
    padding: 0.8rem;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s;
    width: 100%;
}

#partnerForm .btn-primary:hover {
    background: #2980b9;
}

/* تصميم متجاوب للشاشات الصغيرة */
@media (max-width: 768px) {
    #partnerForm {
        grid-template-columns: 1fr;
    }
    
    #remainingInfo,
    #errorMsg,
    #spinner,
    .d-grid {
        grid-column: span 1;
    }
    
    #partnerModal .modal-dialog {
        margin: 0.5rem;
    }
}
     </style>

    <!-- تنسيق عام للصفحة -->
    <style>
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

    <!-- تنسيق مودال التأكيد -->
   <style>
    /* مركز الفورم داخل المودال */
#partnerModal .modal-dialog {
  max-width: 600px;
}

#partnerModal .modal-content {
  border-radius: 20px;
  padding: 20px;
  background: #f9f9f9;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

/* تنظيم العناصر في صفوف مزدوجة */
#partnerForm {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  justify-content: center;
}

/* كل عنصرين على صف */
#partnerForm .mb-3 {
  flex: 0 0 calc(50% - 10px);
}

/* العناصر الفردية (النسبة + النسب المتبقية + الزر) */
#partnerForm input[readonly],
#remainingInfo,
#errorMsg,
#spinner,
#partnerForm .d-grid {
  flex: 0 0 100%;
}

/* الزر */
#partnerForm .btn {
  width: 100%;
  padding: 12px;
  font-size: 16px;
  border-radius: 10px;
}

/* تحسين شكل السليكت والانبت */
#partnerForm .form-control,
#partnerForm .form-select {
  border-radius: 10px;
  border: 1px solid #ddd;
  padding: 10px;
  background-color: #fff;
  transition: border 0.3s ease;
}

#partnerForm .form-control:focus,
#partnerForm .form-select:focus {
  border-color: #0d6efd;
  box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.25);
  outline: none;
}

/* تنسيق باقي النصوص */
#partnerForm label.form-label {
  font-weight: 500;
  margin-bottom: 5px;
  color: #333;
}

/* تنسيق الرسائل */
#remainingInfo {
  font-size: 14px;
  color: #555;
}

#errorMsg {
  font-size: 14px;
  font-weight: bold;
}

/* تنسيق السبنر */
#spinner {
  width: 25px;
  height: 25px;
  align-self: center;
}

   </style>

    <!-- تصميم الجدول -->
    <style>
        .profits-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .profits-table thead tr {
            background-color: #6c8ae4;
            color: #ffffff;
            text-align: center;
            font-weight: 600;
        }

        .profits-table th,
        .profits-table td {
            padding: 15px 12px;
        }

        .profits-table tbody tr {
            border-bottom: 1px solid #f0f2f7;
            text-align: center;
            transition: all 0.2s ease;
        }

        .profits-table tbody tr:nth-child(even) {
            background-color: #f9fafc;
        }

        .profits-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .profits-table tbody tr:hover {
            background-color: #f0f4ff;
            transform: translateX(2px);
        }

        .profits-table th:first-child {
            border-top-left-radius: 12px;
        }

        .profits-table th:last-child {
            border-top-right-radius: 12px;
        }

        .profits-table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 12px;
        }

        .profits-table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 12px;
        }

        /* تنسيق الأرقام الموجبة */
        .profits-table .positive {
            color: #4caf50;
            /* أخضر */
            font-weight: 500;
        }

        /* تنسيق الأرقام السالبة */
        .profits-table .negative {
            color: #f44336;
            /* أحمر */
            font-weight: 500;
        }

        /* تأثيرات للجوال */
        @media (max-width: 768px) {
            .profits-table {
                font-size: 0.8em;
            }

            .profits-table th,
            .profits-table td {
                padding: 10px 8px;
            }
        }
    </style>

<!-- تحديث البيانات -->
<style>
.spinner-border {
    vertical-align: middle;
    margin-right: 5px;
}

#updateProfitsBtn {
    transition: all 0.3s;
}

.negative {
    color: #f44336;
    font-weight: bold;
}

.positive {
    color: #4CAF50;
    font-weight: bold;
}

/* إذا كنت تستخدم Toastify للإشعارات */
@import url('https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css');
</style>


<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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

                @if($permissions->parteners)


                @if($permissions->parteners_admin)
                <!-- Button -->
                @if($permissions->add_partener)
                <div class="text-center mb-6">
                    <button id="openModal" class="vacation-btn">
                        اضافة شريك جديد
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="partnerModal" tabindex="-1" aria-labelledby="partnerModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="partnerModalLabel">إضافة شريك جديد</h5>
                            </div>
                            <div class="modal-body">
                                <form id="partnerForm">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">اسم الشريك</label>
                                        <select name="user_id" class="form-select" required>
    <option value="">اختر اسم الشريك</option>
    @foreach ($users as $user)
        <option value="{{ $user->id }}"
            data-phone="{{ $user->phone ?? '' }}"
            data-age="{{ $user->age ?? '' }}"
            data-address="{{ $user->address ?? '' }}"
            data-job="{{ $user->job ?? '' }}">
            {{ $user->name }} ({{ $user->usertype }})
        </option>
    @endforeach
</select>

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">العمر</label>
                                        <input type="number" name="age" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">العنوان</label>
                                        <input type="text" name="address" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">رقم الهاتف</label>
                                        <input type="text" name="phone" class="form-control" required placeholder="رقم الهاتف">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">المهنة</label>
                                        <input type="text" name="job" class="form-control" required placeholder="المهنة">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">المبلغ</label>
                                        <input type="text" name="amount" placeholder="المبلغ" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">النسبة</label>
                                        <input type="text" name="percentage" readonly class="form-control mt-2">
                                    </div>

                                    <div id="remainingInfo" class="mt-1 text-muted">النسب المتبقية: {{ 100 - $parteners->sum('percentage') }}%</div>
                                    <div id="errorMsg" class="d-none text-danger mt-1">⚠️ لا يمكن تخطي نسبة 100%</div>

                                    <div id="spinner" class="spinner-border d-none mt-3" role="status"><span class="visually-hidden">جاري الإرسال...</span></div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary mt-3">حفظ الشريك</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @endif
                <h3 class="mt-10 text-xl font-bold text-center mb-5 mt-5">بيانات جميع الشركاء</h3>

                <table class="profits-table mt-5">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>العمر</th>
                            <th>العنوان</th>
                            <th>الهاتف</th>
                            <th>الوظيفة</th>
                            <th>المبلغ</th>
                            <th>النسبة</th>
                            <th>الربح الخاص بك</th>
                            <th>تمت الاضافة بواسطة</th>
                            <th>حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($parteners as $partener)
                        <tr>
                            <td>{{ $partener->name_partener }}</td>
                            <td>{{ $partener->age }}</td>
                            <td>{{ $partener->address }}</td>
                            <td>{{ $partener->phone }}</td>
                            <td>{{ $partener->job }}</td>
                            <td class="{{ $partener->amount < 0 ? 'negative' : 'positive' }}">{{ number_format($partener->amount, 2) }} جنيه</td>
                            <td class="{{ $partener->percentage < 0 ? 'negative' : 'positive' }}">{{ number_format($partener->percentage, 1) }}%</td>
                            <td class="{{ $partener->total_profits_you < 0 ? 'negative' : 'positive' }}">
    <span class="profit-amount">{{ number_format($partener->total_profits_you, 2) }}</span> جنيه
</td>                            <td>{{ $partener->user->name }}</td>
                            <td>
                                 <button class="btn btn-danger btn-sm delete-partner" 
                                     data-id="{{ $partener->id }}" 
                                    onclick="confirmDelete({{ $partener->id }})">حذف</button>      
                              </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @endif


                <!-- جدول خاص بكل شريك منفصل -->
                @if($myPartener)
                <h3 class="mt-10 text-xl font-bold text-center mb-5 mt-5">بياناتك كشريك</h3>
                <table class="profits-table mt-2">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>العمر</th>
                            <th>العنوان</th>
                            <th>الهاتف</th>
                            <th>الوظيفة</th>
                            <th>المبلغ</th>
                            <th>النسبة</th>
                            <th>الربح الخاص بك</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $myPartener->name_partener }}</td>
                            <td>{{ $myPartener->age }}</td>
                            <td>{{ $myPartener->address }}</td>
                            <td>{{ $myPartener->phone }}</td>
                            <td>{{ $myPartener->job }}</td>
                            <td class="{{ $myPartener->amount < 0 ? 'negative' : 'positive' }}">{{ number_format($myPartener->amount, 2) }} جنيه</td>
                            <td class="{{ $myPartener->percentage < 0 ? 'negative' : 'positive' }}">{{ number_format($myPartener->percentage, 1) }}%</td>
                            <td class="{{ $myPartener->total_profits_you < 0 ? 'negative' : 'positive' }}">{{ number_format($myPartener->total_profits_you, 2) }} جنيه</td>
                        </tr>
                    </tbody>
                </table>
                @endif


            </div>
        </div>


        <button id="updateProfitsBtn" class="btn btn-primary text-center">
    <span id="updateText">تحديث الأرباح</span>
    <span id="updateSpinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
</button>

     

        <!-- JavaScript files-->
        @include('admin.js')
    </div>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- تعبئة بيانات الهاتف بناء على اختيار -->
    <script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. تعريف عناصر DOM
    const openModalBtn = document.getElementById('openModal');
    const partnerModalEl = document.getElementById('partnerModal');
    const partnerModal = partnerModalEl ? new bootstrap.Modal(partnerModalEl) : null;
    const partnerForm = document.getElementById('partnerForm');
    const spinner = document.getElementById('spinner');

    // 2. عناصر حقول الفورم
    const namePartenerSelect = document.querySelector('select[name="user_id"]');
    const phoneInput = document.querySelector('input[name="phone"]');
    const ageInput = document.querySelector('input[name="age"]');
    const addressInput = document.querySelector('input[name="address"]');
    const jobInput = document.querySelector('input[name="job"]');
    const amountInput = document.querySelector('input[name="amount"]');
    const percentageInput = document.querySelector('input[name="percentage"]');
    const remainingInfo = document.getElementById('remainingInfo');
    const errorMsg = document.getElementById('errorMsg');
    const submitBtn = partnerForm ? partnerForm.querySelector('button[type="submit"]') : null;

    // 3. البيانات الأولية
    const outputs = {{ $outputs ?? 0 }};
    const usedPercentage = {{ $parteners->sum('percentage') ?? 0 }};
    const usersData = {!! json_encode($users->keyBy('id') ?? '{}') !!};

    // 4. فتح المودال
    if (openModalBtn && partnerModal) {
        openModalBtn.addEventListener('click', function () {
            partnerModal.show();
            resetForm();
        });
    }

    // 5. تعبئة بيانات المستخدم
    if (namePartenerSelect) {
        namePartenerSelect.addEventListener('change', function() {
            const userId = this.value;
            
            if (userId && usersData[userId]) {
                const user = usersData[userId];
                if (phoneInput) phoneInput.value = user.phone || '';
                if (ageInput) ageInput.value = user.age || '';
                if (addressInput) addressInput.value = user.address || '';
                if (jobInput) jobInput.value = user.job || '';
            } else {
                if (phoneInput) phoneInput.value = '';
                if (ageInput) ageInput.value = '';
                if (addressInput) addressInput.value = '';
                if (jobInput) jobInput.value = '';
            }
            
            if (amountInput && amountInput.value) {
                amountInput.dispatchEvent(new Event('input'));
            }
        });
    }

    // 6. حساب النسبة المئوية
    if (amountInput && percentageInput && remainingInfo) {
        amountInput.addEventListener('input', function () {
            const amount = parseFloat(this.value.replace(/,/g, '')) || 0;
            
            if (!isNaN(amount)) {
                const newPercentage = outputs > 0 ? parseFloat(((amount / outputs) * 100).toFixed(2)) : 0;
                const totalPercentage = usedPercentage + newPercentage;
                const remaining = (100 - usedPercentage).toFixed(2);

                percentageInput.value = newPercentage + '%';
                percentageInput.dataset.rawValue = newPercentage;
                remainingInfo.textContent = `النسب المتبقية: ${remaining}%`;

                if (totalPercentage > 100) {
                    percentageInput.classList.add('is-invalid');
                    if (errorMsg) errorMsg.classList.remove('d-none');
                    remainingInfo.classList.add('text-danger');
                    if (submitBtn) submitBtn.disabled = true;
                } else {
                    percentageInput.classList.remove('is-invalid');
                    if (errorMsg) errorMsg.classList.add('d-none');
                    remainingInfo.classList.remove('text-danger');
                    if (submitBtn) submitBtn.disabled = false;
                }
            }
        });
    }

    // 7. إرسال الفورم
    if (partnerForm) {
        partnerForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            
            if (spinner) spinner.classList.remove('d-none');
            if (submitBtn) submitBtn.disabled = true;

            try {
                const formData = new FormData(partnerForm);
                
                if (percentageInput && percentageInput.dataset.rawValue) {
                    formData.set('percentage', percentageInput.dataset.rawValue);
                }

                const response = await fetch("{{ route('store.partener') }}", {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': formData.get('_token')
                    },
                    body: formData
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Request failed');
                }

                if (data.success) {
                    showAlert('success', 'تمت الإضافة بنجاح!');
                    if (partnerModal) {
                        partnerModal.hide();
                    }
                    setTimeout(() => location.reload(), 1500);
                } else {
                    throw new Error(data.message || 'حدث خطأ غير متوقع');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('error', error.message || 'حدث خطأ في الاتصال');
            } finally {
                if (spinner) spinner.classList.add('d-none');
                if (submitBtn) submitBtn.disabled = false;
            }
        });
    }

    // 8. دوال مساعدة
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '9999';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertDiv);
        setTimeout(() => alertDiv.remove(), 5000);
    }

    function resetForm() {
        if (partnerForm) partnerForm.reset();
        if (percentageInput) {
            percentageInput.value = '';
            delete percentageInput.dataset.rawValue;
        }
        if (remainingInfo) {
            remainingInfo.textContent = `النسب المتبقية: ${(100 - usedPercentage).toFixed(2)}%`;
            remainingInfo.classList.remove('text-danger');
        }
        if (errorMsg) errorMsg.classList.add('d-none');
        if (submitBtn) submitBtn.disabled = false;
    }
});
</script>




    <!-- الارسال ب AJAX -->
    <script>
        document.getElementById('vacationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            document.getElementById('spinner').classList.remove('hidden');

            let formData = new FormData(this);

            fetch("{{ route('store.partener') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('spinner').classList.add('hidden');
                    if (data.success) {
                        toastr.success('تم إضافة الشريك بنجاح');
                        location.reload();
                    }
                }).catch(() => {
                    toastr.error("حدث خطأ");
                    document.getElementById('spinner').classList.add('hidden');
                });
        });
    </script>

    <!-- فتح مودال -->
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

        // فتح مودال 
        document.getElementById('openModal')?.addEventListener('click', function() {
            document.getElementById('vacationModal').classList.remove('hidden');
        });

        // إغلاق مودال 
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
    </script>

<!-- حذف الشريك -->
<script>
function confirmDelete(partnerId) {
    if (confirm('هل أنت متأكد من حذف هذا الشريك؟')) {
        // إنشاء form لإرسال طلب الحذف
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/partners/${partnerId}`;
        
        // إضافة حقول CSRF و method spoofing
        const csrfField = document.createElement('input');
        csrfField.type = 'hidden';
        csrfField.name = '_token';
        csrfField.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfField);
        form.appendChild(methodField);
        document.body.appendChild(form);
        
        // إرسال form
        form.submit();
    }
}
</script>

<!-- تحديث البيانات -->
<script>
$(document).ready(function() {
    $('#updateProfitsBtn').click(function(e) {
        e.preventDefault();
        const btn = $(this);
        const spinner = $('#updateSpinner');
        const updateText = $('#updateText');
        
        // إظهار سبنر التحميل
        btn.prop('disabled', true);
        spinner.removeClass('d-none');
        updateText.text('جاري التحديث...');
        
        // إنشاء form وإرساله
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("update.profits") }}';
        
        const csrfField = document.createElement('input');
        csrfField.type = 'hidden';
        csrfField.name = '_token';
        csrfField.value = '{{ csrf_token() }}';
        
        form.appendChild(csrfField);
        document.body.appendChild(form);
        form.submit();
    });
});
</script>


    @else
    <h2 class="text-danger text-center">! لا تملك صلاحيات للدخول لهذه الصفحة</h2>
    @endif

</body>

</html>