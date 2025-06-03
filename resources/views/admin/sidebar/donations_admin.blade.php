<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
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
        font-size: 1.8rem;
    }

    .dev_deg {
        background: #ffffff;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-top: 15px;
        width: 100%;
        box-sizing: border-box;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        font-size: 0.9rem;
    }

    .table th {
        background-color: #007bff;
        color: #fff;
        text-align: center;
        vertical-align: middle;
        padding: 10px 5px;
    }

    .table td {
        vertical-align: middle;
        text-align: center;
        background-color: #fefefe;
        padding: 8px 5px;
    }

    .btn {
        font-size: 0.9rem;
        border-radius: 6px;
        padding: 8px 12px;
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

    .modal-content {
        border-radius: 10px;
        margin: 10px;
    }

    .modal-header {
        border-bottom: 1px solid #ddd;
        background-color: #f1f1f1;
        padding: 15px;
    }

    .modal-title {
        font-weight: 600;
        font-size: 1.2rem;
    }

    .modal-footer {
        background-color: #fefefe;
        border: none;
        padding: 15px;
    }

    .form-group {
        margin-bottom: 12px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        font-size: 0.9rem;
    }

    .form-control {
        border-radius: 6px;
        border: 1px solid #ccc;
        background-color: #ffffff;
        padding: 8px 10px;
        font-size: 0.9rem;
        transition: border 0.3s;
        width: 100%;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 4px rgba(0, 123, 255, 0.3);
    }

    #loadingSpinner {
        margin: 20px auto;
        text-align: center;
    }

    .btn-close-custom {
        background: none;
        border: none;
        font-size: 1.2rem;
        color: #555;
    }

    .modal-body {
        background-color: #fefefe;
        padding: 15px;
        border-radius: 0 0 10px 10px;
    }

    .form-group {
        margin-bottom: 15px;
        padding: 8px 12px;
        background-color: #f9f9f9;
        border-left: 3px solid #007bff;
        border-radius: 6px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
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

    /* تحسينات للجوال */
    @media (max-width: 768px) {
        .page-content {
            padding: 15px 5px;
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .dev_deg {
            padding: 12px;
        }

        .table {
            font-size: 0.8rem;
        }

        .table th, .table td {
            padding: 6px 3px;
        }

        .btn {
            font-size: 0.8rem;
            padding: 6px 10px;
        }

        .modal-header, .modal-footer {
            padding: 12px;
        }

        .modal-title {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 480px) {
        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            font-size: 0.75rem;
        }

        .btn {
            font-size: 0.75rem;
        }
    }
</style>

    <link href="https://cdn.jsdelivr.net/npm/toastr/build/toastr.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

            @if($permissions->donations_admin)
                <!-- زر الإضافة -->
                <div class="text-center">
                    <button class="btn btn-danger mb-4 px-5 py-3 rounded" data-bs-toggle="modal" data-bs-target="#donationModal">
                        Add a donation
                    </button>
                </div>

                <h1>Donations</h1>

                <div class="dev_deg">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Reason</th>
                                <th>Date</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody id="donationTable">

                        </tbody>
                    </table>
                </div>

            </div>
        </div>


        <!-- مودال الإدخال -->
        <div class="modal fade" id="donationModal" tabindex="-1" aria-labelledby="donationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="donationForm">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Donation</h5>
                            <button type="button" class="btn-close-custom" data-bs-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter full name" required>
                            </div>

                            <div class="form-group">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" id="age" name="age" class="form-control" placeholder="Enter age" required>
                            </div>

                            <div class="form-group">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" id="address" name="address" class="form-control" placeholder="Enter address" required>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter phone number" required>
                            </div>

                            <div class="form-group">
                                <label for="amount" class="form-label">Donation Amount</label>
                                <input type="number" id="amount" name="amount" class="form-control" placeholder="Enter amount" required>
                            </div>

                            <div class="form-group">
                                <label for="reason" class="form-label">Donation Reason</label>
                                <input type="text" id="reason" name="reason" class="form-control" placeholder="Enter reason" required>
                            </div>

                            <div class="form-group">
                                <label for="date" class="form-label">Donation Date</label>
                                <input type="date" id="date" name="date" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="submitDonationBtn">
                                <span id="submitText">Submit</span>
                                <span id="submitSpinner" class="spinner-border spinner-border-sm ms-2" style="display: none;" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- مودال التعديل -->
        <div class="modal fade" id="editDonationModal" tabindex="-1" aria-labelledby="editDonationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="editDonationForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Donation</h5>
                            <button type="button" class="btn-close-custom" data-bs-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="donation_id" id="edit_donation_id">

                            <div class="form-group">
                                <label for="edit_name" class="form-label">Full Name</label>
                                <input type="text" name="name" id="edit_name" class="form-control" placeholder="Enter full name" required>
                            </div>

                            <div class="form-group">
                                <label for="edit_age" class="form-label">Age</label>
                                <input type="number" name="age" id="edit_age" class="form-control" placeholder="Enter age" required>
                            </div>

                            <div class="form-group">
                                <label for="edit_address" class="form-label">Address</label>
                                <input type="text" name="address" id="edit_address" class="form-control" placeholder="Enter address" required>
                            </div>

                            <div class="form-group">
                                <label for="edit_phone" class="form-label">Phone Number</label>
                                <input type="text" name="phone" id="edit_phone" class="form-control" placeholder="Enter phone number" required>
                            </div>

                            <div class="form-group">
                                <label for="edit_amount" class="form-label">Donation Amount</label>
                                <input type="number" name="amount" id="edit_amount" class="form-control" placeholder="Enter amount" required>
                            </div>

                            <div class="form-group">
                                <label for="edit_reason" class="form-label">Donation Reason</label>
                                <input type="text" name="reason" id="edit_reason" class="form-control" placeholder="Enter reason" required>
                            </div>

                            <div class="form-group">
                                <label for="edit_date" class="form-label">Donation Date</label>
                                <input type="date" name="date" id="edit_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success me-2" id="editSubmitBtn">
                                <span id="editSubmitText">Update</span>
                                <span id="editSubmitSpinner" class="spinner-border spinner-border-sm ms-2" style="display: none;" role="status" aria-hidden="true"></span>
                            </button>
                            <!-- زر الحذف في مودال التعديل -->
                            <button type="button" class="btn btn-danger" id="deleteDonationBtn">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- سبنر التحميل -->
        <div id="loadingSpinner" style="display: none; text-align: center; margin: 20px 0;">
            <div id="lottieLoader" style="width: 100px; height: 100px; margin: auto;"></div>
        </div>


        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-3 shadow">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">تأكيد الحذف</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body">
                        هل أنت متأكد أنك تريد حذف هذا التبرع؟ لا يمكن التراجع بعد الحذف.
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">تأكيد الحذف</button>
                    </div>
                </div>
            </div>
        </div>



        <!-- JavaScript files-->
        @include('admin.js')

        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/toastr/build/toastr.min.js"></script>
        <script src="https://unpkg.com/lottie-web@5.12.0/build/player/lottie.min.js"></script>
    </div>

    <script>
    $(document).ready(function() {
        // تحميل البيانات عند فتح الصفحة
        loadDonations();

        // إعداد CSRF Token لجميع طلبات AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // إرسال نموذج الإضافة
        $('#donationForm').on('submit', function(e) {
            e.preventDefault();
            showButtonSpinner('#submitDonationBtn', 'Submitting...');

            $.ajax({
                url: '/donations',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#donationModal').modal('hide');
                        $('#donationForm')[0].reset();
                        loadDonations();
                        showToast('success', response.message);
                    }
                },
                error: function(xhr) {
                    showToast('error', 'Error: ' + xhr.responseJSON.message);
                },
                complete: function() {
                    hideButtonSpinner('#submitDonationBtn', 'Submit');
                }
            });
        });

        // فتح مودال التعديل
        $(document).on('click', '.edit-btn', function() {
            const donationId = $(this).data('id');
            showButtonSpinner('#editSubmitBtn', 'Loading...');

            $.ajax({
                url: '/donations/' + donationId + '/edit',
                type: 'GET',
                success: function(donation) {
                    $('#edit_donation_id').val(donation.id);
                    $('#edit_name').val(donation.name);
                    $('#edit_age').val(donation.age);
                    $('#edit_address').val(donation.address);
                    $('#edit_phone').val(donation.phone);
                    $('#edit_amount').val(donation.amount);
                    $('#edit_reason').val(donation.reason);
                    
                    // تحويل التاريخ للتنسيق الصحيح
                    const date = new Date(donation.date);
                    const formattedDate = date.toISOString().substr(0, 10);
                    $('#edit_date').val(formattedDate);
                    
                    $('#editDonationModal').modal('show');
                },
                error: function(xhr) {
                    showToast('error', 'Failed to load donation data: ' + xhr.responseJSON.message);
                },
                complete: function() {
                    hideButtonSpinner('#editSubmitBtn', 'Update');
                }
            });
        });

        // إرسال نموذج التعديل
        $('#editDonationForm').on('submit', function(e) {
            e.preventDefault();
            const donationId = $('#edit_donation_id').val();
            showButtonSpinner('#editSubmitBtn', 'Updating...');

            $.ajax({
                url: '/donations/' + donationId,
                type: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#editDonationModal').modal('hide');
                        loadDonations();
                        showToast('success', response.message);
                    }
                },
                error: function(xhr) {
                    showToast('error', 'Error: ' + xhr.responseJSON.message);
                },
                complete: function() {
                    hideButtonSpinner('#editSubmitBtn', 'Update');
                }
            });
        });

        // حذف تبرع
        $('#deleteDonationBtn').on('click', function() {
            $('#confirmDeleteModal').modal('show');
        });

        $('#confirmDeleteBtn').on('click', function() {
            const donationId = $('#edit_donation_id').val();
            showButtonSpinner('#confirmDeleteBtn', 'Deleting...');

            $.ajax({
                url: '/donations/' + donationId,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        $('#editDonationModal').modal('hide');
                        $('#confirmDeleteModal').modal('hide');
                        loadDonations();
                        showToast('success', response.message);
                    }
                },
                error: function(xhr) {
                    showToast('error', 'Error: ' + xhr.responseJSON.message);
                },
                complete: function() {
                    hideButtonSpinner('#confirmDeleteBtn', 'Confirm Delete');
                }
            });
        });

        // دالة تحميل التبرعات
        function loadDonations() {
            $('#loadingSpinner').show();

            $.ajax({
                url: '/donations',
                type: 'GET',
                success: function(donations) {
                    let tableBody = $('#donationTable');
                    tableBody.empty();

                    donations.forEach((donation, index) => {
                        tableBody.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${donation.name}</td>
                                <td>${donation.age}</td>
                                <td>${donation.address}</td>
                                <td>${donation.phone}</td>
                       <td class="text-success">${parseFloat(donation.amount || 0).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})} EGP</td>
                                <td>${donation.reason}</td>
                                <td>${donation.date.split('T')[0]}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn" data-id="${donation.id}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                },
                error: function() {
                    showToast('error', 'Failed to load donations');
                },
                complete: function() {
                    $('#loadingSpinner').hide();
                }
            });
        }

        // دالة عرض السبنر على الأزرار
        function showButtonSpinner(buttonId, text) {
            $(buttonId).prop('disabled', true);
            $(buttonId).find('span:not(.spinner-border)').text(text);
            $(buttonId).find('.spinner-border').show();
        }

        // دالة إخفاء السبنر عن الأزرار
        function hideButtonSpinner(buttonId, text) {
            $(buttonId).prop('disabled', false);
            $(buttonId).find('span:not(.spinner-border)').text(text);
            $(buttonId).find('.spinner-border').hide();
        }

        // دالة عرض التنبيهات
        function showToast(type, message) {
            toastr[type](message, type.charAt(0).toUpperCase() + type.slice(1), {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 5000
            });
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