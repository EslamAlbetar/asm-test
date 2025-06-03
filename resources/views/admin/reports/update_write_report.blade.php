<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.css')
    <style>
    :root {
        --primary-color: #3498db;
        --secondary-color: #2ecc71;
        --dark-color: #2c3e50;
        --light-color: #ecf0f1;
        --danger-color: #e74c3c;
        --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --border-radius: 12px;
    }

    body {
        background-color: #f8fafc;
        font-family: 'Segoe UI', 'Roboto', sans-serif;
        line-height: 1.6;
        color: #333;
    }

    h1 {
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 2rem;
        color: var(--light-color);
        position: relative;
        padding-bottom: 15px;
    }

    h1::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 4px;
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border-radius: 2px;
    }

    .report-container {
        max-width: 1000px;
        margin: 2rem auto;
        background: #fff;
        padding: 2.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .report-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .report-container h3 {
        color: var(--dark-color);
        margin-bottom: 1.2rem;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .report-container h3 i {
        margin-right: 10px;
        color: var(--primary-color);
    }

    textarea {
        width: 100%;
        min-height: 300px;
        padding: 1.2rem;
        border-radius: var(--border-radius);
        border: 2px solid #e2e8f0;
        resize: vertical;
        margin-bottom: 1.5rem;
        font-size: 1rem;
        line-height: 1.6;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }

    .form-control-sign {
        font-family: "Caveat", cursive;
        font-size: 1.8rem;
        padding: 0.8rem 1rem;
        border-radius: var(--border-radius);
        border: 2px solid #e2e8f0;
        width: 100%;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }

    .form-control-sign:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        background-color: #fff;
    }

    .signature-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--dark-color);
    }

    .btn-submit {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.8rem 1.8rem;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn i {
        margin-right: 8px;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    }

    .btn-success {
        background-color: var(--secondary-color);
        color: white;
    }

    .btn-success:hover {
        background-color: #27ae60;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
    }

    .patient-info {
        background-color: #f8f9fa;
        padding: 1.5rem;
        border-radius: var(--border-radius);
        margin-bottom: 2rem;
        display: grid;
        grid-template-columns: 2fr 1fr 1fr; /* تعديل توزيع الأعمدة */
        gap: 1rem;
        align-items: center; /* محاذاة العناصر عمودياً في المنتصف */
    }

    /* تخصيص كلاس الاسم الكامل ليكون أوسع */
    .patient-info .fullname {
        grid-column: 1;
        width: 100%;
    }

    /* تخصيص كلاس العمر ليكون بحجم الرقم فقط */
    .patient-info .age {
        grid-column: 2;
        text-align: center;
        min-width: fit-content; /* يتناسب مع محتواه فقط */
    }

    /* تخصيص كلاس التاريخ ليكون في المنتصف */
    .patient-info .date {
        grid-column: 3;
        text-align: center;
    }

    /* أيقونة المستخدم */
    .fa-user {
        margin-right: 8px;
    }
    .patient-info h3 {
        margin: 0;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .report-container {
            padding: 1.5rem;
        }
        
        .btn-submit {
            flex-direction: column;
            gap: 1rem;
        }
        
        .btn {
            width: 100%;
        }
    }

    /* Animation for the form */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .report-container {
        animation: fadeIn 0.6s ease-out forwards;
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

                @if($permissions->write_report_now)
                <h1>Medical Report</h1>

                <div class="report-container">
                    <form id="reportForm" method="POST" action="{{ url('confirm_report/'.$patient->id) }}">
                        @csrf

                        <div class="patient-info">
                            <h3 class="fullname"><i class="fas fa-user"></i> Name: {{ $patient->full_name }}</h3>
                            <h3 class="age"><i class="fas fa-birthday-cake"></i> Age: {{ $patient->age }} y</h3>
                            <h3 class="date"><i class="far fa-calendar-alt"></i> Date: {{ $patient->created_at->format('Y-m-d') }}</h3>
                        </div>

                        <textarea name="report_text" placeholder="Write your detailed medical report here...">{{ $patient->report_details }}</textarea>

                        <label for="signature" class="signature-label">
                            <i class="fas fa-signature"></i> Doctor's Signature
                        </label>
                        <input name="signature" class="form-control-sign" type="text" 
                               placeholder="Enter your full name as signature" 
                               value="{{ $patient->doctor_signature }}">

                        <div class="btn-submit">
                            <a href="{{ url('/writing_report') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <input type="button" id="confirmBtn" class="btn btn-success" value="Confirm Report">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        @include('admin.js')

        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session("success") }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
        @endif


        <script>
            document.getElementById('confirmBtn').addEventListener('click', function() {
                Swal.fire({
                    title: 'Confirm Submission?',
                    text: "Are you sure you want to submit the report?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Submit it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading and submit form
                        Swal.fire({
                            title: 'Saving...',
                            text: 'Please wait while we save the report',
                            timer: 2000,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading()
                                document.getElementById('reportForm').submit();
                            }
                        });
                    }
                });
            });
        </script>

    </div>

    @else
    <div class="no-data">
        <p style="margin: 0; font-size: 18px;">لا تملك صلاحية الوصول للصفحة</p>
    </div>
    @endif
</body>

</html>