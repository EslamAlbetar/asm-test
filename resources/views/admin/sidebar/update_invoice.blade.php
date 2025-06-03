<!DOCTYPE html>
<html>

<head>
    @include('admin.css')

    <style>
        /* Base Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        .row {
            margin-bottom: 2rem;
        }

        .h3 {
            font-size: 2.75rem;
            color: rgb(255, 255, 255);
            margin-bottom: 1.5rem;
            font-weight: 600;
            text-align: center;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #3498db;
        }

        /* Form Container */
        form.forms {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

       

        /* Form Input Groups */
        .dev_inp {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .dev_inp label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #2c3e50;
            font-size: 1rem;
        }

        /* Input Fields */
        .dev_inp input[type="text"],
        .dev_inp input[type="date"],
        .dev_inp input[type="file"],
        .dev_inp textarea,
        select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
        }

        .dev_inp input[type="text"]:focus,
        .dev_inp input[type="date"]:focus,
        .dev_inp textarea:focus,
        select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
            background-color: #fff;
        }

        /* Readonly Input */
        .dev_inp input[readonly] {
            background-color: #e9ecef;
            color: #6c757d;
        }

        /* Select Dropdown */
        select {
            height: auto;
            padding: 0.75rem 1rem;
            appearance: none;
        }

        /* Textarea */
        .dev_inp textarea {
            min-height: 120px;
            resize: vertical;
        }

        /* File Input */
        .dev_inp input[type="file"] {
            padding: 0.5rem;
            border: 1px dashed #ddd;
            background-color: #f9f9f9;
            color: #333;
        }

        .dev_inp input[type="file"]::file-selector-button {
            padding: 0.5rem 1rem;
            background-color: #e9ecef;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .dev_inp input[type="file"]::file-selector-button:hover {
            background-color: #ddd;
        }

        /* Submit Button */
        .btn-sub {
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            width: 60%;
            margin: 2rem auto 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-sub:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


        /* Responsive Adjustments */
        @media (max-width: 768px) {
            form {
                padding: 1.5rem;
            }

            .h3 {
                font-size: 1.5rem;
            }

            .dev_inp {
                margin-bottom: 1.2rem;
            }
        }

        /* Form Layout Improvements */
        form>div:not(.dev_inp) {
            margin-bottom: 1.5rem;
        }

        form>div:not(.dev_inp) label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #2c3e50;
            font-size: 1rem;
        }
    </style>

    <style>
        /* تصميم المودال كله */
        .delete-modal {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border: 1px solid #f0f0f0;
        }

        /* هيدر المودال */
        .delete-modal .modal-header {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            border-bottom: none;
            padding: 1.2rem 1.5rem;
        }

        .delete-modal .modal-title {
            color: #fff;
            font-weight: 600;
            font-size: 1.25rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* جسم المودال */
        .delete-modal .modal-body {
            padding: 2rem;
            text-align: center;
            background-color: #fff;
        }

        .warning-icon {
            color: #ff9a9e;
            font-size: 3.5rem;
            margin-bottom: 1.2rem;
            animation: pulse 1.5s infinite;
        }

        .warning-text {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .warning-subtext {
            color: #888;
            font-size: 0.9rem;
        }

        /* فوتر المودال (الأزرار) */
        .delete-modal .modal-footer {
            border-top: none;
            justify-content: center;
            padding: 1.5rem;
            background-color: #f9f9f9;
        }

        /* أزرار المودال */
        .cancel-btn {
            background-color: #f1f1f1;
            color: #555;
            padding: 8px 22px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .cancel-btn:hover {
            background-color: #e9e9e9;
            transform: translateY(-1px);
        }

        .delete-btn {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            color: white;
            padding: 8px 22px;
            border-radius: 8px;
            border: none;
            transition: all 0.3s ease;
            font-weight: 500;
            box-shadow: 0 2px 5px rgba(255, 154, 158, 0.3);
        }

        .delete-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(255, 154, 158, 0.4);
        }

        /* حركة بسيطة للأيقونة */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .modal-open .modal .modal-content {
            border-radius: 0;
            background: #ffffff !important;
        }
    </style>

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

            @if($permissions->all_bills)
              

                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="h3">Continue Bill</h1>
                    </div>
                </div>

                <div>
                    <form class="forms" action="{{ url('edit_invoice', $data->id) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="dev_inp">
                            <label>User ID</label>
                            <input readonly type="text" name="id_user" value="{{ $data->id_user }}"></input>
                        </div>

                        <div class="dev_inp">
                            <label>Item Name</label>
                            <input type="text" name="name" value="{{ $data->name }}"></input>
                        </div>

                        <div>
                            <label>Bill Type</label>
                            <select name="type">
                                <option value="{{ $data->type }}">{{ $data->type }}</option>

                                <option value="شراء">شراء</option>
                                <option value="صيانة">صيانة</option>
                                <option value="فاتورة">فاتورة</option>
                                <option value="اخرى">اخرى</option>
                            </select>
                        </div>

                        <div class="dev_inp">
                            <label>Required quantity</label>
                            <input type="text" name="required_quantity" value="{{ $data->required_quantity }}"></input>
                        </div>

                        <div class="dev_inp">
                            <label>Category</label>
                            <input readonly type="text" value="{{ $data->category }}"></input>
                        </div>

                        <div class="dev_inp">
                            <label>supplier</label>
                            <input type="text" name="supplier" placeholder="Enter supplier name" value="{{ $data->supplier }}" />
                        </div>

                        <div class="dev_inp">
                            <label>Price Bill</label>
                            <input type="text" name="price" placeholder="Enter Price Item" value="{{ $data->price }}"></input>
                        </div>

                        <div class="dev_inp">
                            <label>discount</label>
                            <input type="text" name="discount" placeholder="Enter discount" value="{{ $data->discount }}"></input>
                        </div>

                        <div class="dev_inp">
                            <label>expiration date</label>
                            <input type="date" name="expiration_date" placeholder="Enter expiration date" value="{{ $data->expiration_date }}"></input>
                        </div>

                        <div class="dev_inp">
                            <label>image</label>
                            <input type="file" name="image" placeholder="Enter image" value="{{ $data->image }}"></input>
                        </div>

                        <div class="dev_inp">
                            <label>Comments Bill</label>
                            <textarea type="text" name="comments_bill" placeholder="Enter comments">{{ $data->comments_bill }}</textarea>
                        </div>



                        <div class="dev_inp">
                            <input class="btn btn-success btn-sub" type="submit" value="Update Invoice">
                        </div>

                        <div class="dev_inp">
                            <!-- زر حذف يفتح المودال -->
                            <button type="button" class="btn btn-danger btn-sub" data-bs-toggle="modal" data-bs-target="#deleteModal_{{ $data->id }}">
                                Delete
                            </button>
                        </div>

                        <div class="dev_inp">
                            <a href="{{ url('/all_bills') }}" class="btn btn-warning btn-sub">Cancel</a>
                        </div>




                    </form>
                </div>




            </div>
        </div>


        <!-- مودال تأكيد الحذف -->
        <div class="modal fade" id="deleteModal_{{ $data->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content delete-modal">
                    <div class="modal-header">
                        <h5 class="modal-title">تأكيد الحذف</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <i class="fas fa-exclamation-triangle warning-icon"></i>
                        <p class="warning-text">هل أنت متأكد أنك تريد حذف هذه الفاتورة؟</p>
                        <p class="warning-subtext">هذا الإجراء لا يمكن التراجع عنه</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn cancel-btn" data-bs-dismiss="modal">إلغاء</button>
                        <form action="{{ url('delete_invoice', $data->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn delete-btn">نعم، احذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- JavaScript files-->
        @include('admin.js')
    </div>

    @else
    <h2 class="text-danger text-center">! لا تملك صلاحيات للدخول لهذه الصفحة</h2>
    @endif
</body>

</html>