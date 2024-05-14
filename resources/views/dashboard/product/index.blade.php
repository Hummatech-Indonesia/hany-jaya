@extends('dashboard.layouts.dashboard') @section('content')
<div class="container-fluid">
    <div
        class="card bg-light-info shadow-none position-relative overflow-hidden"
    >
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Produk</h4>
                    <p>List produk yang ada di toko anda.</p>
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
                placeholder="Pemasok"
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
        <div class="col-lg-3">
            <div class="card rounded-2 overflow-hidden hover-img">
                <div class="position-relative">
                    <a href="javascript:void(0)"
                        ><img
                            src="{{
                                asset('assets/images/blog/blog-img1.jpg')
                            }}"
                            class="card-img-top rounded-0"
                            alt="..."
                    /></a>
                    <span
                        class="badge bg-danger text-white fs-2 rounded-4 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0"
                        >Hampir Habis</span
                    >
                </div>
                <div class="card-body px-4 py-3">
                    <span
                        class="badge rounded-pill font-medium bg-light-primary text-primary"
                        ><small>PT. Danone</small></span
                    >
                    <a class="d-block my-2 fs-5 text-dark fw-semibold" href="#"
                        >Aqua</a
                    >
                    <p>Air Mineral</p>
                    <div class="d-flex align-items-center gap-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-eye text-dark fs-5"></i>9,125
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="ti ti-message-2 text-dark fs-5"></i>3
                        </div>
                        <div class="d-flex align-items-center fs-2 ms-auto">
                            <i class="ti ti-point text-dark"></i>Mon, Dec 19
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
