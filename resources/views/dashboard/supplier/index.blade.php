@extends('dashboard.layouts.dashboard') 
@push("title")
    Pemasok
@endpush
@section('content')
    <div class="container-fluid">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Pemasok</h4>
                        <p>List pemasok di toko anda.</p>
                        @role('admin')
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddSuplier">
                            Tambah Pemasok
                        </button>
                        @endrole
                        @include('dashboard.supplier.widgets.modal-create')
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt=""
                                class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form action="" method="get">
            <div class="row justify-content-end">
                <div class="col-3">
                    <input type="text" class="form-control" id="nametext" name="product"
                        value="{{ Request::get('product') }}" aria-describedby="name" placeholder="Produk" />
                </div>
                <div class="col-3">
                    <input type="text" value="{{ Request::get('name') }}" class="form-control" id="name"
                        name="name" aria-describedby="name" placeholder="Name" />
                </div>
                <div class="col-1">
                    <button class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>
        <div class="row mt-3">
            @if (session()->has('error'))
                <div class="col-12">
                    <x-alert-failed />
                </div>
            @endif
            @if ($errors->any())
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <strong>Terjadi Kesalahan</strong>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                        </div>
                    </div>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="col-12">
                    <x-alert-success />
                </div>
            @endif
        </div>
        <!--  Row 1 -->
        <div class="row mt-3">
            @forelse($suppliers as $supplier)
                <div class="col-md-6 col-lg-4">
                    <div class="card rounded-3 flex-fill">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <span class="flex-shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ $supplier->name }}&rounded=true&background=EBF3FE" alt="">
                                </span>
                                <div class="ms-4 flex-grow-1">
                                    <div class="row">
                                        <div class="col-10">
                                            <h4 class="card-title text-dark">
                                                {{ $supplier->name }}
                                            </h4>
                                            <h6 class="card-subtitle mb-0 fs-2 fw-normal mb-1">
                                                {{ $supplier->address }}
                                            </h6>
                                        </div>
                                        @role('admin')
                                        <div class="col-2 mx-auto">
                                            <div class="dropdown">
                                                <a class="" href="javascript:void(0)" id="t2"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical fs-4"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="t2">
                                                    <li>
                                                        <a class="dropdown-item btn-update" href="#"
                                                            data-supplier="{{ $supplier }}"
                                                            data-url="{{ route('admin.suppliers.update', $supplier->id) }}">
                                                            <i class="ti ti-edit text-muted me-1 fs-4"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item btn-delete" href="#"
                                                            data-url="{{ route('admin.suppliers.destroy', $supplier->id) }}">
                                                            <i class="ti ti-trash text-muted me-1 fs-4"></i>Hapus
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        @endrole
                                    </div>
                                    @if (count($supplier->supplierProducts) > 0)
                                        <div class="mt-3">
                                            @if ($supplier->supplierProducts)
                                                @foreach ($supplier->supplierProducts as $supplierProduct)
                                                    <span
                                                        class="mb-1 badge rounded-pill font-medium bg-light-primary text-primary"><small>{{ $supplierProduct->product->name }}</small></span>
                                                @endforeach
                                            @endif
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
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/forms/select2.init.js') }}"></script>
    <script>
        $("#select-product").select2({
            dropdownParent: $("#modalAddSuplier"),
        });
    </script>
    <script>

        // set autofocus 
        $('#modalAddSuplier').on('shown.bs.modal', function () {
            $('#supplier-name').focus();
        });
        $('#modalUpdateSuplier').on('shown.bs.modal', function () {
            $('#edit-supplier-name').focus();
        });

        function validate(listId, listMessage) {
            let countError = 0;
            listId.map(id => {
                let siblings = $(id).parent().children().length;
                if (($(id).val() == '' || $(id).val() == null) && siblings == 2) {
                    $(id).addClass('is-invalid')
                    $(id).parent().append(
                        '<small class="text-danger">' + listMessage[listId.indexOf(id)] + '</small>'
                    )
                    countError++;
                }
                if (($(id).val() == '' || $(id).val() == null) && siblings > 2) {
                    countError = 1;
                }
            })

            return countError > 0 ? true : false;
        }

        $(".btn-update").on("click", function() {
            $("#modalUpdateSuplier").modal("show");
            let url = $(this).attr("data-url");
            let supplier = $(this).data("supplier");

            $("#modalUpdateSuplier").find("#edit-supplier-name").val(supplier.name);
            $("#modalUpdateSuplier").find("#edit-supplier-address").val(supplier.address);
            $("#form-update-supplier").attr("action", url);
        });
        $(".btn-delete").on("click", function() {
            $("#delete-modal").modal("show");

            let url = $(this).attr("data-url");
            $("#form-delete").attr("action", url);
        });

        // clear validation 
        $('#modalAddSuplier').on('hidden.bs.modal', function () {
            $('#supplier-name').val('');
            $('#supplier-address').val('');
            $('#supplier-name').removeClass('is-invalid');
            $('#supplier-address').removeClass('is-invalid');
            $('#supplier-name').next('small').remove();
            $('#supplier-address').next('small').remove();
        });
        $('#modalUpdateSuplier').on('hidden.bs.modal', function () {
            $('#edit-supplier-name').val('');
            $('#edit-supplier-address').val('');
            $('#edit-supplier-name').removeClass('is-invalid');
            $('#edit-supplier-address').removeClass('is-invalid');
            $('#edit-supplier-name').next('small').remove();
            $('#edit-supplier-address').next('small').remove();
        });

        // validate form 
        $('.btn-tambah').on('click', function(e) {
            e.preventDefault();

            let isError = validate(['#supplier-name', '#supplier-address'], [
                'Nama pemasok tidak boleh kosong.',
                'Alamat pemasok tidak boleh kosong.'
            ])

            if (!isError) {
                $(this).closest('form').submit();
            }

            return false
        });
        $('.btn-edit').on('click', function(e) {
            e.preventDefault();

            let isError = validate(['#edit-supplier-name', '#edit-supplier-address'], [
                'Nama pemasok tidak boleh kosong.',
                'Alamat pemasok tidak boleh kosong.'
            ])

            if (!isError) {
                $(this).closest('form').submit();
            }

            return false
        });
        
    </script>
    <script>
        @if (session()->has('success'))
            toastr.success(
                "Berhasil",
                "{{ session('success') }}", {
                    showMethod: "slideDown",
                    hideMethod: "slideUp",
                    timeOut: 2000
                }
            );
        @endif
    </script>
@endsection
