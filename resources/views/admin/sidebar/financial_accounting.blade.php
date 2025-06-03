<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    <style>
        .card {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .stat {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            font-size: 18px;
        }

        .profit {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .profit.green {
            background: #e0f9e0;
            color: green;
        }

        .profit.red {
            background: #ffe0e0;
            color: red;
        }
    </style>

    <style>
        .card {
            background-color: #f9f9f9;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin: auto;
            font-family: 'Cairo', sans-serif;
            text-align: center;
        }

        .card h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .stat {
            display: flex;
            justify-content: space-between;
            background-color: #fff;
            padding: 10px 15px;
            margin: 8px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 18px;
            color: #444;
        }

        .profit {
            padding: 12px;
            margin-top: 15px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 20px;
        }

        .profit.green {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .profit.red {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }


        #refresh-btn {
            display: flex;
            margin: auto;
        }


        #spinner {
            margin-top: 15px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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

                @if($permissions->financial_accounting)
                @if($data)
                <div class="card">
                    <h2>الحسابات المالية</h2>
                    <div class="stat">
                        <span>إجمالي المدخلات:</span>
                        <span>{{ number_format($data->inputs, 2) }} جنيه</span>
                    </div>
                    <div class="stat">
                        <span>إجمالي المخرجات:</span>
                        <span>{{ number_format($data->outputs, 2) }} جنيه</span>
                    </div>
                    @php
                    $profit = $data->gross_profit;
                    $isProfit = $profit >= 0;
                    @endphp
                    <div class="profit {{ $isProfit ? 'green' : 'red' }}">
                        الربح: {{ number_format($profit, 2) }} جنيه
                    </div>
                </div>
                @else
                <div class="alert alert-warning text-center">
                    لا توجد بيانات مالية متاحة حاليًا.
                </div>
                @endif



                <button id="refresh-btn" class="btn btn-lg btn-success ">تحديث الآن</button>

                <div id="spinner" style="display:none; text-align: center;">
                    <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_usmfx6bp.json" background="transparent" speed="1" style="width: 100px; height: 100px; margin: auto;" loop autoplay></lottie-player>
                    <p>جاري التحديث...</p>
                </div>


                <h3 style="text-align:center; margin-top: 40px;">إحصائيات بيانية</h3>
                <canvas id="financialChart" width="600" height="300" style="display:block; margin: auto;"></canvas>


            </div>
        </div>
        <!-- JavaScript files-->
        @include('admin.js')
    </div>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <script>
    function updateFinancialView(data) {
        if (!data) {
            console.error('No data provided to updateFinancialView');
            return;
        }

        // تنسيق العرض بالعملة
        const formatCurrency = (value) => {
            const num = Number(value) || 0;
            return num.toLocaleString('eg-EG', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        };

        // تحديث العناصر مع التحقق من وجودها
        try {
            // إجمالي المدخلات
            const inputsEl = document.querySelector(".stat:nth-child(2) span:last-child");
            if (inputsEl) inputsEl.innerText = formatCurrency(data.inputs) + ' جنيه';

            // إجمالي المخرجات
            const outputsEl = document.querySelector(".stat:nth-child(3) span:last-child");
            if (outputsEl) outputsEl.innerText = formatCurrency(data.outputs) + ' جنيه';

            // الربح
            const profit = Number(data.gross_profit) || 0;
            const profitText = 'الربح: ' + formatCurrency(data.gross_profit) + ' جنيه';

            const profitDiv = document.querySelector(".profit");
            if (profitDiv) {
                profitDiv.innerText = profitText;
                profitDiv.className = 'profit ' + (profit >= 0 ? 'green' : 'red');
            }

            // تحديث الرسم البياني
            updateChart(data);
        } catch (e) {
            console.error('Error in updateFinancialView:', e);
        }
    }

    function updateChart(data) {
        const canvas = document.getElementById('financialChart');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        const labels = ['المدخلات', 'المخرجات', 'الربح'];
        const values = [data.inputs, data.outputs, data.gross_profit];

        const max = Math.max(...values.map(Math.abs), 1); // تجنب القسمة على صفر
        const barWidth = 100;
        const spacing = 60;
        const baseLine = 250;

        values.forEach((value, i) => {
            const barHeight = (Math.abs(value) / max) * 200;
            const yPos = value >= 0 ? baseLine - barHeight : baseLine;

            ctx.fillStyle = i === 2 ? (value >= 0 ? 'green' : 'red') : ['#2196f3', '#f44336'][i];
            ctx.fillRect(i * (barWidth + spacing) + 50, yPos, barWidth, barHeight);

            ctx.fillStyle = '#000';
            ctx.textAlign = 'center';
            ctx.font = '16px Arial';
            ctx.fillText(labels[i], i * (barWidth + spacing) + 50 + barWidth / 2, baseLine + 20);
            ctx.fillText(formatCurrency(value) + ' ج', i * (barWidth + spacing) + 50 + barWidth / 2, yPos - 10);
        });

        // خط الأساس
        ctx.beginPath();
        ctx.moveTo(0, baseLine);
        ctx.lineTo(canvas.width, baseLine);
        ctx.strokeStyle = '#999';
        ctx.stroke();
    }

    function formatCurrency(value) {
        return Number(value || 0).toLocaleString('eg-EG', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function fetchData(event) {
        if (event) event.preventDefault(); // منع السلوك الافتراضي
        
        const refreshBtn = document.getElementById("refresh-btn");
        const spinner = document.getElementById("spinner");
        
        if (refreshBtn) refreshBtn.style.display = 'none';
        if (spinner) spinner.style.display = 'block';

        fetch("{{ route('financial.refresh') }}", {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            updateFinancialView(data);
            toastr.success("تم تحديث البيانات بنجاح");
        })
        .catch(error => {
            console.error('Error details:', error);
            toastr.error(error.message || "حدث خطأ أثناء تحميل البيانات");
        })
        .finally(() => {
            if (refreshBtn) refreshBtn.style.display = 'block';
            if (spinner) spinner.style.display = 'none';
        });
    }

    // تهيئة الأحداث بعد تحميل الصفحة
    document.addEventListener('DOMContentLoaded', function() {
        const refreshBtn = document.getElementById("refresh-btn");
        if (refreshBtn) {
            refreshBtn.addEventListener("click", fetchData);
        }

        // التهيئة الأولية
        const initialData = {
            inputs: {{ $data?->inputs ?? 0 }},
            outputs: {{ $data?->outputs ?? 0 }},
            gross_profit: {{ $data?->gross_profit ?? 0 }}
        };
        updateFinancialView(initialData);
    });

    // تحديث تلقائي كل دقيقة
    setInterval(fetchData, 60000);
</script>



                @else
                <h2 class="text-danger text-center">! لا تملك صلاحيات للدخول لهذه الصفحة</h2>
                @endif

</body>

</html>