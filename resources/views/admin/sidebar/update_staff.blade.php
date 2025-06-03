<!DOCTYPE html>
<html>

<head>
    @include('admin.css')

    <style>
        /* التصميم العام */
        .page-content .container-fluid {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page-header h1 {
            color: #2d3748;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e2e8f0;
        }

        /* تصميم الفورم */
        .dev_inp {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .dev_inp label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #4a5568;
            font-size: 0.95rem;
        }

        .dev_inp input,
        .dev_inp select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8fafc;
            color: #2d3748;
        }

        .dev_inp input:focus,
        .dev_inp select:focus {
            outline: none;
            border-color: #4299e1;
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
        }

        /* حقول القراءة فقط */
        .dev_inp input[readonly] {
            background-color: #edf2f7;
            color: #4a5568;
            font-weight: 500;
        }

        /* تصميم الأزرار */
        .btn-sub {
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-size: 1rem;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-success {
            background-color: #38a169;
            color: white;
        }

        .btn-success:hover {
            background-color: #2f855a;
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(56, 161, 105, 0.3);
        }

        /* تصميم القوائم المنسدلة */
        .dev_inp select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%234a5568' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 12px;
            padding-right: 2.5rem;
        }

        /* تأثيرات حركية */
        .dev_inp input,
        .dev_inp select,
        .btn-sub {

            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* التجاوب مع الشاشات الصغيرة */
        @media (max-width: 768px) {
            .page-content .container-fluid {
                padding: 1rem;
            }

            .page-header h1 {
                font-size: 1.5rem;
            }

            .dev_inp {
                margin-bottom: 1.2rem;
            }
        }

        /* تنسيق إضافي لجعل التصميم أكثر أناقة */
        form.forms {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        /* تلوين خفيف للحقول المهمة */
        .dev_inp:nth-child(1) input {
            background-color: #f0fff4;
            color: #2f855a;
        }

        .dev_inp:nth-child(4) input {
            background-color: #ebf8ff;
            color: #2b6cb0;
        }

        .btn-success {
            background: #38a169;
            color: #fff;
        }
    </style>

    <style>
        /* التصميم العام */
        .permissions-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            direction: rtl;
            font-family: 'Tajawal', sans-serif;
        }

        .permissions-header {
            margin-bottom: 2rem;
            text-align: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 1rem;
        }

        .permissions-title {
            color: #2c3e50;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .permissions-subtitle {
            color: #7f8c8d;
            font-size: 1rem;
        }

        /* شبكة الصلاحيات */
        .permissions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .permission-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: #f9f9f9;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1px solid #eee;
        }

        .permission-item:hover {
            background: #f1f1f1;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .permission-checkbox {
            width: 20px;
            height: 20px;
            margin-left: 10px;
            accent-color: #3498db;
            cursor: pointer;
        }

        .permission-label {
            font-size: 1rem;
            color: #34495e;
            cursor: pointer;
            flex-grow: 1;
        }

        /* أزرار التحكم */
        .form-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-save {
            background: #3498db;
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .btn-cancel {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
        }

        .btn-cancel:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }

        /* تأثيرات للتركيز */
        .permission-checkbox:focus {
            outline: 2px solid #3498db;
            outline-offset: 2px;
        }

        .btn-select-all {
            background: #2ecc71;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-select-all:hover {
            background: #27ae60;
            transform: translateY(-2px);
        }

        /* تصميم متجاوب */
        @media (max-width: 768px) {
            .permissions-grid {
                grid-template-columns: 1fr;
            }

            .permissions-container {
                padding: 1rem;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
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

                @if($permissions->update_staff)
                <h1>Edit A Staff</h1>
                <div>
                    <form class="forms" action="{{ url('edit_staff_team', $data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="dev_inp">
                            <label>ID</label>
                            <input readonly type="text" name="id" value="{{ $data->id }}"></input>
                        </div>

                        <div class="dev_inp">
                            <label>First and Middle Name</label>
                            <input type="text" name="name" value="{{ $data->name }}"></input>
                        </div>

                        <div class="dev_inp">
                            <label>Last Name</label>
                            <input type="text" name="last_name" value="{{ $data->last_name }}"></input>
                        </div>

                        <div class="dev_inp">
                            <label>Email</label>
                            <input type="text" name="email" value="{{ $data->email }}"></input>
                        </div>

                        <div class="dev_inp">
                            <label>Phone</label>
                            <input type="text" name="phone" value="{{ $data->phone }}"></input>

                        </div class="dev_inp">

                        <div class="dev_inp">
                            <label>UserType</label>
                            <select name="usertype" class="form-select" id="usertype-select">
                                @foreach($usertypes as $type)
                                <option value="{{ $type->name_usertype }}"
                                    data-color="{{ $type->color_code }}"
                                    {{ $data->usertype === $type->name_usertype ? 'selected' : '' }}>
                                    {{ $type->name_usertype }}
                                </option>
                                @endforeach
                            </select>
                            <input readonly type="text" id="color_code_input" name="color_code" value="{{ $data->color_code }}">
                        </div>
                        <div class="dev_inp">
                            <input class="btn btn-success btn-sub" type="submit" value="Update User">
                        </div>


                    </form>
                </div>





                <div class="permissions-container">
                    <div class="permissions-header">
                        <h2 class="permissions-title">تعديل صلاحيات المستخدم</h2>
                        <p class="permissions-subtitle"><span class="parColor">{{ $data->name }}</span> Edit the permissions granted to </p>
                    </div>

                    <form method="POST" action="{{ route('permissions.update', $data->id) }}" class="permissions-form">
                        @csrf
                        @method('PUT')

                        @php
                        $pages = [
                        'Page: Add New Patient' => 'add_patient_admin',
                        'Page: Admin Dashboard' => 'admin_dashboard',
                        'Page: Waiting List' => 'waiting_list_admin',
                        'Button: Edit Details info Center' => 'editName_center',
                        'Button: Update Waiting List' => 'update_waiting_list_admin',
                        'Page: View Categories' => 'view_category',
                        'Button: Complete Patient' => 'completePatient',
                        'Page: Center Devices' => 'center_devices',
                        'Page: All Patients' => 'total_patients_admin',
                        'Page: Donations' => 'donations_admin',
                        'Button: Update Patient List' => 'update_patient_list_admin',
                        'Page: Staff Team' => 'staff_team',
                        'Page: Writing Report' => 'writing_report',
                        'Button: Add User Type' => 'add_user_type',
                        'Button: Write Report Now' => 'write_report_now',
                        'Button: Update Staff' => 'update_staff',
                        'Page: New Bills' => 'bills_admin',
                        'Button: Details Staff' => 'details_staff',
                        'Button: Add New Bill' => 'add_bill',
                        'Button: Delete Staff' => 'delete_staff',
                        'Button: Continue Bill To All Bills' => 'continue_bill',
                        'Page: Total Items' => 'total_items_admin',
                        'Page: All Bills' => 'all_bills',
                        'Page: Edit Items For Total Items' => 'add_item',
                        'Page: Profile User' => 'profile_user',
                        'Page: Add Device' => 'add_device',
                        'Page: Vacation User' => 'vacation',
                        'Button: Update Device' => 'update_device',
                        'Page: Permission' => 'permission',
                        'Page: Financial Accounting' => 'financial_accounting',
                        'Page: Deduction' => 'deduction',
                        'Page: Profits' => 'profit',
                        'Page: Partners' => 'parteners',
                        'Button: Start Shift' => 'shift_start',
                        'Button: Add New Partner' => 'add_partener',
                        'Table: Shifts For Admin' => 'shift_admin',
                        'Table: Partner For Admin' => 'parteners_admin',
                        'Table: Vacation For Admin' => 'vacation_admin',
                        'Table: Deduction For Admin' => 'deduction_admin',
                        'Table: Permission For Admin' => 'permission_admin',
                        ];
                        @endphp

                        <div class="permissions-grid">
                            @foreach ($pages as $label => $page)
                            <div class="permission-item">
                                <input class="permission-checkbox"
                                    type="checkbox"
                                    name="permissions[{{ $page }}]"
                                    id="{{ $page }}"
                                    {{ optional($data->AuthedPage)->$page ? 'checked' : '' }}>
                                <label class="permission-label" for="{{ $page }}">
                                    {{ $label }}
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-save">Save changes</button>
                            <a href="{{ route('staff_team') }}" class="btn-cancel">Cancel</a>
                        </div>
                    </form>
                </div>






            </div>
        </div>
        <!-- JavaScript files-->
        @include('admin.js')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تحديد/إلغاء تحديد الكل
            const selectAllBtn = document.createElement('button');
            selectAllBtn.textContent = 'Select All';
            selectAllBtn.className = 'btn-select-all';
            document.querySelector('.form-actions').prepend(selectAllBtn);

            selectAllBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const checkboxes = document.querySelectorAll('.permission-checkbox');
                const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

                checkboxes.forEach(checkbox => {
                    checkbox.checked = !allChecked;
                });

                selectAllBtn.textContent = allChecked ? 'Unselect All' : 'Select All';
            });
        });
    </script>

    @else
    <h2 class="text-danger text-center">! لا تملك صلاحيات للدخول لهذه الصفحة</h2>
    @endif
</body>

</html>