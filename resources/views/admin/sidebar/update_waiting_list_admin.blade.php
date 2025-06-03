<!DOCTYPE html>
<html>

<head>
    @include('admin.css')

    <style>
        /* تصميم عام للصفحة */
        .page-content {
            padding: 2rem;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .page-title {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 2rem;
            font-weight: 600;
            text-align: center;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eaeaea;
        }

        /* تصميم الفورم */
        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .patient-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .input-group.full-width {
            grid-column: 1 / -1;
        }

        /* تصميم العناصر */
        label {
            font-weight: 500;
            color: #4a5568;
            font-size: 0.95rem;
        }

        .form-input,
        .form-select,
        .form-textarea {
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #fff;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-multiselect {
            height: auto;
            min-height: 100px;
            padding: 0.5rem;
        }

        .form-multiselect option {
            padding: 0.5rem;
        }

        .form-file {
            padding: 0.5rem 0;
        }

        /* تصميم الصورة */
        .patient-image {
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            padding: 5px;
            background-color: #fff;
        }

        .no-image {
            color: #e53e3e;
            font-style: italic;
        }

        /* تصميم الأزرار */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eaeaea;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-success {
            background-color: #38a169;
            color: white;
            border: none;
        }

        .btn-success:hover {
            background-color: #2f855a;
        }

        .btn-danger {
            background-color: #e53e3e;
            color: white;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c53030;
        }

        .btn-warning {
            background-color: #dd6b20;
            color: white;
            border: none;
        }

        .btn-warning:hover {
            background-color: #c05621;
        }

        .modal-content {
            padding: 0 !important;
        }

        /* تصميم متجاوب */
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .page-content {
                padding: 1rem;
            }

            .form-container {
                padding: 1.5rem;
            }

            .page-title {
                font-size: 1.5rem;
            }
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

                @if($permissions->update_waiting_list_admin)
                <h1 class="page-title">Update Patient</h1>
                <div class="form-container">
                    <form action="{{url('edit_waiting_list_admin', $data->id)}}" method="post" enctype="multipart/form-data" class="patient-form">
                        @csrf

                        <div class="form-grid">
                            <!-- الصف الأول -->
                            <div class="input-group">
                                <label>Full Name</label>
                                <input type="text" name="name" value="{{$data->full_name}}" class="form-input">
                            </div>

                            <div class="input-group">
                                <label>Phone</label>
                                <input type="text" name="phone" value="{{$data->phone}}" class="form-input">
                            </div>

                            <!-- الصف الثاني -->
                            <div class="input-group">
                                <label>Address</label>
                                <input type="text" name="address" value="{{$data->address}}" class="form-input">
                            </div>

                            <div class="input-group">
                                <label>Age</label>
                                <input type="text" name="age" value="{{$data->age}}" class="form-input">
                            </div>

                            <!-- الصف الثالث -->
                            <div class="input-group">
                                <label>Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="male" {{ $data->gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $data->gender == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <div class="input-group">
                                <label>Doctor Name</label>
                                <input type="text" name="doctor" value="{{$data->dr_name}}" class="form-input">
                            </div>

                            <!-- الصف الرابع -->
                            <div class="input-group">
                                <label>Category</label>
                                <select name="category" id="category" class="form-select">
                                </select>
                            </div>

                            <div class="input-group">
                                <label>Position</label>
                                <select name="positions[]" id="position" multiple class="form-multiselect">
                                    @php
                                    $selectedPositions = is_array($data->positions) ? $data->positions : json_decode($data->positions ?? '[]');
                                    $selectedPositions = is_array($selectedPositions) ? $selectedPositions : [];
                                    $allPosi = count($selectedPositions) ? \App\Models\PositionName::whereIn('id', $selectedPositions)->get() : collect();
                                    @endphp

                                    @forelse($allPosi as $pos)
                                    <option value="{{ $pos->id }}" selected>{{ $pos->position_name }}</option>
                                    @empty
                                    <option disabled selected>No saved data!</option>
                                    @endforelse
                                </select>
                            </div>

                            <!-- الصف الخامس -->
                            <div class="input-group">
                                <label>Situations</label>
                                <select name="situations[]" id="situation" multiple class="form-multiselect">
                                    @php
                                    $selectedSituations = is_array($data->situations) ? $data->situations : json_decode($data->situations ?? '[]');
                                    $selectedSituations = is_array($selectedSituations) ? $selectedSituations : [];
                                    $allSit = count($selectedSituations) ? \App\Models\Situation::whereIn('id', $selectedSituations)->get() : collect();
                                    @endphp

                                    @forelse($allSit as $sit)
                                    <option value="{{ $sit->id }}" selected>{{ $sit->situation_name }}</option>
                                    @empty
                                    <option disabled selected>No saved data!</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="input-group full-width">
                                <label>Reason for complaint</label>
                                <textarea name="complaint" id="complaint" class="form-textarea">{{ $data->complaint }}</textarea>
                            </div>

                            <!-- الصف السادس -->
                            <div class="input-group">
                                <label>Location</label>
                                <select name="location" id="location" class="form-select"></select>
                            </div>

                            <div class="input-group">
                                <label>Payment</label>
                                <select name="payment" class="form-select">
                                    <option value="">Select Payment</option>
                                    <option value="cash" {{ $data->payment == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="InstaPay" {{ $data->payment == 'InstaPay' ? 'selected' : '' }}>InstaPay</option>
                                    <option value="cash_wallet" {{ $data->payment == 'cash_wallet' ? 'selected' : '' }}>Cash Wallet</option>
                                    <option value="other" {{ $data->payment == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="input-group">
                                <label>Price</label>
                                <input type="text" name="price" id="price" value="{{ $data->price ? $data->price : 0 }}" class="form-input">
                            </div>

                            <!-- discount -->
                            <div class="input_deg">
                                <label>discount</label>
                                <input class="text-success" type="text" name="discount" id="discount" value="{{ $data->discount ? $data->discount : 0 }}" placeholder="أدخل نسبة الخصم (%)">
                            </div>

                            <!-- final Price -->
                            <div class="input_deg">
                                <label>Final Price</label>
                                <input readonly class="text-success" type="text" name="finalPrice" id="final_price" value="{{ $data->finalPrice ? $data->finalPrice : 0 }}" placeholder="السعر بعد الخصم">
                            </div>

                            <!-- الصف السابع -->
                            <div class="input-group full-width">
                                <label>Comments</label>
                                <textarea name="comments" class="form-textarea">{{$data->comments}}</textarea>
                            </div>

                            <!-- الصف الثامن -->
                            <div class="input-group">
                                <label>Current Image</label>
                                @if ($data->image)
                                <img width="150" src="/Rochetes/{{$data->image}}" alt="Patient Image" class="patient-image">
                                @else
                                <p class="no-image">No Image Available</p>
                                @endif
                            </div>

                            <div class="input-group">
                                <label>New Image</label>
                                <input type="file" name="image" class="form-file">
                            </div>
                        </div>

                        <div class="form-actions">
                            <input class="btn btn-success" type="submit" value="Update Patient">
                            <a class="btn btn-danger" onclick="confirmation(event)" href="{{url('delete_waiting_patient_admin', $data->id)}}">Delete</a>
                            <a class="btn btn-warning" href="{{url('waiting_list_admin')}}">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    @include('admin.js')
    </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function confirmation(event) {
            event.preventDefault(); // علشان يمنع اللينك يشتغل على طول

            if (confirm("هل أنت متأكد من حذف هذا المريض؟")) {
                window.location.href = event.currentTarget.getAttribute('href');
            }
        }
    </script>

<script>
    $(document).ready(function() {
        let allPositions = {};
        let allSituations = {};
        let currentTotal = 0; // متغير لتخزين السعر الإجمالي الحالي

        // البيانات الجاية من السيرفر للمريض (مع معالجة null أو undefined)
        const selectedCategory = {!! json_encode($data->category ?? null) !!};
        const selectedPositions = {!! json_encode(is_array($data->positions) ? $data->positions : json_decode($data->positions ?? '[]')) !!} || [];
        const selectedSituations = {!! json_encode(is_array($data->situations) ? $data->situations : json_decode($data->situations ?? '[]')) !!} || [];
        const selectedLocation = {!! json_encode($data->location ?? null) !!};
        const complaintText = {!! json_encode($data->complaint ?? '') !!};

        // تحميل الفئات
        $.get('/get-categories', function(cats) {
            $('#category').empty();
            cats.forEach(function(cat) {
                let selected = (cat.id == selectedCategory) ? 'selected' : '';
                $('#category').append(`<option value="${cat.id}" ${selected}>${cat.name}</option>`);
            });

            setTimeout(function() {
                if (selectedCategory) {
                    $('#category').trigger('change');
                }
            }, 200); // ربع ثانية تأخير
        });

        // تحميل المواقع
        $.get('/get-locations', function(locs) {
            $('#location').empty();
            locs.forEach(function(loc) {
                let selected = (loc.id == selectedLocation) ? 'selected' : '';
                $('#location').append(`<option value="${loc.id}" ${selected}>${loc.location_name}</option>`);
            });
        });

        // تفعيل Select2
        $('#position').select2();
        $('#situation').select2();

        setTimeout(function() {
            $('#position').val(selectedPositions).trigger('change');
        }, 200); // ربع ثانية تقريباً

        // لما يختار فئة – نحمل الفحوصات
        $('#category').change(function() {
            let categoryId = $(this).val();
            $('#position').empty().append('<option disabled>Loading...</option>');
            $('#situation').empty();
            $('#price').val('');
            allPositions = {};

            $.get('/get-positions/' + categoryId, function(positions) {
                $('#position').empty();
                positions.forEach(function(pos) {
                    let selected = selectedPositions.includes(pos.id) ? 'selected' : '';
                    $('#position').append(`<option value="${pos.id}" ${selected}>${pos.position_name}</option>`);
                    allPositions[pos.id] = pos.position_name;
                });

                // شغل Select2 من جديد
                $('#position').trigger('change.select2');

                // هنا تقدر بأمان تجهز الـ situations بعد ما الـ positions اتحملت فعلاً
                $('#position').val(selectedPositions).trigger('change');
            });
        });

        // لما يختار فحوصات – نحمل أوضاعهم
        $('#position').change(function() {
            $('#situation').empty();
            $('#price').val('');
            allSituations = {};

            let selected = $(this).val() || [];
            let loaded = 0;

            if (selected.length === 0) {
                $('#situation').append(`<option disabled selected>لا يوجد بيانات محفوظة!</option>`);
                return;
            }

            selected.forEach(function(posId) {
                $.get('/get-situations/' + posId, function(situations) {
                    situations.forEach(function(sit) {
                        if (!$(`#situation option[value="${sit.id}"]`).length) {
                            let selected = selectedSituations.includes(sit.id.toString()) ? 'selected' : '';
                            $('#situation').append(`<option value="${sit.id}" ${selected}>${sit.situation_name}</option>`);
                            allSituations[sit.id] = sit.price;
                        }
                    });

                    loaded++;
                    if (loaded === selected.length) {
                        $('#situation').trigger('change.select2').trigger('change');
                    }
                });
            });
        });

        // حساب السعر عند تغيير الأوضاع
        $('#situation').change(function() {
            currentTotal = 0; // إعادة تعيين السعر الإجمالي
            let prices = [];

            ($(this).val() || []).forEach(function(id) {
                let price = parseFloat(allSituations[id]) || 0;
                prices.push(price);
                currentTotal += price;
            });

            if (prices.length > 0) {
                $('#price').val(prices.join(' + ') + ' = ' + currentTotal);
            } else {
                $('#price').val('');
            }
            
            // حساب السعر النهائي بعد التحديث
            calculateDiscount();
        });

        // دالة لحساب الخصم والسعر النهائي
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

        // حساب السعر الأولي عند تحميل الصفحة
        if (selectedSituations.length > 0) {
            setTimeout(function() {
                $('#situation').trigger('change');
            }, 500);
        }
    });
</script>

    <!-- Head -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

            // بعد تحميل الصفحة لو في بيانات محفوظة، نبدأ التحميل التلقائي
            if (selectedCategory) {
                $('#category').trigger('change');
            }


        });
    </script>

    @else
    <h2 class="text-danger text-center">! لا تملك صلاحيات للدخول لهذه الصفحة</h2>
    @endif
</body>

</html>