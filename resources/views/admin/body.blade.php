<h1 class="h5 no-margin-bottom">Dashboard</h1>
</div>

<div class="page-header">
    <div class="container-fluid">
        <div class="d-flex align-items-center">

            @php
            $permissions = \App\Models\AuthedPage::where('user_id', auth()->id())->first();
            @endphp

            @if($permissions->editName_center)

            <div class="container mt-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0 text-center">Center Details</h5>
                            <small class="text-muted">Edit </small>
                        </div>

                        <!-- حالة العرض -->
                        <div id="name-display" class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <h2 class="mb-0 mr-2 text-primary fw-bold">
                                    <span class="text-dark">Name:</span> {{ $center->first_name }} {{ $center->second_name }}
                                    <br>
                                    <span class="text-dark">Address:</span> {{ $center->address }}
                                    <br>
                                    <span class="text-dark">Phone:</span> {{ $center->phone }}
                                </h2>
                            </div>
                            <button id="edit-name-btn" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-pen"></i> Edit
                            </button>
                        </div>

                        <!-- حالة التعديل -->
                        <div id="name-edit" class="row g-2 mt-3" style="display: none;">
                            <div class="col-md-5">
                                First Name <input type="text" id="first_name" class="form-control form-control-sm"
                                    value="{{ $center->first_name }}" placeholder="First Name">
                            </div>
                            <div class="col-md-5">
                                Seconde Name <input type="text" id="second_name" class="form-control form-control-sm"
                                    value="{{ $center->second_name }}" placeholder="Second Name">
                            </div>
                            <div class="col-md-5">
                                Address <input type="text" id="address" class="form-control form-control-sm"
                                    value="{{ $center->address }}" placeholder="Address">
                            </div>
                            <div class="col-md-5">
                                Phone <input type="text" id="phone" class="form-control form-control-sm"
                                    value="{{ $center->phone }}" placeholder="Phone">
                            </div>
                            <div class="col-md-5">
                                <div class="btn-group d-flex align-items-center gap-2" role="group">
                                    <button id="save-name-btn" class="btn btn-success btn-sm mr-2">
                                        <i class="fas fa-check"></i> Save
                                    </button>
                                    <button id="cancel-edit-btn" class="btn btn-danger btn-sm">
                                        <i class="fas fa-times"></i> Cancel
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            @endif

        </div>
    </div>
</div>
<section class="no-padding-top no-padding-bottom">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="icon-user-1"></i></div>
                            <strong>New Patients Today</strong>
                        </div>
                        <div id="today-count" class="number dashtext-1">0</div>
                    </div>
                    <div class="progress progress-template">
                        <div id="progress-bar" role="progressbar" style="width: 0%; transition: width 1s ease;"
                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="20"
                            class="progress-bar progress-bar-template">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="fa-solid fa-users"></i></div><strong>All Users</strong>
                        </div>
                        <div class="number dashtext-1">{{ $userCount }}</div>
                    </div>
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                            aria-valuemax="100" class="progress-bar progress-bar-template dashbg-1"></div>
                    </div>
                </div>
            </div>


            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="fa-solid fa-handshake"></i></div><strong>Partners</strong>
                        </div>
                        <div class="number dashtext-1">{{ $PartCount }}</div>
                    </div>
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                            aria-valuemax="100" class="progress-bar progress-bar-template dashbg-1"></div>
                    </div>
                </div>
            </div>


            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="fa-solid fa-receipt"></i></div><strong>All Invoices</strong>
                        </div>
                        <div class="number dashtext-1">{{ $billCount }}</div>
                    </div>
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                            aria-valuemax="100" class="progress-bar progress-bar-template dashbg-1"></div>
                    </div>
                </div>
            </div>


            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="fa-solid fa-hospital-user"></i></div>
                            <strong>Total Patients</strong>
                        </div>
                        <div id="today-count" class="number dashtext-3">{{ $patCount }}</div>
                    </div>
                    <div class="progress progress-template">
                        <div id="progress-bar" role="progressbar" style="width: 100%; transition: width 1s ease;"
                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                            class="progress-bar progress-bar-template dashbg-3">
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="fa-solid fa-user-tie"></i></div><strong>Employees</strong>
                        </div>
                        <div class="number dashtext-3">{{ $employeeCount }}</div>
                    </div>
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                            aria-valuemax="100" class="progress-bar progress-bar-template dashbg-3"></div>
                    </div>
                </div>
            </div>




            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="fas fa-hand-holding-usd"></i></div><strong>Total donations</strong>
                        </div>
                        <div class="h5 text-bold dashtext-3">{{ number_format($totalDonations, 2) }} EGP</div>
                    </div>
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: {{ $donationProgress }}%" aria-valuenow="{{ $donationProgress }}" aria-valuemin="0"
                            aria-valuemax="100" class="progress-bar progress-bar-template dashbg-3"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="fa-solid fa-file-invoice"></i></div><strong>Total Invoices</strong>
                        </div>
                        <div class="h6 text-bold dashtext-3">{{ number_format($totalBills, 2) }} EGP</div>
                    </div>
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: {{ $billProgress }}%" aria-valuenow="{{ $billProgress }}" aria-valuemin="0"
                            aria-valuemax="100" class="progress-bar progress-bar-template dashbg-3"></div>
                    </div>
                </div>
            </div>


            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="fa-solid fa-sitemap"></i></div><strong>All Items </strong>
                        </div>
                        <div class="number dashtext-4">{{ $itemCount }}</div>
                    </div>
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                            aria-valuemax="100" class="progress-bar progress-bar-template dashbg-4"></div>
                    </div>
                </div>
            </div>


            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="fa-solid fa-boxes-stacked"></i></div><strong>Items Quantity</strong>
                        </div>
                        <div class="number dashtext-4">{{ $totalItems }} Item</div>
                    </div>
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                            aria-valuemax="100" class="progress-bar progress-bar-template dashbg-4"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="fas fa-user-friends"></i></div><strong>All donations</strong>
                        </div>
                        <div class="number dashtext-4">{{ $donorsCount }}</div>
                    </div>
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: {{ $donationProgress }}%" aria-valuenow="{{ $donationProgress }}" aria-valuemin="0"
                            aria-valuemax="100" class="progress-bar progress-bar-template dashbg-4"></div>
                    </div>
                </div>
            </div>


            <div class="col-md-3 col-sm-6">
                <div class="statistic-block block">
                    <div class="progress-details d-flex align-items-end justify-content-between">
                        <div class="title">
                            <div class="icon"><i class="fa-solid fa-laptop-medical"></i></div><strong>Total Devices</strong>
                        </div>
                        <div class="number dashtext-4">{{ $devCount }}</div>
                    </div>
                    <div class="progress progress-template">
                        <div role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                            aria-valuemax="100" class="progress-bar progress-bar-template dashbg-4"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



<section class="no-padding-bottom mb-2 ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card my-4">
                    <div class="card-body">
                        <div class="chart-container" style="height: 400px;">
                            <canvas id="profitChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<footer class="footer">
    <div class="footer__block block no-margin-bottom">
        <div class="container-fluid text-center">
            <p class="no-margin-bottom">2025 &copy; ASM. All rights reserved.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($labels);
    const data = @json($data);

    const ctx = document.getElementById('profitChart').getContext('2d');
    const profitChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Net Profit Today',
                data: data,
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Daily Earnings Report'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>