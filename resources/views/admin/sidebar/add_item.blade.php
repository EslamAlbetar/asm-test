<!DOCTYPE html>
<html lang="ar">

<head>
    @include('admin.css')

    <style>
        /* Spinner Styles */
        .spinner-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .spinner-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
            border: 0.25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border 0.75s linear infinite;
        }

        @keyframes spinner-border {
            to {
                transform: rotate(360deg);
            }
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }

        /* Page Layout */
        .page-content {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header {
            margin-bottom: 2rem;
            text-align: center;
            padding: 1.5rem;
            background-color: rgb(153, 157, 161);
            color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .category-title {
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
        }

        h1 {
            color: white !important;
        }

        .container {
            background-color: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .section-title {
            color: #2c3e50;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #eee;
            font-size: 1.5rem;
        }

        /* Item Card Styles */
        .item-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid #e0e6ed;
        }

        .item-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            background-color: #f8fafc;
            border-bottom: 1px solid #e0e6ed;
        }

        .item-name {
            font-size: 1.2rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .item-actions {
            display: flex;
            gap: 0.75rem;
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            gap: 0.5rem;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.85rem;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
        }

        .btn-outline-primary {
            color: #3498db;
            border-color: #3498db;
            background-color: transparent;
        }

        .btn-outline-primary:hover {
            background-color: #3498db;
            color: white;
        }

        .btn-outline-danger {
            color: #e74c3c;
            border-color: #e74c3c;
            background-color: transparent;
        }

        .btn-outline-danger:hover {
            background-color: #e74c3c;
            color: white;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        /* Edit Form Styles */
        .edit-form-container {
            max-height: none;
            padding: 0;
            display: block;
        }

        .elegant-form {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: none;
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
            color: white;
            padding: 1.5rem;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .form-header h3 {
            margin: 0;
            font-size: 1.5rem;
        }

        .form-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #34495e;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #dfe6e9;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            color: #2d3436;
        }

        .form-input:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            outline: none;
            background-color: #ffffff;
        }

        .required-symbol {
            color: #e74c3c;
            margin-right: 5px;
            font-size: 1.2rem;
            position: absolute;
            right: -15px;
            top: 35px;
        }

        .form-footer {
            padding: 1.5rem 2rem;
            background: #f8f9fa;
            border-top: 1px solid #dfe6e9;
            text-align: left;
            display: flex;
            gap: 1rem;
        }

        .submit-button {
            background: #2980b9;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .submit-button:hover {
            background: #3498db;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cancel-button {
            background: #95a5a6;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cancel-button:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Back Button Container */
        .btn-container {
            text-align: center;
            margin-top: 2rem;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.active {
            display: flex;
            opacity: 1;
        }

        .modal-content {
            background-color: white;
            padding: 0;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: modalFadeIn 0.3s ease;
            overflow: hidden;
        }

        .close-modal {
            position: absolute;
            top: 1rem;
            left: 1rem;
            font-size: 1.5rem;
            color: #7f8c8d;
            cursor: pointer;
            transition: color 0.3s ease;
            z-index: 10;
        }

        .close-modal:hover {
            color: #e74c3c;
        }

        .modal-text {
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
            color: #2c3e50;
            text-align: center;
        }

        .modal-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        /* Animations */
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

        .fade-in {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .page-content {
                padding: 1rem;
            }

            .container {
                padding: 1.5rem 1rem;
            }

            .item-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .item-actions {
                width: 100%;
                justify-content: flex-end;
            }

            .form-body,
            .form-footer {
                padding: 1.5rem 1rem;
            }

            .form-footer {
                flex-direction: column;
            }

            .submit-button,
            .cancel-button {
                width: 100%;
            }

            .modal-actions {
                flex-direction: column;
            }

            .confirm-btn,
            .cancel-btn {
                width: 100%;
            }
        }
    </style>

    <style>
        /* تنسيقات نافذة الحذف المودال */
        #deleteModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #deleteModal.active {
            display: flex;
            opacity: 1;
        }

        .deleteModal-content {
            background-color: #fff;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: modalFadeIn 0.3s ease-out;
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            left: 15px;
            font-size: 24px;
            color: #7f8c8d;
            cursor: pointer;
            transition: all 0.3s ease;
            background: transparent;
            border: none;
            padding: 5px;
        }

        .close-modal:hover {
            color: #e74c3c;
            transform: rotate(90deg);
        }

        .deleteModal-text {
            margin: 30px 20px 25px;
            font-size: 18px;
            color: #2c3e50;
            text-align: center;
            line-height: 1.6;
            font-weight: 500;
            padding: 0 15px;
        }

        .modal-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            padding: 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #eaeaea;
        }

        /* تنسيقات الأزرار */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            gap: 8px;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
            box-shadow: 0 2px 10px rgba(231, 76, 60, 0.3);
        }

        .btn-danger:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
            box-shadow: 0 2px 10px rgba(149, 165, 166, 0.3);
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(149, 165, 166, 0.4);
        }

        /* تأثيرات الحركة */
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* التجاوب مع الشاشات الصغيرة */
        @media (max-width: 576px) {
            .deleteModal-content {
                width: 95%;
            }

            .deleteModal-text {
                font-size: 16px;
                margin: 25px 15px 20px;
            }

            .deleteModal-actions {
                flex-direction: column;
                gap: 10px;
            }

            .btn {
                width: 100%;
                padding: 10px 20px;
            }
        }
    </style>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')

    @php
    $permissions = \App\Models\AuthedPage::where('user_id', auth()->id())->first();
    @endphp

    <div id="spinnerOverlay" class="spinner-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">جارٍ التحميل...</span>
        </div>
    </div>
    
    <div class="page-content">
        <div class="page-header">
            @if($permissions->add_item)
            <h1 class="category-title text-light">{{ $category->name_category }}</h1>
        </div>

        <div class="container">
            <h4 class="section-title">تعديل الأصناف الحالية</h4>

            @foreach($items as $item)
            @if(!$item->is_hidden)
            <div class="card item-card fade-in" id="itemCard{{ $item->id }}">
                <div class="item-header">
                    <strong class="item-name">{{ $item->item_name }}</strong>
                    <div class="item-actions">
                        <button type="button" class="btn btn-sm btn-outline-primary edit-btn" onclick="openEditModal({{ $item->id }}, '{{ $item->item_name }}', {{ $item->quantity }}, '{{ $item->total_price }}')">
                            <i class="fas fa-edit"></i> تعديل
                        </button>
                        <button class="btn btn-sm btn-outline-danger delete-btn" type="button" onclick="openDeleteModal({{ $item->id }})">
                            <i class="fas fa-trash"></i> حذف
                        </button>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <div class="btn-container">
            <a href="{{ url('/total_items_admin') }}" class="btn btn-secondary btn-lg back-btn">
                <i class="fas fa-arrow-left"></i> رجوع
            </a>
        </div>
    </div>

    <!-- نافذة التعديل المودال -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeEditModal()">&times;</span>
            <div id="editFormContainer" class="edit-form-container">
                <!-- سيتم تحميل محتوى النموذج هنا ديناميكيًا -->
            </div>
        </div>
    </div>

    <!-- نافذة الحذف -->
    <div id="deleteModal" class="modal">
        <div class="deleteModal-content">
            <span class="close-modal" onclick="closeDeleteModal()">&times;</span>
            <p class="deleteModal-text">هل أنت متأكد من رغبتك في حذف هذا العنصر؟</p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-actions">
                    <button type="submit" class="btn btn-danger confirm-btn">
                        <i class="fas fa-check"></i> تأكيد الحذف
                    </button>
                    <button type="button" onclick="closeDeleteModal()" class="btn btn-secondary cancel-btn">
                        <i class="fas fa-times"></i> إلغاء
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.js')

    <script>
        // عرض/إخفاء spinner التحميل
        function toggleSpinner(show) {
            const spinner = document.getElementById('spinnerOverlay');
            if (show) {
                spinner.classList.add('active');
            } else {
                spinner.classList.remove('active');
            }
        }

        // فتح نافذة التعديل
        function openEditModal(itemId, itemName, quantity, totalPrice) {
            // إنشاء محتوى النموذج ديناميكيًا
            const formContent = `
                <form method="POST" action="{{ url('update_item') }}/${itemId}" class="elegant-form">
                    @csrf
                    <div class="form-header">
                        <h3>تعديل العنصر</h3>
                    </div>

                    <div class="form-body">
                        <div class="form-group required-field">
                            <label class="form-label">اسم العنصر</label>
                            <input type="text" name="item_name" value="${itemName}" class="form-input" required>
                            <span class="required-symbol">*</span>
                        </div>

                        <div class="form-group required-field">
                            <label class="form-label">الكمية</label>
                            <input type="number" name="quantity" value="${quantity}" class="form-input" required>
                            <span class="required-symbol">*</span>
                        </div>

                        <div class="form-group required-field">
                            <label class="form-label">السعر الاجمالي</label>
                            <input type="text" name="total_price" value="${totalPrice}" class="form-input" required>
                            <span class="required-symbol">*</span>
                        </div>
                    </div>

                    <div class="form-footer">
                        <button class="submit-button" type="submit">
                            <i class="fas fa-save"></i> حفظ التعديلات
                        </button>
                        <button type="button" class="cancel-button" onclick="closeEditModal()">
                            <i class="fas fa-times"></i> إلغاء
                        </button>
                    </div>
                </form>
            `;

            // إضافة المحتوى إلى المودال
            document.getElementById('editFormContainer').innerHTML = formContent;

            // عرض المودال
            document.getElementById('editModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // إغلاق نافذة التعديل
        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // إغلاق نافذة الحذف
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // إغلاق النوافذ المودال عند النقر خارجها
        window.onclick = function(event) {
            const editModal = document.getElementById('editModal');
            const deleteModal = document.getElementById('deleteModal');

            if (event.target === editModal) {
                closeEditModal();
            }

            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        }

        // إخفاء spinner بعد تحميل الصفحة
        window.addEventListener('load', function() {
            setTimeout(() => {
                toggleSpinner(false);

                // إضافة تأثير ظهور تدريجي للبطاقات
                const cards = document.querySelectorAll('.item-card');
                cards.forEach((card, index) => {
                    setTimeout(() => {
                        card.style.opacity = 1;
                    }, index * 100);
                });
            }, 500);
        });

        // إظهار spinner عند إرسال النماذج
        document.addEventListener('submit', function(e) {
            if (e.target.matches('form')) {
                toggleSpinner(true);
            }
        });

        // التحقق من صحة النماذج قبل الإرسال
        document.querySelectorAll('.elegant-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const requiredInputs = form.querySelectorAll('[required]');
                let isValid = true;

                requiredInputs.forEach(input => {
                    if (!input.value.trim()) {
                        input.style.borderColor = '#e74c3c';
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('الرجاء ملء جميع الحقول المطلوبة');
                    toggleSpinner(false);
                }
            });
        });

        // معالج عام لإرسال النماذج (للتعديل)
        document.addEventListener('submit', function(e) {
            // نتأكد أن هذا ليس نموذج الحذف
            if (e.target.matches('form') && !e.target.matches('#deleteForm')) {
                e.preventDefault();
                const form = e.target;
                const formData = new FormData(form);
                const url = form.getAttribute('action');
                const method = form.getAttribute('method');

                toggleSpinner(true);

                fetch(url, {
                        method: method,
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.message || 'حدث خطأ أثناء العملية');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('حدث خطأ أثناء الاتصال بالخادم');
                    })
                    .finally(() => {
                        toggleSpinner(false);
                    });
            }
        });

        // وظيفة فتح نافذة الحذف
        function openDeleteModal(itemId) {
            const modal = document.getElementById('deleteModal');
            const deleteForm = document.getElementById('deleteForm');

            // تحديث رابط الحذف بالمعرف الصحيح
            deleteForm.action = `/delete_item/${itemId}`;

            modal.classList.add('active');
            document.body.style.overflow = 'hidden';

            // إزالة أي معالجات أحداث سابقة
            deleteForm.onsubmit = null;

            // إضافة معالج جديد للأحداث
            deleteForm.onsubmit = function(e) {
                e.preventDefault();
                toggleSpinner(true);

                fetch(this.action, {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (response.status === 204) { // في حالة عدم إرجاع محتوى
                            window.location.reload();
                            return;
                        }
                        if (!response.ok) {
                            return response.json().then(err => Promise.reject(err));
                        }
                        return response.json();
                    })
                    .then(() => {
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (error.message) {
                            alert(error.message || 'حدث خطأ أثناء الحذف');
                        }
                    })
                    .finally(() => {
                        toggleSpinner(false);
                        closeDeleteModal();
                    });
            };
        }

        // إعادة لون الحدود عند التركيز على الحقل
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.borderColor = '#3498db';
            });

            input.addEventListener('blur', function() {
                if (this.value.trim()) {
                    this.style.borderColor = '#dfe6e9';
                }
            });
        });
    </script>

    @else
    <div class="no-data">
        <p style="margin: 0; font-size: 18px;">لا تملك صلاحية الوصول للصفحة</p>
    </div>
    @endif
</body>

</html>