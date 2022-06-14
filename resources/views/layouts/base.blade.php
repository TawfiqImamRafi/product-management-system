<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Page title -->
    <title>@yield('page-title', '6amtech')</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/elearning-logo.svg') }}">
    <!-- css vendors -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendors.css') }}">
    <!-- stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- external styles -->
    @stack('styles')
</head>
<body>

<!-- page wrapper area -->
<div class="page-wrapper">
    <!-- header area -->
    @include('partials.header')
    <!-- main-content page area -->
    <section class="wrapper">
        @include('partials.sidebar')
        <!-- main-content -->
        <div class="main-content">
            <div class="content">
                <!--content-->
                @yield('content')
            </div>
        </div>
    </section> <!-- footer -->
</div> <!--end page wrapper-->

<script src="{{ asset('assets/js/vendors.js') }}"></script>
@stack('scripts')
</body>
</html>
