<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')
    <style>
        /* تصميم الأعمدة المزدوجة المتوازية */
        .dual-columns {
            display: flex;
            gap: 30px;
            margin-bottom: 20px;
        }

        .form-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 8px;
            color: #6c757d;
            font-size: 1rem;
            font-weight: 500;
            flex-shrink: 0;
        }

        .form-group input,
        .form-group select {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #fff;
            min-height: 44px;
        }

        .full-width {
            width: 100%;
            margin-top: 20px;
        }

        /* تحسينات للتوازي البصري */
        .form-column {
            position: relative;
        }

        .form-column::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            right: -15px;
            width: 1px;
            background-color: #e9ecef;
        }

        .dual-columns .form-column:last-child::after {
            display: none;
        }

        /* التأكيد على التوازي */
        .form-group {
            position: relative;
        }

        /* بقية الأنماط تبقى كما هي */
        .page-title {
            color: #495057;
            font-size: 2.5rem;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 600;
        }

        .card.device-form {
            background-color: #f8f9fa;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin: 20px auto;
            max-width: 900px;
            border: none;
        }

        /* تنسيق ملف الرفع */
        .custom-file {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .custom-file-input {
            position: relative;
            z-index: 2;
            width: 100%;
            height: calc(2.25rem + 2px);
            margin: 0;
            opacity: 0;
        }

        .custom-file-label {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1;
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .custom-file-input:focus~.custom-file-label {
            border-color: #a0d2eb;
            box-shadow: 0 0 0 3px rgba(160, 210, 235, 0.3);
        }

        .image-preview {
            width: 150px;
            height: 150px;
            border: 2px dashed #e9ecef;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* تنسيق الأزرار */
        .btn-submit {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-success {
            background-color: #5cb85c;
            color: white;
        }

        .btn-success:hover {
            background-color: #4cae4c;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(92, 184, 92, 0.3);
        }

        .btn-warning {
            background-color: #f0ad4e;
            color: white;
        }

        .btn-warning:hover {
            background-color: #eea236;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(240, 173, 78, 0.3);
        }

        /* تصميم متجاوب */
        @media (max-width: 768px) {
            .dual-columns {
                flex-direction: column;
                gap: 20px;
            }

            .form-column::after {
                display: none;
            }

            .btn-submit {
                flex-direction: column;
                gap: 10px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>


</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="container-fluid">
            @php
            $permissions = \App\Models\AuthedPage::where('user_id', auth()->id())->first();
            @endphp

            @if($permissions->add_device)
            <h1 class="page-title">Add Device</h1>

            <div class="card device-form">
                <form id="addDeviceForm" action="{{url('add_devices')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <!-- صف الأعمدة المزدوجة -->
                    <div class="dual-columns">
                        <!-- العمود الأول -->
                        <div class="form-column">
                            <div class="form-group">
                                <label>Device Name & (Type)</label>
                                <input type="text" name="device_name" placeholder="Enter Device Name" required>
                            </div>

                            <div class="form-group">
                                <label>Device Model</label>
                                <input type="text" name="device_model" placeholder="Enter Device Model" required>
                            </div>

                            <div class="form-group">
                                <label>Device Serial</label>
                                <input type="text" name="device_serial" placeholder="Enter Device Serial">
                            </div>
                        </div>

                        <!-- العمود الثاني -->
                        <div class="form-column">
                            <div class="form-group">
                                <label>Status of Get the Device</label>
                                <select name="device_get_status" required>
                                    <option value="select_status" disabled selected>Select Status</option>
                                    <option value="new">New</option>
                                    <option value="used">Used</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Purchase Date</label>
                                <input type="date" name="purchase_date">
                            </div>

                            <div class="form-group">
                                <label>Price Device</label>
                                <input type="text" name="price_device" placeholder="Enter Price Device">
                            </div>
                        </div>
                    </div>

                    <!-- حقل رفع الصورة (عرض كامل) -->
                    <div class="form-group full-width">
                        <label>Device Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="deviceImage" name="device_image">
                            <label class="custom-file-label" for="deviceImage">Choose image file</label>
                        </div>
                        <div class="image-preview mt-3" id="imagePreview"></div>
                    </div>

                    <div class="btn-submit">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus-circle"></i> Add Device
                        </button>
                        <a class="btn btn-warning back" href="{{url('center_devices')}}">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('admin.js')
    <script>
        // معاينة الصورة قبل الرفع
        document.getElementById('deviceImage').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    preview.innerHTML = `<img src="${event.target.result}" alt="Device Preview">`;
                }

                reader.readAsDataURL(file);
                document.querySelector('.custom-file-label').textContent = file.name;
            } else {
                preview.innerHTML = '';
                document.querySelector('.custom-file-label').textContent = 'Choose image file';
            }
        });

        // إدارة إرسال النموذج
        document.getElementById('addDeviceForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // يمكنك إضافة تحقق إضافي هنا قبل الإرسال

            this.submit();
        });
    </script>
    
    @else
    <div class="no-data">
        <p style="margin: 0; font-size: 18px;">لا تملك صلاحية الوصول للصفحة</p>
    </div>
    @endif
</body>

</html>