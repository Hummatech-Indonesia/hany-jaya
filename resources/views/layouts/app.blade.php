<!DOCTYPE html>
<html lang="en">
    <!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/authentication-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jul 2023 02:01:04 GMT -->

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
            <div
                class="position-relative overflow-hidden radial-gradient min-vh-100"
            >
                <div class="position-relative z-index-5">
                    <div class="row">
                        <div class="col-xl-7 col-xxl-8">
                            <a
                                href="/"
                                class="text-nowrap logo-img d-block px-4 py-9 w-100"
                            >
                                <img
                                    src="{{asset('logo.png')}}"
                                    width="180"
                                    alt=""
                                />
                            </a>
                            <div
                                class="d-none d-xl-flex align-items-center justify-content-center"
                                style="height: calc(100vh - 80px)"
                            >
                                <img
                                    src="{{
                                        asset(
                                            'assets/images/illustration/cashier.png'
                                        )
                                    }}"
                                    alt=""
                                    class="img-fluid"
                                    width="500"
                                />
                            </div>
                        </div>
                        <div class="col-xl-5 col-xxl-4">@yield('content')</div>
                    </div>
                </div>
            </div>
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
        @yield('script')
    </body>

    <!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/authentication-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jul 2023 02:01:04 GMT -->
</html>
