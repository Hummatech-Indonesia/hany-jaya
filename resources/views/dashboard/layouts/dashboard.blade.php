<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jul 2023 01:54:29 GMT -->

<head>
    <!--  Title -->
    <title>Hany Jaya - @stack("title")</title>
    <!--  Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--  Favicon -->
    <link rel="shortcut icon" type="image/png"
        href="{{asset('favicon.png')}}" />
    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}" />

    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}" />

    <!-- --------------------------------------------------- -->
    <!-- Select2 -->
    <!-- --------------------------------------------------- -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}">
    <style>
        .form-control:focus{
            box-shadow:0 0 0 .25rem rgba(93,135,255,.25)!important
        }
        .max-w-full {
            max-width: 100%!important;
        }
        .btn-update-icon{
            color: #7e7e7e;
        }
        .btn-delete-icon{
            color: #7e7e7e;
        }
        .btn-update-icon:hover {
            background-color: #FEF5E5;
            color: #FFAE1F;
            border-color: #FEF5E5;
        }
        .btn-delete-icon:hover {
            background-color: #FEE2E2;
            color: #F87171;
            border-color: #FEE2E2;
        }
    </style>
    @yield('style')
    @stack('custom-style')
</head>

<body style="background: #fafafa">
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('favicon.ico') }}"
            alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('favicon.ico') }}"
            alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-theme="blue_theme" data-layout="vertical" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        @include('dashboard.layouts.sidebar')
        <!--  Main wrapper -->
        <div class="body-wrapper">
            @include('dashboard.layouts.header')
            @yield('content')

        </div>
    </div>

    <!--  Customizer -->

    @include('layouts.script')
    @yield('script')
    @stack('custom-script')
</body>

<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jul 2023 01:55:21 GMT -->

</html>
