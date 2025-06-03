<!-- البروفايل -->
<style>
    /* الحاوية العامة */
    .profile-section {
        background: #f9f9fb;
        padding: 40px 20px;
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

    /* صندوق كل فورم */
    .form-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: 0.3s ease-in-out;
    }

    /* عند المرور عليه بالماوس */
    .form-card:hover {
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.07);
    }

    /* العناوين */
    .form-card header h2 {
        font-size: 1.25rem;
        color: #2d3748;
        font-weight: 600;
        margin-bottom: 8px;
    }

    /* الفقرة التوضيحية */
    .form-card header p {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 24px;
    }

    /* المدخلات */
    .form-card input[type="text"],
    .form-card input[type="email"],
    .form-card input[type="password"] {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #fdfdfd;
        transition: border 0.3s;
    }

    .form-card input:focus {
        outline: none;
        border-color: #6366f1;
        /* Indigo */
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }

    /* الأزرار */
    .form-card button {
        background: #6366f1;
        color: white;
        font-weight: 500;
        padding: 10px 20px;
        border-radius: 8px;
        transition: background 0.3s;
        border: none;
    }

    .form-card button:hover {
        background: #4f46e5;
    }

    /* زر الحذف */
    .form-card .text-red-600 {
        background: #fee2e2;
        color: #b91c1c;
    }

    /* ملاحظات الحفظ */
    .form-card .text-sm.text-gray-600 {
        color: #10b981;
        font-weight: 500;
    }

    /* الحاوية الأساسية */
    section {
        background: #ffffff;
        padding: 32px;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
        margin-bottom: 40px;
        transition: 0.3s;
    }

    /* العنوان */
    section header h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1f2937;
        /* Gray-900 */
        margin-bottom: 6px;
    }

    /* الوصف */
    section header p {
        font-size: 0.95rem;
        color: #6b7280;
        /* Gray-600 */
    }

    /* عناصر الفورم */
    form .block {
        margin-top: 10px;
    }

    /* مدخلات */
    input[type="text"],
    input[type="email"] {
        padding: 12px 16px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        /* Gray-300 */
        background: #f9fafb;
        font-size: 1rem;
        width: 100%;
        transition: 0.2s border;
    }

    input[type="text"]:focus,
    input[type="email"]:focus {
        outline: none;
        border-color: #6366f1;
        /* Indigo-500 */
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }

    /* رسائل الخطأ */
    input:invalid {
        border-color: #f87171;
        /* Red-400 */
    }

    /* زر الحفظ */
    button[type="submit"],
    .x-primary-button {
        background: #6366f1;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        border: none;
        transition: background 0.3s;
    }

    button[type="submit"]:hover,
    .x-primary-button:hover {
        background: #4f46e5;
    }

    /* رسالة "Saved." */
    .text-sm.text-gray-600 {
        color: #10b981;
        font-weight: 500;
        margin-top: 6px;
    }


    /* الحاوية الأساسية */
    section {
        background: #ffffff;
        padding: 32px;
        border-radius: 16px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.05);
        max-width: 700px;
        margin: 40px auto;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* العنوان */
    section header h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 6px;
    }

    /* وصف العنوان */
    section header p {
        font-size: 0.95rem;
        color: #6b7280;
        margin-bottom: 24px;
    }

    /* الحقول */
    form>div {
        margin-bottom: 20px;
    }

    /* المدخلات */
    input[type="text"],
    input[type="email"] {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background-color: #f9fafb;
        font-size: 1rem;
        transition: 0.2s;
    }

    input:focus {
        border-color: #6366f1;
        outline: none;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }

    /* رسائل الخطأ */
    input:invalid {
        border-color: #f87171;
    }

    /* الزر الرئيسي */
    button[type="submit"],
    .x-primary-button {
        background-color: #6366f1;
        color: #fff;
        padding: 10px 20px;
        border: none;
        font-weight: 500;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.3s ease;
    }

    button[type="submit"]:hover,
    .x-primary-button:hover {
        background-color: #4f46e5;
    }

    /* رسائل الحالة */
    .text-sm.text-gray-600 {
        color: #10b981;
        font-weight: 500;
        margin-top: 8px;
    }

    /* الزر الخاص بإعادة الإيميل */
    button[form="send-verification"] {
        font-size: 0.875rem;
        color: #6b7280;
        text-decoration: underline;
        margin-top: 8px;
        background: none;
        padding: 0;
    }

    button[form="send-verification"]:hover {
        color: #4b5563;
    }



    /* الحاوية العامة */
    section.space-y-6 {
        background-color: #fff;
        padding: 32px;
        border-radius: 16px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.05);
        max-width: 700px;
        margin: 40px auto;
        font-family: 'Segoe UI', sans-serif;
    }

    /* العنوان */
    section header h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 6px;
    }

    /* الوصف */
    section header p {
        font-size: 0.95rem;
        color: #6b7280;
        margin-top: 8px;
    }

    /* زر الحذف */
    .x-danger-button {
        background-color: #ef4444 !important;
        color: #fff !important;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: background-color 0.3s ease;
    }

    .x-danger-button:hover {
        background-color: #dc2626 !important;
    }

    /* المودال */
    [x-cloak] {
        display: none !important;
    }

    .x-modal form {
        background-color: #fff;
        border-radius: 12px;
        padding: 24px;
        max-width: 500px;
        margin: auto;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    /* مدخل كلمة المرور */
    input[type="password"] {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background-color: #f9fafb;
        font-size: 1rem;
        transition: border-color 0.2s;
    }

    input[type="password"]:focus {
        border-color: #ef4444;
        outline: none;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
    }

    /* زر الإلغاء */
    .x-secondary-button {
        background-color: #e5e7eb;
        color: #111827;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: 0.3s ease;
    }

    .x-secondary-button:hover {
        background-color: #d1d5db;
    }

    .none_bg {
        background-color: #ffffff !important;
        font-size: 20px !important;
    }
</style>

<style>

    /* تصميم مبهر لعنصر الاسم مع وضعية التحرير */
    #name-display,
    #name-edit {
        padding: 15px;
        border-radius: 10px;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    #name-display:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    #name-display h2 {
        font-family: 'NotoSansArabic', 'Tajawal', sans-serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        margin: 0;
        padding: 0;
        background: linear-gradient(to right, #3498db, #2c3e50);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* تصميم زر التعديل */
    #edit-name-btn {
        border: none;
        background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    #edit-name-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    }

    #edit-name-btn i {
        font-size: 0.9rem;
    }

    /* تصميم وضعية التحرير */
    #name-edit {
        animation: fadeIn 0.3s ease-out;
        background: linear-gradient(135deg, #ffffff 0%, #f1f8fe 100%);
        border: 1px solid #e0e0e0;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    #name-edit input {
        font-family: 'NotoSansArabic', 'Tajawal', sans-serif;
        font-size: 1.1rem;
        font-weight: 500;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 8px 12px;
        transition: all 0.3s ease;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    #name-edit input:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        outline: none;
    }

    /* تصميم أزرار الحفظ والإلغاء */
    #save-name-btn,
    #cancel-edit-btn {
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    #save-name-btn {
        background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        color: white;
    }

    #save-name-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(46, 204, 113, 0.3);
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
    }

    #cancel-edit-btn {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
    }

    #cancel-edit-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(231, 76, 60, 0.3);
        background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
    }

    #save-name-btn i,
    #cancel-edit-btn i {
        font-size: 0.9rem;
    }

    /* تأثيرات إضافية */
    .d-flex.align-items-center {
        gap: 10px;
    }

    /* التأكد من أن العناصر متجاوبة */
    @media (max-width: 576px) {
        #name-display h2 {
            font-size: 1.5rem;
        }

        #name-edit {
            flex-wrap: wrap;
        }

        #name-edit input {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>
{{-- تنسيقات تعديل اسم النظام --}}

<style>
    /* أنماط عامة */
    .name-editor-container {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding: 20px;
    }

    .name-editor-wrapper {
        position: relative;
        min-height: 60px;
    }

    /* حالة العرض العادي */
    .name-display {
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
    }

    .name-text {
        margin: 0;
        font-size: 2rem;
        color: #333;
        font-weight: 600;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }

    .edit-btn {
        background: #f0f0f0;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .edit-btn:hover {
        background: #e0e0e0;
        transform: scale(1.05);
    }

    .pencil-icon {
        font-size: 1.2rem;
    }

    /* حالة التحرير */
    .name-edit {
        display: flex;
        align-items: center;
        gap: 10px;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        width: 100%;
    }

    .name-input {
        flex: 1;
        padding: 10px 15px;
        border: 2px solid #ddd;
        border-radius: 8px;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .name-input:focus {
        border-color: #4a90e2;
        outline: none;
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
    }

    .action-btn {
        width: 40px;
        height: 40px;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .save-btn {
        background: #4CAF50;
        color: white;
    }

    .save-btn:hover {
        background: #3e8e41;
        transform: scale(1.05);
    }

    .cancel-btn {
        background: #f44336;
        color: white;
    }

    .cancel-btn:hover {
        background: #d32f2f;
        transform: scale(1.05);
    }

    /* الحالة النشطة */
    .name-edit.active {
        opacity: 1;
        visibility: visible;
    }

    .name-display.hidden {
        opacity: 0;
        visibility: hidden;
    }

    /* أنماط التنبيهات المخصصة */
    .custom-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transform: translateX(120%);
        transition: transform 0.3s ease;
        z-index: 1000;
        max-width: 350px;
        color: white;
    }

    .custom-alert.show {
        transform: translateX(0);
    }

    .custom-alert h3 {
        margin-top: 0;
        margin-bottom: 10px;
    }

    .custom-alert p {
        margin-bottom: 0;
    }

    .custom-alert.error {
        background: #f44336;
    }

    .custom-alert.success {
        background: #4CAF50;
    }

    .custom-alert.warning {
        background: #ff9800;
    }

    /* أنماط تأكيد مخصصة */
    .custom-confirm {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .custom-confirm.show {
        opacity: 1;
        visibility: visible;
    }

    .confirm-content {
        background: white;
        padding: 25px;
        border-radius: 10px;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .confirm-content h3 {
        margin-top: 0;
        color: #333;
    }

    .confirm-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .confirm-btn,
    .cancel-btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
    }

    .confirm-btn {
        background: #4CAF50;
        color: white;
    }

    .cancel-btn {
        background: #f44336;
        color: white;
    }
</style>