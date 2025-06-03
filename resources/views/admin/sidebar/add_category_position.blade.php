<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @include('admin.css')

    <style>
        .page-content {
            width: 100%;
            height: auto;
        }
        .card {
            background-color: #f8f9fa;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin: 20px auto;
            max-width: 800px;
            border: none;
        }

        .card h1 {
            color: #495057;
            font-size: 3.5rem !important;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #6c757d;
            font-size: 1.1rem;
            font-weight: 500;
            width: 100% !important;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            background-color: #fff;
        }

        .form-group input:focus {
            border-color: #a0d2eb;
            box-shadow: 0 0 0 3px rgba(160, 210, 235, 0.3);
            outline: none;
        }

        .btn-submit {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            border: none;
        }

        .btn-primary {
            background-color: #4e73df;
            color: white;
        }

        .btn-primary:hover {
            background-color: #3d64d4;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        }

        #loader2 {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
            display: none;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 768px) {
            .card {
                padding: 20px;
                margin: 15px;
            }

            .btn-submit {
                flex-direction: column;
                gap: 10px;
            }

            .btn {
                width: 100%;
            }
        }
    </style>

</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <div class="page-content">
        <div class="page-content">
            <div class="page-header">
                <div class="container-fluid">
                    <h1>Add examination categories</h1>
                    <div class="card">
                        <div class="loader" id="loader2"></div>

                        <form method="POST" action="{{ url('add_category_position') }}">
                        @csrf

                            <div class="form-group">
                                <label>Add examination categories</label>
                                <input type="text" name="name" placeholder="Enter Category Positions" required>
                            </div>
                            <div class="btn-submit">
                                <input class="btn btn-primary" type="submit" value="Add Position">
                                <a class="btn btn-secondary back" href="{{url('/view_category')}}">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- JavaScript files-->
        @include('admin.js')

        <script>
            document.getElementById('addCategoryPositionsForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);
                const loader = document.getElementById('loader2');
                const url = "{{ url('add_category_position') }}";

                loader.style.display = 'block';

             

                        if (data.status === 'success') {
                            swal("Success!", "New position category added!", "success");
                            setTimeout(() => {
                                window.location.href = "{{ url('/view_category') }}";
                            }, 1000);
                        } else {
                            swal("Error!", data.message || "Error while adding", "error");
                        }
                    })
                    .catch(() => {
                        loader.style.display = 'none';
                        swal("Error!", "Connection error", "error");
                    });
        </script>




    </div>
</body>

</html>