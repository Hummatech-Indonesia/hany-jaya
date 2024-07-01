@php
    use App\Helpers\UserHelper;

@endphp
<header class="topbar">
    <div class="with-vertical">
        <!-- Start Vertical Layout Header -->
        <nav class="navbar navbar-expand-lg p-0">
            <ul class="navbar-nav quick-links d-none d-lg-flex align-items-center">
                <!-- ------------------------------- -->
                <!-- end apps Dropdown -->
                <!-- ------------------------------- -->
                <li class="nav-item dropdown-hover d-none d-lg-block">
                    <a class="nav-link"
                        href="https://bootstrapdemos.adminmart.com/modernize/dist/horizontal/app-chat.html">
                        <i class="ti ti-message-circle"></i> Chat
                    </a>
                </li>
                <li class="nav-item dropdown-hover d-none d-lg-block">
                    <a class="nav-link"
                        href="https://bootstrapdemos.adminmart.com/modernize/dist/horizontal/app-calendar.html">
                        <i class="ti ti-calendar"></i> Calendar
                    </a>
                </li>
                <li class="nav-item dropdown-hover d-none d-lg-block">
                    <a class="nav-link"
                        href="https://bootstrapdemos.adminmart.com/modernize/dist/horizontal/app-email.html">
                        <i class="ti ti-mail"></i> Email
                    </a>
                </li>
            </ul>

            <div class="d-block d-lg-none py-4">
                <a href="#" class="text-nowrap logo-img">
                    <img src="{{ asset('logo.png') }}" class="dark-logo" alt="Logo-Dark" />
                    <img src="{{ asset('logo.png') }}" class="light-logo" alt="Logo-light" />
                </a>
            </div>
            <a class="navbar-toggler nav-icon-hover-bg rounded-circle p-0 mx-0 border-0" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="ti ti-dots fs-7"></i>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="javascript:void(0)"
                        class="nav-link nav-icon-hover-bg rounded-circle mx-0 ms-n1 d-flex d-lg-none align-items-center justify-content-center"
                        type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                        aria-controls="offcanvasWithBothOptions">
                        <i class="ti ti-align-justified fs-7"></i>
                    </a>
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                        <!-- ------------------------------- -->
                        <!-- start language Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item nav-icon-hover-bg rounded-circle">
                            <a class="nav-link moon dark-layout" href="javascript:void(0)">
                                <i class="ti ti-moon moon"></i>
                            </a>
                            <a class="nav-link sun light-layout" href="javascript:void(0)">
                                <i class="ti ti-sun sun"></i>
                            </a>
                        </li>
                        <li class="nav-item nav-icon-hover-bg rounded-circle dropdown">
                            <a class="nav-link" href="javascript:void(0)" id="drop2" aria-expanded="false">
                                <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-flag-en.svg"
                                    alt="modernize-img" width="20px" height="20px"
                                    class="rounded-circle object-fit-cover round-20" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop2">
                                <div class="message-body">
                                    <a href="javascript:void(0)"
                                        class="d-flex align-items-center gap-2 py-3 px-4 dropdown-item">
                                        <div class="position-relative">
                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-flag-en.svg"
                                                alt="modernize-img" width="20px" height="20px"
                                                class="rounded-circle object-fit-cover round-20" />
                                        </div>
                                        <p class="mb-0 fs-3">English (UK)</p>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="d-flex align-items-center gap-2 py-3 px-4 dropdown-item">
                                        <div class="position-relative">
                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-flag-cn.svg"
                                                alt="modernize-img" width="20px" height="20px"
                                                class="rounded-circle object-fit-cover round-20" />
                                        </div>
                                        <p class="mb-0 fs-3">
                                            中国人 (Chinese)
                                        </p>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="d-flex align-items-center gap-2 py-3 px-4 dropdown-item">
                                        <div class="position-relative">
                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-flag-fr.svg"
                                                alt="modernize-img" width="20px" height="20px"
                                                class="rounded-circle object-fit-cover round-20" />
                                        </div>
                                        <p class="mb-0 fs-3">
                                            fran��ais (French)
                                        </p>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="d-flex align-items-center gap-2 py-3 px-4 dropdown-item">
                                        <div class="position-relative">
                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-flag-sa.svg"
                                                alt="modernize-img" width="20px" height="20px"
                                                class="rounded-circle object-fit-cover round-20" />
                                        </div>
                                        <p class="mb-0 fs-3">عربي (Arabic)</p>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end language Dropdown -->
                        <!-- ------------------------------- -->

                        <!-- ------------------------------- -->
                        <!-- start shopping cart Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item nav-icon-hover-bg rounded-circle">
                            <a class="nav-link position-relative" href="javascript:void(0)" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                <i class="ti ti-basket"></i>
                                <span class="popup-badge rounded-pill bg-danger text-white fs-2">2</span>
                            </a>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end shopping cart Dropdown -->
                        <!-- ------------------------------- -->

                        <!-- ------------------------------- -->
                        <!-- start notification Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item nav-icon-hover-bg rounded-circle dropdown">
                            <a class="nav-link position-relative" href="javascript:void(0)" id="drop2"
                                aria-expanded="false">
                                <i class="ti ti-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop2">
                                <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                    <h5 class="mb-0 fs-5 fw-semibold">
                                        Notifications
                                    </h5>
                                    <span class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">5 new</span>
                                </div>
                                <div class="message-body" data-simplebar>
                                    <a href="javascript:void(0)"
                                        class="py-6 px-7 d-flex align-items-center dropdown-item">
                                        <span class="me-3">
                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-2.jpg"
                                                alt="user" class="rounded-circle" width="48"
                                                height="48" />
                                        </span>
                                        <div class="w-100">
                                            <h6 class="mb-1 fw-semibold lh-base">
                                                Roman Joined the Team!
                                            </h6>
                                            <span class="fs-2 d-block text-body-secondary">Congratulate him</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="py-6 px-7 d-flex align-items-center dropdown-item">
                                        <span class="me-3">
                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-3.jpg"
                                                alt="user" class="rounded-circle" width="48"
                                                height="48" />
                                        </span>
                                        <div class="w-100">
                                            <h6 class="mb-1 fw-semibold lh-base">
                                                New message
                                            </h6>
                                            <span class="fs-2 d-block text-body-secondary">Salma sent you new
                                                message</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="py-6 px-7 d-flex align-items-center dropdown-item">
                                        <span class="me-3">
                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-4.jpg"
                                                alt="user" class="rounded-circle" width="48"
                                                height="48" />
                                        </span>
                                        <div class="w-100">
                                            <h6 class="mb-1 fw-semibold lh-base">
                                                Bianca sent payment
                                            </h6>
                                            <span class="fs-2 d-block text-body-secondary">Check your earnings</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="py-6 px-7 d-flex align-items-center dropdown-item">
                                        <span class="me-3">
                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-5.jpg"
                                                alt="user" class="rounded-circle" width="48"
                                                height="48" />
                                        </span>
                                        <div class="w-100">
                                            <h6 class="mb-1 fw-semibold lh-base">
                                                Jolly completed tasks
                                            </h6>
                                            <span class="fs-2 d-block text-body-secondary">Assign her new tasks</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="py-6 px-7 d-flex align-items-center dropdown-item">
                                        <span class="me-3">
                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-6.jpg"
                                                alt="user" class="rounded-circle" width="48"
                                                height="48" />
                                        </span>
                                        <div class="w-100">
                                            <h6 class="mb-1 fw-semibold lh-base">
                                                John received payment
                                            </h6>
                                            <span class="fs-2 d-block text-body-secondary">$230 deducted from
                                                account</span>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="py-6 px-7 d-flex align-items-center dropdown-item">
                                        <span class="me-3">
                                            <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-7.jpg"
                                                alt="user" class="rounded-circle" width="48"
                                                height="48" />
                                        </span>
                                        <div class="w-100">
                                            <h6 class="mb-1 fw-semibold lh-base">
                                                Roman Joined the Team!
                                            </h6>
                                            <span class="fs-2 d-block text-body-secondary">Congratulate him</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="py-6 px-7 mb-1">
                                    <button class="btn btn-outline-primary w-100">
                                        See All Notifications
                                    </button>
                                </div>
                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end notification Dropdown -->
                        <!-- ------------------------------- -->

                        <!-- ------------------------------- -->
                        <!-- start profile Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item dropdown">
                            <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="user-profile-img">
                                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-1.jpg"
                                            class="rounded-circle" width="35" height="35"
                                            alt="modernize-img" />
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop1">
                                <div class="profile-dropdown position-relative" data-simplebar>
                                    <div class="py-3 px-7 pb-0">
                                        <h5 class="mb-0 fs-5 fw-semibold">
                                            User Profile
                                        </h5>
                                    </div>
                                    <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/profile/user-1.jpg"
                                            class="rounded-circle" width="80" height="80"
                                            alt="modernize-img" />
                                        <div class="ms-3">
                                            <h5 class="mb-1 fs-3">
                                                {{ UserHelper::getUserName() }}
                                            </h5>
                                            <span class="mb-1 d-block">{{ UserHelper::getUserRole() }}</span>
                                            <p class="mb-0 d-flex align-items-center gap-2">
                                                <i class="ti ti-mail fs-4"></i>
                                                {{ UserHelper::getUserEmail() }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="message-body">
                                        <a href="https://bootstrapdemos.adminmart.com/modernize/dist/horizontal/page-user-profile.html"
                                            class="py-8 px-7 mt-8 d-flex align-items-center">
                                            <span
                                                class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-account.svg"
                                                    alt="modernize-img" width="24" height="24" />
                                            </span>
                                            <div class="w-100 ps-3">
                                                <h6 class="mb-1 fs-3 fw-semibold lh-base">
                                                    My Profile
                                                </h6>
                                                <span class="fs-2 d-block text-body-secondary">Account Settings</span>
                                            </div>
                                        </a>
                                        <a href="https://bootstrapdemos.adminmart.com/modernize/dist/horizontal/app-email.html"
                                            class="py-8 px-7 d-flex align-items-center">
                                            <span
                                                class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-inbox.svg"
                                                    alt="modernize-img" width="24" height="24" />
                                            </span>
                                            <div class="w-100 ps-3">
                                                <h6 class="mb-1 fs-3 fw-semibold lh-base">
                                                    My Inbox
                                                </h6>
                                                <span class="fs-2 d-block text-body-secondary">Messages & Emails</span>
                                            </div>
                                        </a>
                                        <a href="https://bootstrapdemos.adminmart.com/modernize/dist/horizontal/app-notes.html"
                                            class="py-8 px-7 d-flex align-items-center">
                                            <span
                                                class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-tasks.svg"
                                                    alt="modernize-img" width="24" height="24" />
                                            </span>
                                            <div class="w-100 ps-3">
                                                <h6 class="mb-1 fs-3 fw-semibold lh-base">
                                                    My Task
                                                </h6>
                                                <span class="fs-2 d-block text-body-secondary">To-do and Daily
                                                    Tasks</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="d-grid py-4 px-7 pt-8">
                                        <div
                                            class="upgrade-plan bg-primary-subtle position-relative overflow-hidden rounded-4 p-4 mb-9">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h5 class="fs-4 mb-3 fw-semibold">
                                                        Unlimited Access
                                                    </h5>
                                                    <button class="btn btn-primary">
                                                        Upgrade
                                                    </button>
                                                </div>
                                                <div class="col-6">
                                                    <div class="m-n4 unlimited-img">
                                                        <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/backgrounds/unlimited-bg.png"
                                                            alt="modernize-img" class="w-100" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="https://bootstrapdemos.adminmart.com/modernize/dist/horizontal/authentication-login.html"
                                            class="btn btn-outline-primary">Log Out</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end profile Dropdown -->
                        <!-- ------------------------------- -->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Vertical Layout Header -->
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="mobilenavbar"
            aria-labelledby="offcanvasWithBothOptionsLabel">

        </div>
    </div>
    <div class="app-header with-horizontal">
        <nav class="navbar navbar-expand-xl container-fluid p-0">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item nav-icon-hover-bg rounded-circle d-flex d-xl-none ms-n2">
                    <a class="nav-link sidebartoggler" id="sidebarCollapse" href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-xl-block">
                    <a href="#" class="text-nowrap nav-link">
                        <img src="{{ asset('logo.png') }}" class="dark-logo" width="180" alt="modernize-img" />
                        <img src="{{ asset('logo.png') }}" class="light-logo" width="180" alt="modernize-img" />
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav quick-links d-none d-xl-flex align-items-center">
                <!-- ------------------------------- -->
                <!-- end apps Dropdown -->
                <!-- ------------------------------- -->
                <li class="nav-item dropdown-hover d-none d-lg-block">
                    <a class="nav-link {{ request()->routeIs('cashier.index') ? 'text-primary' : '' }}"
                        href="{{ route('cashier.index') }}">
                        <i class="ti ti-shopping-cart"></i> Penjualan
                    </a>
                </li>
                @role('cashier')
                    <li class="nav-item dropdown-hover d-none d-lg-block">
                        <a class="nav-link {{ request()->routeIs('cashier.selling.history') ? 'text-primary' : '' }}"
                            href="{{ route('cashier.selling.history') }}">
                            <i class="ti ti-history"></i> Riwayat
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown-hover d-none d-lg-block">
                        <a class="nav-link {{ request()->routeIs('cashier.admin.selling.history') ? 'text-primary' : '' }}"
                            href="{{ route('cashier.admin.selling.history') }}">
                            <i class="ti ti-history"></i> Riwayat
                        </a>
                    </li>
                @endrole
                <li class="nav-item dropdown-hover d-none d-lg-block">
                    <a class="nav-link {{ request()->routeIs('cashier.list.debt') ? 'text-primary' : '' }}"
                        href="{{ route('cashier.list.debt') }}">
                        <i class="ti ti-list"></i> Daftar Hutang
                    </a>
                </li>
                <li class="nav-item dropdown-hover d-none d-lg-block">
                    <a class="nav-link {{ request()->routeIs('cashier.history.debt') ? 'text-primary' : '' }}"
                        href="{{ route('cashier.history.debt') }}">
                        <i class="ti ti-book"></i> Riwayat Hutang
                    </a>
                </li>
                <li class="nav-item dropdown-hover d-none d-lg-block">
                    <a class="nav-link {{ request()->routeIs('cashier.history.pay.debt') ? 'text-primary' : '' }}"
                        href="{{ route('cashier.history.pay.debt') }}">
                        <i class="ti ti-credit-card"></i> Riwayat Pembayaran Hutang
                    </a>
                </li>
            </ul>
            <div class="d-block d-xl-none">
                <a href="#" class="text-nowrap nav-link">
                    <img src="{{ asset('logo.png') }}" width="180" alt="modernize-img" />
                </a>
            </div>
            <a class="navbar-toggler nav-icon-hover-bg rounded-circle p-0 mx-0 border-0" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="p-2">
                    <i class="ti ti-dots fs-7"></i>
                </span>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between px-0 px-xl-8">
                    <a href="javascript:void(0)"
                        class="nav-link round-40 p-1 ps-0 d-flex d-xl-none align-items-center justify-content-center"
                        type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                        aria-controls="offcanvasWithBothOptions">
                        <i class="ti ti-align-justified fs-7"></i>
                    </a>
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">

                        <!-- ------------------------------- -->
                        <!-- start profile Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item dropdown">
                            <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="user-profile-img">
                                        <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('assets/images/profile/user-1.jpg') }}"
                                            alt="photo" class="rounded-circle mb-2" style="object-fit: cover;"
                                            width="35" height="35">
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop1">
                                <div class="profile-dropdown position-relative" data-simplebar>
                                    <div class="py-3 px-7 pb-0">
                                        <h5 class="mb-0 fs-5 fw-semibold">
                                            Profil Pengguna
                                        </h5>
                                    </div>
                                    <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                        <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('assets/images/profile/user-1.jpg') }}"
                                            alt="photo" class="rounded-circle mb-2" style="object-fit: cover;"
                                            width="80" height="80">
                                        <div class="ms-3">
                                            <h5 class="mb-1 fs-3">
                                                {{ UserHelper::getUserName() }}
                                            </h5>
                                            <span class="mb-1 d-block">{{ UserHelper::getUserRole() }}</span>
                                            <p class="mb-0 d-flex align-items-center gap-2">
                                                <i class="ti ti-mail fs-4"></i>
                                                {{ UserHelper::getUserEmail() }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="message-body">
                                        <a href="{{ route('cashier.profile') }}"
                                            class="py-8 px-7 mt-8 d-flex align-items-center">
                                            <span
                                                class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                <img src="https://bootstrapdemos.adminmart.com/modernize/dist/assets/images/svgs/icon-account.svg"
                                                    alt="modernize-img" width="24" height="24" />
                                            </span>
                                            <div class="w-100 ps-3">
                                                <h6 class="mb-1 fs-3 fw-semibold lh-base">
                                                    Profil Saya
                                                </h6>
                                                <span class="fs-2 d-block text-body-secondary">Pengaturan Akun</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="d-grid py-4 px-7 pt-8">

                                        <form action="{{ route('logout') }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary">Log Out</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end profile Dropdown -->
                        <!-- ------------------------------- -->
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
