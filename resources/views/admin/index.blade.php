<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
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

                @if($permissions->admin_dashboard)
                @include('admin.body')
                @else
                <h2 class="text-danger text-center">! لا تملك صلاحيات للدخول لهذه الصفحة</h2>
                @endif


            </div>
        </div>
        <!-- JavaScript files-->
        @include('admin.js')
    </div>
</body>

</html>