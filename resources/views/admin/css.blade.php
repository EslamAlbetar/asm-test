<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Dark Bootstrap Admin </title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="all,follow">
<!-- Bootstrap CSS-->
<link rel="stylesheet" href="{{asset('home/vendor/bootstrap/css/bootstrap.min.css')}}">
<!-- Font Awesome CSS-->
<link rel="stylesheet" href="{{asset('home/vendor/font-awesome/css/font-awesome.min.css')}}">
<!-- Custom Font Icons CSS-->
<link rel="stylesheet" href="{{asset('home/css/font.css')}}">
<!-- Google fonts - Muli-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
<!-- theme stylesheet-->
<link rel="stylesheet" href="{{asset('home/css/style.default.css')}}" id="theme-stylesheet">
<!-- Custom stylesheet - for your changes-->
<link rel="stylesheet" href="{{asset('home/css/custom.css')}}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&display=swap" rel="stylesheet">


<!-- Font Awesome للأيقونات -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">



<!-- head: below existing links -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@4.0.1/dist/css/multi-select-tag.min.css">

<!-- Favicon-->
<link rel="shortcut icon" href="{{asset('home/img/favicon.ico')}}">

<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

<!-- اشعارات الموظفين -->
<style>
    .alert-border {
        border: 3px solid gold;
        position: relative;
        animation: shake .5s infinite;
        box-shadow: 0 0 10px gold;
    }

    .alert-icon {
        position: absolute;
        top: -10px;
        left: -10px;
        color: #ffffff;
        font-weight: bold;
        font-size: 36px;
        border-radius: 4rem;
        z-index: 999;
        filter: drop-shadow(0px 0px 2px rgba(0, 0, 0, .8));
        animation: ringBell .5s infinite;
    }

    .fa-regular fa-bell {
        animation: ringBell .5s infinite !important;

    }

    .alert-button {
        animation: bounceBtn 1.5s infinite;
    }

    @keyframes shake {
        0% {
            transform: rotate(0deg);
        }

        25% {
            transform: rotate(1deg);
        }

        50% {
            transform: rotate(-1deg);
        }

        75% {
            transform: rotate(1deg);
        }

        100% {
            transform: rotate(0deg);
        }
    }

    @keyframes ringBell {
        0% {
            transform: rotate(0);
        }

        20% {
            transform: rotate(10deg);
        }

        40% {
            transform: rotate(-10deg);
        }

        60% {
            transform: rotate(10deg);
        }

        80% {
            transform: rotate(-10deg);
        }

        100% {
            transform: rotate(0);
        }
    }

    @keyframes bounceBtn {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }
</style>

<!-- اشعار ! في السايد بار -->
<style>
    .notification-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        background-color: white;
        color: #ffc107;
        /* اللون الأصفر التحذيري */
        font-weight: bold;
        font-size: 14px;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        margin-left: 5px;
        vertical-align: middle;
        animation: pulse 1s infinite;
        transform: translateY(-1px);
    }

    @keyframes pulse {
        0% {
            transform: scale(1) translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        50% {
            transform: scale(1.1) translateY(-1px);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.3);
        }

        100% {
            transform: scale(1) translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
    }

    /* تعديلات للعرض على الهواتف */
    @media (max-width: 768px) {
        .notification-badge {
            width: 18px;
            height: 18px;
            font-size: 12px;
        }
    }
</style>

<!-- Sidebar -->
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .page-content {
        padding: 20px 15px;
        max-width: 100%;
        overflow-x: hidden;
    }

    h1 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 20px;
        font-size: 1.8rem;
        line-height: 1.3;
    }

    .dev_deg {
        background: #ffffff;
        padding: 20px 15px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-top: 20px;
        width: 100%;
        box-sizing: border-box;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        font-size: 0.95rem;
        min-width: 600px;
    }

    .table th {
        background-color: #007bff;
        color: #fff;
        text-align: center;
        vertical-align: middle;
        padding: 12px 8px;
        font-weight: 500;
    }

    .table td {
        vertical-align: middle;
        text-align: center;
        background-color: #fefefe;
        padding: 10px 8px;
        border-bottom: 1px solid #eee;
    }

    .btn {
        font-size: 0.95rem;
        border-radius: 6px;
        padding: 8px 16px;
        white-space: nowrap;
        transition: all 0.3s;
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

    .modal-content {
        border-radius: 10px;
        margin: 15px auto;
        max-width: 95%;
    }

    .modal-header {
        border-bottom: 1px solid #ddd;
        background-color: #f1f1f1;
        padding: 15px 20px;
        border-radius: 10px 10px 0 0;
    }

    .modal-title {
        font-weight: 600;
        font-size: 1.3rem;
    }

    .modal-footer {
        background-color: #fefefe;
        border: none;
        padding: 15px 20px;
        border-radius: 0 0 10px 10px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        font-size: 0.95rem;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        border-radius: 6px;
        border: 1px solid #ddd;
        background-color: #ffffff;
        padding: 10px 12px;
        font-size: 0.95rem;
        transition: all 0.3s;
        width: 100%;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    #loadingSpinner {
        margin: 30px auto;
        text-align: center;
    }

    .btn-close-custom {
        background: none;
        border: none;
        font-size: 1.3rem;
        color: #555;
        cursor: pointer;
    }

    .modal-body {
        background-color: #fefefe;
        padding: 20px;
    }

    .form-group {
        margin-bottom: 15px;
        padding: 12px 15px;
        background-color: #f9f9f9;
        border-left: 3px solid #007bff;
        border-radius: 6px;
        transition: all 0.3s;
    }

    .form-group:hover {
        background-color: #f1faff;
    }

    /* إخفاء أسهم أرقام المتصفحات */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    /* تحسينات للشريط الجانبي */
    #sidebar {
        width: 100%;
        max-width: 280px;
        overflow-y: auto;
        z-index: 1000;
        background-color: #f8f9fa !important;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1) !important;
    }

    .sidebar-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 20px 15px !important;
        background-color: #f1f8ff !important;
        border-bottom: 1px solid #dee2e6 !important;
    }

    .avatar-container {
        width: 100px;
        height: 100px;
        margin-bottom: 15px;
    }

    .preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        transition: transform 0.3s ease;
    }

    .parColor {
        margin-top: 5px !important;
        font-size: 1.3rem !important;
        font-weight: 700 !important;
        text-align: center;
        color: #000 !important;
    }

    #sidebar ul li a {
        color: #495057 !important;
        padding: 12px 15px !important;
        border-left: 3px solid transparent !important;
        transition: all 0.3s !important;
        font-size: 0.95rem;
    }

    .title {
        text-align: center;
        padding: 10px 0;
    }

    .title h1 {
        font-size: 1.2rem;
        margin: 0;
        font-weight: bold;
    }

    .title p.parColor {
        font-size: 0.95rem;
        margin: 5px 0 10px;
        color: #555;
    }


    /* تحسينات للشاشات الصغيرة */
    @media (max-width: 992px) {
        .page-content {
            padding: 15px 10px;
        }

        h1 {
            font-size: 1.5rem;
        }

        .dev_deg {
            padding: 15px;
        }

        .table th,
        .table td {
            padding: 8px 6px;
            font-size: 0.9rem;
        }

        .btn {
            font-size: 0.9rem;
            padding: 7px 12px;
        }

        .modal-title {
            font-size: 1.2rem;
        }

        #sidebar {
            width: 100%;
            max-width: 240px;
        }

        .avatar-container {
            width: 80px;
            height: 80px;
        }

        .title {
            display: block !important;
            padding: 10px 0 !important;
            text-align: center !important;
        }

        .title h1 {
            font-size: 1rem !important;
        }

        .title p.parColor {
            font-size: 0.85rem !important;
        }

        #shiftTimer {
            font-size: 1rem !important;
            align-items: center !important;
        }

        .btn {
            font-size: 0.85rem !important;
            padding: 6px 10px !important;
        }
    }

    @media (max-width: 768px) {
        .page-content {
            padding: 15px 8px;
        }

        h1 {
            font-size: 1.4rem;
            margin-bottom: 15px;
        }

        .dev_deg {
            padding: 12px;
        }

        .table th,
        .table td {
            padding: 6px 4px;
            font-size: 0.85rem;
        }

        .btn {
            font-size: 0.85rem;
            padding: 6px 10px;
        }

        .modal-header,
        .modal-footer {
            padding: 12px 15px;
        }

        .modal-title {
            font-size: 1.1rem;
        }

        .form-control {
            padding: 8px 10px;
            font-size: 0.9rem;
        }

        #sidebar {
            max-width: 220px;
        }

        .sidebar-header {
            padding: 15px 10px !important;
        }

        .avatar-container {
            width: 70px;
            height: 70px;
        }


        .title h1 {
            font-size: 1.2rem;
        }

        .parColor {
            font-size: 0.9rem !important;
        }

        #shiftTimer {
            font-size: 0.85rem;
            padding: 4px 8px;
        }

        .btn-sm {
            font-size: 0.8rem;
            padding: 4px 8px;
        }
    }

    @media (max-width: 576px) {
        h1 {
            font-size: 1.3rem;
        }

        .table th,
        .table td {
            font-size: 0.8rem;
        }

        .btn {
            font-size: 0.8rem;
        }

        .modal-content {
            max-width: 98%;
        }

        #sidebar {
            max-width: 200px;
        }

        .avatar-container {
            width: 60px;
            height: 60px;
        }


        #sidebar ul li a {
            padding: 10px 12px !important;
            font-size: 0.85rem;
        }

        .title h1 {
            font-size: 1.1rem;
            margin-bottom: 3px;
        }

        .parColor {
            font-size: 0.85rem !important;
            margin-bottom: 8px !important;
        }

        #shiftTimer {
            font-size: 0.8rem;
            padding: 3px 6px;
        }

        .btn-sm {
            font-size: 0.75rem;
            padding: 3px 6px;
        }
    }

    @media (max-width: 480px) {
        .page-content {
            padding: 12px 5px;
        }

        h1 {
            font-size: 1.25rem;
        }

        .dev_deg {
            padding: 10px;
        }

        .btn {
            padding: 5px 8px;
        }

        .modal-header,
        .modal-footer {
            padding: 10px 12px;
        }

        .modal-title {
            font-size: 1rem;
        }

        .form-group {
            padding: 10px 12px;
        }

        #sidebar {
            max-width: 180px;
        }

        .sidebar-header {
            padding: 12px 8px !important;
        }

        .avatar-container {
            width: 50px;
            height: 50px;
        }


        .title h1 {
            font-size: 1rem;
        }

        .parColor {
            font-size: 0.8rem !important;
        }

        #shiftTimer {
            font-size: 0.75rem;
        }
    }
</style>

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
        border: none;
    }

    .page-content {
        padding: 40px 20px;
    }

    h1 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 30px;
    }

    .dev_deg {
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        margin-top: 20px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table th {
        background-color: #007bff;
        color: #fff;
        text-align: center;
        vertical-align: middle;
    }

    .table td {
        vertical-align: middle;
        text-align: center;
        background-color: #fefefe;
    }

    .btn {
        font-size: 16px;
        border-radius: 8px;
        padding: 10px 20px;
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

    .modal-content {
        border-radius: 12px;
    }

    .modal-header {
        border-bottom: 1px solid #ddd;
        background-color: #f1f1f1;
    }

    .modal-title {
        font-weight: 600;
    }

    .modal-footer {
        background-color: #fefefe;
        border: none;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-control {
        border-radius: 6px;
        border: 1px solid #ccc;
        background-color: #ffffff;
        padding: 10px;
        font-size: 15px;
        transition: border 0.3s;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 4px rgba(0, 123, 255, 0.3);
    }

    #loadingSpinner {
        margin: 40px auto;
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

    .modal-open .modal .modal-content {
        border-radius: 0;
        background: #ffffff;
    }

    .modal-body {
        background-color: #fefefe;
        padding: 25px 20px;
        border-radius: 0 0 12px 12px;
        border: none !important;
    }

    .form-group {
        margin-bottom: 20px;
        padding: 10px 15px;
        background-color: #f9f9f9;
        border-left: 4px solid #007bff;
        border-radius: 8px;
        transition: background 0.3s;
    }

    .form-group:hover {
        background-color: #f1faff;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
        font-size: 15px;
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
</style>
<style>
    /* التعديلات الجديدة فقط */
    #sidebar {
        margin-top: 0%;
        width: 250px;
        overflow-y: auto;
        z-index: 1000;
    }

    .sidebar-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 20px 15px !important;
    }

    .avatar-container {
        width: 120px;
        height: 120px;
        margin-bottom: 15px;
    }

    .sidebar-header .title {
        width: 100%;
    }

    /* التعديلات للشاشات الصغيرة */
    @media (max-width: 768px) {
        .sidebar-header {
            padding: 15px 5px !important;
        }

        .avatar-container {
            width: 80px;
            height: 80px;
        }

        .sidebar-header .title h1 {
            font-size: 1rem;
        }

        .parColor {
            font-size: 16px !important;
        }
    }

    /* باقي الكود الأصلي يبقى كما هو دون تعديل */
    hr {
        border: none;
        border-top: 1px solid #ddd;
        margin: 10px 0;
    }

    .preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        transition: transform 0.3s ease;
    }



    .user-profile {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        padding: 0rem;
        border-radius: 10px;
        max-width: 500px;
        width: 90%;
        text-align: center;
    }

    #shiftTimer {
        font-weight: bold;
        color: #333;
        background: #f8f9fa;
        padding: 5px 10px;
        border-radius: 5px;
        display: inline-block;
    }

    .parColor {
        margin-top: -10px !important;
        font-size: 22px !important;
        text-transform: uppercase !important;
        font-weight: 700 !important;
        font-family: 'Caveat', cursive !important;
        text-align: center;

        color: {{auth()->user()->color_code ?? '#000'}}!important;
    }

    /* تنسيقات عامة للـ sidebar */
    #sidebar {
        background-color: #f8f9fa !important;
        color: #495057 !important;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1) !important;
    }

    /* تنسيق عنوان الـ sidebar */
    .sidebar-header {
        background-color: #f1f8ff !important;
        border-bottom: 1px solid #dee2e6 !important;
    }

    .sidebar-header .title h1 {
        color: #212529 !important;
    }

    /* تنسيق قوائم الـ sidebar */
    #sidebar ul li a {
        color: #495057 !important;
        padding: 12px 15px !important;
        border-left: 3px solid transparent !important;
        transition: all 0.3s !important;
    }

    #sidebar ul li a:hover {
        background-color: #e9ecef !important;

        color: {{auth()->user()->color_code ?? '#000'}}!important;!important;

        border-left: 3px solid {{auth()->user()->color_code ?? '#000'}}!important;
    }

    #sidebar ul li.active a {
        background-color: #e9ecef !important;

        color: {{auth()->user()->color_code ?? '#000'}}!important;

        border-left: 3px solid {{auth()->user()->color_code ?? '#000'}}!important;

    font-weight: 500 !important;
    }

    /* تنسيق الأيقونات */
    #sidebar ul li a i {
        color: #6c757d !important;
        margin-right: 10px !important;
        width: 20px !important;
        text-align: center !important;
    }

    #sidebar ul li.active a i,
    #sidebar ul li a:hover i {
        color: {{auth()->user()->color_code ?? '#000'}}!important;

        !important;
    }

    /* تنسيق الـ badges */
    .glow-badge {
        padding: 3px 8px !important;
        border-radius: 50px !important;
        font-size: 12px !important;
        font-weight: bold !important;
        margin-left: 5px !important;
    }

    .badge-green {
        background-color: #d1fae5 !important;
        color: #065f46 !important;
    }

    .badge-blue {
        background-color: #dbeafe !important;
        color: #1e40af !important;
    }

    .badge-purple {
        background-color: #ede9fe !important;
        color: #5b21b6 !important;
    }

    .badge-orange {
        background-color: #ffedd5 !important;
        color: #9a3412 !important;
    }

    .badge-red {
        background-color: #fee2e2 !important;
        color: #991b1b !important;
    }

    /* تنسيقات إضافية */
    #sidebar .heading {
        color: #6c757d !important;
        font-size: 12px !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        padding: 15px 15px 5px !important;
        display: block !important;
    }

    .avatar {
        border: none !important;
    }
</style>

<!-- index -->
<style>
    /* تنسيقات عامة للصفحة */
    .page-content {
        background-color: #ffffff !important;
        padding: 20px !important;
        min-height: calc(100vh - 60px) !important;
    }

    .page-header {
        background-color: #f8f9fa !important;
        padding: 15px 0 !important;
        margin-bottom: 20px !important;
        border-bottom: 1px solid #e9ecef !important;
    }

    .container-fluid {
        padding-right: 15px !important;
        padding-left: 15px !important;
        margin-right: auto !important;
        margin-left: auto !important;
        width: 100% !important;
    }

    /* تنسيقات العنوان الرئيسي */
    .page-header h1 {
        color: #495057 !important;
        font-size: 24px !important;
        margin: 0 !important;
        font-weight: 500 !important;
    }

    /* تنسيقات الروابط في الهيدر */
    .page-header .breadcrumb {
        background-color: transparent !important;
        padding: 0 !important;
        margin-bottom: 0 !important;
        list-style: none !important;
    }

    .page-header .breadcrumb-item {
        display: inline-block !important;
        color: #6c757d !important;
    }

    .page-header .breadcrumb-item a {
        color: #0d6efd !important;
        text-decoration: none !important;
    }

    .page-header .breadcrumb-item.active {
        color: #495057 !important;
    }

    .page-header .breadcrumb-item+.breadcrumb-item::before {
        content: "/" !important;
        padding: 0 8px !important;
        color: #6c757d !important;
    }

    /* تنسيقات إضافية للواجهة الفاتحة */
    .page-content .card {
        background-color: #ffffff !important;
        border: 1px solid #e9ecef !important;
        border-radius: 5px !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05) !important;
        margin-bottom: 20px !important;
    }

    .page-content .card-header {
        background-color: #f8f9fa !important;
        border-bottom: 1px solid #e9ecef !important;
        padding: 15px 20px !important;
    }

    .page-content .card-title {
        color: #495057 !important;
        margin: 0 !important;
        font-size: 18px !important;
    }

    .page-content .card-body {
        padding: 20px !important;
    }
</style>

<!-- header -->
<style>
    /* تنسيق الهيدر العام */
    .header {
        background-color: #f8f9fa !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
        position: sticky !important;
        top: 0 !important;
        z-index: 1000 !important;
    }

    /* تنسيق النافبار */
    .navbar {
        padding: 0.5rem 1rem !important;
        background-color: #ffffff !important;
        border-bottom: 1px solid #e9ecef !important;
    }

    /* تنسيق العلامة التجارية */
    .navbar-brand {
        padding: 0.5rem 1rem !important;
    }

    .brand-text {
        font-weight: 700 !important;
        font-size: 1.25rem !important;
    }

    .brand-big .text-warning {
        color: #ffc107 !important;
    }

    .brand-big .text-white {
        color: #495057 !important;
        /* تغيير من الأبيض إلى الغامق */
    }

    .brand-sm .text-warning {
        color: #ffc107 !important;
    }

    .brand-sm strong:last-child {
        color: #495057 !important;
        /* تغيير من الأبيض إلى الغامق */
    }

    /* تنسيق زر القائمة الجانبية */
    .sidebar-toggle {
        background: transparent !important;
        border: none !important;
        color: #495057 !important;
        font-size: 1.25rem !important;
        cursor: pointer !important;
        padding: 0.5rem !important;
    }

    /* تنسيق لوحة البحث */
    .search-panel {
        background-color: rgba(248, 249, 250, 0.98) !important;
    }

    .search-inner {
        padding: 2rem !important;
    }

    .close-btn {
        color: #495057 !important;
        font-weight: 600 !important;
        position: absolute !important;
        top: 1rem !important;
        right: 1rem !important;
        cursor: pointer !important;
    }

    #searchForm input[type="search"] {
        background-color: #ffffff !important;
        border: 1px solid #ced4da !important;
        color: #495057 !important;
        font-weight: 500 !important;
        padding: 0.75rem 1rem !important;
        width: 100% !important;
        max-width: 500px !important;
    }

    #searchForm button[type="submit"] {
        background-color: #0d6efd !important;
        color: white !important;
        font-weight: 600 !important;
        border: none !important;
        padding: 0.75rem 1.5rem !important;
        margin-left: 0.5rem !important;
        cursor: pointer !important;
    }

    /* تنسيق زر الخروج */
    .logout .btn {
        font-weight: 600 !important;
        padding: 0.5rem 1.25rem !important;
        border-radius: 4px !important;
    }

    .logout .btn-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
        border: none !important;
    }

    /* تنسيق العناصر المرنة */
    .d-flex {
        display: flex !important;
    }

    .align-items-center {
        align-items: center !important;
    }

    .justify-content-between {
        justify-content: space-between !important;
    }

    .align-items-stretch {
        align-items: stretch !important;
    }
</style>

<!-- Dashboard = body -->
<style>
    /* تنسيقات عامة للقسم */
    .no-padding-top {
        padding-top: 0 !important;
    }

    .no-padding-bottom {
        padding-bottom: 0 !important;
    }

    .container-fluid {
        padding: 15px !important;
        background-color: #f8f9fa !important;
    }

    /* تنسيقات العناوين */
    .h5 {
        font-size: 1.25rem !important;
        font-weight: 700 !important;
        color: #212529 !important;
        margin-bottom: 1rem !important;
    }

    .no-margin-bottom {
        margin-bottom: 0 !important;
    }

    /* تنسيقات كتل الإحصائيات */
    .statistic-block {
        background-color: #ffffff !important;
        border-radius: 5px !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05) !important;
        padding: 15px !important;
        margin-bottom: 20px !important;
        border: 1px solid #e9ecef !important;
    }

    .statistic-block strong {
        font-weight: 700 !important;
        color: #212529 !important;
    }

    .statistic-block .title {
        margin-bottom: 10px !important;
    }

    .statistic-block .icon {
        color: #6c757d !important;
        margin-right: 10px !important;
        display: inline-block !important;
    }

    .statistic-block .number {
        font-size: 1.5rem !important;
        font-weight: 700 !important;
    }

    /* تنسيقات أشرطة التقدم */
    .progress {
        height: 6px !important;
        background-color: #e9ecef !important;
        border-radius: 3px !important;
        margin-top: 10px !important;
    }

    .progress-bar {
        border-radius: 3px !important;
    }

    .progress-template {
        background-color: #f1f8ff !important;
    }

    .progress-bar-template {
        background-color: #0d6efd !important;
    }

    /* تنسيقات الألوان للإحصائيات */
    .dashtext-1,
    .dashbg-1 {
        color: #0d6efd !important;
    }

    .dashbg-1 {
        background-color: #0d6efd !important;
    }

    .dashtext-2,
    .dashbg-2 {
        color: #6610f2 !important;
    }

    .dashbg-2 {
        background-color: #6610f2 !important;
    }

    .dashtext-3,
    .dashbg-3 {
        color: #6f42c1 !important;
    }

    .dashbg-3 {
        background-color: #6f42c1 !important;
    }

    .dashtext-4,
    .dashbg-4 {
        color: #fd7e14 !important;
    }

    .dashbg-4 {
        background-color: #fd7e14 !important;
    }

    /* تنسيقات المخططات */
    .bar-chart,
    .line-cahrt {
        background-color: #ffffff !important;
        border-radius: 5px !important;
        padding: 15px !important;
        margin-bottom: 20px !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05) !important;
        border: 1px solid #e9ecef !important;
    }

    /* تنسيقات الإحصائيات الصغيرة */
    .stats-2-block {
        background-color: #ffffff !important;
        border-radius: 5px !important;
        padding: 15px !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05) !important;
        border: 1px solid #e9ecef !important;
    }

    .stats-2 {
        margin-right: 15px !important;
    }

    .stats-2-content strong {
        font-size: 1.5rem !important;
        font-weight: 700 !important;
        color: #212529 !important;
    }

    .stats-2-content span {
        color: #6c757d !important;
        font-weight: 500 !important;
    }

    .stats-2-arrow {
        margin-right: 10px !important;
        font-size: 1.5rem !important;
    }

    .stats-2-arrow.low {
        color: #dc3545 !important;
    }

    .stats-2-arrow.height {
        color: #28a745 !important;
    }

    /* تنسيقات الفوتر */


    .footer p {
        color: #6c757d !important;
        font-weight: 500 !important;
        margin: 0 !important;
    }

    .footer a {
        color: #0d6efd !important;
        font-weight: 600 !important;
        text-decoration: none !important;
    }

    /* تنسيقات إضافية */
    .progress-small {
        height: 4px !important;
    }

    .progress-bar-small {
        border-radius: 2px !important;
    }

    .footer__block {
        background-color: #f8f9fa !important;
        /* لون فاتح للخلفية */
        padding: 40px 0 !important;
        /* مسافة داخلية كبيرة */
        margin-top: 80px !important;
        /* مسافة كبيرة من الأعلى */
        border-top: 1px solid #e9ecef !important;
        /* حد فاتح */
        color: #495057 !important;
        /* لون نص غامق للقراءة الجيدة */
    }

    .footer__block .container-fluid {
        max-width: 1200px !important;
        margin: 0 auto !important;
        padding: 0 15px !important;
    }

    .footer__block p {
        font-size: 14px !important;
        font-weight: 500 !important;
        /* نص غامق */
        margin: 0 !important;
        line-height: 1.6 !important;
    }

    .footer__block a {
        color: #0d6efd !important;
        /* لون روابط */
        font-weight: 600 !important;
        /* نص غامق */
        text-decoration: none !important;
        transition: color 0.3s ease !important;
    }

    .footer__block a:hover {
        color: #0a58ca !important;
        /* لون روابط عند التحويم */
        text-decoration: underline !important;
    }

    /* تنسيقات إضافية للاستجابة */
    @media (max-width: 768px) {
        .footer__block {
            padding: 30px 0 !important;
            margin-top: 60px !important;
        }
    }
</style>


<style>
    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .glow-badge {
        color: white !important;
        font-weight: bold;
        border-radius: 50px;
        padding: 5px 10px;
        font-size: 14px;
        animation: pulseGlow 1.5s infinite;
        margin-left: 10px;
        transition: all 0.3s ease-in-out;

        #sidebar ul li a:hover,
        #sidebar ul li.active a {
            background-color: #f1f8ff;
            color: #1a73e8;
            border-left: 3px solid #1a73e8;
        }
    }

    /* اللون حسب العدد */
    .badge-green {
        background: linear-gradient(45deg, #28a745, #218838);
        box-shadow: 0 0 10px rgba(40, 167, 69, 0.6);
    }

    .badge-blue {
        background: linear-gradient(45deg, #007bff, #0056b3);
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.6);
    }

    .badge-purple {
        background: linear-gradient(45deg, #6f42c1, #5a32a3);
        box-shadow: 0 0 10px rgba(111, 66, 193, 0.6);
    }

    .badge-orange {
        background: linear-gradient(45deg, #fd7e14, #e8590c);
        box-shadow: 0 0 10px rgba(253, 126, 20, 0.6);
    }

    .badge-red {
        background: linear-gradient(45deg, #dc3545, #c82333);
        box-shadow: 0 0 10px rgba(220, 53, 69, 0.6);
    }

    @keyframes pulseGlow {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }
</style>

<style>
    .page-header {
        padding: 20px;
        border-radius: 8px;
    }

    .dev_deg {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 60px;
    }

    h1 {
        font-size: 64px;
        margin-top: 20px;
        text-align: center;
        color: white;
    }

    .form_deg {
        background-color: #343434;
        padding: 30px;
        border-radius: 10px;
        width: 80%;
        max-width: 900px;
        border: 1px solid black;
    }

    label {
        display: inline-block;
        width: 200px;
        font-size: 20px !important;
        color: #333;
        margin-bottom: 10px;
    }

    input[type="text"],
    select,
    textarea {
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        box-sizing: border-box;
        color: black !important;
    }

    input[type="date"] {
        color: black !important;
        width: 40%;
        padding: 12px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        box-sizing: border-box;
        cursor: pointer;
    }

    .btn-sub {
        text-transform: capitalize;
        display: flex;
        margin: 30px auto auto;
        width: 75%;
        border-radius: 5px;
        border: none;
        padding: 15px 0;
        cursor: pointer;
        font-size: 18px;
        transition: background-color 0.3s;
    }

    input[type="file"] {
        color: white;
    }


    textarea {
        height: 100px;
    }

    .input_deg {
        padding: 5px;
    }

    .input_deg img {
        border-radius: 5px;
        margin-top: 10px;
        color: white;
    }

    select {
        width: 350px;
        height: 50px;
        border-radius: 5px;
    }

    .input_deg {
        margin-bottom: 20px;
    }

    .input_deg select,
    .input_deg input {
        display: block;
    }
</style>

<style>
    .search-container {
        width: 100%;
        margin: 2rem 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .search-form {
        width: 50%;
        margin: 0 auto;
        display: flex;
        gap: 10px;
    }

    .search-input {
        flex-grow: 1;
        padding: 12px 20px;
        font-size: 1rem;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        background-color: #f8f8f8;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .search-input:focus {
        outline: none;
        border-color: #9c7aff;
        box-shadow: 0 0 0 2px rgba(156, 122, 255, 0.2);
        background-color: #fff;
    }

    .search-btn {
        padding: 12px 24px;
        font-size: 1rem;
        color: white;
        background: linear-gradient(135deg, #8e2de2, #4a00e0);
        border: none;
        border-radius: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .search-btn:hover {
        background: linear-gradient(135deg, #7b1fa2, #311b92);
        transform: translateY(-2px);
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
    }

    .search-btn:active {
        transform: translateY(0);
    }

    .search-icon {
        margin-right: 8px;
        width: 18px;
        height: 18px;
    }

    @media (max-width: 768px) {
        .search-form {
            width: 90%;
            flex-direction: column;
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