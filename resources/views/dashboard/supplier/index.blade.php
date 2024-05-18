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
                    @include('dashboard.supplier.widgets.modal-create')
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
        @forelse($suppliers as $supplier)
        <div class="col-md-6 col-lg-4">
            <div class="card rounded-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <span class="flex-shrink-0"
                            ><i class="ti ti-users text-success display-6"></i
                        ></span>
                        <div class="ms-4 flex-grow-1">
                            <div class="row">
                                <div class="col-10">
                                    <h4 class="card-title text-dark">
                                        {{ $supplier->name }}
                                    </h4>
                                    <h6
                                        class="card-subtitle mb-0 fs-2 fw-normal mb-1"
                                    >
                                        {{ $supplier->address }}
                                    </h6>
                                </div>
                                <div class="col-2 mx-auto">
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
                                                    class="dropdown-item btn-update"
                                                    href="#"
                                                    data-supplier="{{
                                                        $supplier
                                                    }}"
                                                    data-url="{{
                                                        route(
                                                            'admin.suppliers.update',
                                                            $supplier->id
                                                        )
                                                    }}"
                                                >
                                                    <i
                                                        class="ti ti-share text-muted me-1 fs-4"
                                                    ></i
                                                    >Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a
                                                    class="dropdown-item btn-delete"
                                                    href="#"
                                                    data-url="{{ route('admin.suppliers.destroy', $supplier->id) }}"
                                                >
                                                    <i
                                                        class="ti ti-download text-muted me-1 fs-4"
                                                    ></i
                                                    >Hapus
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @if (count($supplier->supplierProducts) > 0)
                            <div class="mt-3">
                                <span
                                    class="mb-1 badge rounded-pill font-medium bg-light-primary text-primary"
                                    ><small
                                        >{{ $supplier->supplierProducts }}</small
                                    ></span
                                >
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <p>Belum ada data supplier di toko anda.</p>
        @endforelse
    </div>

    @include('dashboard.supplier.widgets.modal-update')

    <x-dialog.delete title="Hapus Pemasok" />
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
<script>
    $(".btn-update").on("click", function () {
        $("#modalUpdateSuplier").modal("show");
        let url = $(this).attr("data-url");
        let supplier = $(this).data("supplier");

        $("#modalUpdateSuplier").find("#input-name").val(supplier.name);
        $("#modalUpdateSuplier").find("#input-address").val(supplier.address);
        $("#form-update").attr("action", url);
    });
    $(".btn-delete").on("click", function () {
        $("#delete-modal").modal("show");

        let url = $(this).attr("data-url");
        $("#form-delete").attr("action", url);
    });
</script>
<script>
    @if(session()->has('success'))
    toastr.success(
        "Berhasil",
        "{{ session('success') }}",
        { showMethod: "slideDown", hideMethod: "slideUp", timeOut: 2000 }
      );
    @endif
</script>
@endsection
