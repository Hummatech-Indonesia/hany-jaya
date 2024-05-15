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
                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalAddSuplier"
                    >
                        Tambah Pemasok
                    </button>

                    <!-- Modal -->
                    <div
                        class="modal fade"
                        id="modalAddSuplier"
                        data-bs-backdrop="static"
                        data-bs-keyboard="false"
                        tabindex="-1"
                        aria-labelledby="modalAddSuplierLabel"
                        aria-hidden="true"
                    >
                        <div
                            class="modal-dialog modal-dialog-scrollable modal-lg"
                        >
                            <div class="modal-content">
                                <div
                                    class="modal-header d-flex align-items-center"
                                >
                                    <h4
                                        class="modal-title"
                                        id="myLargeModalLabel"
                                    >
                                        Tambah Pemasok
                                    </h4>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>
                                <div class="modal-body row">
                                    <div class="col-md-6 mb-4">
                                        <label
                                            for="exampleInputPassword1"
                                            class="form-label fw-semibold"
                                            >Nama Pemasok</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="exampleInputtext"
                                            placeholder="John Deo"
                                        />
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label
                                            for="exampleInputPassword1"
                                            class="form-label fw-semibold"
                                            >Produk</label
                                        >
                                        <select
                                            id="select-product"
                                            class="select2 form-control"
                                            style="width: 100%; height: 36px"
                                        >
                                            <option>Select</option>
                                            <optgroup
                                                label="Alaskan/Hawaiian Time Zone"
                                            >
                                                <option value="AK">
                                                    Alaska
                                                </option>
                                                <option value="HI">
                                                    Hawaii
                                                </option>
                                            </optgroup>
                                            <optgroup label="Pacific Time Zone">
                                                <option value="CA">
                                                    California
                                                </option>
                                                <option value="NV">
                                                    Nevada
                                                </option>
                                                <option value="OR">
                                                    Oregon
                                                </option>
                                                <option value="WA">
                                                    Washington
                                                </option>
                                            </optgroup>
                                            <optgroup
                                                label="Mountain Time Zone"
                                            >
                                                <option value="AZ">
                                                    Arizona
                                                </option>
                                                <option value="CO">
                                                    Colorado
                                                </option>
                                                <option value="ID">
                                                    Idaho
                                                </option>
                                                <option value="MT">
                                                    Montana
                                                </option>
                                                <option value="NE">
                                                    Nebraska
                                                </option>
                                                <option value="NM">
                                                    New Mexico
                                                </option>
                                                <option value="ND">
                                                    North Dakota
                                                </option>
                                                <option value="UT">Utah</option>
                                                <option value="WY">
                                                    Wyoming
                                                </option>
                                            </optgroup>
                                            <optgroup label="Central Time Zone">
                                                <option value="AL">
                                                    Alabama
                                                </option>
                                                <option value="AR">
                                                    Arkansas
                                                </option>
                                                <option value="IL">
                                                    Illinois
                                                </option>
                                                <option value="IA">Iowa</option>
                                                <option value="KS">
                                                    Kansas
                                                </option>
                                                <option value="KY">
                                                    Kentucky
                                                </option>
                                                <option value="LA">
                                                    Louisiana
                                                </option>
                                                <option value="MN">
                                                    Minnesota
                                                </option>
                                                <option value="MS">
                                                    Mississippi
                                                </option>
                                                <option value="MO">
                                                    Missouri
                                                </option>
                                                <option value="OK">
                                                    Oklahoma
                                                </option>
                                                <option value="SD">
                                                    South Dakota
                                                </option>
                                                <option value="TX">
                                                    Texas
                                                </option>
                                                <option value="TN">
                                                    Tennessee
                                                </option>
                                                <option value="WI">
                                                    Wisconsin
                                                </option>
                                            </optgroup>
                                            <optgroup label="Eastern Time Zone">
                                                <option value="CT">
                                                    Connecticut
                                                </option>
                                                <option value="DE">
                                                    Delaware
                                                </option>
                                                <option value="FL">
                                                    Florida
                                                </option>
                                                <option value="GA">
                                                    Georgia
                                                </option>
                                                <option value="IN">
                                                    Indiana
                                                </option>
                                                <option value="ME">
                                                    Maine
                                                </option>
                                                <option value="MD">
                                                    Maryland
                                                </option>
                                                <option value="MA">
                                                    Massachusetts
                                                </option>
                                                <option value="MI">
                                                    Michigan
                                                </option>
                                                <option value="NH">
                                                    New Hampshire
                                                </option>
                                                <option value="NJ">
                                                    New Jersey
                                                </option>
                                                <option value="NY">
                                                    New York
                                                </option>
                                                <option value="NC">
                                                    North Carolina
                                                </option>
                                                <option value="OH">Ohio</option>
                                                <option value="PA">
                                                    Pennsylvania
                                                </option>
                                                <option value="RI">
                                                    Rhode Island
                                                </option>
                                                <option value="SC">
                                                    South Carolina
                                                </option>
                                                <option value="VT">
                                                    Vermont
                                                </option>
                                                <option value="VA">
                                                    Virginia
                                                </option>
                                                <option value="WV">
                                                    West Virginia
                                                </option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label
                                            for="exampleInputPassword1"
                                            class="form-label fw-semibold"
                                            >Alamat</label
                                        >
                                        <textarea
                                            class="form-control p-7"
                                            name=""
                                            id=""
                                            cols="20"
                                            rows="1"
                                            placeholder="Hi, Do you  have a moment to talk Jeo ?"
                                        ></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-light-danger text-danger font-medium waves-effect text-start"
                                        data-bs-dismiss="modal"
                                    >
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
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
            <div class="card rounded-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <span class="flex-shrink-0"
                            ><i class="ti ti-users text-success display-6"></i
                        ></span>
                        <div class="ms-4">
                            <div class="row">
                                <div class="col-10">
                                    <h4 class="card-title text-dark">
                                        PT. Danone Indonesia
                                    </h4>
                                    <h6
                                        class="card-subtitle mb-0 fs-2 fw-normal mb-1"
                                    >
                                        Jl. Soekarno-Hatta No.90, Kota Malang
                                    </h6>
                                </div>
                                <div class="col-2">
                                    <div class="dropdown">
                                        <a
                                            class=""
                                            href="javascript:void(0)"
                                            id="t2"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            <i
                                                class="ti ti-dots-vertical fs-4"
                                            ></i>
                                        </a>
                                        <ul
                                            class="dropdown-menu"
                                            aria-labelledby="t2"
                                        >
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="#"
                                                >
                                                    <i
                                                        class="ti ti-share text-muted me-1 fs-4"
                                                    ></i
                                                    >Share
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="#"
                                                >
                                                    <i
                                                        class="ti ti-download text-muted me-1 fs-4"
                                                    ></i
                                                    >Download
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
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
        <div class="col-md-6 col-lg-4">
            <div class="card rounded-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <span class="flex-shrink-0"
                            ><i class="ti ti-users text-success display-6"></i
                        ></span>
                        <div class="ms-4">
                            <div class="row">
                                <div class="col-10">
                                    <h4 class="card-title text-dark">
                                        PT. Danone Indonesia
                                    </h4>
                                    <h6
                                        class="card-subtitle mb-0 fs-2 fw-normal mb-1"
                                    >
                                        Jl. Soekarno-Hatta No.90, Kota Malang
                                    </h6>
                                </div>
                                <div class="col-2">
                                    <div class="dropdown">
                                        <a
                                            class=""
                                            href="javascript:void(0)"
                                            id="t2"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            <i
                                                class="ti ti-dots-vertical fs-4"
                                            ></i>
                                        </a>
                                        <ul
                                            class="dropdown-menu"
                                            aria-labelledby="t2"
                                        >
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="#"
                                                >
                                                    <i
                                                        class="ti ti-share text-muted me-1 fs-4"
                                                    ></i
                                                    >Share
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="#"
                                                >
                                                    <i
                                                        class="ti ti-download text-muted me-1 fs-4"
                                                    ></i
                                                    >Download
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
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
        <div class="col-md-6 col-lg-4">
            <div class="card rounded-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <span class="flex-shrink-0"
                            ><i class="ti ti-users text-success display-6"></i
                        ></span>
                        <div class="ms-4">
                            <div class="row">
                                <div class="col-10">
                                    <h4 class="card-title text-dark">
                                        PT. Danone Indonesia
                                    </h4>
                                    <h6
                                        class="card-subtitle mb-0 fs-2 fw-normal mb-1"
                                    >
                                        Jl. Soekarno-Hatta No.90, Kota Malang
                                    </h6>
                                </div>
                                <div class="col-2">
                                    <div class="dropdown">
                                        <a
                                            class=""
                                            href="javascript:void(0)"
                                            id="t2"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                        >
                                            <i
                                                class="ti ti-dots-vertical fs-4"
                                            ></i>
                                        </a>
                                        <ul
                                            class="dropdown-menu"
                                            aria-labelledby="t2"
                                        >
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="#"
                                                >
                                                    <i
                                                        class="ti ti-share text-muted me-1 fs-4"
                                                    ></i
                                                    >Share
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item"
                                                    href="#"
                                                >
                                                    <i
                                                        class="ti ti-download text-muted me-1 fs-4"
                                                    ></i
                                                    >Download
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
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
@endsection @section('script')
<script src="{{
        asset('assets/libs/select2/dist/js/select2.full.min.js')
    }}"></script>
<script src="{{
        asset('assets/libs/select2/dist/js/select2.min.js')
    }}"></script>
<script src="{{ asset('assets/js/forms/select2.init.js') }}"></script>
<script>
    $("#select-product").select2({
        dropdownParent: $("#modalAddSuplier"),
    });
</script>
@endsection
