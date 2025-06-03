<!DOCTYPE html>
<html>

<head>
    @include('admin.css')

    <style>
        .receipt {
            width: 320px;
            background: #ffffff;
            border: 1px solid #dee2e6;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transition: 0.3s ease-in-out;
            height: auto;
        }

        .receipt:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .shop-name {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
            color: #0d6efd;
        }

        .info {
            text-align: center;
            font-size: 0.9rem;
            margin-bottom: 20px;
            color: #6c757d;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .receipt table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 0.88rem;
        }

        .receipt table thead {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .receipt table th,
        .receipt table td {
            padding: 8px;
            border-bottom: 1px solid #e9ecef;
            text-align: center;
        }

        .receipt table th {
            color: #495057;
        }

        .receipt table td {
            color: #212529;
        }

        .total {
            display: flex;
            justify-content: space-between;
            font-size: 1rem;
            font-weight: bold;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 2px dashed #adb5bd;
            color: #198754;
        }

        .thanks {
            font-size: 0.9rem;
            text-align: center;
            margin-top: 10px;
            color: #6c757d;
            font-style: italic;
        }

        .cards_box {
            display: flex;
            justify-content: center;
            align-items: start;
            flex-direction: row;
            flex-wrap: wrap;
            margin: 0 10px;
            gap: 30px;
        }

        .receipt .btn {
            display: block;
            width: 100%;
            margin-top: 10px;
            font-size: 0.9rem;
            padding: 6px 12px;
            border-radius: 6px;
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

                @if($permissions->bills_admin)
                <!-- زر الإضافة -->
                <div class="text-center">
                    <a href="{{url('add_new_bill')}}" class="btn btn-primary mb-4 px-5 py-3 rounded">Add New Bill</a>
                </div>

                @if($newbills->isEmpty())
                <h1 class="text-center text-danger">No new Bills</h1>
                @endif

                <div class="cards_box">

                    @foreach ($newbills as $newbills)
                    <div class="receipt">
                        <p class="shop-name">Invoice Center</p>
                        <p class="info">
                            <span>Added by User: {{$newbills->id_user}}</span>
                            <span>Date: {{ \Carbon\Carbon::parse($newbills->created_at)->format('Y-m-d') }}</span>
                            <span>Time: {{ \Carbon\Carbon::parse($newbills->created_at)->format('H:i A') }}</span>
                        </p>

                        <table>
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$newbills->bill_name}}</td>
                                    <td class="text-success">{{$newbills->bill_type}}</td>
                                    <td class="text-danger">{{$newbills->required_qty}}</td>
                                </tr>

                            </tbody>
                        </table>
                        <p class="thanks">{{$newbills->comments_bill}}</p>

                        <div class="total">
                            <p>Total:</p>
                            <p class="text-success">
                                {{ number_format($newbills->required_qty * $newbills->price_bill, 2) }} EGP
                            </p>
                        </div>

                        <div><a class="btn btn-primary " href="{{ url('continue_bill', $newbills->id) }}">Continue</a></div>

                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        <!-- JavaScript files-->
        @include('admin.js')
    </div>
    @else
    <div class="no-data">
        <p style="margin: 0; font-size: 18px;">لا تملك صلاحية الوصول للصفحة</p>
    </div>
    @endif
</body>

</html>