<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Report PDF</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #fff;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header .subtitle {
            font-size: 16px;
            color: #7f8c8d;
            margin-top: 5px;
        }

        .patient-info {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
        }

        .patient-info h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
        }

        .report-content {
            margin-bottom: 40px;
            line-height: 1.8;
        }

        .report-content h3 {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .signature-section {
            margin-top: 50px;
            text-align: right;
        }

        .signature-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #2c3e50;
        }

        .signature-line {
            border-top: 1px solid #2c3e50;
            width: 300px;
            margin-left: auto;
            margin-top: 40px;
            padding-top: 5px;
            text-align: center;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        /* طباعة خاصة */
        @media print {
            body {
                padding: 0;
            }

            .header {
                margin-bottom: 20px;
            }

            .patient-info {
                background-color: transparent;
            }
        }
    </style>
</head>

<body>
    <div class="header">

        <h1>{{ $center->first_name }} {{ $center->second_name}}</h1>
        <div class="subtitle">Medical Diagnostic Center</div>
    </div>

    <div class="patient-info">
        <h3>Patient Name: {{ $patient->full_name }}</h3>
        <h3>Age: {{ $patient->age }} years</h3>
        <h3>Date: {{ $patient->created_at->format('F j, Y') }}</h3>
    </div>

    <div class="report-content">
        <h3>Medical Report</h3>
        <div>{!! nl2br(e($patient->report_details)) !!}</div>
    </div>

    <div class="signature-section">
        <div class="signature-line">
            <span class="signature-label">Doctor's Signature</span>
            <div style="margin-top: 20px; font-family: 'Times New Roman', serif;">
                {{ $patient->doctor_signature ?? '_________________________' }}
            </div>
        </div>
    </div>

    <div class="footer">
        <p>{{ $center->first_name }} {{ $center->second_name}} Medical Center &bull; {{ $center->address }} &bull; Phone: {{ $center->phone }}</p>
        <p>This is an official medical document. Unauthorized duplication is prohibited.</p>
    </div>
    <script>
        // عندما يتم تقديم النموذج، إظهار انيميشن "loading"
        document.querySelector('form').addEventListener('submit', function() {
            let btn = document.querySelector('input[type="submit"]');
            btn.classList.add('btn-loading');
        });
    </script>
</body>

</html>