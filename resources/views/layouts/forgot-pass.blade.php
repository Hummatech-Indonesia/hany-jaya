<!DOCTYPE html>
<html lang="en">
    <head>
        <!--  Title -->
        <title>Hany Jaya</title>
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
        <!-- Core Css -->
        <link
            id="themeColors"
            rel="stylesheet"
            href="{{ asset('assets/css/style.min.css') }}"
        />
    </head>
    <body>
        <!-- Preloader -->
        <div class="preloader">
            <img
                src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico"
                alt="loader"
                class="lds-ripple img-fluid"
            />
        </div>
        <!-- Preloader -->
        <div class="preloader">
            <img
                src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico"
                alt="loader"
                class="lds-ripple img-fluid"
            />
        </div>
        <!--  Body Wrapper -->
        <div
            class="page-wrapper"
            id="main-wrapper"
            data-layout="vertical"
            data-sidebartype="full"
            data-sidebar-position="fixed"
            data-header-position="fixed"
        >
            @yield('content')
        </div>

        <!--  Import Js Files -->
        <script src="{{
                asset('assets/libs/jquery/dist/jquery.min.js')
            }}"></script>
        <script src="{{
                asset('assets/libs/simplebar/dist/simplebar.min.js')
            }}"></script>
        <script src="{{
                asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')
            }}"></script>
        <!--  core files -->
        <script src="{{ asset('assets/js/app.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.init.js') }}"></script>
        <script src="{{ asset('assets/js/app-style-switcher.js') }}"></script>
        <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>

        <script src="{{ asset('assets/js/custom.js') }}"></script>
    </body>

    <!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/authentication-login2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jul 2023 02:01:04 GMT -->
</html>
