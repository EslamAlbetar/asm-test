<!DOCTYPE html>
<html>

<head>
    @include('admin.css')

    <style>
    /* تنسيقات أساسية */
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
        line-height: 1.6;
    }

    .page-content {
        padding: 20px 10px;
        max-width: 100%;
        overflow-x: hidden;
    }

    h1 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 20px;
        font-size: clamp(1.5rem, 5vw, 2rem);
    }

    /* تنسيقات الجدول */
    .dev_deg {
        background: #ffffff;
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        min-width: 600px;
    }

    .table th {
        background-color: #007bff;
        color: #fff;
        text-align: center;
        vertical-align: middle;
        padding: 12px 8px;
        font-size: clamp(0.8rem, 2vw, 0.9rem);
    }

    .table td {
        vertical-align: middle;
        text-align: center;
        background-color: #fefefe;
        padding: 10px 8px;
        font-size: clamp(0.8rem, 2vw, 0.9rem);
        border-bottom: 1px solid #f1f5f9;
    }

    /* تنسيقات الأزرار */
    .btn {
        font-size: clamp(0.8rem, 2vw, 1rem);
        border-radius: 8px;
        padding: 8px 15px;
        margin: 3px;
        white-space: nowrap;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
        width: 100%;
    }

    .btn-warning {
        background-color: #ffc107;
        border: none;
        color: #000;
    }

    /* تنسيقات المودال */
    .modal-content {
        border-radius: 12px;
    }

    .modal-header {
        border-bottom: 1px solid #ddd;
        background-color: #f1f1f1;
        padding: 15px;
    }

    .modal-title {
        font-weight: 600;
        font-size: clamp(1.1rem, 3vw, 1.3rem);
    }

    .modal-footer {
        background-color: #fefefe;
        border: none;
        padding: 15px;
    }

    /* تنسيقات النماذج */
    .form-group {
        margin-bottom: 15px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        font-size: clamp(0.9rem, 2vw, 1rem);
        margin-bottom: 5px;
        display: block;
    }

    .form-control {
        border-radius: 6px;
        border: 1px solid #ccc;
        background-color: #ffffff;
        padding: 10px;
        font-size: clamp(0.9rem, 2vw, 1rem);
        transition: border 0.3s;
        width: 100%;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 4px rgba(0, 123, 255, 0.3);
    }

    /* تأثيرات خاصة */
    #loadingSpinner {
        margin: 30px auto;
        text-align: center;
    }

    .btn-close-custom {
        background: none;
        border: none;
        font-size: 22px;
        color: #555;
    }

    .btn-close-custom:hover {
        color: #000;
        cursor: pointer;
    }

    .form-group {
        margin-bottom: 15px;
        padding: 10px;
        background-color: #f9f9f9;
        border-left: 4px solid #007bff;
        border-radius: 8px;
        transition: background 0.3s;
    }

    .form-group:hover {
        background-color: #f1faff;
    }

    /* إخفاء أسهم حقول الأرقام */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    /* تنسيقات إضافية للاستجابة */
    .bg-light-blue-50 {
        background-color: #f0f7ff;
    }

    .table-hover tbody tr:hover {
        background-color: #f8fafc;
    }

    .rounded-lg {
        border-radius: 0.8rem;
    }

    /* تنسيقات حالة الشيفت */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: clamp(0.7rem, 2vw, 0.85rem);
        font-weight: 500;
    }

    .status-icon {
        margin-left: 3px !important;
        font-size: 0.9rem !important;
    }

    .status-active {
        background-color: #dbeafe;
        color: #1d4ed8;
    }

    .status-completed {
        background-color: #dcfce7;
        color: #166534;
    }

    .status-unknown {
        background-color: #f3f4f6;
        color: #4b5563;
    }

    /* استجابة للشاشات الصغيرة */
    @media (max-width: 768px) {
        .page-content {
            padding: 15px 5px;
        }
        
        .dev_deg {
            padding: 10px;
        }
        
        .table th, 
        .table td {
            padding: 8px 5px;
        }
        
        .btn {
            padding: 6px 10px;
            font-size: 0.8rem;
        }
        
        .modal-header,
        .modal-footer {
            padding: 10px;
        }
    }

    /* استجابة للشاشات الكبيرة */
    @media (min-width: 1200px) {
        .page-content {
            padding: 30px 20px;
        }
        
        .dev_deg {
            padding: 25px;
        }
    }
</style>

    <style>
        /* تنسيقات عامة للشاشات الصغيرة */
        @media (max-width: 767.98px) {
            .container-fluid {
                padding: 0 0.5rem;
            }

            .card-header {
                padding: 0.8rem;
            }

            h2 {
                font-size: 1.1rem;
            }

            .shift-card {
                background: white;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }

            .status-badge {
                padding: 4px 8px;
                font-size: 0.8rem;
            }

            .status-icon {
                font-size: 0.9rem;
            }
        }

        /* تنسيقات حالة الشيفت */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-active {
            background-color: #dbeafe;
            color: #1d4ed8;
        }

        .status-completed {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-unknown {
            background-color: #f3f4f6;
            color: #4b5563;
        }

        /* تحسينات للقراءة على الجوال */
        .text-muted.small {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .font-weight-medium {
            font-weight: 500;
        }

        .dropdown-menu {
            max-height: 300px;
            overflow-y: auto;
        }

        .dropdown-item {
            padding: 0.5rem 1.5rem;
            font-size: 0.9rem;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #0056b3;
        }

        .name {
            font-size: 36px !important;
            font-weight: bold;
            text-align: center;
            text-transform: capitalize;
            margin-bottom: 45px;
        }

        .pdff {
            background-color: #f8f9fa;
            color: rgb(1, 13, 26);
            border: none;

            &:hover {
                background-color: #f8f9fa;
                color: rgb(1, 13, 26);
            }
        }
    </style>

    <!-- Spinner Styles -->
    <style>
        .fade {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .fade.show {
            opacity: 1;
        }

        .loader {
            border-top-color: #3498db;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* تنسيق المودال الرئيسي */
        #vacationModal,
        #permissionModal,
        #deductionModal,
        #objectionModal {
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

        #vacationModal:not(.hidden),
        #permissionModal:not(.hidden),
        #deductionModal:not(.hidden),
        #objectionModal:not(.hidden) {
            opacity: 1;
            visibility: visible;
        }

        /* تنسيق محتوى المودال */
        #vacationModal>div,
        #permissionModal>div,
        #deductionModal>div,
        #objectionModal>div {
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

        #vacationModal:not(.hidden)>div,
        #permissionModal:not(.hidden)>div,
        #deductionModal:not(.hidden)>div,
        #objectionModal:not(.hidden)>div {
            transform: translateY(0);
        }

        /* تنسيق العنوان */
        #vacationModal h2,
        #permissionModal h2,
        #deductionModal h2,
        #objectionModal h2 {
            color: #2d3748;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 600;
        }

        /* تنسيق حقول الإدخال */
        #vacationForm input,
        #vacationForm select,
        #vacationForm textarea,
        #permissionForm input,
        #permissionForm select,
        #permissionForm textarea,
        #deductionForm input,
        #deductionForm select,
        #deductionForm textarea,
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

        #vacationForm input:focus,
        #vacationForm select:focus,
        #vacationForm textarea:focus,
        #permissionForm input:focus,
        #permissionForm select:focus,
        #permissionForm textarea:focus,
        #deductionForm input:focus,
        #deductionForm select:focus,
        #deductionForm textarea:focus,
        #objectionForm label {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
            background-color: white;
        }

        #vacationForm input:read-only,
        #permissionForm input:read-only,
        #deductionForm input:read-only,
        #objectionForm label {
            background-color: #edf2f7;
            cursor: not-allowed;
        }

        /* تنسيق التسميات */
        #vacationForm label,
        #permissionForm label,
        #deductionForm label,
        #objectionForm label {
            display: block;
            color: #4a5568;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        /* تنسيق زر الإرسال */
        #vacationForm button[type="submit"],
        #permissionForm button[type="submit"],
        #deductionForm button[type="submit"],
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

        #vacationForm button[type="submit"]:hover,
        #permissionForm button[type="submit"]:hover,
        #deductionForm button[type="submit"]:hover,
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

        .reply-vacation-btn,
        .reply-permission-btn,
        .reply-deduction-btn,
        .reply-objection-btn {
            background-color: #3490dc;
            /* أزرق جميل */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .reply-vacation-btn:hover,
        .reply-permission-btn:hover,
        .reply-deduction-btn:hover,
        .reply-objection-btn:hover {
            background-color: #2779bd;
            /* أزرق أغمق عند التمرير */
            transform: scale(1.05);
        }

        .reply-vacation-btn:active,
        .reply-permission-btn:active,
        .reply-deduction-btn:active,
        .reply-objection-btn:active {
            transform: scale(0.98);
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 24px;
            font-weight: bold;
            color: #888;
            cursor: pointer;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .close-btn:hover {
            color: #333;
            transform: scale(1.2);
        }

        .close-btn:focus {
            outline: none;
        }


        .pagination-wrapper {
            display: flex;
            justify-content: center;
            /* توسيط أفقي */
            align-items: center;
            /* توسيط عمودي (لو كنت عايز) */
            margin-top: 2rem;
            padding: 1rem;
            background-color: #f9fafb;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
            transition: all 0.3s ease;
        }

        .pagination-wrapper:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        }


        /* تنسيق للشاشات الصغيرة */
        @media (max-width: 640px) {

            #vacationModal>div,
            #permissionModal>div,
            #deductionModal>div,
            #objectionModal>div {
                width: 95%;
                padding: 1.5rem;
            }

            #vacationModal h2,
            #permissionModal h2,
            #deductionModal h2 {
                font-size: 1.3rem;
            }

            #vacationForm input,
            #vacationForm select,
            #vacationForm textarea {
                padding: 0.65rem 0.9rem;
            }

            #permissionForm input,
            #permissionForm select,
            #permissionForm textarea {
                padding: 0.65rem 0.9rem;
            }

            #deductionForm input,
            #deductionForm select,
            #deductionForm textarea {
                padding: 0.65rem 0.9rem;
            }

            #objectionForm input,
            #objectionForm select,
            #objectionForm textarea {
                padding: 0.65rem 0.9rem;
            }
        }
    </style>

    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 100% !important;

            margin: 30px auto;
            padding: 0 20px;
        }


        h2 {
            color: var(--dark-color);
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
            position: relative;
            padding-bottom: 15px;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 50%;
            transform: translateX(50%);
            width: 100px;
            height: 3px;
            background-color: var(--primary-color);
        }

        .card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 30px;
            overflow: hidden;
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px 20px;
            font-size: 18px;
            font-weight: bold;
        }

        .card-body {
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-color);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: var(--transition);
            text-align: center;
        }

        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .btn-primary {
            background-color: var(--primary-color);
        }

        .btn-success {
            background-color: var(--success-color);
        }

        .btn-success:hover {
            background-color: #27ae60;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 15px;
        }

        p {
            margin-bottom: 15px;
            font-size: 16px;
        }

        strong {
            color: var(--dark-color);
        }

        #total-hours,
        #monthly-salary {
            font-weight: bold;
            color: var(--primary-color);
            font-size: 18px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: var(--border-radius);
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 15px;
            }
        }



        .deduction-btn {
            background-color: rgb(144, 15, 15);
            color: white;
            padding: 10px 20px;
            border: none;
            font-weight: bold;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
            letter-spacing: 1px;
        }

        .deduction-btn:hover {
            background-color: rgb(176, 46, 46);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .deduction-btn:active {
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


        /* لإخفاء الأسهم في Chrome, Safari, Edge */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* لإخفاء الأسهم في Firefox */
        input[type=number] {
            -moz-appearance: textfield;
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

        .permission-alert {
            border: 3px solid gold;
            animation: slowShake 2s infinite;
            box-shadow: 0 0 10px rgba(218, 165, 32, 0.6);
            border-radius: 10px;
            padding: 10px;
        }

        @keyframes slowShake {
            0% {
                transform: rotate(0);
            }

            25% {
                transform: rotate(0.5deg);
            }

            50% {
                transform: rotate(-0.5deg);
            }

            75% {
                transform: rotate(0.5deg);
            }

            100% {
                transform: rotate(0);
            }
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <div class="page-content">
        <div class="page-header">

            @php
            $userPermissions = \App\Models\AuthedPage::where('user_id', auth()->id())->first();
            @endphp

            @if($userPermissions->details_staff)
            <h4 class="name"> {{ $user->name }} {{ $user->last_name }}</h1>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="text-center text-dark">طباعة التقارير الشهرية</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('staff.filter', $user->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="month">اختر الشهر والسنة</label>
                                    <select name="month" id="month" class="form-select" required>
                                        @foreach($availableMonths as $month)
                                        @php
                                        [$year, $monthNum] = explode('-', $month);
                                        $monthName = \Carbon\Carbon::createFromDate($year, $monthNum)->translatedFormat('F Y');
                                        @endphp
                                        <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                            {{ $monthName }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary mr-3">فلترة</button>

                                    @if(request('month'))
                                    <a href="{{ route('staff.report', [$user->id, 'month' => request('month')]) }}"
                                        class="btn btn-success ms-2" target="_blank">
                                        <i class="fas fa-file-pdf"></i> طباعة تقرير {{ \Carbon\Carbon::createFromFormat('Y-m', request('month'))->translatedFormat('F Y') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if($userPermissions->shift_admin)
                <div class="container">
                    <h2 class="mb-4">💰 حساب الراتب الشهري</h2>

                    {{-- رسائل النجاح والخطأ --}}
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif




                    <!-- اعداد الساعات والايام المستحقة وإعدادات الراتب-->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-center text-dark">اعداد الساعات والايام المستحقة</div>
                        <div class="card-body">
                            <form action="{{ route('salary.update', $user->id) }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="base_salary" class="w-100">الراتب الأساسي (شهريًا):</label>
                                    <input type="number" step="0.01" class="form-control" id="base_salary"
                                        name="base_salary"
                                        value="{{ $salaryCalculator->base_salary ?? 0 }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="gools_day" class="w-100">: عدد الايام المستحقة في الشهر</label>
                                    <input type="number" class="form-control" id="gools_day"
                                        name="gools_day"
                                        value="{{ $salaryCalculator->gools_day ?? 0 }}" required>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="hourly_shift" class="w-100">: مدة الشيفت الواحد (بالساعة)</label>
                                    <input type="number" class="form-control" id="hourly_shift"
                                        name="hourly_shift"
                                        value="{{ $salaryCalculator->hourly_shift ?? 0 }}" required>
                                </div>

                                <button type="submit" class="btn btn-success w-100">💾 حفظ الإعدادات</button>
                            </form>
                        </div>
                    </div>

                    @php
                    $hourly = $salaryCalculator->hourly_rate ?? 0;
                    $hours = $totalHours ?? 0;
                    $monthlySalary = $hourly * $hours;
                    @endphp

                    <div class="card shadow">
                        <div class="card-header bg-success text-center text-dark">تفاصيل الراتب الشهري</div>
                        <div class="card-body">
                            <div class="row text-center">

                                <div class="col-md-6 mb-3">
                                    <h5>🕒 عدد ساعات العمل المستحقة في الشهر</h5>
                                    <p class="fs-5">
                                        <strong id="total-hours">{{ $expectedHoursFormatted }}</strong> ساعة
                                    </p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <h5>📅 عدد الايام المستحقة في الشهر</h5>
                                    <p class="fs-5">
                                        يوم <strong>{{ $salaryCalculator->gools_day ?? 0 }}</strong>
                                    </p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <h5>⏳ إجمالي ساعات العمل هذا الشهر</h5>
                                    <p class="fs-5">
                                        <strong id="total-hours">{{ $formattedWorkTime }}</strong> ساعة
                                    </p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <h5>⏱ مدة الشيفت الواحد (بالساعة) </h5>
                                    <p class="fs-5">
                                        ساعة <strong>{{ $salaryCalculator->hourly_shift ?? 0 }}</strong>
                                    </p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <h5>⏱️ سعر الساعة</h5>
                                    <p class="fs-5">
                                        <strong id="hourly-rate-display">{{ $hourPrice }}</strong> جنيه
                                    </p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <h5>📌 الراتب الأساسي</h5>
                                    <p class="fs-5">
                                        <strong>{{ number_format($salaryCalculator->base_salary ?? 0, 2) }}</strong> جنيه
                                    </p>
                                </div>

                                {{-- عناصر مخفية للسكريبت --}}
                                <input type="hidden" id="hourly-rate" value="{{ $salaryCalculator->hourly_rate ?? 0 }}">
                                <input type="hidden" id="total-hours-hidden" value="{{ $hours }}">
                            </div>
                        </div>
                    </div>




                    <div class="container-fluid">
                        <div class="container">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h2 class="h4 text-dark font-weight-bold text-capitalize m-auto">
                                        <i class="fas fa-clock mr-2 text-primary"></i>
                                        ساعات العمل
                                    </h2>


                                    @if(isset($shifts) && $shifts->count() > 0)
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="pdfDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-file-pdf mr-1"></i> تصدير PDF
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right pdff" aria-labelledby="pdfDropdown">
                                            @foreach($availableMonths as $month)
                                            <a class="dropdown-item" href="{{ route('staff.shifts.pdf', ['id' => $user->id, 'month' => $month]) }}">
                                                {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y') }}
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>


                                <div class="card-body p-4">
                                    @if(isset($shifts) && $shifts->count() > 0)
                                    <div class="table-responsive rounded-lg">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr class="bg-light-blue-50">
                                                    <th class="py-3 px-4 text-center font-semibold text-gray-700">اليوم</th>
                                                    <th class="py-3 px-4 text-center font-semibold text-gray-700">وقت البداية</th>
                                                    <th class="py-3 px-4 text-center font-semibold text-gray-700">وقت النهاية</th>
                                                    <th class="py-3 px-4 text-center font-semibold text-gray-700">المدة</th>
                                                    <th class="py-3 px-4 text-center font-semibold text-gray-700">الحالة</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                @foreach($shifts as $shift)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="py-3 px-4 text-gray-600 text-center">{{ $shift->day }}</td>
                                                    <td class="py-3 px-4 text-gray-600 text-center">
                                                        {{ $shift->started_at ? \Carbon\Carbon::parse($shift->started_at)->format('Y-m-d H:i A') : '-' }}
                                                    </td>
                                                    <td class="py-3 px-4 text-gray-600 text-center">
                                                        {{ $shift->ended_at ? \Carbon\Carbon::parse($shift->ended_at)->format('Y-m-d H:i A') : '-' }}
                                                    </td>
                                                    <td class="py-3 px-4 text-gray-600 text-center">{{ $shift->time ?? '-' }}</td>
                                                    <td class="py-3 px-4 text-center">
                                                        @if($shift->status == 'داخل الشيفت')
                                                        <span class="status-badge status-active">
                                                            <i class="fas fa-play-circle status-icon"></i> {{ $shift->status }}
                                                        </span>
                                                        @elseif($shift->status == 'انتهى الشيفت')
                                                        <span class="status-badge status-completed">
                                                            <i class="fas fa-check-circle status-icon"></i> {{ $shift->status }}
                                                        </span>
                                                        @else
                                                        <span class="status-badge status-unknown">
                                                            <i class="fas fa-question-circle status-icon"></i> {{ $shift->status ?? 'غير معروف' }}
                                                        </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination -->
                                    <div class="mt-6 flex items-center justify-center">
                                        {{ $shifts->links('pagination::bootstrap-4') }}
                                    </div>
                                    @else
                                    <div class="text-center py-8">
                                        <div class="inline-block p-4 bg-blue-50 rounded-full">
                                            <i class="fas fa-calendar-times text-blue-400 text-4xl"></i>
                                        </div>
                                        <h3 class="mt-4 text-lg font-medium text-gray-700">لا توجد ساعات عمل مسجلة</h3>
                                        <p class="mt-1 text-gray-500">لم يتم تسجيل أي شيفتات لهذا الموظف حتى الآن</p>
                                    </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif

                    @if($userPermissions->permission_admin)

                    <!-- طلبات الاذن -->
                    @php
                    $hasMissingSignaturePer = $user->permissions->whereNull('signature')->count() > 0;
                    @endphp
                    <div class="container-fluid ">
                        <div class="container {{ $hasMissingSignaturePer ? 'permission-alert' : '' }}">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h2 class="h4 text-dark font-weight-bold text-capitalize m-auto">
                                        <i class="fas fa-clock mr-2 text-primary"></i>
                                        طلبات الاذن
                                    </h2>
                                </div>

                                <div class="card-body p-4">
                                    @if($permissions->count() > 0)
                                    <div class="table-responsive rounded-lg ">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr class="bg-light-blue-50">
                                                    <th class="py-3 px-4 text-center font-semibold text-gray-700">ساعات الاذن</th>
                                                    <th class="py-3 px-4 text-center font-semibold text-gray-700">وقت الاذن</th>
                                                    <th class="py-3 px-4 text-center font-semibold text-gray-700">السبب</th>
                                                    <th class="py-3 px-4 text-center font-semibold text-gray-700">الحالة</th>
                                                    <th class="py-3 px-4 text-center font-semibold text-gray-700">سبب المدير</th>
                                                    <th class="py-3 px-4 text-center font-semibold text-gray-700">التوقيع</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                @foreach($permissions as $permission)
                                                <tr data-permission-id="{{ $permission->id }}" class="hover:bg-gray-50 transition-colors">
                                                    <td class="py-3 px-4 text-gray-600 text-center">{{ $permission->time_per }} ساعة</td>
                                                    <td class="py-3 px-4 text-gray-600 text-center">{{ $permission->start_end_per }}</td>
                                                    <td class="py-3 px-4 text-gray-600 text-center">{{ $permission->reason_per ?? '-' }}</td>
                                                    <td class="py-3 px-4 text-center status-cell">
                                                        @if($permission->status_per == 'pending')
                                                        <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">
                                                            <i class="fas fa-clock mr-1"></i> قيد المراجعة
                                                        </span>
                                                        @elseif($permission->status_per == 'Approved')
                                                        <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                                            <i class="fas fa-check-circle mr-1"></i> تمت الموافقة
                                                        </span>
                                                        @elseif($permission->status_per == 'Rejected')
                                                        <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">
                                                            <i class="fas fa-times-circle mr-1"></i> مرفوض
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td class="py-3 px-4 text-gray-600 text-center">{{ $permission->reason_admin ?? '-' }}</td>
                                                    <td class="py-3 px-4 text-center">
                                                        @if (!$permission->signature)
                                                        <button class="reply-permission-btn" data-id="{{ $permission->id }}">الرد</button>
                                                        @else
                                                        {{ $permission->signature }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                                <!-- Pagination -->
                                <div class="pagination-wrapper">
                                    {{ $permissions->links('pagination::bootstrap-4') }}
                                </div>
                                @else
                                <div class="text-center py-8">
                                    <div class="inline-block p-4 bg-blue-50 rounded-full">
                                        <i class="fas fa-clock text-blue-400 text-4xl"></i>
                                    </div>
                                    <h3 class="mt-4 text-lg font-medium text-gray-700">لا توجد طلبات إذن</h3>
                                    <p class="mt-1 text-gray-500">لم يتم تقديم أي طلبات إذن حتى الآن</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>




                    <!-- Reply Modal to permission -->
                    <div id="permissionModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex justify-center items-center hidden z-50 transition-all duration-300">
                        <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-2xl relative transform scale-95 opacity-0 transition-all duration-300">
                            <!-- زر X -->
                            <button id="permissionModalCloseX" class="close-btn">&times;</button>

                            <h2 class="text-dark text-lg font-bold mb-4">الرد على طلب الإذن</h2>

                            <form id="permissionForm" method="POST" action="{{ route('permissions.reply') }}">
                                @csrf
                                <input type="hidden" name="permission_id" id="permission_id">

                                <!-- الاسم -->
                                <div class="mb-4">
                                    <label class="">الاسم كامل</label>
                                    <input type="text" value="{{ auth()->user()->name }} {{ auth()->user()->last_name }}" readonly
                                        class="w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-3 shadow-sm focus:outline-none">
                                </div>

                                <!-- الحالة -->
                                <div class="mb-4">
                                    <label class="">حالة الطلب</label>
                                    <select name="status_per" required
                                        class="w-full border border-gray-300 rounded-lg py-2 px-3 bg-white shadow-sm focus:outline-none">
                                        <option selected value="waiting">قيد الانتظار</option>
                                        <option value="Approved">موافقة</option>
                                        <option value="Rejected">مرفوض</option>
                                    </select>
                                </div>

                                <!-- السبب -->
                                <div class="mb-4">
                                    <label class="">سبب المدير</label>
                                    <textarea name="reason_admin" rows="4" required placeholder="اكتب السبب"
                                        class="w-full border border-gray-300 rounded-lg py-2 px-3 shadow-sm focus:outline-none"></textarea>
                                </div>

                                <!-- التوقيع -->
                                <div class="mb-4">
                                    <label class="">توقيع المسؤول</label>
                                    <input type="text" name="signature" readonly value="{{ auth()->user()->name }}"
                                        class="w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-3 shadow-sm focus:outline-none">
                                </div>


                                <!-- زر الإرسال -->
                                <div class="flex justify-center">
                                    <button type="submit"
                                        class="bg-green-500 text-white font-semibold px-6 py-2 rounded-lg hover:bg-green-600 transition relative">
                                        ارسال
                                        <span id="spinner" class="hidden absolute right-3 top-1/2 transform -translate-y-1/2">
                                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>


                    @endif









                    @if($userPermissions->vacation_admin)

                    @php
                    $hasMissingSignatureVac = $user->Vacations->whereNull('signature')->count() > 0;
                    @endphp

                    <!-- طلبات الاجازة -->
                    <div class="container-fluid ">
                        <div class="container {{ $hasMissingSignatureVac ? 'permission-alert' : '' }}">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h2 class="h4 text-dark font-weight-bold text-capitalize m-auto">
                                        <i class="fas fa-clock mr-2 text-primary"></i>
                                        طلبات الاجازة
                                    </h2>
                                </div>

                                <div class="card-body p-4">
                                    @if($vacations->count() > 0)
                                    <div class="table-responsive rounded-lg">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr class="bg-light-blue-50">
                                                    <th class="py-3 px-4 text-center font-semibold text-gray-700">ايام الاجازة</th>
                                                    <th class="py-3 px-4 text-center font-semibold text-gray-700">سبب الموظف</th>
                                                    <th class="py-3 px-4 text-center font-semibold text-gray-700">الحالة</th>
                                                    <th class="py-3 px-4 text-center font-semibold text-gray-700">سبب المدير</th>
                                                    <th class="py-3 px-4 text-center font-semibold text-gray-700">التوقيع</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                @foreach($vacations as $vacation)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="py-3 px-4 text-gray-600 text-center">{{ $vacation->num_vac }} يوم</td>

                                                    <td class="py-3 px-4 text-gray-600 text-center">{{ $vacation->reason_vac ?? '-' }}</td>
                                                    <td class="py-3 px-4 text-center">
                                                        @if($vacation->status_vac == 'pending')
                                                        <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">
                                                            <i class="fas fa-clock mr-1"></i> قيد الانتظار
                                                        </span>
                                                        @elseif($vacation->status_vac == 'Approved')
                                                        <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                                            <i class="fas fa-check-circle mr-1"></i> تمت الموافقة
                                                        </span>
                                                        @else
                                                        <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800">
                                                            <i class="fas fa-times-circle mr-1"></i> مرفوض
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td class="py-3 px-4 text-gray-600 text-center">{{ $vacation->reason_admin ?? '-' }}</td>
                                                    <td class="py-3 px-4 text-center">
                                                        @if (!$vacation->signature)
                                                        <button class="reply-vacation-btn" data-id="{{ $vacation->id }}">الرد</button>
                                                        @else
                                                        {{ $vacation->signature }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <!-- Pagination -->
                                <div class="pagination-wrapper">
                                    {{ $vacations->links('pagination::bootstrap-4') }}
                                </div>
                                @else
                                <div class="text-center py-8">
                                    <div class="inline-block p-4 bg-blue-50 rounded-full">
                                        <i class="fas fa-clock text-blue-400 text-4xl"></i>
                                    </div>
                                    <h3 class="mt-4 text-lg font-medium text-gray-700">لا توجد طلبات اجازة</h3>
                                    <p class="mt-1 text-gray-500">لم يتم تقديم أي طلبات اجازة حتى الآن</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>






                    <!-- Reply Modal to Vacations -->
                    <div id="vacationModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex justify-center items-center hidden z-50 transition-all duration-300">
                        <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-2xl relative transform scale-95 opacity-0 transition-all duration-300">
                            <!-- زر X -->
                            <button id="vacationModalCloseX" class="close-btn">&times;</button>

                            <h2 class="text-dark text-lg font-bold mb-4">الرد على طلب الاجازة</h2>

                            <form id="vacationForm" method="POST" action="{{ route('vacations.reply') }}">
                                @csrf
                                <input type="hidden" name="vacation_id" id="vacation_id">

                                <!-- الاسم -->
                                <div class="mb-4">
                                    <label class="">الاسم كامل</label>
                                    <input type="text" value="{{ auth()->user()->name }} {{ auth()->user()->last_name }}" readonly
                                        class="w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-3 shadow-sm focus:outline-none">
                                </div>

                                <!-- الحالة -->
                                <div class="mb-4">
                                    <label class="">حالة الطلب</label>
                                    <select name="status_vac" required
                                        class="w-full border border-gray-300 rounded-lg py-2 px-3 bg-white shadow-sm focus:outline-none">
                                        <option selected value="waiting">قيد الانتظار</option>
                                        <option value="Approved">موافقة</option>
                                        <option value="Rejected">مرفوض</option>
                                    </select>
                                </div>

                                <!-- السبب -->
                                <div class="mb-4">
                                    <label class="">سبب المدير</label>
                                    <textarea name="reason_admin" rows="4" required placeholder="اكتب السبب"
                                        class="w-full border border-gray-300 rounded-lg py-2 px-3 shadow-sm focus:outline-none"></textarea>
                                </div>

                                <!-- التوقيع -->
                                <div class="mb-4">
                                    <label class="">توقيع المسؤول</label>
                                    <input type="text" name="signature" readonly value="{{ auth()->user()->name }}"
                                        class="w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-3 shadow-sm focus:outline-none">
                                </div>


                                <!-- زر الإرسال -->
                                <div class="flex justify-center">
                                    <button type="submit"
                                        class="bg-green-500 text-white font-semibold px-6 py-2 rounded-lg hover:bg-green-600 transition relative">
                                        ارسال
                                        <span id="spinner" class="hidden absolute right-3 top-1/2 transform -translate-y-1/2">
                                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>


                    @endif

                    @if($userPermissions->deduction_admin)

                    @php
                    $hasMissingSignatureDed = $user->deductions->whereNull('signature_objection_admin')->count() > 0;
                    @endphp
                    <!-- طلبات الخصومات -->
                    <div class="container-fluid">
                        <div class="container container-wide  {{ $hasMissingSignatureDed ? 'permission-alert' : '' }}">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h2 class="h4 text-dark font-weight-bold text-capitalize m-auto">
                                        <i class="fas fa-clock mr-2 text-primary"></i>
                                        جدول الخصومات
                                    </h2>


                                    <!-- Button -->
                                    <div class="text-center mb-6">
                                        <button id="openModalDed" class="deduction-btn">
                                            تقديم خصم
                                        </button>
                                    </div>

                                </div>

                                <div class="card-body">
                                    @if($deductions->count() > 0)
                                    <div class="table-responsive rounded-lg" style="overflow-x: auto; white-space: nowrap;">
                                        <table class="table table-hover mb-0 table-bordered w-full">
                                            <thead>
                                                <tr class="bg-light-blue-50">
                                                    <th class="py-3 px-4 border-b text-center text-nowrap">#</th>
                                                    <th class="py-3 px-4 border-b text-center text-nowrap">الاسم</th>
                                                    <th class="py-3 px-4 border-b text-center text-nowrap">مبلغ الخصم</th>
                                                    <th class="py-3 px-4 border-b text-center text-nowrap">سبب الخصم</th>
                                                    <th class="py-3 px-4 border-b text-center text-nowrap">حالة الخصم</th>
                                                    <th class="py-3 px-4 border-b text-center text-nowrap">توقيع المسؤول</th>
                                                    <th class="py-3 px-4 border-b text-center text-nowrap">اعتراض</th>
                                                    <th class="py-3 px-4 border-b text-center text-nowrap">سبب الاعتراض</th>
                                                    <th class="py-3 px-4 border-b text-center text-nowrap">حالة الاعتراض</th>
                                                    <th class="py-3 px-4 border-b text-center text-nowrap">الرد على الاعتراض</th>
                                                    <th class="py-3 px-4 border-b text-center text-nowrap">توقيع المسؤول</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                @foreach($deductions as $deduction)
                                                <tr class="border-t hover:bg-gray-50">
                                                    <td class="py-3 px-4 text-nowrap">{{ $loop->iteration }}</td>
                                                    <td class="py-3 px-4 text-nowrap">{{ $deduction->user->name ?? 'غير معروف' }} {{ $deduction->user->last_name ?? '' }}</td>
                                                    <td class="py-3 px-4 text-nowrap">{{ $deduction->amount_ded }}</td>
                                                    <td class="py-3 px-4 text-nowrap">{{ $deduction->reason_ded }}</td>
                                                    <td class="py-3 px-4 text-nowrap">


                                                        @if($deduction->status_ded == 'Approved')
                                                        <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-success">
                                                            <i class="fas fa-circle mr-1"></i> تم تطبيق الخصم
                                                        </span>
                                                        @else
                                                        <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-danger">
                                                            <i class="fas fa-circle mr-1"></i> تم رفع الخصم
                                                        </span>

                                                        @endif

                                                    </td>
                                                    <td class="py-3 px-4 text-nowrap">{{ $deduction->signature_ded }}</td>
                                                    <td class="py-3 px-4 text-nowrap">
                                                        @if($deduction->objection_ded == 'Approved')
                                                        <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-success">
                                                            <i class="fas fa-circle mr-1"></i> تم الاعتراض
                                                        </span>
                                                        @else
                                                        <span class="px-2 py-1 rounded-full text-xs text-secondary">
                                                            <i class="fas fa-circle mr-1"></i> لم يتم الاعتراض
                                                        </span>

                                                        @endif

                                                    </td>
                                                    <td class="py-3 px-4 text-nowrap">{{ $deduction->objection_reason ?? '---' }}</td>
                                                    <td class="py-3 px-4 text-nowrap text-center">
                                                        @if($deduction->objection_status == 'pending')
                                                        <span class="px-2 py-1 rounded-full text-xs bg-yellow-100 text-warning">
                                                            <i class="fas fa-clock mr-1"></i> قيد الانتظار
                                                        </span>
                                                        @elseif($deduction->objection_status == 'Approved')
                                                        <span class="px-2 py-1 rounded-full text-xs bg-green-100 text-success">
                                                            <i class="fas fa-check-circle mr-1"></i> تمت الموافقة
                                                        </span>
                                                        @elseif($deduction->objection_status == 'Rejected')
                                                        <span class="px-2 py-1 rounded-full text-xs bg-red-100 text-danger">
                                                            <i class="fas fa-times-circle mr-1"></i> تم الرفض
                                                        </span>
                                                        @else
                                                        <span class="px-2 py-1 rounded-full text-xs text-secondary">
                                                            ---
                                                        </span>
                                                        @endif
                                                    </td>





                                                    <td class="py-3 px-4 text-nowrap">{{ $deduction->reason_admin_objection ?? '---' }}</td>

                                                    <td class="py-3 px-4 text-nowrap text-center">
                                                        @if (!$deduction->signature_objection_admin)
                                                        <button class="reply-objection-btn" data-id="{{ $deduction->id }}">الرد</button>
                                                        @else
                                                        {{ $deduction->signature_objection_admin  }}
                                                        @endif
                                                    </td>

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <!-- Pagination -->
                                <div class="pagination-wrapper">
                                    {{ $deductions->links('pagination::bootstrap-4') }}
                                </div>
                                @else
                                <div class="text-center py-8">
                                    <div class="inline-block p-4 bg-blue-50 rounded-full">
                                        <i class="fas fa-clock text-blue-400 text-4xl"></i>
                                    </div>
                                    <h3 class="mt-4 text-lg font-medium text-gray-700">لا توجد خصومات</h3>
                                    <p class="mt-1 text-gray-500">لم يتم تقديم أي خصومات حتى الآن</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>




                    <!-- مودل تقديم خصم جديد -->
                    <div id="deductionModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex justify-center items-center hidden z-50 transition-all duration-300">
                        <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-2xl relative">
                            <h2 class="text-dark">تقديم خصم</h2>

                            <form id="deductionForm">
                                @csrf

                                <!-- Full Name -->
                                <div class="mb-4">
                                    <label class="">الاسم كامل</label>
                                    <input type="text" value="{{ $user->name }}" readonly
                                        class="w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-3 shadow-sm focus:outline-none">
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                </div>

                                <!-- Number of Days -->
                                <div class="mb-4">
                                    <label class="">مبلغ الخصم </label>
                                    <input name="amount_ded" type="text" required
                                        class="w-full border border-gray-300 rounded-lg py-2 px-3 shadow-sm focus:outline-none"
                                        placeholder="مبلغ الخصم">
                                </div>

                                <!-- Reason -->
                                <div class="mb-4">
                                    <label class="">سبب الخصم</label>
                                    <textarea name="reason_ded" rows="4" required
                                        placeholder="اكتب سبب تقديم الخصم"
                                        class="w-full border border-gray-300 rounded-lg py-2 px-3 shadow-sm focus:outline-none"></textarea>
                                </div>

                                <!-- objection status -->
                                <div class="mb-4">
                                    <input type="hidden" name="objection_status" readonly value="{{ 'Approved' }}"
                                        class="w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-3 shadow-sm focus:outline-none">
                                </div>

                                <!-- signature -->
                                <div class="mb-4">
                                    <label class="">توقيع المسؤول</label>
                                    <input type="text" name="signature_ded" readonly value="{{ auth()->user()->name }}"
                                        class="w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-3 shadow-sm focus:outline-none">
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



                    <!-- الرد على اعتراض الخصم -->
                    <div id="objectionModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex justify-center items-center hidden z-50 transition-all duration-300">
                        <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-2xl relative transform scale-95 opacity-0 transition-all duration-300">
                            <!-- زر X -->
                            <button id="objectionModalCloseX" class="close-btn">&times;</button>

                            <h2 class="text-dark text-lg font-bold mb-4">الرد على طلب الاعتراض للخصم</h2>

                            <form id="objectionForm" method="POST" action="{{ route('deductions.reply') }}">
                                @csrf
                                <input type="hidden" name="deduction_id" id="deduction_id">

                                <!-- السبب -->
                                <div class="mb-4">
                                    <label class="">رد المدير على الاعتراض</label>
                                    <textarea name="reason_admin_objection" rows="4" required placeholder="اكتب رد المدير على الاعتراض"
                                        class="w-full border border-gray-300 rounded-lg py-2 px-3 shadow-sm focus:outline-none"></textarea>
                                </div>

                                <!-- الحالة -->
                                <div class="mb-4">
                                    <label class="">حالة الاعتراض</label>
                                    <select name="objection_status" required
                                        class="w-full border border-gray-300 rounded-lg py-2 px-3 bg-white shadow-sm focus:outline-none">
                                        <option selected value="waiting">قيد الانتظار</option>
                                        <option value="Approved">موافقة</option>
                                        <option value="Rejected">مرفوض</option>
                                    </select>
                                </div>

                                <!-- objection status -->
                                <div class="mb-4">
                                    <label class="">الحالة النهائية للخصم </label>
                                    <select name="status_ded" required
                                        class="w-full border border-gray-300 rounded-lg py-2 px-3 bg-white shadow-sm focus:outline-none">
                                        <option value="Approved" class="text-success"> اختر حالة تطبيق الخصم</option>
                                        <option value="Approved" class="text-success"> تطبيق الخصم</option>
                                        <option value="Rejected" class="text-danger"> رفع الخصم</option>
                                    </select>
                                </div>

                                <!-- التوقيع -->
                                <div class="mb-4">
                                    <label class="">توقيع المسؤول</label>
                                    <input type="text" name="signature_objection_admin" readonly value="{{ auth()->user()->name }}"
                                        class="w-full bg-gray-100 text-gray-700 border border-gray-300 rounded-lg py-2 px-3 shadow-sm focus:outline-none">
                                </div>


                                <!-- زر الإرسال -->
                                <div class="flex justify-center">
                                    <button type="submit"
                                        class="bg-green-500 text-white font-semibold px-6 py-2 rounded-lg hover:bg-green-600 transition relative">
                                        ارسال
                                        <span id="spinner" class="hidden absolute right-3 top-1/2 transform -translate-y-1/2">
                                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>


                    @endif
                </div>
        </div>



        <div id="confirmCancelModal" class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex justify-center items-center hidden z-50">
            <div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-2xl relative">
                <h2 class="text-xl font-bold mb-4">تأكيد الإلغاء</h2>
                <p class="mb-6">هل أنت متأكد من رغبتك في إلغاء هذا الخصم؟</p>

                <div class="flex justify-end space-x-4">
                    <button onclick="closeCancelModal()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        إلغاء
                    </button>
                    <button id="confirmCancelBtn" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                        نعم، إلغاء
                    </button>
                </div>
            </div>
        </div>

        <!-- JavaScript files-->
        @include('admin.js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@flasher/flasher@1.2.4/dist/flasher.min.js"></script>
        <script src="/js/your-custom-scripts.js"></script>

        <!-- ارسال خصم -->
        <script>
            // Modal handling
            const openBtn = document.getElementById("openModalDed");
            const closeBtn = document.getElementById("closeModal");
            const modal = document.getElementById("deductionModal");

            if (openBtn && closeBtn && modal) {
                openBtn.addEventListener("click", () => {
                    modal.classList.remove("hidden");
                });

                closeBtn.addEventListener("click", () => {
                    modal.classList.add("hidden");
                });

                window.addEventListener("click", (e) => {
                    if (e.target === modal) {
                        modal.classList.add("hidden");
                    }
                });
            }

            // Form submission
            const deductionForm = document.getElementById("deductionForm");
            if (deductionForm) {
                deductionForm.addEventListener("submit", async function(e) {
                    e.preventDefault();

                    const spinner = this.querySelector("#spinner");
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (spinner) spinner.classList.remove("hidden");
                    if (submitBtn) submitBtn.disabled = true;

                    try {
                        const formData = new FormData(this);
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

                        if (!csrfToken) {
                            throw new Error('CSRF token not found');
                        }

                        const response = await fetch("{{ route('deduction.store') }}", {
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                            body: formData
                        });

                        const data = await response.json();
                        if (response.ok) {
                            // نجاح
                            alert("تم إرسال الطلب بنجاح");
                            window.location.reload();
                        } else {
                            console.error("Server Error", data);
                            alert("حدث خطأ في الارسال");
                        }

                    } catch (error) {
                        console.error("Error:", error.message);
                        alert("حدث خطأ في الاتصال بالخادم");
                    } finally {
                        if (spinner) spinner.classList.add("hidden");
                        if (submitBtn) submitBtn.disabled = false;
                    }
                });

            }

            // Toastr configuration
            if (typeof toastr !== 'undefined') {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "timeOut": "3000"
                };
            }

            // Cancel deduction functionality
            let selectedDeductionId = null;
            let selectedButton = null;

            function showCancelModal(id, button) {
                selectedDeductionId = id;
                selectedButton = button;
                const modal = document.getElementById('confirmCancelModal');
                if (modal) modal.classList.remove('hidden');
            }

            function closeCancelModal() {
                const modal = document.getElementById('confirmCancelModal');
                if (modal) modal.classList.add('hidden');
            }

            const confirmCancelBtn = document.getElementById('confirmCancelBtn');
            if (confirmCancelBtn) {
                confirmCancelBtn.addEventListener('click', async () => {
                    if (!selectedDeductionId) return;

                    const cancelBtn = document.querySelector('#confirmCancelModal button[onclick="closeCancelModal()"]');

                    if (confirmCancelBtn) confirmCancelBtn.disabled = true;
                    if (cancelBtn) cancelBtn.disabled = true;
                    if (confirmCancelBtn) confirmCancelBtn.textContent = "جارٍ الإلغاء...";

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                        if (!csrfToken) throw new Error('CSRF token not found');

                        const response = await fetch(`/deduction/${selectedDeductionId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'فشل في إلغاء الطلب');
                        }

                        if (data.success) {
                            if (selectedButton) {
                                const row = selectedButton.closest('tr');
                                if (row) row.remove();
                            }
                            if (typeof toastr !== 'undefined') {
                                toastr.success(data.message || 'تم إلغاء الطلب بنجاح');
                            }
                        } else {
                            if (typeof toastr !== 'undefined') {
                                toastr.error(data.message || 'فشل في إلغاء الطلب');
                            }
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        if (typeof toastr !== 'undefined') {
                            toastr.error(error.message || "حدث خطأ أثناء الإلغاء");
                        }
                    } finally {
                        if (confirmCancelBtn) confirmCancelBtn.disabled = false;
                        if (cancelBtn) cancelBtn.disabled = false;
                        if (confirmCancelBtn) confirmCancelBtn.textContent = "نعم، إلغاء";
                        closeCancelModal();
                    }
                });
            }
        </script>


        <!-- الرد على الاعتراض -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // العناصر
                const modal = document.getElementById('objectionModal');
                const closeX = document.getElementById('objectionModalCloseX');
                const replyButtons = document.querySelectorAll('.reply-objection-btn');
                const vacationIdInput = document.getElementById('deduction_id');

                // فتح المودال
                replyButtons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.getAttribute('data-id');
                        vacationIdInput.value = id;
                        modal.classList.remove('hidden');
                        setTimeout(() => {
                            modal.querySelector('div').classList.remove('opacity-0', 'scale-95');
                            modal.querySelector('div').classList.add('opacity-100', 'scale-100');
                        }, 10);
                    });
                });

                // قفل المودال بالزر X
                closeX.addEventListener('click', () => {
                    modal.querySelector('div').classList.add('opacity-0', 'scale-95');
                    modal.querySelector('div').classList.remove('opacity-100', 'scale-100');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                    }, 300);
                });

                // قفل المودال لما تضغط بره المودال (خلفية المودال)
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        closeX.click();
                    }
                });
            });

            document.getElementById('objectionForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = e.target;
                const spinner = document.getElementById('spinner');
                const submitBtn = form.querySelector('button[type="submit"]');
                const formData = new FormData(form);

                // إظهار spinner وتعطيل زر الإرسال
                spinner.classList.remove('hidden');
                submitBtn.disabled = true;

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            toastr.success(data.message);

                            // إغلاق المودال
                            const modal = document.getElementById('objectionModal');
                            modal.querySelector('div').classList.add('opacity-0', 'scale-95');
                            modal.querySelector('div').classList.remove('opacity-100', 'scale-100');
                            setTimeout(() => {
                                modal.classList.add('hidden');
                            }, 300);

                            // تحديث الصفحة بعد ثانيتين
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            toastr.error(data.message || 'حدث خطأ أثناء الإرسال');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('حدث خطأ أثناء الإرسال');
                    })
                    .finally(() => {
                        spinner.classList.add('hidden');
                        submitBtn.disabled = false;
                    });
            });
        </script>





        <!-- ازرار القائمة المنسدلة -->
        <script>
            $(document).ready(function() {
                // تعديل زر القائمة المنسدلة لاستخدام data-bs-toggle بدلاً من data-toggle
                $('.dropdown-toggle').click(function() {
                    var dropdownMenu = $(this).next('.dropdown-menu');
                    $('.dropdown-menu').not(dropdownMenu).hide();
                    dropdownMenu.toggle();
                });

                // إغلاق القوائم المنسدلة عند النقر خارجها
                $(document).click(function(e) {
                    if (!$(e.target).closest('.dropdown').length) {
                        $('.dropdown-menu').hide();
                    }
                });
            });
        </script>


        <!--  الرد على الاذن -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // تحديد العناصر الخاصة بالاذن
                const permissionModal = document.getElementById('permissionModal');
                const permissionModalBox = permissionModal.querySelector('div.bg-white');
                const permissionForm = document.getElementById('permissionForm');
                const permissionSpinner = document.getElementById('permissionSpinner');

                // فتح مودال الاذن
                function openPermissionModal(permissionId) {
                    document.getElementById('permission_id').value = permissionId;
                    permissionModal.classList.remove('hidden');
                    setTimeout(() => {
                        permissionModalBox.classList.remove('scale-95', 'opacity-0');
                        permissionModalBox.classList.add('scale-100', 'opacity-100');
                    }, 10);
                }

                // إغلاق مودال الاذن
                function closePermissionModal() {
                    permissionModalBox.classList.remove('scale-100', 'opacity-100');
                    permissionModalBox.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        permissionModal.classList.add('hidden');
                    }, 300);
                }

                // حدث الزر للاذن (استخدم فئة مختلفة)
                document.querySelectorAll('.reply-permission-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        openPermissionModal(this.dataset.id);
                    });
                });

                // أحداث الإغلاق للاذن
                document.getElementById('permissionModalCloseX').addEventListener('click', closePermissionModal);
                document.getElementById('closeModalPermission').addEventListener('click', closePermissionModal);

                // إرسال AJAX للاذن
                permissionForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    permissionSpinner.classList.remove('hidden');

                    try {
                        const formData = new FormData(permissionForm);
                        const response = await fetch(permissionForm.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'حدث خطأ في الخادم');
                        }

                        if (data.success) {
                            updatePermissionRow(data.permission);
                            closePermissionModal();
                            toastr.success(data.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        toastr.error(error.message || 'حدث خطأ أثناء الحفظ');
                    } finally {
                        permissionSpinner.classList.add('hidden');
                    }
                });

                function updatePermissionRow(permission) {
                    const row = document.querySelector(`tr[data-permission-id="${permission.id}"]`);
                    if (!row) return;

                    // تحديث الحالة
                    const statusCell = row.querySelector('.status-permission-cell');
                    if (statusCell) {
                        statusCell.innerHTML = permission.status_per === 'Approved' ?
                            '<span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i> تمت الموافقة</span>' :
                            '<span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800"><i class="fas fa-times-circle mr-1"></i> مرفوض</span>';
                    }

                    // تحديث سبب المدير
                    const reasonCell = row.querySelector('.reason-permission-cell');
                    if (reasonCell) reasonCell.textContent = permission.reason_admin;

                    // تحديث التوقيع
                    const signatureCell = row.querySelector('.signature-permission-cell');
                    if (signatureCell) signatureCell.innerHTML = permission.signature;
                }
            });
        </script>

        <!-- الرد على الاجازة -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // تحديد العناصر الخاصة بالاجازة
                const vacationModal = document.getElementById('vacationModal');
                const vacationModalBox = vacationModal.querySelector('div.bg-white');
                const vacationForm = document.getElementById('vacationForm');
                const vacationSpinner = document.getElementById('vacationSpinner');

                // فتح مودال الاجازة
                function openVacationModal(vacationId) {
                    document.getElementById('vacation_id').value = vacationId;
                    vacationModal.classList.remove('hidden');
                    setTimeout(() => {
                        vacationModalBox.classList.remove('scale-95', 'opacity-0');
                        vacationModalBox.classList.add('scale-100', 'opacity-100');
                    }, 10);
                }

                // إغلاق مودال الاجازة
                function closeVacationModal() {
                    vacationModalBox.classList.remove('scale-100', 'opacity-100');
                    vacationModalBox.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        vacationModal.classList.add('hidden');
                    }, 300);
                }

                // حدث الزر للاجازة (استخدم فئة مختلفة)
                document.querySelectorAll('.reply-vacation-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        openVacationModal(this.dataset.id);
                    });
                });

                // أحداث الإغلاق للاجازة
                document.getElementById('vacationModalCloseX').addEventListener('click', closeVacationModal);
                document.getElementById('closeModalVacation').addEventListener('click', closeVacationModal);

                // إرسال AJAX للاجازة
                vacationForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    vacationSpinner.classList.remove('hidden');

                    try {
                        const formData = new FormData(vacationForm);
                        const response = await fetch(vacationForm.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'حدث خطأ في الخادم');
                        }

                        if (data.success) {
                            updateVacationRow(data.vacation);
                            closeVacationModal();
                            toastr.success(data.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        toastr.error(error.message || 'حدث خطأ أثناء الحفظ');
                    } finally {
                        vacationSpinner.classList.add('hidden');
                    }
                });

                function updateVacationRow(vacation) {
                    const row = document.querySelector(`tr[data-vacation-id="${vacation.id}"]`);
                    if (!row) return;

                    // تحديث الحالة
                    const statusCell = row.querySelector('.status-vacation-cell');
                    if (statusCell) {
                        statusCell.innerHTML = vacation.status_vac === 'Approved' ?
                            '<span class="px-2 py-1 rounded-full text-xs bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i> تمت الموافقة</span>' :
                            '<span class="px-2 py-1 rounded-full text-xs bg-red-100 text-red-800"><i class="fas fa-times-circle mr-1"></i> مرفوض</span>';
                    }

                    // تحديث سبب المدير
                    const reasonCell = row.querySelector('.reason-vacation-cell');
                    if (reasonCell) reasonCell.textContent = vacation.reason_admin;

                    // تحديث التوقيع
                    const signatureCell = row.querySelector('.signature-vacation-cell');
                    if (signatureCell) signatureCell.innerHTML = vacation.signature;
                }
            });
        </script>





    </div>
    @else
    <div class="no-data">
        <p style="margin: 0; font-size: 18px;">لا توجد بيانات يومية متاحة لهذا الشهر</p>
    </div>
    @endif
</body>

</html>