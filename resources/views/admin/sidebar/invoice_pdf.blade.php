<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>فاتورة رقم {{ $invoice->id }}</title>
    <style>
        body {
            font-family: 'NotoSansArabic', 'DejaVu Sans', sans-serif;
            font-size: 5px !important;
            line-height: 1.6;
            direction: ltr;
            color: #333;
            padding: 10px;
            max-width: 800px;
            margin: 0 auto;
        }

        .invoice-box {
            border: 1px solid #e0e0e0;
            padding: 20px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .header {
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            margin-bottom: -10px !important;
        }

        .header h2 {
            margin: 0 0 5px 0;
            font-size: 16px;
            font-weight: 600;
            color: #222;
        }

        .header p {
            margin: 3px 0;
            color: #555;
        }

        .details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 15px;
            text-align: left;
        }

        .details p {
            margin: 2px 0;
            display: flex;
        }

        .details strong {
            display: inline-block;
            min-width: 100px;
            color: #444;
        }

        .amounts {
            width: 60%;
            text-align: center;
            border-top: 1px dashed #ccc;
            border-bottom: 1px dashed #ccc;
            padding: 8px 0;
        }

        .amounts p {
            margin: 5px 0;
            display: flex;
            justify-content: space-between;
        }

        .amounts strong {
            font-weight: 500;
        }

        .amounts p:last-child {
            font-weight: 600;
            color: #2e7d32;
            margin-top: 8px;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            color: #666;
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid #eee;
        }

        @media print {
            body {
                padding: 5px;
            }

            .invoice-box {
                border: none;
                box-shadow: none;
                padding: 10px;
            }
        }
    </style>

</head>

<body>
    <div class="invoice-box">
        <div class="header">
            <h2 style="font-size: 16px;">{{ $center->first_name }} {{ $center->second_name }}</h2>
            <p style="font-size: 10px;">Address Center: {{ $center->address }}</p>
            <p style="font-size: 10px;">Phone Number: {{ $center->phone }}</p>
        </div>

        <div class="details">
            <p style="font-size: 10px;"><strong>Invoice Number:</strong> {{ $invoice->id }}</p>
            <p style="font-size: 10px;"><strong>Date of purchase:</strong> {{ $invoice->created_at->format('Y-m-d') }}</p>
            <p style="font-size: 10px;"><strong>Added by user:</strong> {{ $invoice->id_user }}</p>
            <p style="font-size: 10px;"><strong>Item Name:</strong> {{ $invoice->name }}</p>
            <p style="font-size: 10px;"><strong>Type:</strong> {{ $invoice->type }}</p>
            <p style="font-size: 10px;"><strong>Quantity:</strong> {{ $invoice->required_quantity }}</p>
            <p style="font-size: 10px;"><strong>Category:</strong> {{ $invoice->category }}</p>
            <p style="font-size: 10px;"><strong>Supplier:</strong> {{ $invoice->supplier }}</p>
            <p style="font-size: 10px;"><strong>Expiration Date:</strong> {{ $invoice->expiration_date }}</p>
            <p style="font-size: 10px;"><strong>Comments:</strong> {{ $invoice->comments_bill }}</p>
        </div>

        <div class="amounts">
            <p style="font-size: 10px;"><strong>Price:</strong> {{ number_format($invoice->price, 2) }} EGP</p>
            <p style="font-size: 10px;"><strong>Discount:</strong> {{ $invoice->discount }}%</p>
            <p style="font-size: 10px;"><strong>Total:</strong> {{ number_format($total, 2) }} EGP</p>
        </div>

        <div class="footer">
            <strong class="text-dark">Address Center:</strong> {{ $center->address }}
        </div>
    </div>
</body>

</html>