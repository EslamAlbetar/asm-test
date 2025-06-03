<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    <style>
        /* تصميم عام للصفحة */
        .page-content {
            padding: 2rem;
            background-color: #f8fafc;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }



        .page-title {
            color: #2d3748;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        /* تنبيه النجاح */
        .success-alert {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #d4edda;
            color: #155724;
            padding: 15px 25px;
            border-radius: 10px;
            z-index: 3000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                top: 0;
            }

            to {
                opacity: 1;
                top: 20px;
            }
        }

        /* حالة عدم وجود بيانات */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .empty-icon {
            font-size: 3rem;
            color: #a0aec0;
            margin-bottom: 1rem;
        }

        .empty-state h2 {
            color: #718096;
            font-weight: 500;
        }

        /* تصميم الجدول */
        .table-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-responsive {
            overflow-x: auto;
            padding: 1px;
        }

        .patients-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        .patients-table thead {
            background-color: #f7fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        .patients-table th {
            padding: 15px 12px;
            text-align: right;
            color: #4a5568;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            text-align: center;
        }


        .patients-table td {
            padding: 12px;
            border-bottom: 1px solid #edf2f7;
            color: #4a5568;
            vertical-align: middle;
        }

        .patient-row:hover {
            background-color: #f8fafc;
        }

        /* تصميم البادجات */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
            margin: 2px;
        }

        .position-badge {
            background-color: #ebf8ff;
            color: #3182ce;
            border: 1px solid #bee3f8;
        }

        .situation-badge {
            background-color: #fffaf0;
            color: #dd6b20;
            border: 1px solid #feebc8;
        }

        .gender-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            text-transform: capitalize;
        }

        .gender-badge.male {
            background-color: #ebf8ff;
            color: #3182ce;
        }

        .gender-badge.female {
            background-color: #fff5f7;
            color: #d53f8c;
        }

        /* تصميم الأزرار */
        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
        }

        .update-btn {
            background-color: #f6e05e;
            color: #975a16;
        }

        .update-btn:hover {
            background-color: #ecc94b;
            transform: translateY(-1px);
        }

        .complete-btn {
            background-color: #68d391;
            color: #22543d;
        }

        .complete-btn:hover {
            background-color: #48bb78;
            transform: translateY(-1px);
        }

        /* تصميم الخلايا الخاصة */
        .comments-cell {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* تصميم السبنر */
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
            z-index: 2000;
            display: none;
        }

        .spinner {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .spinner-circle {
            width: 50px;
            height: 50px;
            border: 4px solid #e2e8f0;
            border-top: 4px solid #4299e1;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .spinner span {
            color: #4a5568;
            font-size: 1rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* تصميم المودال */
        .confirm-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2500;
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background-color: white;
            border-radius: 12px;
            width: 100%;
            max-width: 450px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .modal-icon {
            font-size: 1.5rem;
            color: #4299e1;
        }

        .modal-title {
            margin: 0;
            color: #2d3748;
            font-size: 1.25rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-message {
            margin: 0;
            color: #4a5568;
            line-height: 1.6;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .modal-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .confirm-btn {
            background-color: #48bb78;
            color: white;
        }

        .confirm-btn:hover {
            background-color: #38a169;
            transform: translateY(-1px);
        }

        .cancel-btn {
            background-color: #f56565;
            color: white;
        }

        .cancel-btn:hover {
            background-color: #e53e3e;
            transform: translateY(-1px);
        }

        /* تصميم متجاوب */
        @media (max-width: 992px) {

            .patients-table th,
            .patients-table td {
                padding: 10px 8px;
            }

            .action-btn {
                padding: 6px 10px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 768px) {
            .page-content {
                padding: 1.5rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .modal-content {
                max-width: 90%;
            }
        }

        @media (max-width: 576px) {
            .modal-footer {
                flex-direction: column;
            }

            .modal-btn {
                width: 100%;
                justify-content: center;
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

                @if($permissions->waiting_list_admin)

                <!-- تنبيه النجاح -->
                <div id="successAlert" class="success-alert">
                    ✅ تم نقل المريض بنجاح!
                </div>

                <h1 class="page-title">Waiting List</h1>

                @if($patients->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-user-injured empty-icon"></i>
                    <h2>لا يوجد مرضى في قائمة الانتظار</h2>
                </div>
                @else
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="patients-table">
                            <thead>
                                <tr>
                                    <th>Added by User</th>
                                    <th>Full Name</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Category</th>
                                    <th>Position</th>
                                    <th>Situations</th>
                                    <th>Location</th>
                                    <th>Comments</th>
                                    <th>Update</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patients as $patient)
                                <tr id="patient-row-{{ $patient->id }}" class="patient-row">
                                    <td>{{ $patient->id_user }}</td>
                                    <td>{{ $patient->full_name }}</td>
                                    <td>{{ $patient->age }}</td>
                                    <td><span class="gender-badge {{ $patient->gender }}">{{ $patient->gender }}</span></td>
                                    <td>{{ $patient->category_name ?? 'غير محدد' }}</td>
                                    <td>
                                        @forelse($patient->position_names as $pos)
                                        <span class="badge position-badge">{{ $pos }}</span>
                                        @empty
                                        <span class="text-muted">غير محدد</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        @if(count($patient->situation_names))
                                        @foreach($patient->situation_names as $situation)
                                        <span class="badge situation-badge">{{ $situation }}</span>
                                        @endforeach
                                        @else
                                        <span class="text-muted">غير محدد</span>
                                        @endif
                                    </td>
                                    <td>{{ $patient->locationData->location_name ?? 'غير محدد' }}</td>
                                    <td class="comments-cell">{!! Str::limit($patient->comments, 25) !!}</td>
                                    @php
                                    $permissions = \App\Models\AuthedPage::where('user_id', auth()->id())->first();
                                    @endphp
                                    <td>
                                        @if($permissions->update_waiting_list_admin)
                                        <a class="btn action-btn update-btn" href="{{ url('update_waiting_list_admin', $patient->id) }}">
                                            <i class="fas fa-edit"></i> Update
                                        </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($permissions->completePatient)
                                        <a class="btn action-btn complete-btn" href="javascript:void(0);" onclick="showConfirmModal({{ $patient->id }})">
                                            <i class="fas fa-check-circle"></i> Completed
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <!-- ترقيم الصفحات -->
                <div class="pagination-container mt-4">
                    {{ $patients->links() }}
                </div>

            </div>
        </div>

        <!-- Spinner Overlay -->
        <div id="spinnerOverlay" class="spinner-overlay">
            <div class="spinner">
                <div class="spinner-circle"></div>
                <span>جاري المعالجة...</span>
            </div>
        </div>

        <!-- Modern Confirmation Modal -->
        <div id="confirmModal" class="confirm-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fas fa-question-circle modal-icon"></i>
                    <h3 class="modal-title">تأكيد الإجراء</h3>
                </div>
                <div class="modal-body">
                    <p class="modal-message">هل أنت متأكد أنك تريد إكمال حالة هذا المريض؟</p>
                </div>
                <div class="modal-footer">
                    <button id="confirmYes" class="modal-btn confirm-btn">
                        <i class="fas fa-check"></i> نعم، أكمل
                    </button>
                    <button onclick="closeModal()" class="modal-btn cancel-btn">
                        <i class="fas fa-times"></i> إلغاء
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script>
        let selectedPatientId = null;

        function showConfirmModal(patientId) {
            selectedPatientId = patientId;
            document.getElementById('confirmModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('confirmModal').style.display = 'none';
            selectedPatientId = null;
        }

        function showSpinner() {
            document.getElementById('spinnerOverlay').style.display = 'flex';
        }

        function hideSpinner() {
            document.getElementById('spinnerOverlay').style.display = 'none';
        }

        function showSuccessAlert() {
            const alert = document.getElementById('successAlert');
            const sound = document.getElementById('successSound');
            if (sound) sound.play();
            alert.style.display = 'block';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 3000);
        }

        document.getElementById('confirmYes').addEventListener('click', function() {
            if (!selectedPatientId) return;

            showSpinner();

            fetch(`/completeAjax/${selectedPatientId}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    hideSpinner();

                    if (data.status === 'success') {
                        const row = document.getElementById(`patient-row-${selectedPatientId}`);
                        if (row) {
                            row.style.transition = 'opacity 0.5s ease';
                            row.style.opacity = '0';
                            setTimeout(() => {
                                row.remove();
                                showSuccessAlert();
                            }, 500);
                        }
                    } else {
                        alert('حدث خطأ: ' + data.message);
                    }

                    closeModal();
                })
                .catch(error => {
                    hideSpinner();
                    alert('حدث خطأ في الاتصال');
                    closeModal();
                });
        });
    </script>

        @include('admin.js')

    @else
    <h2 class="text-danger text-center">! لا تملك صلاحيات للدخول لهذه الصفحة</h2>
    @endif
</body>

</html>