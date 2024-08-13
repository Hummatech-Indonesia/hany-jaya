<aside class="left-sidebar" style="z-index: 999">
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

                @role(['admin'])
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Master</span>
                    </li>
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
                    @role('admin')
                    <li class="sidebar-item">
                        <a class="sidebar-link {{ request()->routeIs('admin.adjustments.index') ? 'active' : '' }}" href="{{ route('admin.adjustments.index') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-package"></i> <!-- Ganti ikon di sini -->
                            </span>
                            <span class="hide-menu">Penyesuaian Stok</span>
                        </a>
                    </li>
                    @endrole
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
                                <span class="hide-menu">Pembelian Produk</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.purchases.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-history"></i> <!-- Ganti ikon di sini -->
                                </span>
                                <span class="hide-menu">Riwayat Pembelian</span>
                            </a>
                        </li>
                    @endrole
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Riwayat</span>
                    </li>
                @endrole
                @role(['admin', 'cashier'])
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
                @endrole
                
                @role(['admin', 'owner'])
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Akuntansi</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('accountant.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-cash"></i>
                        </span>
                        <span class="hide-menu">Laporan Laba Rugi</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('accountant.cost') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-cash"></i>
                        </span>
                        <span class="hide-menu">Pengeluaran Lainnya</span>
                    </a>
                </li>
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
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
