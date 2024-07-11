@php
    use App\Helpers\FormatedHelper;
@endphp

<!--  Header Start -->
<header class="app-header">
    <nav class="navbar navbar-light">
        {{-- <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link sidebartoggler nav-icon-hover ms-n3" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>
        </ul> --}}
        <div>
            <h3 class="fw-bolder text-center mb-0">Keranjang Penjualan</h3>
        </div>
        <div class="justify-content-end d-block" id="navbarNav">
            <div class="d-flex align-items-center justify-content-between">
                <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                    <li class="nav-item dropdown">
                        <div class="d-flex align-items-center">
                            <div class="card bg-primary-subtle m-0">
                                <div class="card-body p-2 text-primary">{{ FormatedHelper::dateFormat(now()) }} - <span id="timer">{{ FormatedHelper::timeFormat(now()) }}</span></div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown"
                        aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <div class="user-profile-img">
                                    <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('assets/images/profile/user-1.jpg') }}"
                                            alt="photo" class="rounded-circle mb-2"
                                            style="object-fit: cover;" width="35" height="35">
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
                                        alt="photo" class="rounded-circle" style="object-fit: cover;"
                                        width="80" height="80">
                                    <div class="ms-3">
                                        <h5 class="mb-1 fs-3">
                                            {{ auth()->user()->name }}
                                        </h5>
                                        <p class="mb-0 d-flex text-dark align-items-center gap-2">
                                            <i class="ti ti-mail fs-4"></i>
                                            {{ auth()->user()->email }}
                                        </p>
                                    </div>
                                </div>
                                <div class="message-body">
                                    <a href="{{ route('admin.profile') }}"
                                        class="py-8 px-7 mt-8 d-flex align-items-center">
                                        <span
                                            class="d-flex align-items-center justify-content-center bg-light rounded-1 p-6">
                                            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/svgs/icon-account.svg"
                                                alt="" width="24" height="24" />
                                        </span>
                                        <div class="w-75 d-inline-block v-middle ps-3">
                                            <h6 class="mb-1 bg-hover-primary fw-semibold">
                                                Profil Saya
                                            </h6>
                                            <span class="d-block text-dark">Pengaturan akun</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="d-grid py-4 px-7 pt-8">
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary">Keluar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

@push('custom-script')
    <script>
        setInterval(() => {
            updateTimer()
        }, 10000);

        function updateTimer() {
            let date = new Date()
            let hours = date.getHours().toString().padStart(2, '0');
            let minutes = date.getMinutes().toString().padStart(2, '0');
            $('#timer').html(`${hours}:${minutes}`);
        }
    </script>
@endpush