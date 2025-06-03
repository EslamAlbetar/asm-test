<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @include('admin.css')

    <style>
        .dev_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 60px;
        }

        h1 {
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            margin-bottom: -20px;
        }

        input[type="text"] {
            width: 400px;
            height: 40px;
            padding: 10px;
            font-size: 17px;
        }
    </style>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">



                <h1>Update Location Name</h1>
                <div class="dev_deg">
                    <form id="updateLocationForm">
                        @csrf
                        <input type="text" name="location" value="{{$location->location_name}}">
                        <input type="submit" class="btn btn-primary" value="Update Location">
                    </form>

                </div>


            </div>
        </div>
        <!-- JavaScript files-->
        @include('admin.js')
        <script>
            document.getElementById('updateLocationForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);
                const url = "{{ url('update_location', $location->id) }}";

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            swal("تم التحديث!", "تم تحديث الموقع بنجاح!", "success");
                            setTimeout(() => {
                                window.location.href = "{{ url('/view_category') }}";
                            }, 500);
                        } else {
                            swal("خطأ!", data.message || "حدث خطأ أثناء التحديث", "error");
                        }
                    })
                    .catch(() => {
                        swal("خطأ!", "حدث خطأ في الاتصال", "error");
                    });
            });
        </script>




    </div>
</body>

</html>