<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jul 2023 01:54:29 GMT -->

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
    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}" />

    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}" />

    <!-- --------------------------------------------------- -->
    <!-- Select2 -->
    <!-- --------------------------------------------------- -->
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}" />
    @yield('style')
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico"
            alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
        <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico"
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

    <!--  Mobilenavbar -->
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="mobilenavbar"
        aria-labelledby="offcanvasWithBothOptionsLabel">
        <nav class="sidebar-nav scroll-sidebar">
            <div class="offcanvas-header justify-content-between">
                <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/logos/favicon.ico"
                    alt="" class="img-fluid" />
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body profile-dropdown mobile-navbar" data-simplebar="" data-simplebar>
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Menu</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}"
                            aria-expanded="false">
                            <span>
                                <i class="ti ti-home"></i> <!-- Ganti ikon di sini -->
                            </span>
                            <span class="hide-menu">Beranda</span>
                        </a>
                    </li>
    
                    @role(['admin', 'owner'])
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Master</span>
                        </li>
                        @role('owner')
                            <li class="sidebar-item">
                                <a class="sidebar-link {{ request()->routeIs('admin.cashiers.admin') ? 'active' : '' }}"
                                    href="{{ route('admin.cashiers.admin') }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-user"></i> <!-- Ganti ikon di sini -->
                                    </span>
                                    <span class="hide-menu">Data Admin</span>
                                </a>
                            </li>
                        @endrole
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.cashiers.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-wallet"></i> <!-- Ganti ikon di sini -->
                                </span>
                                <span class="hide-menu">Data Kasir</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.categories.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-list"></i> <!-- Ganti ikon di sini -->
                                </span>
                                <span class="hide-menu">Kategori</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.units.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-ruler"></i> <!-- Ganti ikon di sini -->
                                </span>
                                <span class="hide-menu">Satuan</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.products.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-package"></i> <!-- Ganti ikon di sini -->
                                </span>
                                <span class="hide-menu">Produk</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.suppliers.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-truck"></i> <!-- Ganti ikon di sini -->
                                </span>
                                <span class="hide-menu">Pemasok</span>
                            </a>
                        </li>
                        <!-- ============================= -->
                        <!-- Apps -->
                        <!-- ============================= -->
                        @role('admin')
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Transaksi</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('admin.purchases.create') }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-shopping-cart"></i> <!-- Ganti ikon di sini -->
                                    </span>
                                    <span class="hide-menu">Pembelian</span>
                                </a>
                            </li>
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Kasir</span>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('cashier.index') }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-shopping-cart"></i> <!-- Ganti ikon di sini -->
                                    </span>
                                    <span class="hide-menu">Pindah Akun Kasir</span>
                                </a>
                            </li>
                        @endrole
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Riwayat</span>
                        </li>
                    @endrole
                    @role(['owner', 'admin'])
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.purchases.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-history"></i> <!-- Ganti ikon di sini -->
                                </span>
                                <span class="hide-menu">Riwayat Pembelian</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.selling.history') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-chart-line"></i> <!-- Ganti ikon di sini -->
                                </span>
                                <span class="hide-menu">Riwayat Penjualan</span>
                            </a>
                        </li>
                    @endrole
                </ul>
            </div>
        </nav>
    </div>


    <!--  Customizer -->

    @include('layouts.script')
    @yield('script')
</body>

<!-- Mirrored from demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/html/main/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 06 Jul 2023 01:55:21 GMT -->

</html>
