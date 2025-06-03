<!DOCTYPE html>
<html>

<head>
    @include('admin.css')

    <style>
        /* تنسيق عام */


        /* ترويسة الصفحة */
        .page-header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2b6777;
        }

        /* حاوية الفورم */
        .dev_deg {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            max-width: 800px;
            margin: auto;
        }

        /* عناصر الإدخال */
        .input_deg {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        .input_deg label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #2b6777;
            width: 100%;
        }

        .input_deg input,
        .input_deg select,
        .input_deg textarea {
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            background-color: #fdfdfd;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input_deg input:focus,
        .input_deg select:focus,
        .input_deg textarea:focus {
            border-color: #2b6777;
            box-shadow: 0 0 0 3px rgba(43, 103, 119, 0.15);
            outline: none;
        }

        /* الزر */
        .btn-sub {
            background-color: #2b6777;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-sub:hover {
            background-color: #1b4e5e;
        }

        /* للحقول المتعددة مثل select2 */
        .select2-container--default .select2-selection--multiple {
            border-radius: 8px;
            border: 1px solid #ccc;
            padding: 5px;
        }

        /* معالجة الحقول غير المرئية */
        .invisible {
            display: none;
        }

        .form_deg {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            max-width: 900px;
            margin: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
            border: none;
        }


        .form_deg input[type="text"],
        .form_deg input[type="file"],
        .form_deg textarea,
        .form_deg select {
            padding: 12px 14px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fdfdfd;
            width: 100%;
            transition: all 0.3s ease;
        }

        .form_deg input[type="text"]:focus,
        .form_deg input[type="file"]:focus,
        .form_deg textarea:focus,
        .form_deg select:focus {
            border-color: #2b6777;
            box-shadow: 0 0 0 3px rgba(43, 103, 119, 0.15);
            outline: none;
        }

        .form_deg label {
            font-weight: 600;
            color: #2b6777;
            margin-bottom: 6px;
            display: block;
        }

        .btn-sub {
            align-self: flex-start;
            background-color: #2b6777;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-sub:hover {
            background-color: #1b4e5e;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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


                @if($permissions->add_patient_admin)

                <h1>Add Patient</h1>
                <div class="dev_deg">
                    <form class="form_deg" action="{{url('upload_patient_admin')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="input_deg invisible">
                            <label>User Name</label>
                            <input readonly type="text" name="id_user" value="{{Auth::user()->name}} [ID: {{Auth::user()->id}}]">
                        </div>

                        <div class="input_deg">
                            <label>* Full Name</label>
                            <input require type="text" name="name" placeholder="Enter Full Name">
                        </div>

                        <div class="input_deg">
                            <label>* Phone</label>
                            <input require type="text" name="phone" placeholder="Enter Phone">
                        </div>

                        <div class="input_deg">
                            <label>Address</label>
                            <input type="text" name="address" placeholder="Enter Address">
                        </div>

                        <div class="input_deg">
                            <label>* Age</label>
                            <input require type="text" name="age" placeholder="Enter Age">
                        </div>

                        <div class="input_deg">
                            <label>* Gender</label>
                            <select require name="gender" id="">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>

                        <div class="input_deg">
                            <label>Doctor Name</label>
                            <input type="text" name="doctor" placeholder="Enter Doctor">
                        </div>

                        <!-- Category -->
                        <div class="input_deg">
                            <label class="mb-3">* Category</label>
                            <select name="category" id="category">
                                <option value="">اختر الفئة</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Position -->
                        <div class="input_deg">
                            <label class="mb-3">* Positions</label>
                            <select id="position" name="positions[]" class="form-control select2" multiple></select>
                        </div>

                        <!-- Situation -->
                        <div class="input_deg">
                            <label class="mb-3">* Situations</label>
                            <select id="situation" name="situations[]" class="form-control select2" multiple></select>
                        </div>


                        <!-- Complaint -->
                        <div class="input_deg mt-4">
                            <label>Reason for complaint</label>
                            <textarea name="complaint" placeholder="Enter Reason for complaint"></textarea>
                        </div>

                        <!-- Location -->
                        <div class="input_deg">
                            <label>* Location</label>
                            <select name="location" required>
                                <option value="">Select Location</option>
                                @foreach($dataLoc as $loc)
                                <option value="{{ $loc->id }}">{{ $loc->location_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price -->
                        <div class="input_deg">
                            <label>Price</label>
                            <input readonly class="text-success" type="text" name="price" id="price" placeholder="السعر الإجمالي">
                        </div>

                        <!-- discount -->
                        <div class="input_deg">
                            <label>discount</label>
                            <input class="text-success" type="text" name="discount" id="discount" placeholder="أدخل نسبة الخصم (%)">
                        </div>

                        <!-- final Price -->
                        <div class="input_deg">
                            <label>Final Price</label>
                            <input readonly class="text-success" type="text" name="finalPrice" id="final_price" placeholder="السعر بعد الخصم">
                        </div>

                        <!-- payment -->
                        <div class="input_deg">
                            <label>* payment</label>
                            <select require name="payment" id="">
                                <option value="">Select payment</option>
                                <option value="cash">Cash</option>
                                <option value="InstaPay">InstaPay</option>
                                <option value="cash_wallet">Cash Wallet</option>
                                <option value="other">other</option>
                            </select>
                        </div>

                        <!-- Comments -->
                        <div class="input_deg">
                            <label>Comments</label>
                            <textarea name="comments" placeholder="Enter Comments"></textarea>
                        </div>

                        <!-- Image -->
                        <div class="input_deg">
                            <label>A image of the prescription</label>
                            <input type="file" name="image">
                        </div>

                        <!-- Submit -->
                        <div>
                            <input class="btn btn-success btn-sub" type="submit" value="Add Patient">
                        </div>
                    </form>

                    <!-- Scripts -->

                    @include('admin.js')

                    <!-- jQuery -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                    <!-- Toastr -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

                    <!-- سكريبت إظهار التنبيهات -->
                    <script>
                        $(document).ready(function() {
                            @if(session('success'))
                            toastr.success("{{ session('success') }}");
                            @elseif(session('error'))
                            toastr.error("{{ session('error') }}");
                            @elseif(session('info'))
                            toastr.info("{{ session('info') }}");
                            @elseif(session('warning'))
                            toastr.warning("{{ session('warning') }}");
                            @endif
                        });
                    </script>


                    <script>
                        $(document).ready(function() {
                            // إعداد Toastr
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true,
                                "positionClass": "toast-top-center",
                                "timeOut": "5000"
                            };

                            let allPositions = {};
                            let allSituations = {};
                            let currentTotal = 0; // متغير لحفظ السعر الإجمالي

                            $('#category').change(function() {
                                let categoryId = $(this).val();
                                $('#position').empty().append('<option>جاري التحميل...</option>');
                                $('#situation').empty();
                                $('#price').val('');
                                $('#final_price').val(''); // مسح حقل السعر النهائي

                                if (!categoryId) {
                                    toastr.warning("يرجى اختيار فئة أولاً");
                                    return;
                                }

                                $.ajax({
                                    url: '/get-positions/' + categoryId,
                                    type: 'GET',
                                    success: function(data) {
                                        $('#position').empty();
                                        $.each(data, function(index, value) {
                                            $('#position').append('<option value="' + value.id + '">' + value.position_name + '</option>');
                                            allPositions[value.id] = value.position_name;
                                        });
                                    },
                                    error: function() {
                                        toastr.error("فشل تحميل الفحوصات");
                                    }
                                });
                            });

                            $('#position').change(function() {
                                $('#situation').empty();
                                $('#price').val('');
                                $('#final_price').val(''); // مسح حقل السعر النهائي

                                let selectedPositions = $(this).val();
                                if (selectedPositions.length === 0) {
                                    toastr.info("لم يتم اختيار أي فحص");
                                    return;
                                }

                                selectedPositions.forEach(function(positionId) {
                                    $.ajax({
                                        url: '/get-situations/' + positionId,
                                        type: 'GET',
                                        success: function(data) {
                                            $.each(data, function(index, value) {
                                                if (!$('#situation option[value="' + value.id + '"]').length) {
                                                    $('#situation').append('<option value="' + value.id + '">' + value.situation_name + '</option>');
                                                    allSituations[value.id] = value.price;
                                                }
                                            });
                                        },
                                        error: function() {
                                            toastr.error("فشل تحميل الأوضاع");
                                        }
                                    });
                                });
                            });

                            $('#situation').change(function() {
                                currentTotal = 0; // إعادة تعيين السعر الإجمالي
                                let prices = [];

                                $(this).val().forEach(function(situationId) {
                                    let price = parseFloat(allSituations[situationId]) || 0;
                                    prices.push(price);
                                    currentTotal += price;
                                });

                                let display = prices.join(' + ') + ' = ' + currentTotal;
                                $('#price').val(display);
                                calculateDiscount(); // حساب الخصم مباشرة عند تغيير الأوضاع
                            });

                            // دالة لحساب الخصم
                            function calculateDiscount() {
                                let discountPercentage = parseFloat($('#discount').val()) || 0;
                                let discountAmount = (currentTotal * discountPercentage) / 100;
                                let finalPrice = currentTotal - discountAmount;

                                $('#final_price').val(finalPrice.toFixed(2));
                            }

                            // استماع لتغييرات حقل الخصم
                            $('#discount').on('input', function() {
                                calculateDiscount();
                            });
                        });
                    </script>

                    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

                    <script>
                        $(document).ready(function() {
                            // تفعيل Select2
                            $('#position').select2({
                                placeholder: "اختر الفحوصات",
                                width: '100%'
                            });

                            $('#situation').select2({
                                placeholder: "اختر الأوضاع",
                                width: '100%'
                            });

                            // باقي السكريبت حق تحميل الفحوصات والأوضاع والسعر شغال بدون تعديل.
                            var tagSelector = new MultiSelectTag('position', {
                                maxSelection: 5,
                                placeholder: 'اختر فحص',
                            });

                            var tagSelector2 = new MultiSelectTag('situation', {
                                maxSelection: 5,
                                placeholder: 'اختر الوضع',
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