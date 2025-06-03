<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- CSS -->
    @include('admin.css')
    @include('admin.css_profile')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')
    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        <div class="text-center mb-6">
                <a href="{{ url('/profile_user') }}" class="back-btn">
                    رجوع
                </a>
            </div>
    </div>
    </div>

    @include('admin.js')
</body>
</html>