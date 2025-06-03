<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    <style>
        /* التصميم العام */


        .invoices-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        /* بطاقة الفاتورة */
        .invoice-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            border-top: 4px solid #4f46e5;
            position: relative;
        }

        .invoice-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .invoice-header {
            padding: 15px;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .invoice-id {
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
        }

        .invoice-status {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-paid {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background-color: #fef9c3;
            color: #854d0e;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .invoice-body {
            padding: 15px;
        }

        .invoice-client {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 10px;
            text-align: center;
        }

        .invoice-details {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 15px;
        }

        .invoice-detail {
            display: flex;
            justify-content: space-between;
        }

        .detail-label {
            font-size: 13px;
            color: #64748b;
        }

        .detail-value {
            font-size: 13px;
            font-weight: 500;
            color: #1e293b;

        }

        .invoice-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-top: 1px dashed #e2e8f0;
            margin-top: 10px;
        }

        .total-label {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        .total-amount {
            font-size: 18px;
            font-weight: 700;
            color: #4f46e5;
        }

        .invoice-actions {
            display: flex;
            border-top: 1px solid #f1f5f9;
            padding: 10px 15px;
            gap: 10px;
        }

        .action-btn {
            flex: 1;
            padding: 8px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .view-btn {
            background-color: #e0e7ff;
            color: #4f46e5;
            border: 1px solid #c7d2fe;
        }

        .view-btn:hover {
            background-color: #c7d2fe;
            text-decoration: none;
        }

        .print-btn {
            background-color: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }

        .print-btn:hover {
            background-color: #e2e8f0;
            text-decoration: none;
        }

        .invoice-date {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 12px;
            color: #94a3b8;
        }

        /* تأثيرات للهواتف */
        @media (max-width: 768px) {
            .invoices-container {
                grid-template-columns: 1fr;
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

                @if($permissions->all_bills)

                @if($data->isEmpty())
                <h1 class="text-center text-danger">لا توجد فواتير محفوظة</h1>
                @endif
                <div class="invoices-container">
                    @foreach($data as $data)
                    <!-- بطاقة الفاتورة - يمكن تكرارها لكل فاتورة -->
                    <div class="invoice-card">
                        <span class="invoice-date">{{ $data->created_at->format('Y-m-d') }}</span>
                        <div class="invoice-header">
                            <div class="invoice-id">{{ $data->id_user }}</div>
                            <div class="invoice-status status-{{ $data->status }}">
                                {{ ucfirst($data->status) }}
                            </div>
                        </div>
                        <div class="invoice-body">
                            <div class="invoice-client">{{ $data->name }}</div>
                            <div class="invoice-details">
                                <div class="invoice-detail">
                                    <span class="detail-value">{{ $data->type }}</span>
                                    <span class="detail-label">: نوع الفاتورة</span>
                                </div>
                                <div class="invoice-detail">
                                    <span class="detail-value">{{ $data->required_quantity }}</span>
                                    <span class="detail-label">: الكمية المطلوبة</span>
                                </div>
                                <div class="invoice-detail">
                                    <span class="detail-value">{{ $data->category }}</span>
                                    <span class="detail-label">: الفئة </span>
                                </div>
                                <div class="invoice-detail">
                                    <span class="detail-value">{{ $data->supplier }}</span>
                                    <span class="detail-label">: المورد</span>
                                </div>
                                <div class="invoice-detail">
                                    <span class="detail-value">{{ $data->price }} EGP</span>
                                    <span class="detail-label">: السعر</span>
                                </div>
                                <div class="invoice-detail">
                                    <span class="detail-value">{{ $data->discount }}%</span>
                                    <span class="detail-label">: الخصم</span>
                                </div>
                                <div class="invoice-detail">
                                    <span class="detail-value">{{ $data->expiration_date }}</span>
                                    <span class="detail-label">: تاريخ الانتهاء</span>
                                </div>
                            </div>


                            <div class="invoice-total">
                                <span class="total-label">Total :</span>
                                <span class="total-amount text-success">
                                    @php
                                    $price = is_numeric($data->price) ? (float)$data->price : 0;
                                    $discount = is_numeric($data->discount) ? (float)$data->discount : 0;
                                    $total = $price - ($price * ($discount / 100));
                                    echo number_format($total, 2) . ' EGP';
                                    @endphp
                                </span>
                            </div>


                        </div>
                        <div class="invoice-actions">
                            <a href="{{ url('update_invoice/'.$data->id) }}" class="action-btn view-btn">
                                <i class="fas fa-eye"></i> تعديل
                            </a>
                            <a href="{{ route('invoice.print', $data->id) }}" class="action-btn print-btn">
                                <i class="fas fa-print"></i> طباعة
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- JavaScript files-->
        @include('admin.js')
        <!-- Font Awesome للأيقونات -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </div>

    @else
    <div class="no-data">
        <p style="margin: 0; font-size: 18px;">لا تملك صلاحية الوصول للصفحة</p>
    </div>
    @endif
</body>

</html>