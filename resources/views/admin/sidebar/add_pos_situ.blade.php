<!DOCTYPE html>
<html lang="ar">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('admin.css')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e9ecef;
        }

        .page-header {
            padding: 20px;
            color: black;
            border-radius: 8px;
            background-color: #d6d8db;
            text-align: center;
        }

        h1 {
            font-size: 48px;
            margin-top: 20px;
            color: #2c2c2c;
        }

        .btn-primary {
            background-color: #3c78d8;
            color: white;
            padding: 12px 25px;
            font-size: 20px;
            transition: transform 0.3s ease;
        }

        .btn-primary:hover {
            transform: scale(1.08);
            background-color: #355f9a;
        }

        .card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 40px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border-radius: 5px;
            border: 1px solid #aaa;
        }

        .btn-sub {
            background-color: #3c78d8;
            color: white;
            width: 100%;
            padding: 15px;
            border-radius: 5px;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }

        .btn-sub:hover {
            background-color: #2e5ca8;
        }

        #addItemForm {
            display: none;
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #closeAddForm {
            background: none;
            border: none;
            color: red;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            float: right;
            margin-bottom: 15px;
        }

        h4 {
            font-size: 36px;
            text-align: center;
            margin-top: 40px;
        }

        .btn_sub {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn_sub a {
            text-decoration: none;
            width: 20%;
        }
    </style>


    <style>
        /* التصميم العام للكارد */
        .card {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(200, 200, 230, 0.2);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            overflow: hidden;
            margin-bottom: 30px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            padding: 28px;
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg,
                    rgba(220, 240, 255, 0.3),
                    rgba(230, 220, 255, 0.3),
                    rgba(255, 220, 240, 0.3));
            z-index: -1;
            border-radius: 18px;
            animation: softGlow 8s ease infinite;
            background-size: 300% 300%;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(200, 200, 230, 0.3);
        }

        @keyframes softGlow {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* عنوان الكارد */
        .card h4 {
            color: #7d5fff;
            font-weight: 600;
            margin-bottom: 24px;
            text-align: center;
            position: relative;
            padding-bottom: 12px;
            font-size: 1.4rem;
        }

        .card h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(to right, #a18cd1, #fbc2eb);
            border-radius: 3px;
            opacity: 0.7;
        }

        /* أزرار الكارد */
        .card .btn {
            border-radius: 28px;
            padding: 9px 18px;
            font-weight: 500;
            margin: 0 6px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            border-width: 1.8px;
            position: relative;
            overflow: hidden;
            font-size: 0.9rem;
        }

        .btn-outline-success {
            color: #6dd5a7;
            border-color: #6dd5a7;
            background: rgba(109, 213, 167, 0.1);
        }

        .btn-outline-success:hover {
            background: rgba(109, 213, 167, 0.2);
            color: #4bc08a;
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(109, 213, 167, 0.2);
        }

        .btn-outline-primary {
            color: #64b5f6;
            border-color: #64b5f6;
            background: rgba(100, 181, 246, 0.1);
        }

        .btn-outline-primary:hover {
            background: rgba(100, 181, 246, 0.2);
            color: #42a5f5;
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(100, 181, 246, 0.2);
        }

        .btn-outline-danger {
            color: #ff8a80;
            border-color: #ff8a80;
            background: rgba(255, 138, 128, 0.1);
        }

        .btn-outline-danger:hover {
            background: rgba(255, 138, 128, 0.2);
            color: #ff6e60;
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(255, 138, 128, 0.2);
        }

        /* الجدول داخل الكارد */
        .card .table {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(240, 240, 255, 0.8);
        }

        .card .table thead {
            background: linear-gradient(to right, #a18cd1, #fbc2eb);
            color: white;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        }

        .card .table th {
            border: none;
            font-weight: 500;
            padding: 14px;
        }

        .card .table td {
            vertical-align: middle;
            border-color: rgba(240, 240, 255, 0.8);
            padding: 12px;
        }

        .card .table tr:hover td {
            background: rgba(240, 240, 255, 0.4);
        }

        /* النموذج داخل الكارد */
        .card form {
            margin-top: 24px;
            background: rgba(255, 255, 255, 0.8);
            padding: 22px;
            border-radius: 12px;
            border: 1px solid rgba(240, 240, 255, 0.8);
        }

        .card input[type="text"],
        .card input[type="number"] {
            border: 1px solid rgba(220, 220, 255, 0.8);
            border-radius: 28px;
            padding: 12px 18px;
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .card input[type="text"]:focus,
        .card input[type="number"]:focus {
            border-color: #b8b8ff;
            box-shadow: 0 0 0 0.2rem rgba(184, 184, 255, 0.25);
        }

        .card .btn-warning {
            background: linear-gradient(to right, #ffc3a0, #ffafbd);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 28px;
            padding: 12px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .card .btn-warning:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 22px rgba(255, 175, 189, 0.3);
        }

        /* تأثير الظهور */
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* زر العودة */
        .btn_sub .btn-lg {
            background: linear-gradient(to right, #a18cd1, #fbc2eb);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 32px;
            padding: 14px 32px;
            margin-top: 35px;
            transition: all 0.3s ease;
            box-shadow: 0 6px 18px rgba(161, 140, 209, 0.3);
            font-size: 1rem;
        }

        .btn_sub .btn-lg:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(161, 140, 209, 0.4);
        }
    </style>


    <style>
        /* التصميم العام للجدول */
        .glowing-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(106, 17, 203, 0.1);
            position: relative;
        }

        .glowing-table::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg,
                    rgba(106, 17, 203, 0.1),
                    rgba(37, 117, 252, 0.1),
                    rgba(106, 17, 203, 0.1));
            z-index: -1;
            border-radius: 14px;
            animation: glow 6s ease infinite;
            background-size: 200% 200%;
        }

        @keyframes glow {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* رأس الجدول */
        .glowing-table thead {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
        }

        .glowing-table th {
            padding: 15px;
            text-align: center;
            font-weight: 500;
            letter-spacing: 0.5px;
            border: none;
            position: relative;
        }

        .glowing-table th:not(:last-child)::after {
            content: '';
            position: absolute;
            right: 0;
            top: 25%;
            height: 50%;
            width: 1px;
            background: rgba(255, 255, 255, 0.3);
        }

        /* خلايا الجدول */
        .glowing-table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .glowing-table tr:not(:last-child) td {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .glowing-table tr:hover td {
            background: rgba(106, 17, 203, 0.03);
        }

        /* رسالة عدم وجود بيانات */
        .empty-message {
            color: #888;
            font-style: italic;
            padding: 20px;
            background: rgba(255, 255, 255, 0.5);
        }

        /* أزرار الجدول */
        .glow-btn {
            border: none;
            border-radius: 20px;
            padding: 8px 15px;
            margin: 0 5px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-weight: 500;
        }

        .edit-btn {
            background: rgba(52, 152, 219, 0.1);
            color: #3498db;
        }

        .edit-btn:hover {
            background: #3498db;
            color: white;
            box-shadow: 0 0 15px rgba(52, 152, 219, 0.4);
        }

        .delete-btn {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }

        .delete-btn:hover {
            background: #e74c3c;
            color: white;
            box-shadow: 0 0 15px rgba(231, 76, 60, 0.4);
        }

        /* تأثير التوهج عند hover */
        .glow-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .edit-btn::after {
            box-shadow: 0 0 10px 2px rgba(52, 152, 219, 0.6);
        }

        .delete-btn::after {
            box-shadow: 0 0 10px 2px rgba(231, 76, 60, 0.6);
        }

        .glow-btn:hover::after {
            opacity: 1;
        }

        /* أيقونات الأزرار */
        .glow-btn i {
            margin-right: 5px;
        }
    </style>

    <style>
        /* تنسيق المودال الأساسي */
        .glowing-modal {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* هيدر المودال */
        .glowing-modal .modal-header {
            background: linear-gradient(135deg, #f9fafb, #f3f4f6);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.2rem 1.5rem;
        }

        .glowing-modal .modal-title {
            font-weight: 600;
            color: #374151;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
        }

        .glowing-modal .modal-title i {
            color: #4f46e5;
            font-size: 1.2rem;
        }

        .glowing-modal .btn-close {
            transition: all 0.3s ease;
            opacity: 0.7;
        }

        .glowing-modal .btn-close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        /* جسم المودال */
        .glowing-modal .modal-body {
            padding: 1.8rem;
        }

        .glowing-modal .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .glowing-modal .form-group label {
            display: block;
            margin-bottom: 0.6rem;
            font-weight: 500;
            color: #4b5563;
            font-size: 0.95rem;
        }

        .glowing-modal input {
            width: 100%;
            padding: 0.8rem 1.2rem;
            font-size: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background-color: #f9fafb;
            transition: all 0.3s ease;
            color: #111827;
        }

        .glowing-modal input:focus {
            outline: none;
            border-color: #a5b4fc;
            box-shadow: 0 0 0 3px rgba(165, 180, 252, 0.2);
            background-color: white;
        }

        /* فوتر المودال */
        .glowing-modal .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.2rem 1.5rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.8rem;
        }

        /* أزرار المودال */
        .glow-btn {
            border: none;
            border-radius: 8px;
            padding: 0.7rem 1.4rem;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .save-btn {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            color: white;
            box-shadow: 0 2px 10px rgba(79, 70, 229, 0.2);
        }

        .save-btn:hover {
            background: linear-gradient(to right, #4338ca, #6d28d9);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .cancel-btn {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        .cancel-btn:hover {
            background-color: #e5e7eb;
            transform: translateY(-2px);
        }

        /* تأثيرات الحدود */
        .focus-border {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            transition: width 0.3s ease;
        }

        .glowing-modal input:focus~.focus-border {
            width: 100%;
        }

        /* تأثير الظهور */
        .modal.fade .modal-dialog {
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.3s ease-out;
        }

        .modal.show .modal-dialog {
            transform: translateY(0);
            opacity: 1;
        }

        /* للهواتف المحمولة */
        @media (max-width: 576px) {
            .glowing-modal .modal-footer {
                flex-direction: column;
            }

            .glow-btn {
                width: 100%;
            }
        }
    </style>

    <!-- نافذة الحذف المعدلة -->
<div id="deleteModal" class="modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div class="deleteModal-content" style="background:white;padding:30px;border-radius:12px;width:90%;max-width:400px;text-align:center;position:relative;box-shadow:0 10px 25px rgba(0,0,0,0.2);">
        <span class="close-modal" onclick="closeDeleteModal()" style="position:absolute;top:15px;right:15px;font-size:24px;cursor:pointer;color:#6b7280;">&times;</span>
        
        <div style="margin-bottom:25px;">
            <i class="fas fa-exclamation-triangle" style="font-size:48px;color:#ef4444;margin-bottom:15px;"></i>
            <p class="deleteModal-text" style="font-size:18px;color:#374151;margin-bottom:5px;font-weight:500;">هل أنت متأكد من رغبتك في الحذف؟</p>
            <p style="font-size:14px;color:#6b7280;">هذا الإجراء لا يمكن التراجع عنه</p>
        </div>
        
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-actions" style="display:flex;gap:12px;justify-content:center;">
                <button type="button" onclick="closeDeleteModal()" class="btn btn-secondary cancel-btn" style="padding:10px 20px;border-radius:8px;background:#f3f4f6;color:#4b5563;border:none;cursor:pointer;transition:all 0.3s;font-weight:500;">
                    <i class="fas fa-times" style="margin-left:8px;"></i> إلغاء
                </button>
                <button type="submit" class="btn btn-danger confirm-btn" style="padding:10px 20px;border-radius:8px;background:#ef4444;color:white;border:none;cursor:pointer;transition:all 0.3s;font-weight:500;">
                    <i class="fas fa-check" style="margin-left:8px;"></i> تأكيد الحذف
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* تأثيرات الأزرار */
    .confirm-btn:hover {
        background: #dc2626 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }
    
    .cancel-btn:hover {
        background: #e5e7eb !important;
        transform: translateY(-2px);
    }
    
    /* تأثير الظهور */
    .deleteModal-content {
        animation: modalFadeIn 0.3s ease-out;
    }
    
    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* للهواتف المحمولة */
    @media (max-width: 480px) {
        .modal-actions {
            flex-direction: column;
        }
        
        .deleteModal-content {
            padding: 20px !important;
        }
    }
</style>

</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div id="spinnerOverlay" class="d-flex">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">جاري المعالجة...</span>
        </div>
    </div>

    <div class="page-content">
        <div class="page-header">
            <h1>{{ $category->name }}</h1>
        </div>

        <div class="container mt-4">
            <div class="text-center mb-4">
                <button id="showAddForm" class="btn btn-primary btn-lg">Add Position ➕</button>
            </div>

            <div id="addItemForm" class="card">
                <div class="text-start">
                    <button id="closeAddForm">❌</button>
                </div>
                <form id="addCategoryItemsForm" action="{{ url('add_position_success_ajax/' . $category->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="total_items_id" value="{{ $category->id }}">
                    <div class="input_deg">
                        <label>Position Name</label>
                        <input type="text" name="position_name" class="form-control" required>
                    </div>
                    <input type="submit" class="btn btn-success mt-3 w-100" value="Add">
                </form>
            </div>

            <h4>تعديل الأصناف الحالية</h4>
            <div id="itemsContainer">
                @foreach($category->positions as $item)
                <div class="card fade-in" id="itemCard {{ $item->id }}">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>{{ $item->position_name }}</strong>
                        <div>
                            <button class="btn btn-sm btn-outline-success toggle-form-btn" data-id="{{ $item->id }}">➕ أوضاع</button> <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleEditForm({{ $item->id }})">✏️ تعديل الفئة</button>
                            <button class="btn btn-sm btn-outline-danger" type="button" onclick="openDeleteModal({{ $item->id }}, 'category')">🗑️ حذف الفئة</button>
                        </div>
                    </div>

                    <div class="container mt-4">
                        <div class="table-responsive ">
                            <table class="glowing-table">
                                <thead class="glowing-table">
                                    <tr>
                                        <th>اسم الحاله ( + الاتجاه)</th>
                                        <th>السعر</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody id="situationTableBody">
                                    @if($item->situations->isEmpty())
                                    <tr id="no-situation-row">
                                        <td colspan="3" class="empty-message">لا توجد أوضاع مضافة</td>
                                    </tr>
                                    @else
                                    @foreach($item->situations as $situation)
                                    <tr id="situation-row-{{ $situation->id }}">
                                        <td>{{ $situation->situation_name }}</td>
                                        <td>{{ $situation->price }}</td>
                                        <td>
                                            <button type="button"
                                                class="glow-btn edit-btn edit-situation"
                                                data-id="{{ $situation->id }}"
                                                data-name="{{ $situation->situation_name }}"
                                                data-price="{{ $situation->price }}">
                                                <i class="fas fa-pencil-alt"></i> تعديل
                                            </button>

                                            <button class="glow-btn delete-btn" type="button" onclick="openDeleteModal({{ $situation->id }}, 'situation')">
                                                <i class="fas fa-trash-alt"></i> حذف
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>



                    <form style="display: none;" id="addSituationForm{{ $item->id }}" method="POST" action="{{ url('add_situation/' . $item->id) }}">
                        @csrf
                        <input type="text" name="situation_name" placeholder="Add Situation" class="form-control mb-2" required>
                        <input type="number" step="1" name="price" placeholder="Add Price" class="form-control mb-2" required>
                        <button class="btn btn-warning w-100" onclick="openSituationModal({{ $item->id }})" type="submit"> Add Situation 💾</button>
                    </form>

                    <div id="editForm{{ $item->id }}" style="display: none; margin-top: 20px;">
                        <form class="update-position-form" data-id="{{ $item->id }}" method="POST" action="{{ url('update_position/'.$item->id) }}">
                            @csrf
                            <input type="text" name="position_name" value="{{ $item->position_name }}" class="form-control mb-2" required>
                            <input type="submit" class="btn btn-warning w-100" value="💾 حفظ التعديلات">
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="btn_sub">
            <a href="{{ url('/view_category') }}" class="btn btn-warning btn-lg">Back</a>
        </div>
    </div>



    <!-- مودال تعديل الوضع -->
    <div class="modal fade" id="editSituationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content glowing-modal">
                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i> تعديل الوضع
                    </h5>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <form id="editSituationForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="situationName">اسم الوضع</label>
                            <input type="text"
                                id="situationName" name="situation_name" required
                                placeholder="أدخل اسم الوضع الجديد">
                            <div class="focus-border"></div>
                        </div>
                        <div class="form-group">
                            <label for="situationPrice"> السعر</label>

                            <input type="number" id="situationPrice" name="price" required
                                placeholder="أدخل السعر الجديد">
                            <div class="focus-border"></div>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="submit" form="editSituationForm" class="glow-btn save-btn">
                        <i class="fas fa-save me-1"></i> حفظ التغييرات
                    </button>
                    <button type="button" class="glow-btn cancel-btn" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1 "></i> إلغاء
                    </button>
                </div>
            </div>
        </div>
    </div>









    <!-- نافذة الحذف المعدلة -->
    <div id="deleteModal" class="modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
        <div class="deleteModal-content" style="background:white;padding:30px;border-radius:12px;width:90%;max-width:400px;text-align:center;position:relative;box-shadow:0 10px 25px rgba(0,0,0,0.2);">
            <span class="close-modal" onclick="closeDeleteModal()" style="position:absolute;top:15px;right:15px;font-size:24px;cursor:pointer;color:#6b7280;">&times;</span>

            <div style="margin-bottom:25px;">
                <i class="fas fa-exclamation-triangle" style="font-size:48px;color:#ef4444;margin-bottom:15px;"></i>
                <p class="deleteModal-text" style="font-size:18px;color:#374151;margin-bottom:5px;font-weight:500;">هل أنت متأكد من رغبتك في الحذف؟</p>
                <p style="font-size:14px;color:#6b7280;">هذا الإجراء لا يمكن التراجع عنه</p>
            </div>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-actions" style="display:flex;gap:12px;justify-content:center;">
                    <button type="button" onclick="closeDeleteModal()" class="btn btn-secondary cancel-btn" style="padding:10px 20px;border-radius:8px;background:#f3f4f6;color:#4b5563;border:none;cursor:pointer;transition:all 0.3s;font-weight:500;">
                        <i class="fas fa-times" style="margin-left:8px;"></i> إلغاء
                    </button>
                    <button type="submit" class="btn btn-danger confirm-btn" style="padding:10px 20px;border-radius:8px;background:#ef4444;color:white;border:none;cursor:pointer;transition:all 0.3s;font-weight:500;">
                        <i class="fas fa-check" style="margin-left:8px;"></i> تأكيد الحذف
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.js')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).on('click', '.toggle-form-btn', function() {
            const id = $(this).data('id');
            const form = $(`#addSituationForm${id}`);
            form.slideToggle(); // بيعمل Show/Hide بشكل ناعم
        });


        $(document).on('click', '.edit-situation', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const price = $(this).data('price');

            $('#situationName').val(name);
            $('#situationPrice').val(price);
            $('#editSituationForm').attr('action', '/update_situation/' + id);
            $('#editSituationModal').modal('show');
        });


        $(document).on('submit', '#editSituationForm', function(event) {
            event.preventDefault();
            $('#spinnerOverlay').show(); // لو عندك سبينر

            let form = $(this);
            let formData = form.serialize();
            let url = form.attr('action');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(data) {
                    $('#spinnerOverlay').hide();
                    $('#editSituationModal').modal('hide');

                    if (data.success) {
                        // تحديث فوري في الجدول
                        const id = data.id;
                        $('#situation-row-' + id).find('.situation-name').text(data.name);
                        $('#situation-row-' + id).find('.situation-price').text(data.price);

                        Swal.fire({
                            title: "تم!",
                            text: data.message,
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire("خطأ!", data.message, "error");
                    }
                },
                error: function(xhr) {
                    $('#spinnerOverlay').hide();
                    Swal.fire("خطأ!", "حدث خطأ في الاتصال", "error");
                }
            });
        });



        $(document).ready(function() {

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            window.toggleEditForm = function(id) {
                $('#editForm' + id).slideToggle();
            }

            window.openSituationModal = function(id) {
                const formId = `#addSituationForm${id}`;
                $(document).off('submit', formId).on('submit', formId, function(e) {
                    e.preventDefault();
                    const form = $(this);
                    const action = form.attr('action');

                    $.ajax({
                        url: action,
                        type: 'POST',
                        data: form.serialize(),
                        success: function(response) {
                            if (response.status === 'success') {
                                const sit = response.situation;

                                const table = form.siblings('div').find('table tbody');
                                if (table.length > 0) {
                                    // ✅ إزالة صف "لا توجد أوضاع" لو موجود
                                    table.find('#no-situation-row').remove();

                                    // ✅ إضافة الوضع الجديد
                                    table.append(`
<tr id="situationRow${sit.id}">
    <td>${sit.situation_name}</td>
    <td>${sit.price}</td>
    <td>
        <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleEditForm(${sit.id})">
            <i class="fas fa-pencil-alt"></i> تعديل
        </button>
        <button class="btn btn-sm btn-outline-danger" onclick="openDeleteModal(${sit.id}, 'situation')">
            <i class="fas fa-trash-alt"></i> حذف
        </button>
    </td>
</tr>
`);
                                }

                                form[0].reset();

                                Toast.fire({
                                    icon: 'success',
                                    title: 'تمت إضافة الوضع بنجاح اعد تحميل الصفحة'
                                });
                            }
                        },
                        error: function() {
                            Toast.fire({
                                icon: 'error',
                                title: 'فشل في إضافة الوضع'
                            });
                        }
                    });
                });
            }

            $('#spinnerOverlay').hide();

            window.openDeleteModal = function(id, type) {
                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: "سيتم حذف هذا العنصر نهائيًا!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'نعم، احذف!',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#spinnerOverlay').fadeIn();

                        let url = '';
                        let selector = '';

                        if (type === 'position') {
                            url = `/delete_position/${id}`;
                            selector = `#itemCard${id}`;
                        } else if (type === 'situation') {
                            url = `/delete_situation/${id}`;
                            selector = `#situationRow${id}`;
                        } else if (type === 'category') {
                            url = `/delete_cetegory_pos/${id}`;
                            selector = `#categoryCard${id}`;
                        }

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    $(selector).fadeOut(400, function() {
                                        $(this).remove();
                                    });

                                    setTimeout(() => {
                                        $('#spinnerOverlay').fadeOut();
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'تم حذف العنصر بنجاح اعد تحميل الصفحة'
                                        });
                                    }, 500);
                                } else {
                                    $('#spinnerOverlay').fadeOut();
                                    Toast.fire({
                                        icon: 'error',
                                        title: 'خطأ أثناء الحذف'
                                    });
                                }
                            },
                            error: function() {
                                $('#spinnerOverlay').fadeOut();
                                Toast.fire({
                                    icon: 'error',
                                    title: 'فشل الاتصال بالخادم'
                                });
                            }
                        });
                    }
                });
            }

            $('#addCategoryItemsForm').submit(function(e) {
                e.preventDefault();
                const form = $(this);

                if (form.hasClass('loading')) return;
                form.addClass('loading');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            const position = response.position;

                            const newCard = `
<div class="card fade-in" id="itemCard${position.id}">
    <div class="d-flex justify-content-between align-items-center">
        <strong>${position.position_name}</strong>
        <div>
            <button class="btn btn-sm btn-outline-success toggle-form-btn" data-id="${position.id}">➕ أوضاع</button>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="toggleEditForm(${position.id})">✏️ تعديل الفئة</button>
            <button class="btn btn-sm btn-outline-danger" type="button" onclick="openDeleteModal(${position.id}, 'position')">🗑️ حذف الفئة</button>
        </div>
    </div>

    <div class="container mt-4">
        <div class="table-responsive">
            <table class="glowing-table">
                <thead class="glowing-table">
                    <tr>
                                        <th>اسم الحاله ( + الاتجاه)</th>
                        <th>السعر</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="situationTableBody${position.id}">
                    <tr id="no-situation-row">
                        <td colspan="3" class="empty-message">لا توجد أوضاع مضافة</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <form style="display: none;" id="addSituationForm${position.id}" method="POST" action="/add_situation/${position.id}">
        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
        <input type="text" name="situation_name" placeholder="Add Situation" class="form-control mb-2" required>
        <input type="number" step="0.01" name="price" placeholder="Add Price" class="form-control mb-2" required>
        <button class="btn btn-warning w-100" type="submit"> Add Situation 💾</button>
    </form>

    <div id="editForm${position.id}" style="display: none; margin-top: 20px;">
        <form class="update-position-form" data-id="${position.id}" method="POST" action="/update_position/${position.id}">
            <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
            <input type="text" name="position_name" value="${position.position_name}" class="form-control mb-2" required>
            <input type="submit" class="btn btn-warning w-100" value="💾 حفظ التعديلات">
        </form>
    </div>
</div>
`;

                            $('#itemsContainer').append(newCard);
                            $('#addItemForm').fadeOut();
                            form[0].reset();

                            Toast.fire({
                                icon: 'success',
                                title: 'تمت إضافة العنصر بنجاح اعد تحميل الصفحة'
                            });
                        }
                    },
                    error: function() {
                        Toast.fire({
                            icon: 'error',
                            title: 'فشل في الإضافة'
                        });
                    },
                    complete: function() {
                        form.removeClass('loading');
                    }
                });
            });

            $('#showAddForm').click(function() {
                $('#addItemForm').fadeIn();
            });

            $('#closeAddForm').click(function() {
                $('#addItemForm').fadeOut();
            });

        });


        $(document).on('submit', '.update-position-form', function(e) {
    e.preventDefault();

    const form = $(this);
    const id = form.data('id');
    const action = form.attr('action');
    const formData = form.serialize();

    $('#spinnerOverlay').fadeIn();

    $.ajax({
        url: action,
        method: 'POST',
        data: formData,
        success: function(response) {
            $('#spinnerOverlay').fadeOut();

            if (response.status === 'success') {
                // تحديث الاسم في الواجهة
                $(`#itemCard${id} strong`).text(response.position_name);

                Swal.fire({
                    icon: 'success',
                    title: 'تم التعديل بنجاح',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                // إخفاء الفورم بعد التعديل
                $(`#editForm${id}`).slideUp();
            } else {
                Swal.fire("خطأ!", response.message || "فشل التعديل", "error");
            }
        },
        error: function(xhr) {
            $('#spinnerOverlay').fadeOut();
            Swal.fire("خطأ!", "فشل الاتصال بالخادم", "error");
        }
    });
});


        $(document).ready(function() {
            $(document).on('submit', '.update-position-form', function(e) {
                e.preventDefault(); // لمنع الإرسال الطبيعي

                const form = $(this);
                const id = form.data('id');
                const positionName = form.find('input[name="position_name"]').val();

                $.ajax({
                    url: `/update_position/${id}`,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        position_name: positionName
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // تعديل الاسم في الـ UI
                            $(`#itemCard${id} strong`).text(response.position_name);

                            Toast.fire({
                                icon: 'success',
                                title: 'تم تعديل الاسم بنجاح'
                            });

                            // إخفاء الفورم بعد التعديل
                            $(`#editForm${id}`).slideUp();
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'حدث خطأ أثناء التعديل'
                            });
                        }
                    },
                    error: function() {
                        Toast.fire({
                            icon: 'error',
                            title: 'فشل الاتصال بالخادم'
                        });
                    }
                });
            });
        });
    </script>



</body>

</html>