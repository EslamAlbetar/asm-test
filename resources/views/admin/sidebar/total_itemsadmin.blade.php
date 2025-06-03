<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    <style>
        .resources-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
            justify-content: flex-start;
        }

        /* بطاقة المورد */
        .resource-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
            border-left: 4px solid #4f46e5;
            width: 30%;
            /* 30% من عرض الصفحة */
            min-width: 300px;
            /* حد أدنى للعرض */
            flex-grow: 1;
        }

        .resource-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .resource-header {
            padding: 15px;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
            /* محاذاة النص إلى المركز */
        }

        .resource-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 5px;
            display: block;
            /* تغيير إلى block لعرض العناصر تحت بعض */
            text-align: center;
            /* محاذاة النص إلى المركز */
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
            text-align: center;
            /* محاذاة النص إلى المركز */
        }

        /* تنسيق العناصر داخل البطاقة */
        .resource-body h6,
        .resource-body span {
            display: block;
            /* لعرض العناصر تحت بعض */
            width: 100%;
            text-align: center;
            /* محاذاة النص إلى المركز */
            margin: 5px 0;
            /* مسافة بين العناصر */
        }

        /* باقي الأنماط تبقى كما هي */
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
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

                @if($permissions && $permissions->total_items_admin)
                <!-- المحتوى الكامل داخل if -->
                <div class="text-center">
                    <a href="{{url('add_category_page')}}" class="btn btn-danger mb-4 px-5 py-3 rounded">Add Category</a>
                </div>

                <div class="search-container">
                    <form method="GET" action="{{ url()->current() }}" class="search-form">
                        <input
                            type="text"
                            name="search"
                            placeholder="Search by Category name..."
                            class="search-input">
                        <button type="submit" class="search-btn">
                            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            بحث
                        </button>
                    </form>
                </div>

                <div class="resources-container">

                    @foreach($categories as $category)
                    @php
                    $categoryItems = $items->where('total_items_id', $category->id);
                    $totalQuantity = $categoryItems->sum(fn($item) => is_numeric($item->quantity) ? (int)$item->quantity : 0);
                    $totalPrice = $categoryItems->sum(fn($item) => is_numeric($item->total_price) ? (float)$item->total_price : 0);
                    @endphp

                    <div class="resource-card blue">
                        <div class="resource-header">


                            <div class="resource-title">{{ $category->name_category }}</div>
                            <div class="resource-count">(عدد: {{ $totalQuantity }})</div>
                            <div class="count-money text-success"> {{ number_format($totalPrice, 2) }} EGP</div>
                        </div>

                        <div class="dropdown" style="position: absolute; top: 10px; right: 10px;">
                            <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenu{{ $category->id }}"
                                data-bs-toggle="dropdown" aria-expanded="false"
                                style="background: rgba(255,255,255,0.7); border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-ellipsis-v" style="font-size: 14px;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu{{ $category->id }}">
                                <li>
                                    <a href="#" class="dropdown-item edit-category" data-id="{{ $category->id }}" data-name="{{ $category->name_category }}">
                                        <i class="fas fa-edit me-2"></i> تعديل
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item delete-category text-danger" data-id="{{ $category->id }}">
                                        <i class="fas fa-trash me-2"></i> حذف
                                    </a>

                                </li>
                            </ul>
                        </div>

                        <div class="resource-body">
                            <div class="items">
                                <h6 class="item-name"> (الاجمالي)</h6>
                                <h6 class="item-name"> (القطعة)</h6>
                                <h6 class="item-value">الكمية</h6>
                                <h6 class="item-value">الصنف</h6>
                            </div>

                            @foreach($categoryItems as $item)
                            @php
                            $price = is_numeric(str_replace(',', '', $item->total_price)) ? (float)str_replace(',', '', $item->total_price) : 0.0;
                            $qty = is_numeric(str_replace(',', '', $item->quantity)) ? (int)str_replace(',', '', $item->quantity) : 1;
                            $peacePrice = $qty != 0 ? $price / $qty : 0.0;
                            @endphp

                            <div class="items">
                                <h6 class="item-name">{{ number_format($price, 2) }} EGP</h6>
                                <h6 class="item-name">{{ number_format($peacePrice, 2) }} EGP</h6>
                                <h6 class="item-value">{{ $qty }}</h6>
                                <h6 class="item-value">{{ $item->item_name }}</h6>
                            </div>
                            @endforeach

                            @if($permissions->add_item)
                            <a href="{{ url('add_item/'.$category->id) }}" class="view-all-btn mt-3">تعديل الكميات</a>
                            @endif
                        </div>
                    </div>

                    @endforeach

                </div>

                {{-- ✅ عرض أزرار الترقيم --}}
                <div class="mt-4">
                    {{ $categories->links('pagination::bootstrap-5') }}
                </div>

                @else
                <h2 class="text-danger text-center">! لا تملك صلاحيات للدخول لهذه الصفحة</h2>
                @endif



                <!-- مودال تعديل الفئة -->
                <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                            <!-- Header -->
                            <div class="modal-header bg-primary text-white" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                                <h5 class="modal-title w-100 text-center">
                                    <i class="fas fa-edit me-2"></i> تعديل الفئة
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <!-- Body -->
                            <div class="modal-body p-4">
                                <form id="editCategoryForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4 d-flex flex-column align-items-center">
                                        <label for="categoryName" class="form-label fw-bold mb-3" style="font-size: 1.1rem;">
                                            اسم الفئة
                                        </label>
                                        <input type="text" class="form-control form-control-lg border-2 border-primary rounded-pill text-center"
                                            id="categoryName" name="name_category" required
                                            placeholder="أدخل اسم الفئة الجديد"
                                            style="max-width: 80%;">
                                    </div>
                                </form>
                            </div>

                            <!-- Footer -->
                            <div class="modal-footer bg-light d-flex justify-content-center" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                                <button type="submit" form="editCategoryForm" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-save me-1"></i> حفظ التغييرات
                                </button>

                                <button type="button" class="btn btn-outline-danger rounded-pill px-4 me-3" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1 "></i> إلغاء
                                </button>
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



                <!-- Modal فرز العناصر -->
                <div class="modal fade" id="sortModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content p-3" style="background-color: #f8f9fa; border-radius: 10px;">
                            <div class="modal-header">
                                <h5 class="modal-title">فرز عنصر من الفئة</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="sortItemForm">
                                    <input type="hidden" name="category_id" id="modalCategoryId">

                                    <div class="mb-3">
                                        <label for="itemSelect" class="form-label">اختر العنصر</label>
                                        <select class="form-select" id="itemSelect" required></select>
                                    </div>

                                    <div class="mb-3 d-flex align-items-center gap-2">
                                        <label class="form-label m-0">الكمية:</label>
                                        <input type="text" id="itemQuantity" class="form-control" readonly style="width: 80px;" />
                                        <button type="button" class="btn btn-success btn-sm" id="increaseQty">↑</button>
                                        <button type="button" class="btn btn-danger btn-sm" id="decreaseQty">↓</button>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary">حفظ</button>
                                        <button type="button" id="deleteItemBtn" class="btn btn-danger d-none">حذف</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- JavaScript files-->
                @include('admin.js')
                <!-- SweetAlert2 CDN -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


                <!-- حذف الفئة -->
                <script>
                    $(document).on('click', '.delete-category', function(e) {
                        e.preventDefault();
                        const categoryId = $(this).data('id');

                        Swal.fire({
                            title: 'هل أنت متأكد؟',
                            text: 'سيتم حذف هذه الفئة وجميع العناصر المرتبطة بها!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'نعم، احذف!',
                            cancelButtonText: 'إلغاء',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#spinnerOverlay').show(); // تأكد إن عندك spinner في الصفحة

                                $.ajax({
                                    url: '/delete_category/' + categoryId,
                                    type: 'DELETE',
                                    data: {
                                        _method: 'DELETE',
                                        _token: $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(data) {
                                        $('#spinnerOverlay').hide();

                                        if (data.success) {
                                            Swal.fire({
                                                title: "تم!",
                                                text: data.message,
                                                icon: "success",
                                                timer: 1500,
                                                showConfirmButton: false
                                            }).then(() => {
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire("خطأ!", data.message, "error");
                                        }
                                    },
                                    error: function() {
                                        $('#spinnerOverlay').hide();
                                        Swal.fire("خطأ!", "حدث خطأ في الاتصال بالسيرفر", "error");
                                    }
                                });
                            }
                        });
                    });
                </script>


                <!-- تعديل الفئة -->
                <script>
                    $(document).on('click', '.edit-category', function() {
                        var categoryId = $(this).data('id');
                        var categoryName = $(this).data('name');

                        // تعبئة البيانات في المودال
                        $('#categoryName').val(categoryName);
                        $('#editCategoryForm').attr('action', '/update_category/' + categoryId);
                        $('#editCategoryModal').modal('show');
                    });

                    $(document).on('submit', '#editCategoryForm', function(event) {
                        event.preventDefault();
                        $('#spinnerOverlay').show();

                        let form = $(this);
                        let url = form.attr('action');
                        let formData = new FormData(this); // استخدم FormData بدل serialize

                        $.ajax({
                            url: url,
                            type: 'POST', // هنخليها POST لأنه هيشيل الـ PUT من الـ formData
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                $('#spinnerOverlay').hide();
                                $('#editCategoryModal').modal('hide');

                                if (data.success) {
                                    Swal.fire({
                                        title: "تم!",
                                        text: data.message,
                                        icon: "success",
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
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
                </script>

                <!-- فرز العناصر -->
                <script>
                    let allItems = @json($items);

                    $('.sort-items-btn').on('click', function() {
                        const categoryId = $(this).data('category-id');
                        $('#modalCategoryId').val(categoryId);

                        // تصفية العناصر اللي ليها نفس total_items_id
                        const filteredItems = allItems.filter(item => item.total_items_id == categoryId);

                        // عرض العناصر في select
                        const select = $('#itemSelect');
                        select.empty();
                        filteredItems.forEach(item => {
                            select.append(`<option value="${item.id}" data-qty="${item.quantity}">${item.item_name}</option>`);
                        });

                        select.trigger('change');
                    });

                    $('#itemSelect').on('change', function() {
                        const qty = parseInt($(this).find(':selected').data('qty'));
                        $('#itemQuantity').val(qty);
                        $('#deleteItemBtn').toggleClass('d-none', qty > 0);
                    });

                    $('#increaseQty').on('click', function() {
                        let val = parseInt($('#itemQuantity').val());
                        $('#itemQuantity').val(val + 1);
                        $('#deleteItemBtn').addClass('d-none');
                    });

                    $('#decreaseQty').on('click', function() {
                        let val = parseInt($('#itemQuantity').val());
                        if (val > 0) val -= 1;
                        $('#itemQuantity').val(val);
                        if (val === 0) $('#deleteItemBtn').removeClass('d-none');
                    });

                    $('#sortItemForm').on('submit', function(e) {
                        e.preventDefault();
                        const itemId = $('#itemSelect').val();
                        const newQty = $('#itemQuantity').val();

                        axios.post('/update-item-quantity', {
                            item_id: itemId,
                            quantity: newQty,
                        }).then(res => {
                            location.reload();
                        }).catch(err => {
                            alert("حصل خطأ");
                        });
                    });

                    $('#deleteItemBtn').on('click', function() {
                        if (confirm('هل أنت متأكد من حذف هذا العنصر؟')) {
                            const itemId = $('#itemSelect').val();
                            axios.post('/delete-item', {
                                item_id: itemId
                            }).then(() => location.reload());
                        }
                    });
                </script>


            </div>





</body>

</html>