<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="/" class="text-nowrap logo-img">
                <img src="{{ asset('logo.png') }}" class="dark-logo" width="180" alt="" />
                <img src="{{ asset('logo.png') }}" class="light-logo" width="180" alt="" />
            </a>
            <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8 text-muted"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
                <!-- ============================= -->
                <!-- Home -->
                <!-- ============================= -->
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Menu</span>
                </li>
                <!-- =================== -->
                <!-- Dashboard -->
                <!-- =================== -->

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
                            <a class="sidebar-link {{ request()->routeIs('admin.users.admin') ? 'active' : '' }}"
                                href="{{ route('admin.users.admin') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-user"></i> <!-- Ganti ikon di sini -->
                                </span>
                                <span class="hide-menu">Data Admin</span>
                            </a>
                        </li>
                    @endrole
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.users.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-users"></i> <!-- Ganti ikon di sini -->
                            </span>
                            <span class="hide-menu">Data Pengguna</span>
                        </a>
                    </li>
                    
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.suppliers.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-truck"></i> <!-- Ganti ikon di sini -->
                            </span>
                            <span class="hide-menu">Distributor</span>
                        </a>
                    </li>

                    <!-- menu item  -->
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Katalog Produk</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-package"></i> <!-- Ganti ikon di sini -->
                            </span>
                            <span class="hide-menu">Produk</span>
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
                                <span class="hide-menu">Suplai Produk</span>
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
                @endrole
                @role(['owner', 'admin', 'cashier'])
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('admin.selling.history') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-chart-line"></i> <!-- Ganti ikon di sini -->
                            </span>
                            <span class="hide-menu">Riwayat Penjualan</span>
                        </a>
                    </li>
                    
                @endrole
                @role('cashier')
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('cashier.history.debt') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-list"></i> <!-- Ganti ikon di sini -->
                            </span>
                            <span class="hide-menu">Hutang Piutang</span>
                        </a>
                    </li>
                    {{-- <li class="sidebar-item">
                        <a class="sidebar-link" href="{{ route('cashier.history.pay.debt') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-list"></i> <!-- Ganti ikon di sini -->
                            </span>
                            <span class="hide-menu">Pembayaran Piutang</span>
                        </a>
                    </li> --}}
                @endrole

                @role('cashier')
                {{-- <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Transaksi</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('cashier.list.debt') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-list"></i> <!-- Ganti ikon di sini -->
                        </span>
                        <span class="hide-menu">Daftar Piutang</span>
                    </a>
                </li> --}}
                @endrole
                @role('cashier')
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Kasir</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" target="_blank" href="{{ route('cashier.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-shopping-cart"></i> <!-- Ganti ikon di sini -->
                        </span>
                        <span class="hide-menu">Pindah Akun Kasir</span>
                    </a>
                </li>
                @endrole
            </ul>
        </nav>
        <div class="fixed-profile p-3 bg-light-secondary rounded sidebar-ad mt-3">
            <div class="hstack gap-3">
                <div class="john-img">
                    <img src="../../dist/images/profile/user-1.jpg" class="rounded-circle" width="40"
                        height="40" alt="" />
                </div>
                <div class="john-title">
                    <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
                    <span class="fs-2 text-dark">Designer</span>
                </div>
                <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button"
                    aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
                    <i class="ti ti-power fs-6"></i>
                </button>
            </div>
        </div>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
