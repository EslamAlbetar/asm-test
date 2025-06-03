<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    <style>
        .usertypes-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .usertype-form {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .color-options {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .color-option {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .color-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
        }

        .color-circle:hover {
            transform: scale(1.1);
        }

        .gold {
            background-color: #9c6a1c;
        }

        .purple {
            background-color: #800080;
        }

        .gray {
            background-color: #808080;
        }

        .blue {
            background-color: #fc531c;
        }

        .green {
            background-color: #008000;
        }

        .submit-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #2980b9;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .hidden {
            display: none;
        }

        .usertypes-table {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: right;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .color-display {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
            margin-left: 10px;
        }

        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-left: 5px;
            transition: opacity 0.3s;
        }

        .edit-btn {
            background-color: #f39c12;
            color: white;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }

        .action-btn:hover {
            opacity: 0.8;
        }

        /* تصميم متجاوب */
        @media (max-width: 768px) {
            .usertypes-container {
                padding: 15px;
            }

            .color-options {
                flex-wrap: wrap;
            }

            th,
            td {
                padding: 8px 10px;
            }
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

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

                @if($permissions->add_user_type)
                <div class="usertypes-container">
                    <h1>Managing user types</h1>

                    <!-- نموذج الإضافة -->
                    <div class="usertype-form mt-4">
                        <h2>Add new user type</h2>
                        <form id="usertypeForm">
                            @csrf
                            <div class="form-group">
                                <label for="name_usertype">Name:</label>
                                <input type="text" id="name_usertype" name="name_usertype" required>
                            </div>

                            <div class="form-group">
                                <label>Choose color:</label>
                                <div class="color-options">
                                    <label class="color-option">
                                        <input type="radio" name="color_code" value="#9c6a1c" required>
                                        <span class="color-circle gold" title="Brown"></span>
                                    </label>
                                    <label class="color-option">
                                        <input type="radio" name="color_code" value="#800080">
                                        <span class="color-circle purple" title="Purple"></span>
                                    </label>
                                    <label class="color-option">
                                        <input type="radio" name="color_code" value="#808080">
                                        <span class="color-circle gray" title="Gray"></span>
                                    </label>
                                    <label class="color-option">
                                        <input type="radio" name="color_code" value="#fc531c">
                                        <span class="color-circle blue" title="Red"></span>
                                    </label>
                                    <label class="color-option">
                                        <input type="radio" name="color_code" value="#008000">
                                        <span class="color-circle green" title="Green"></span>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="submit-btn">
                                <span class="btn-text">Add</span>
                                <span class="spinner hidden"></span>
                            </button>
                        </form>
                    </div>

                    <!-- جدول عرض البيانات -->
                    <div class="usertypes-table">
                        <h2>Users types list</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Color</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="usertypesTableBody">
                                <!-- سيتم ملؤه عبر AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ url('/staff_team') }}" class="btn btn-lg btn-warning mt-5 ">رجوع</a>
                </div>


            </div>
        </div>
        <!-- JavaScript files-->
        @include('admin.js')
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('usertypeForm');
            const tableBody = document.getElementById('usertypesTableBody');
            const submitBtn = form.querySelector('.submit-btn');
            const btnText = submitBtn.querySelector('.btn-text');
            const spinner = submitBtn.querySelector('.spinner');

            fetchUsertypes();

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                btnText.classList.add('hidden');
                spinner.classList.remove('hidden');
                submitBtn.disabled = true;

                const formData = new FormData(form);

                fetch('/usertypes', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        addUsertypeToTable(data);
                        form.reset();
                        toastr.success('تمت إضافة نوع المستخدم بنجاح!');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('حدث خطأ أثناء الإضافة!');
                    })
                    .finally(() => {
                        btnText.classList.remove('hidden');
                        spinner.classList.add('hidden');
                        submitBtn.disabled = false;
                    });
            });

            function fetchUsertypes() {
                fetch('/usertypes')
                    .then(response => response.json())
                    .then(data => {
                        tableBody.innerHTML = '';
                        data.forEach(usertype => {
                            addUsertypeToTable(usertype);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }

            function addUsertypeToTable(usertype) {
                const row = document.createElement('tr');
                row.setAttribute('data-id', usertype.id); // مهم علشان نستخدمه في الحذف

                row.innerHTML = `
        <td>${usertype.name_usertype}</td>
        <td>
            <span class="color-display" style="background-color: ${usertype.color_code}"></span>
            ${usertype.color_code}
        </td>
        <td>
            <button class="action-btn delete-btn" data-id="${usertype.id}">حذف</button>
        </td>
    `;

                tableBody.appendChild(row);

                row.querySelector('.delete-btn').addEventListener('click', function() {
                    if (confirm('هل أنت متأكد من حذف هذا النوع؟')) {
                        deleteUsertype(this.dataset.id);
                    }
                });
            }

            function deleteUsertype(id) {
                fetch(`/usertypes/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken,
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            document.querySelector(`tr[data-id="${id}"]`)?.remove();
                            toastr.success('تم الحذف بنجاح!');
                            fetchUsertypes(); // تحديث الجدول
                        } else {
                            throw new Error('Failed to delete');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('حدث خطأ أثناء الحذف!');
                    });
            }

        });
    </script>

    @else
    <div class="no-data">
        <p style="margin: 0; font-size: 18px;">لا تملك صلاحية الوصول للصفحة</p>
    </div>
    @endif
</body>

</html>