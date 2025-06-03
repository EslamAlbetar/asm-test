<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    <style>
        body {
            background-color: #f9f9f9;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 20px;
        }

        .input_deg {
            margin-bottom: 15px;
        }

        .input_deg label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .input_deg input,
        .input_deg select,
        .input_deg textarea {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            background-color: #f4f4f4;
            color: #222;
        }

        .btn-sub {
            width: 100%;
            padding: 12px;
            font-size: 16px;
        }

        .add-btn {
            font-size: 24px;
            font-weight: bold;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            line-height: 40px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            margin: auto;
        }

        .remove-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
            color: red;
        }

        .spinner-overlay {
            position: fixed;
            width: 100vw;
            height: 100vh;
            background-color: rgba(255, 255, 255, 0.7);
            top: 0;
            left: 0;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background-color: #4e73df;
            color: white;
            padding: 12px 40px;
            font-size: 1.2rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            border: none;
            margin-bottom: 30px;
        }

        .btn-primary:hover {
            background-color: #3d64d4;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <div class="container">
        @php
        $permissions = \App\Models\AuthedPage::where('user_id', auth()->id())->first();
        @endphp

        @if($permissions->add_bill)
        <h1 class="mb-4">New Bill</h1>

        <div id="forms-container">
            <div class="form-container position-relative bill-form">
                <span class="remove-btn d-none">&times;</span>
                <form class="ajax-form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="input_deg invisible">
                        <label>User Name</label>
                        <input readonly type="text" name="id_user" value="{{ Auth::user()->name }} [ID: {{ Auth::user()->id }}]">
                    </div>

                    <div class="input_deg">
                        <label>Item type</label>
                        <select name="bill_type" required>
                            <option value="" disabled selected>اختر نوع الفاتورة</option>
                            <option value="شراء">شراء</option>
                            <option value="صيانة">صيانة</option>
                            <option value="سداد">فاتورة سداد</option>
                            <option value="اخرى">اخرى</option>
                        </select>
                    </div>

                    <div class="input_deg">
                        <label>Item name</label>
                        <input type="text" name="bill_name" required>
                    </div>

                    <div class="input_deg">
                        <label>Required quantity</label>
                        <input type="number" name="required_qty" required min="1">
                    </div>

                    <div class="input_deg">
                        <label>Price A Piece</label>
                        <input type="number" name="price_bill" required min="0" step="0.01">
                    </div>

                    <div class="input_deg">
                        <label>Comments Bill</label>
                        <textarea name="comments_bill"></textarea>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center my-3">
            <button type="button" class="add-btn" id="addFormBtn">+</button>
        </div>

        <div class="text-center">
            <button class="btn btn-primary" id="submitAll">إرسال كل الفواتير</button>
        </div>
    </div>

    <div id="spinnerOverlay" class="spinner-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">جارٍ التحميل...</span>
        </div>
    </div>
    <!-- JavaScript files-->
    @include('admin.js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const spinner = document.getElementById('spinnerOverlay');
            spinner.style.display = 'none';

            const container = document.getElementById('forms-container');
            const addBtn = document.getElementById('addFormBtn');
            const submitBtn = document.getElementById('submitAll');

            // إعداد Toastr
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "timeOut": "5000"
            };

            // إضافة نموذج جديد
            addBtn.addEventListener('click', function() {
                const firstForm = document.querySelector('.bill-form');
                const clone = firstForm.cloneNode(true);

                // Reset inputs
                clone.querySelectorAll('input, textarea, select').forEach(el => {
                    if (el.name !== "_token" && el.name !== "id_user") {
                        el.value = "";
                    }
                });

                clone.querySelector('.remove-btn').classList.remove('d-none');
                container.appendChild(clone);
            });

            // حذف نموذج
            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-btn')) {
                    const forms = document.querySelectorAll('.bill-form');
                    if (forms.length > 1) {
                        e.target.closest('.bill-form').remove();
                    } else {
                        toastr.warning('يجب أن يبقى نموذج واحد على الأقل');
                    }
                }
            });

            // إرسال جميع النماذج
            submitBtn.addEventListener('click', async function(e) {
                e.preventDefault();

                const forms = document.querySelectorAll('.ajax-form');
                if (forms.length === 0) {
                    toastr.warning('لا توجد فواتير لإرسالها');
                    return;
                }

                spinner.style.display = 'flex';

                let hasError = false;
                let successCount = 0;
                let errorMessages = [];

                for (let form of forms) {
                    const formData = new FormData(form);
                    const requiredFields = ['bill_type', 'bill_name', 'required_qty', 'price_bill'];

                    let isValid = true;
                    for (const field of requiredFields) {
                        if (!formData.get(field)) {
                            isValid = false;
                            errorMessages.push(`الرجاء ملء حقل ${field} في جميع النماذج`);
                            break;
                        }
                    }

                    if (!isValid) {
                        hasError = true;
                        continue;
                    }

                    try {
                        const response = await fetch("{{ url('upload_bill') }}", {
                            method: "POST",
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            },
                            body: formData
                        });

                        const contentType = response.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            throw new Error('الخادم لم يعد استجابة JSON صالحة');
                        }

                        const result = await response.json();

                        if (!response.ok || result.status !== 'success') {
                            hasError = true;
                            errorMessages.push(result.message || 'حدث خطأ غير معروف');
                        } else {
                            successCount++;
                        }
                    } catch (error) {
                        hasError = true;
                        errorMessages.push(error.message);
                        console.error("Fetch error:", error);
                    }
                }

                spinner.style.display = 'none';

                if (!hasError) {
                    toastr.success(`تم إرسال ${successCount} فاتورة بنجاح!`);
                    setTimeout(() => {
                        window.location.href = "{{ url('bills_admin') }}";
                    }, 2000);
                } else if (successCount > 0) {
                    toastr.warning(`تم إرسال ${successCount} فاتورة بنجاح، ولكن حدثت الأخطاء التالية:\n${errorMessages.join('\n')}`);
                } else {
                    toastr.error(`فشل إرسال الفواتير. الأخطاء:\n${errorMessages.join('\n')}`);
                }
            });
        });
    </script>
    </div>
    
    @else
    <div class="no-data">
        <p style="margin: 0; font-size: 18px;">لا تملك صلاحية الوصول للصفحة</p>
    </div>
    @endif
</body>

</html>