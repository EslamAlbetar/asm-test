<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    <style>
        /* التصميم العام */
        .page-content {
            padding: 20px;
            display: inline-block;
            align-items: center;
            justify-content: center;

        }

        .resources-container {
            display: flex;
            flex-direction: column;
            /* عشان العناصر تيجي تحت بعض */
            align-items: center;
            /* توسيط الكروت في النص */
            gap: 40px;
            padding: 20px;

        }

        /* بطاقة المورد */
        .resource-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
            border-left: 4px solid #4f46e5;
            margin: 0 auto;
            width: 80%;
            /* ياخد 80% من عرض الصفحة */
            max-width: 1000px;
            /* حد أقصى اختياري لو تحب */

        }


        .resource-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .resource-header {
            padding: 15px;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-bottom: 1px solid #e5e7eb;
        }

        .resource-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .items {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }


        .resource-icon {
            margin-right: 8px;
            color: #4f46e5;
            font-size: 18px;
        }

        .resource-count {
            display: flex;
            justify-content: start;
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
        }

        .count-money {
            display: flex;
            justify-content: end;
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }

        .resource-body {
            padding: 15px;
        }

        .resource-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #e5e7eb;
        }

        .resource-item:last-child {
            border-bottom: none;
        }

        .item-name {
            font-size: 14px;
            color: #4b5563;
        }

        .item-value {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        .view-all-btn {
            display: block;
            text-align: center;
            padding: 8px;
            margin-top: 10px;
            background-color: #f3f4f6;
            color: #4f46e5;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .view-all-btn:hover {
            background-color: #e0e7ff;
        }

        /* ألوان مختلفة للبطاقات */
        .resource-card.blue {
            border-left-color: #3b82f6;
        }

        .resource-card.blue .resource-icon {
            color: #3b82f6;
        }

        .resource-card.green {
            border-left-color: #10b981;
        }

        .resource-card.green .resource-icon {
            color: #10b981;
        }

        .resource-card.orange {
            border-left-color: #f59e0b;
        }

        .resource-card.orange .resource-icon {
            color: #f59e0b;
        }

        .resource-card.purple {
            border-left-color: #8b5cf6;
        }

        .resource-card.purple .resource-icon {
            color: #8b5cf6;
        }

        /* تحسينات القائمة المنسدلة */
        /* تنسيق عصري للدروب داون */
        .dropdown-menu {
            min-width: 180px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 8px 0;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .dropdown-item {
            padding: 8px 16px;
            font-size: 0.9rem;
            color: #4b5563;
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #1f2937;
            transform: translateX(3px);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
            color: #6b7280;
        }

        .dropdown-item.text-danger {
            color: #ef4444;
        }

        .dropdown-item.text-danger:hover {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .dropdown-item.text-danger i {
            color: #ef4444;
        }

        /* زر الدروب داون */
        .dropdown-toggle {
            background: none;
            border: none;
            color: #6b7280 !important;
            padding: 5px 10px;
            transition: all 0.3s;
        }

        .dropdown-toggle:hover {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 50%;
        }

        .dropdown-toggle::after {
            display: none;
        }

        /* تحسينات عامة للكارد */
        .resource-header {
            position: relative;
            padding: 1.5rem;
        }

        /* إضافة خلفية مظللة للمودال */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5) !important;
        }

        .modal-open .modal .modal-content {
            background: #fff !important;
            padding: 0 !important;
        }

        /* تخصيص المودال ليظهر في المنتصف */
        .modal-dialog {
            max-width: 500px;
            /* تعديل العرض ليناسب المحتوى */
            margin: 0 auto;
            /* محاذاة المودال في منتصف الشاشة */
        }

        .modal-content {
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
        }

        /* أنماط المودال العصري */
        .modal-content {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #8b5cf6 100%);
        }

        .modal-header {
            border-bottom: none;
            padding: 1.2rem 1.5rem;
        }

        .modal-title {
            font-weight: 600;
            font-size: 1.3rem;
        }

        .modal-body {
            padding: 2rem;
        }

        /* تحسينات سبينر التحميل */
        #spinnerOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            z-index: 99999;
            display: flex;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }

        .spinner-container {
            text-align: center;
            background: white;
            padding: 2rem 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .spinner-text {
            margin-top: 1rem;
            font-size: 1.1rem;
            color: #4b5563;
            font-weight: 500;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 0.6;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.6;
            }
        }

        /* تحسينات للأزرار */
        .btn {
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        .btn-primary:hover {
            background-color: #4338ca;
            border-color: #4338ca;
            transform: translateY(-2px);
        }

        .btn-outline-secondary:hover {
            background-color: #f3f4f6;
        }

        .rounded-pill {
            padding: 0.5rem 1.5rem;
        }

        /* تحسينات لحقل الإدخال */
        .form-control-lg {
            padding: 0.75rem 1.25rem;
            font-size: 1.1rem;
        }

        .form-control:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 0.25rem rgba(139, 92, 246, 0.25);
        }

        /* مودال تعديل الفئة - شكل عصري وراقي */
        #editCategoryModal .modal-content {
            border-radius: 20px;
            background-color: #ffffff;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border: none;
            overflow: hidden;
        }

        #editCategoryModal .modal-header {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            border-bottom: none;
            padding: 1.5rem 1.5rem;
            align-items: center;
        }

        #editCategoryModal .modal-header .modal-title {
            font-size: 1.4rem;
            font-weight: bold;
        }

        #editCategoryModal .modal-body {
            padding: 2rem;
            background-color: #f9fafb;
        }

        #editCategoryModal .form-label {
            font-weight: 600;
            color: #374151;
            font-size: 1.1rem;
            display: flex;
            align-items: start;
            justify-content: center;
        }

        #editCategoryModal .form-control {
            border-radius: 30px;
            padding: 0.75rem 1.25rem;
            font-size: 1.05rem;
            border: 2px solid #e5e7eb;
            transition: 0.3s ease;
        }

        #editCategoryModal .form-control:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 0.2rem rgba(139, 92, 246, 0.25);
        }

        #editCategoryModal .modal-footer {
            background-color: #f3f4f6;
            border-top: none;
            padding: 1rem 1.5rem;
        }

        #editCategoryModal .btn-outline-secondary {
            border-radius: 30px;
            padding: 0.5rem 1.5rem;
        }

        #editCategoryModal .btn-primary {
            border-radius: 30px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            background-color: #4f46e5;
            border-color: #4f46e5;
            transition: all 0.3s ease;
        }

        #editCategoryModal .btn-primary:hover {
            background-color: #4338ca;
            border-color: #4338ca;
            transform: translateY(-2px);
        }

        .text-muted {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* أنماط الجدول الفاخرة */
        .table-container {
            width: 100%;
            max-width: 800px;
            perspective: 1000px;
        }

        .elegant-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
        }

        .elegant-table:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .elegant-table thead {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
        }

        .elegant-table th {
            padding: 16px 20px;
            font-weight: 600;
            text-align: center;
            position: relative;
        }

        .elegant-table th:not(:last-child):after {
            content: "";
            position: absolute;
            right: 0;
            top: 20%;
            height: 60%;
            width: 1px;
            background: rgba(255, 255, 255, 0.2);
        }

        .elegant-table tbody tr {
            transition: all 0.3s ease;
        }

        .elegant-table tbody tr:hover {
            background: rgba(106, 17, 203, 0.03);
            transform: scale(1.01);
        }

        .elegant-table td {
            padding: 14px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            text-align: center;
            color: #555;
        }

        .elegant-table tr:last-child td {
            border-bottom: none;
        }

        /* أنماط الأزرار */
        .btn {
            padding: 8px 18px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            margin: 0 5px;
            border: none;
            cursor: pointer;
            outline: none;
            position: relative;
            overflow: hidden;
        }

        .edit-btn {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(79, 172, 254, 0.3);
        }



        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .btn:active {
            transform: translateY(0);
        }

        /* تأثير الإضاءة عند hover على الصف */
        .elegant-table tbody tr:hover td {
            color: #333;
            font-weight: 500;
        }

        /* حدود مخصصة للجدول */
        .elegant-table {
            border: 1px solid rgba(106, 17, 203, 0.1);
        }

        /* تأثيرات إضافية للرأس */
        .elegant-table thead tr {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* ظل داخلي للجدول */
        .elegant-table {
            position: relative;
        }

        .elegant-table:after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 12px;
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.03);
            pointer-events: none;
        }
    </style>


    <!-- الموقع -->
    <style>
        /* أنماط النموذج الفاخرة */
        .elegant-form-container {
            width: 100%;
            max-width: 450px;
            perspective: 1000px;
        }

        .elegant-form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .elegant-form:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
            color: #6a11cb;
        }

        .form-header i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .form-header h3 {
            font-weight: 600;
            margin: 0;
            position: relative;
            display: inline-block;
        }

        .form-header h3:after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border-radius: 3px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
            transition: all 0.3s ease;
            margin: auto;
        }

        .form-group input {
            width: 100%;
            padding: 12px 0;
            border: none;
            border-bottom: 1px solid #ddd;
            background: transparent;
            font-size: 16px;
            color: #333;
            outline: none;
            transition: all 0.3s ease;
            text-align: center;
        }

        .form-group input:focus {
            border-bottom-color: transparent;
        }

        .form-group input:focus+.underline {
            transform: scaleX(1);
        }

        .underline {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            transform: scaleX(0);
            transition: all 0.3s ease;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(106, 17, 203, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(106, 17, 203, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* تأثيرات إضافية */
        .elegant-form:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        }

        .elegant-form:after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 15px;
            box-shadow: inset 0 0 30px rgba(0, 0, 0, 0.03);
            pointer-events: none;
        }

        /* أنماط حاوية السهم والرسالة */
        .scroll-down-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            z-index: 999;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(20px);
        }

        .scroll-down-container.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* أنماط الرسالة النصية */
        .scroll-down-message {
            background: rgba(106, 17, 203, 0.9);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            margin-bottom: 10px;
            font-size: 14px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            white-space: nowrap;
            animation: fadeIn 0.5s ease;
        }

        /* أنماط سهم الانتقال */
        .scroll-down-arrow {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            animation: bounce 2s infinite;
        }

        .scroll-down-arrow:hover {
            transform: scale(1.1);
        }

        .scroll-down-arrow i {
            font-size: 20px;
        }

        /* تأثيرات الحركة */
        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>

    <!-- /* Dropdown Container */ -->
    <style>
        .category-dropdown {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }

        /* Dropdown Toggle Button */
        .dropdown-toggle-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 50%;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0;
        }

        .dropdown-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: scale(1.05);
        }

        /* Dropdown Icon */
        .dropdown-toggle-btn .fa-ellipsis-v {
            font-size: 14px;
            color: #333;
        }

        /* Dropdown Menu */
        .category-dropdown .dropdown-menu {
            border: none;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
            min-width: 150px;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Dropdown Items */
        .category-dropdown .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .category-dropdown .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
            padding-right: 1.2rem;
        }

        /* Dropdown Icons */
        .category-dropdown .dropdown-item i {
            width: 18px;
            text-align: center;
        }

        /* RTL Support */
        [dir="rtl"] .category-dropdown {
            right: auto;
            left: 10px;
        }

        [dir="rtl"] .dropdown-menu {
            text-align: right;
        }

        [dir="rtl"] .dropdown-item i {
            margin-left: 0.5rem;
            margin-right: 0;
        }

        [dir="rtl"] .dropdown-item:hover {
            padding-right: 1rem;
            padding-left: 1.2rem;
        }
    </style>

    <!-- مودل الحذف  -->
    <style>
        /* تصميم المودال الفاتح */
        #deleteCategoryModal .modal-dialog {
            max-width: 400px;
            margin: 1.75rem auto;
        }

        #deleteCategoryModal .modal-content {
            border: none;
            border-radius: 12px;
            background: #f8f9fa !important;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        #deleteCategoryModal .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
            padding: 1rem 1.5rem;
        }

        #deleteCategoryModal .modal-title {
            font-weight: 600;
            color: #333;
            font-size: 1.1rem;
            display: flex;
            margin: auto;
        }

        #deleteCategoryModal .btn-close {
            font-size: 0.8rem;
        }

        #deleteCategoryModal .modal-body {
            padding: 1.5rem;
            color: #555;
            line-height: 1.6;
            text-align: center;
        }

        #deleteCategoryModal .modal-body p {
            font-size: 1.1rem;
        }


        #deleteCategoryModal .modal-footer {
            border-top: 1px solid #eee;
            padding: 1rem 1.5rem;
            background-color: #f8f9fa;
            justify-content: center;
        }

        #deleteCategoryModal .btn {
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            min-width: 100px;
        }

        #deleteCategoryModal .btn-secondary {
            background-color: #f0f0f0;
            color: #333;
            border: none;
        }

        #deleteCategoryModal .btn-danger {
            background-color: #ff4d4f;
            border: none;
        }

        #deleteCategoryModal .btn-danger:hover {
            background-color: #ff7875;
        }

        /* تأثيرات الظهور */
        #deleteCategoryModal.fade .modal-dialog {
            transform: translateY(-20px);
            transition: transform 0.3s ease-out;
        }

        #deleteCategoryModal.show .modal-dialog {
            transform: translateY(0);
        }
    </style>


    <style>
        #editLocationModal .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        #editLocationModal .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            padding: 1rem 1.5rem;
        }

        #editLocationModal .modal-title {
            font-weight: 600;
            color: #2c3e50;
            width: 100%;
            text-align: center;
        }

        #editLocationModal .modal-title i {
            color: #3498db;
        }

        #editLocationModal .modal-body {
            padding: 1.5rem;
            background-color: #fff;
        }

        #editLocationModal .form-group {
            margin-bottom: 1.5rem;
        }

        #editLocationModal .form-control {
            background-color: #f8f9fa;
            border: 1px solid #dfe6e9;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            text-align: center;
            transition: all 0.3s;
        }

        #editLocationModal .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.2);
            background-color: #fff;
        }

        #editLocationModal .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #2c3e50;
            font-weight: 500;
            text-align: center;
        }

        #editLocationModal .modal-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #e9ecef;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            padding: 1rem 1.5rem;
            justify-content: center;
        }

        #editLocationModal .btn-save {
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s;
        }

        #editLocationModal .btn-save:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        #editLocationModal .btn-cancel {
            background-color: #f8f9fa;
            color: #7f8c8d;
            border: 1px solid #dfe6e9;
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s;
        }

        #editLocationModal .btn-cancel:hover {
            background-color: #e9ecef;
            color: #2c3e50;
        }

        #editLocationModal .btn-close {
            filter: invert(0.5);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

                @if($permissions->view_category)
                <!-- زر الإضافة -->
                <div class="text-center">
                    <a href="{{url('view_add_category_position')}}" class="btn btn-danger mb-4 px-5 py-3 rounded">Add Category</a>
                </div>


                <div class="resources-container">

                    @foreach($categories as $category)
                    <div class="resource-card blue">
                        <div class="resource-header">
                            <!-- القائمة المنسدلة -->
                            <div class="category-dropdown">
                                <button class="dropdown-toggle-btn" id="dropdownMenu{{ $category->id }}"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu{{ $category->id }}">
                                    <li>
                                        <button class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#editCategoryModal"
                                            data-id="{{ $category->id }}"
                                            data-name="{{ $category->name }}">
                                            <i class="fas fa-edit me-2"></i> تعديل
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item delete-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteCategoryModal"
                                            data-id="{{ $category->id }}">
                                            <i class="fas fa-trash me-2"></i> حذف
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div class="resource-title">{{ $category->name }}</div>
                        </div>

                        <div class="resource-body">
                            <div class="items">
                                <h6 class="item-name">Name Position</h6>
                                <h6 class="item-value">All Situations</h6>
                                <h6 class="item-value">Price</h6>
                            </div>

                            @foreach($category->positions->groupBy('position_name') as $positionName => $positionsGroup)
                            @php
                            $allSituations = $positionsGroup->flatMap->situations;
                            $situationNames = $allSituations->pluck('situation_name')->unique();
                            $minPrice = $allSituations->min('price');
                            $maxPrice = $allSituations->max('price');
                            @endphp

                            <div class="resource-item" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span class="item-name">{{ $positionName }}</span>
                                <span class="item-value text-primary">{{ $situationNames->implode(', ') }}</span>
                                <span class="item-value text-success">{{ $minPrice }} - {{ $maxPrice }}</span>
                            </div>
                            @endforeach
                        </div>

                        <a href="{{ url('add_pos_situ/'.$category->id) }}" class="view-all-btn">إضافة/تعديل الأوضاع والفحوصات</a>
                    </div>
                    @endforeach

                </div>




            </div>



        </div>


        <!-- Wrapper -->
        <div class="d-flex justify-content-center mb-5">
            <!-- Add Location Form -->
            <div class="elegant-form-container">
                <form id="addLocationForm" class="elegant-form">
                    @csrf
                    <div class="form-header">
                        <i class="fas fa-map-marker-alt"></i>
                        <h3>إضافة موقع جديد</h3>
                    </div>

                    <div class="form-group">
                        <label for="locationInput">📍 اسم الموقع</label>
                        <input type="text" id="locationInput" name="location_name"
                            placeholder="أدخل اسم الموقع..."
                            required>
                        <div class="underline"></div>
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-plus"></i> إضافة الموقع
                    </button>
                </form>
            </div>
        </div>


        <!-- Wrapper -->
        <div class="d-flex flex-column align-items-center justify-content-center min-vh-50 p-4 w-100">
            <!-- Location Table -->
            <div class="table-container">
                <table class="elegant-table">
                    <thead>
                        <tr>
                            <th>اسم الموقع</th>
                            <th>التحكم</th>
                        </tr>
                    </thead>
                    <tbody id="locationTableBody">
                        @forelse($locations as $location)
                        <tr id="location-row-{{ $location->id }}">
                            <td>{{ $location->location_name }}</td>
                            <td>
                                <button type="button"
                                    data-id="{{ $location->id }}"
                                    class="btn edit-btn edit-location-btn "
                                    data-name="{{ $location->location_name }}"
                                    style="border-width: 1.5px;">
                                    تعديل
                                </button>
                                <button type="button"
                                    class=" btn delete-btn delete-location-btn"
                                    data-id="{{ $location->id }}"
                                    style="border-width: 1.5px;">
                                    حذف
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr id="no-data-row">
                            <td colspan="2" class="text-center text-muted">لا توجد بيانات</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>




        <!-- سهم الانتقال لأسفل مع الرسالة -->
        <div class="scroll-down-container">
            <div class="scroll-down-message">انتقل إلى قسم الموقع</div>
            <div class="scroll-down-arrow">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>




    </div>

    <!-- مودال تعديل الموقع -->
    <div class="modal fade" id="editLocationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i> تعديل الموقع
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="editLocationForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="locationName">اسم الموقع</label>
                            <input type="text" class="form-control"
                                id="locationName" name="location_name" required
                                placeholder="أدخل اسم الموقع">
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                        إلغاء
                    </button>
                    <button type="submit" form="editLocationForm" class="btn btn-save">
                        <i class="fas fa-save me-1"></i> حفظ
                    </button>
                </div>
            </div>
        </div>
    </div>










    <!-- مودال تعديل الفئة -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title w-100 text-center">
                        <i class="fas fa-edit me-2"></i> تعديل الفئة
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <form id="editCategoryForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="category_id" id="categoryId">
                        <div class="mb-4 d-flex flex-column align-items-center">
                            <label for="categoryName" class="form-label fw-bold mb-3">
                                اسم الفئة
                            </label>
                            <input type="text"
                                class="form-control form-control-lg border-2 border-primary rounded-pill text-center"
                                id="categoryName"
                                name="name"
                                required
                                value=""
                                placeholder="أدخل اسم الفئة الجديد">
                        </div>
                    </form>
                </div>

                <div class="modal-footer bg-light d-flex justify-content-center">
                    <button type="submit" form="editCategoryForm" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-1"></i> حفظ التغييرات
                    </button>
                    <button type="button" class="btn btn-outline-danger rounded-pill px-4 me-3" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> إلغاء
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- مودال تأكيد الحذف -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تأكيد الحذف</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من رغبتك في حذف هذه الفئة؟ سيتم حذف جميع العناصر المرتبطة بها أيضاً.</p>
                    <form id="deleteCategoryForm" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" form="deleteCategoryForm" class="btn btn-danger">نعم، احذف</button>
                </div>
            </div>
        </div>
    </div>





    <!-- Spinner التحميل -->
    <div id="spinnerOverlay" class="d-none">
        <div class="spinner-container">
            <div class="spinner-content">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">جاري المعالجة...</span>
                </div>
                <div class="spinner-text mt-3 fs-5 fw-bold text-primary">
                    جاري المعالجة...
                </div>
            </div>
        </div>
    </div>


    <!-- JavaScript files-->
    @include('admin.js')
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // كود الجافاسكريبت للتحكم في الظهور والاختفاء
        const scrollContainer = document.querySelector('.scroll-down-container');
        const scrollArrow = document.querySelector('.scroll-down-arrow');
        let lastScrollPosition = window.scrollY;

        // الانتقال لأسفل الصفحة عند الضغط على السهم
        scrollArrow.addEventListener('click', function() {
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: 'smooth'
            });
        });

        // التحكم في ظهور العنصر حسب اتجاه التمرير
        window.addEventListener('scroll', function() {
            const currentScrollPosition = window.scrollY;

            // إذا كان المستخدم يمرر لأعلى
            if (currentScrollPosition < lastScrollPosition) {
                scrollContainer.classList.add('visible');
            }
            // إذا كان المستخدم يمرر لأسفل أو في أسفل الصفحة
            else if (currentScrollPosition + window.innerHeight >= document.body.scrollHeight - 100) {
                scrollContainer.classList.remove('visible');
            }
            // إذا كان في أعلى الصفحة
            else if (currentScrollPosition === 0) {
                scrollContainer.classList.remove('visible');
            }

            lastScrollPosition = currentScrollPosition;
        });

        // إخفاء العنصر عند تحميل الصفحة إذا كان في الأسفل
        document.addEventListener('DOMContentLoaded', function() {
            if (window.scrollY + window.innerHeight >= document.body.scrollHeight - 100) {
                scrollContainer.classList.remove('visible');
            } else {
                setTimeout(() => {
                    scrollContainer.classList.add('visible');
                }, 1000);
            }
        });
    </script>

    <!-- جافا سكريبت الموقع -->
    <script>
        $(document).on('click', '.delete-location-btn', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لن تتمكن من التراجع!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذف!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#spinnerOverlay').show();

                    $.ajax({
                        url: '/location/' + id,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#spinnerOverlay').hide();

                            if (response.status === 'success') {
                                $('#location-row-' + id).fadeOut(300, function() {
                                    $(this).remove();
                                });

                                Swal.fire({
                                    icon: 'success',
                                    title: 'تم الحذف!',
                                    text: 'تم حذف الموقع بنجاح',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire("خطأ!", response.message, "error");
                            }
                        },
                        error: function() {
                            $('#spinnerOverlay').hide();
                            Swal.fire("خطأ!", "فشل الاتصال بالخادم", "error");
                        }
                    });
                }
            });
        });



        $(document).on('click', '.edit-location-btn', function() {
            let locationId = $(this).data('id');
            let locationName = $(this).data('name');

            $('#locationName').val(locationName);
            $('#editLocationForm').attr('action', '/update_location/' + locationId);

            $('#editLocationModal').modal('show');
        });

        $(document).on('submit', '#editLocationForm', function(e) {
            e.preventDefault();

            $('#spinnerOverlay').show(); // إظهار سبنر

            let form = $(this);
            let url = form.attr('action');
            let formData = form.serialize();

            $.ajax({
                url: url,
                type: 'POST', // Laravel يتعامل مع PUT عبر _method
                data: formData,
                success: function(response) {
                    $('#spinnerOverlay').hide();
                    $('#editLocationModal').modal('hide');

                    if (response.status === 'success') {
                        // تحديث فوري للموقع في الجدول
                        $('#location-row-' + response.location.id).find('td:first').text(response.location.location_name);

                        Swal.fire({
                            icon: 'success',
                            title: 'تم التحديث!',
                            text: 'تم تعديل الموقع بنجاح',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire("خطأ!", response.message || "حدث خطأ ما", "error");
                    }
                },
                error: function() {
                    $('#spinnerOverlay').hide();
                    Swal.fire("خطأ!", "فشل الاتصال بالخادم", "error");
                }
            });
        });



        $(document).ready(function() {
            $('#addLocationForm').on('submit', function(e) {
                e.preventDefault();

                // Show spinner
                $('#spinnerOverlay').removeClass('d-none');

                let form = $(this);
                let formData = form.serialize();

                $.ajax({
                    url: "{{ url('add_location') }}",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        $('#spinnerOverlay').addClass('d-none');

                        if (response.status === 'success') {
                            // 🟢 إزالة صف "لا توجد بيانات" لو موجود
                            $('#no-data-row').remove();

                            // 🟢 إضافة الصف الجديد للجدول
                            $('#locationTableBody').append(`
                        <tr id="location-row-${response.location.id}">
                            <td>${response.location.location_name}</td>
                            <td>
                                <button type="button"
                                    data-id="${response.location.id}"
                                    class="btn edit-btn edit-location-btn"
                                    data-name="${response.location.location_name}"
                                    style="border-width: 1.5px;">
                                    تعديل
                                </button>
                                <button type="button"
                                    class="btn delete-btn delete-location-btn"
                                    data-id="${response.location.id}"
                                    style="border-width: 1.5px;">
                                    حذف
                                </button>
                            </td>
                        </tr>
                    `);

                            // 🟢 Clear input
                            $('#locationInput').val('');

                            // 🟢 Toast success
                            Swal.fire({
                                icon: 'success',
                                title: 'تمت الإضافة!',
                                text: 'تمت إضافة الموقع بنجاح.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire('خطأ!', 'لم يتم الإضافة، حاول مجددًا', 'error');
                        }
                    },
                    error: function() {
                        $('#spinnerOverlay').addClass('d-none');
                        Swal.fire('خطأ!', 'حدث خطأ في الاتصال', 'error');
                    }
                });
            });
        });
    </script>


    <!-- سكريبت تعديل الفئة  -->

    <script>
        $(document).ready(function() {
            // تهيئة القوائم المنسدلة
            $('.dropdown-toggle-btn').on('click', function(e) {
                e.stopPropagation();
                $(this).next('.dropdown-menu').toggleClass('show');
            });

            // إغلاق القوائم عند النقر خارجها
            $(document).on('click', function() {
                $('.dropdown-menu').removeClass('show');
            });

            // منع إغلاق القائمة عند النقر عليها
            $('.dropdown-menu').on('click', function(e) {
                e.stopPropagation();
            });

            // تهيئة المتغيرات
            const spinnerOverlay = $('#spinnerOverlay');

            // عرض بيانات الفئة في مودال التعديل عند النقر على زر التعديل
            $('#editCategoryModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const categoryId = button.data('id');
                const categoryName = button.data('name');

                const modal = $(this);
                modal.find('#categoryId').val(categoryId);
                modal.find('#categoryName').val(categoryName);

                // تحديث ال action للفورم
                modal.find('form').attr('action', `/categories/${categoryId}`);
            });

            // تهيئة مودال الحذف
            $('#deleteCategoryModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const categoryId = button.data('id');

                const modal = $(this);
                modal.find('form').attr('action', `/categories/${categoryId}`);
            });

            // معالجة إرسال فورم التعديل
            $('#editCategoryForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const url = form.attr('action');
                const method = form.attr('method');
                const data = form.serialize();
                const modal = $('#editCategoryModal');

                showSpinner();

                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    success: function(response) {
                        console.log('Success:', response); // أضف هذا السطر

                        if (response.success) {
                            const categoryId = response.category.id;
                            const newName = response.category.name;

                            // تحديث العنصر اللي بيعرض اسم الفئة
                            $(`.category-name[data-id="${categoryId}"]`).text(newName);

                            // تحديث الزر بتاع التعديل عشان يشيل الاسم الجديد في data-name
                            $(`button[data-bs-target="#editCategoryModal"][data-id="${categoryId}"]`).data('name', newName);

                            showAlert('success', response.message);
                            modal.modal('hide');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText); // أضف هذا السطر
                        const errorMsg = xhr.responseJSON?.message || 'حدث خطأ أثناء تحديث الفئة';
                        showAlert('danger', errorMsg);
                    },
                    complete: function() {
                        hideSpinner();
                    }
                });
            });

            // معالجة إرسال فورم الحذف
            $('#deleteCategoryForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const url = form.attr('action');
                const method = form.attr('method');
                const modal = $('#deleteCategoryModal');

                showSpinner();

                $.ajax({
                    url: url,
                    type: method,
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            // إزالة العنصر من الصفحة بدون ريلود
                            $(`[data-id="${response.category_id}"]`).closest('.category-item').remove();
                            // يمكنك تعديل هذا السطر حسب هيكل صفحتك

                            // إظهار رسالة نجاح
                            showAlert('success', response.message);

                            // إغلاق المودال
                            modal.modal('hide');
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'حدث خطأ أثناء حذف الفئة';
                        showAlert('danger', errorMsg);
                    },
                    complete: function() {
                        hideSpinner();
                    }
                });
            });

            // دالة لعرض السبنر
            function showSpinner() {
                spinnerOverlay.removeClass('d-none').addClass('d-flex');
            }

            // دالة لإخفاء السبنر
            function hideSpinner() {
                spinnerOverlay.removeClass('d-flex').addClass('d-none');
            }

            // دالة لعرض الرسائل
            function showAlert(type, message) {
                const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

                $('body').append(alertHtml);

                // إزالة الرسالة بعد 5 ثواني
                setTimeout(() => {
                    $('.alert').alert('close');
                }, 5000);
            }
        });
    </script>

    @else
    <div class="no-data">
        <p style="margin: 0; font-size: 18px;">لا تملك صلاحية الوصول للصفحة</p>
    </div>
    @endif
    </div>
</body>

</html>