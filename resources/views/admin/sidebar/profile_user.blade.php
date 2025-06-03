<!DOCTYPE html>
<html>

<head>
    @include('admin.css')
    <style>
/* الحاوية العامة */
.button-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 70vh; /* منتصف الصفحة */
    background-color: #f9fafb; /* لون خلفية فاتح */
}

/* الأزرار */
.custom-button {
    display: block;
    width: 300px;
    padding: 18px 30px;
    margin: 12px 0;
    text-align: center;
    font-size: 1.2rem;
    font-weight: bold;
    color: #ffffff;
    background-color: #4f46e5; /* بنفسجي فاتح */
    border-radius: 12px;
    text-decoration: none;
    transition: background-color 0.3s, transform 0.2s;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.custom-button:hover {
    background-color: #4338ca;
    transform: translateY(-2px);
}

a {
    text-decoration: none !important;
    &:hover {
        color: white !important;
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

            @if($permissions->profile_user)

                <div class="button-container">
                    <a href="/profile" class="custom-button">تعديل المعلومات الشخصية</a>
                    @if($permissions->vacation)
                    <a href="/vacation" class="custom-button">الإجازات</a>
                    @endif
                    @if($permissions->permission)
                    <a href="/permission" class="custom-button">الأذونات</a>
                    @endif
                    @if($permissions->deduction)
                    <a href="/deduction" class="custom-button">الخصومات</a>
                    @endif
                </div>


            </div>
        </div>
        <!-- JavaScript files-->
        @include('admin.js')
    </div>
    @else
    <h2 class="text-danger text-center">! لا تملك صلاحيات للدخول لهذه الصفحة</h2>
    @endif
</body>

</html>