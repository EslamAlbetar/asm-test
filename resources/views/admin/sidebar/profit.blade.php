<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* التصميم العام */
        .page-content {
            padding: 20px;
            width: 100%;
        }

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

    <style>
        .resources-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .resource-card {
            width: 30%;
            min-width: 280px;
            background-color: #f5f8ff;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            position: relative;
        }

        /* تصميم الزر المعدل */
        .pdf-export-container {
            display: flex;
            justify-content: flex-start;
            /* المحاذاة لليسار */
            margin: 15px 0;
        }

        .pdf-export-btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 25px;
            background: linear-gradient(135deg, #4a6fdc 0%, #2a4cb2 100%);
            color: white !important;
            border-radius: 30px;
            text-decoration: none !important;
            font-weight: 500;
            font-size: 14px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(74, 111, 220, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            min-width: 180px;
            justify-content: center;
            /* النص في المنتصف */
        }

        .pdf-export-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(74, 111, 220, 0.4);
            background: linear-gradient(135deg, #2a4cb2 0%, #4a6fdc 100%);
        }

        .pdf-export-btn:active {
            transform: translateY(1px);
        }

        .pdf-export-btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .pdf-export-btn:hover::before {
            left: 100%;
        }

        .pdf-export-btn i {
            margin-right: 10px;
            font-size: 16px;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-3px);
            }

            40%,
            80% {
                transform: translateX(3px);
            }
        }

        .pdf-export-btn:active {
            animation: shake 0.4s ease;
        }

        #selectedYearContainer {
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        #printYearlyReportBtn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>

    <style>
        .chart-controls {
            display: flex;
            gap: 8px;
            margin-bottom: 15px;
        }

        .toggle-btn {
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .toggle-btn.active {
            font-weight: bold;
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .toggle-btn[data-type="monthly"].active {
            background-color: rgba(54, 162, 235, 0.2);
            border-color: rgba(54, 162, 235, 1);
        }

        .toggle-btn[data-type="daily"].active {
            background-color: rgba(75, 192, 192, 0.2);
            border-color: rgba(75, 192, 192, 1);
        }

        .toggle-btn[data-type="yearly"].active {
            background-color: rgba(153, 102, 255, 0.2);
            border-color: rgba(153, 102, 255, 1);
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

                @if($permissions->profit)
                <!-- فلاتر السنة والشهر -->
                <div class="container mt-4">
                    <div class="filters-container mb-4">
                        <select id="yearFilter" class="form-control d-inline-block w-auto"></select>
                        <select id="monthFilter" class="form-control d-inline-block w-auto ml-2" disabled></select>
                        <button id="filterBtn" class="btn btn-primary ml-2">تطبيق الفلتر الشهري</button>
                        <button id="resetFilterBtn" class="btn btn-outline-secondary">عرض آخر شهر</button>
                    </div>

                    <!-- زر طباعة التقرير السنوي (سيظهر عند اختيار سنة) -->
                    <div id="yearlyReportBtnContainer" class="text-center mb-4" style="display: none;">
                        <a id="printYearlyReportBtn" href="#" class="btn btn-success btn-lg">
                            <i class="fas fa-file-pdf"></i> طباعة تقرير سنوي للسنة <span id="selectedYear"></span>
                        </a>
                    </div>

                    <div id="monthsContainer"></div>

                    <div class="card my-4">
                        <div class="card-body">
                            <div class="chart-container" style="height: 400px;">
                                <canvas id="profitChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- JavaScript files-->
                @include('admin.js')


                <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

                <!-- تحميل مكتبة Chart.js -->
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    let profitChart;

                    function loadYearsAndMonths() {
    axios.get('{{ route("profit.years_months") }}').then(res => {
        const years = {};
        res.data.forEach(d => {
            years[d.year] = years[d.year] || [];
            years[d.year].push(d.month);
        });

        const yearSelect = document.getElementById("yearFilter");
        const monthSelect = document.getElementById("monthFilter");

        yearSelect.innerHTML = '<option value="">اختر السنة</option>';
        for (let y in years) {
            yearSelect.innerHTML += `<option value="${y}">${y}</option>`;
        }

        const allYears = Object.keys(years).sort((a, b) => b - a); // ترتيب تنازلي
        const latestYear = allYears[0];
        const latestMonths = years[latestYear].sort((a, b) => b - a); // ترتيب تنازلي
        const latestMonth = latestMonths[0];

        yearSelect.value = latestYear;

        monthSelect.innerHTML = '<option value="">اختر الشهر</option>';
        latestMonths.forEach(m => {
            monthSelect.innerHTML += `<option value="${m}">${m}</option>`;
        });
        monthSelect.disabled = false;
        monthSelect.value = latestMonth;

        // زر التقرير السنوي
        document.getElementById('yearlyReportBtnContainer').style.display = 'block';
        document.getElementById('selectedYear').textContent = latestYear;
        document.getElementById('printYearlyReportBtn').href = `/export/yearly/pdf?year=${latestYear}`;

        // ✅ تحميل البيانات تلقائياً لآخر شهر
        fetchProfit(latestYear, latestMonth);

        // عند تغيير السنة
        yearSelect.onchange = () => {
            monthSelect.innerHTML = '<option value="">اختر الشهر</option>';
            if (yearSelect.value && years[yearSelect.value]) {
                monthSelect.disabled = false;
                years[yearSelect.value].forEach(m => {
                    monthSelect.innerHTML += `<option value="${m}">${m}</option>`;
                });

                document.getElementById('yearlyReportBtnContainer').style.display = 'block';
                document.getElementById('selectedYear').textContent = yearSelect.value;
                document.getElementById('printYearlyReportBtn').href = `/export/yearly/pdf?year=${yearSelect.value}`;
            } else {
                monthSelect.disabled = true;
                document.getElementById('yearlyReportBtnContainer').style.display = 'none';
            }
        };
    });
}

                    function renderChart(data) {
                        const labels = data.days.map(d => d.date);
                        const values = data.days.map(d => d.net_profit);

                        if (profitChart) profitChart.destroy();

                        const ctx = document.getElementById("profitChart").getContext("2d");
                        profitChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: "صافي الربح اليومي",
                                    data: values,
                                    borderColor: "#28a745",
                                    backgroundColor: "rgba(40, 167, 69, 0.2)",
                                    tension: 0.3
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }

                    function renderData(data) {
                        let html = `
                    <div class="resources-container d-flex flex-wrap justify-content-center gap-4">
                        <div class="resource-card blue">
                            <div class="resource-header">
                                <div class="resource-title">${data.month} ${data.year}</div>
                                <div class="resource-count">${data.days_count} يوم</div>
                                <div class="count-money text-${data.net_profit >= 0 ? 'success' : 'danger'}">
                                    ${Number(data.net_profit).toFixed(2)} EGP
                                </div>
                            </div>

                            <div class="resource-body">
                                <div class="items">
                                    <h6 class="item-name">PDF</h6>
                                    <h6 class="item-name">(الاجمالي)</h6>
                                    <h6 class="item-name">(المدفوعات)</h6>
                                    <h6 class="item-name">(المدخلات)</h6>
                                    <h6 class="item-value">التاريخ</h6>
                                    <h6 class="item-value">اليوم</h6>
                                </div>

                                ${data.days.map(day => `
                                    <div class="resource-item" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                        <span class="item-value text-success">
                                            <a href="/export/pdf?date=${day.date}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i> PDF
                                            </a>
                                        </span>
                                        <span class="item-value text-${day.net_profit >= 0 ? 'success' : 'danger'}">
                                            ${Number(day.net_profit).toFixed(2)}
                                        </span>
                                        <span class="item-value text-danger">
                                            ${Number(day.payments).toFixed(2)}
                                        </span>
                                        <span class="item-value text-success">
                                            ${Number(day.inputs).toFixed(2)}
                                        </span>
                                        <span class="item-value text-primary">
                                            ${day.date}
                                        </span>
                                        <span class="item-name">${day.day_name}</span>
                                    </div>
                                `).join('')}
                            </div>

                            <a href="/export/monthly/pdf?month=${data.month_number}&year=${data.year}" class="view-all-btn">
                                طباعة تقرير شهري
                            </a>
                        </div>
                    </div>`;

                        document.getElementById("monthsContainer").innerHTML = html;
                        renderChart(data);
                    }

                    function fetchProfit(year = null, month = null) {
                        axios.get('{{ route("profit.fetch") }}', {
                            params: {
                                year,
                                month
                            }
                        }).then(res => {
                            renderData(res.data);
                        });
                    }

                    document.getElementById("filterBtn").onclick = () => {
                        const year = document.getElementById("yearFilter").value;
                        const month = document.getElementById("monthFilter").value;
                        fetchProfit(year, month);
                    };



                    document.getElementById("resetFilterBtn").onclick = () => {
                        fetchProfit(); // يرجع لآخر شهر
                        document.getElementById("yearFilter").value = "";
                        document.getElementById("monthFilter").innerHTML = '<option value="">اختر الشهر</option>';
                        document.getElementById("monthFilter").disabled = true;
                        document.getElementById('yearlyReportBtnContainer').style.display = 'none';
                    };

                    loadYearsAndMonths();
                </script>
                 @else
    <h2 class="text-danger text-center">! لا تملك صلاحيات للدخول لهذه الصفحة</h2>
    @endif
</body>

</html>