@extends('dashboard.layouts.dashboard') @section('content')
<div class="container-fluid">
    <div
        class="card bg-light-info shadow-none position-relative overflow-hidden"
    >
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Pemasok</h4>
                    <p>List pemasok di toko anda.</p>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img
                            src="{{
                                asset('assets/images/breadcrumb/ChatBc.png')
                            }}"
                            alt=""
                            class="img-fluid mb-n4"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-end">
        <div class="col-3">
            <input
                type="text"
                class="form-control"
                id="nametext"
                aria-describedby="name"
                placeholder="Produk"
            />
        </div>
        <div class="col-3">
            <input
                type="text"
                class="form-control"
                id="nametext"
                aria-describedby="name"
                placeholder="Name"
            />
        </div>
        <div class="col-1">
            <button class="btn btn-primary">Cari</button>
        </div>
    </div>
    <!--  Row 1 -->
    <div class="row mt-5">
        <div class="col-md-6 col-lg-4">
            <div class="card rounded-3 card-hover">
                <a href="#" class="stretched-link"></a>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <span class="flex-shrink-0"
                            ><i class="ti ti-users text-success display-6"></i
                        ></span>
                        <div class="ms-4">
                            <h4 class="card-title text-dark">
                                PT. Danone Indonesia
                            </h4>
                            <h6 class="card-subtitle mb-0 fs-2 fw-normal mb-1">
                                Jl. Soekarno-Hatta No.90, Kota Malang
                            </h6>
                            <div class="mt-3">
                                <span
                                    class="mb-1 badge rounded-pill font-medium bg-light-primary text-primary"
                                    ><small>Chitato</small></span
                                >
                                <span
                                    class="mb-1 badge rounded-pill font-medium bg-light-primary text-primary"
                                    ><small>Aqua</small></span
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
