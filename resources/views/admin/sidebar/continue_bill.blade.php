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
        form {
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
            background-color: #3498db;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            width: auto;
            margin: 2rem auto 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-sub:hover {
            background-color: #2980b9;
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

            @if($permissions->continue_bill)

                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="h3">Continue Bill</h1>
                    </div>
                </div>

                <div>
                    <form action="{{ route('continueBill.submit') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="dev_inp">
                            <label>User ID</label>
                            <input readonly type="text" name="id_user" value="{{ $newbills->id_user }}"></input>
                        </div>

                        <div class="dev_inp">
                            <label>Item Name</label>
                            <input type="text" name="name" value="{{ $newbills->bill_name }}"></input>
                        </div>

                        <div>
                            <label>Bill Type</label>
                            <select name="type" class="form-select">
                                <?php
                                $allOptions = [
                                    'شراء' => 'شراء',
                                    'صيانة' => 'صيانة',
                                    'سداد' => 'فاتورة سداد',
                                    'اخرى' => 'اخرى'
                                ];

                                $currentValue = $newbills->bill_type;
                                $currentText = $newbills->bill_type;

                                foreach ($allOptions as $value => $text) {

                                    echo "<option value=\"$value\">$text</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="dev_inp">
                            <label>Required quantity</label>
                            <input type="text" name="required_quantity" value="{{ $newbills->required_qty }}"></input>
                        </div>
                        <div class="dev_inp">
                            <label>Category Items</label>
                            <select name="total_items_id" id="category_select" class="form-select" required>
                                <option readonly value="">Select Category</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name_category }}</option>
                                @endforeach
                            </select>
                        </div>



                        <div class="dev_inp">
                            <label>supplier</label>
                            <input type="text" name="supplier" placeholder="Enter supplier name" />
                        </div>

                        <div class="dev_inp">
                            <label>Price Bill for a peace</label>
                            <input type="text" name="price" placeholder="Enter Price Item" value="{{ $newbills->price_bill }}"></input>
                        </div>

                        <div class="dev_inp">
                            <label>discount</label>
                            <input type="text" name="discount" placeholder="Enter discount"></input>
                        </div>

                        <div class="dev_inp">
                            <label>expiration date</label>
                            <input type="date" name="expiration_date" placeholder="Enter expiration date"></input>
                        </div>

                        <div class="dev_inp">
                            <label>image</label>
                            <input type="file" name="image" placeholder="Enter image"></input>
                        </div>

                        <div class="dev_inp">
                            <label>Comments Bill</label>
                            <textarea type="text" name="comments_bill" placeholder="Enter comments">{{ $newbills->comments_bill }}</textarea>
                        </div>



                        <div class="dev_inp">
                            <input class="btn btn-success btn-sub" type="submit" value="Payment Invoice">
                        </div>



                    </form>
                </div>




            </div>
        </div>
        <!-- JavaScript files-->
        @include('admin.js')
    </div>

    @else
        <div class="no-data">
            <p style="margin: 0; font-size: 18px;">لا تملك صلاحية الوصول للصفحة</p>
        </div>
        @endif
</body>

</html>