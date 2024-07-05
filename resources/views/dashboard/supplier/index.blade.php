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

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table align-middle" id="tb-suppliers"></table>
            </div>
        </div>

        @include('dashboard.supplier.widgets.modal-update')

        <x-dialog.delete title="Hapus Pemasok" />
    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.css">
    <link rel="stylesheet" href="{{asset('assets/libs/daterangepicker/daterangepicker.css')}}">
@endsection
@section('script')
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.js"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/forms/select2.init.js') }}"></script>

    <script>
        const datatable_supplier = $('#tb-suppliers').DataTable({
                processing: true,
                serverSide: true,
                order: [[1, 'asc']],
                language: {
                    processing: 'Memuat...'
                },
                ajax: {
                    url: "{{ route('data-table.list-supplier') }}"
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        title: "No",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "name",
                        title: "Pemasok",
                    },  {
                        mRender: (data, type, row) => {
                            let products = ""
                            row['supplier_products'].forEach((prod) => {
                                products += `<span class="badge m-1 bg-primary">${prod.product.name}</span>`
                            })
                            return products
                        },
                        title: "Produk",
                        searchable: false,
                        orderable: false
                    }, {
                        mRender: (data, type, full) => {
                            let edit_url = "{{ route('admin.suppliers.update', 'selected_id') }}"
                            edit_url = edit_url.replace('selected_id', full['id'])
                            let del_url = "{{ route('admin.suppliers.destroy', 'selected_id') }}"
                            del_url = del_url.replace('selected_id', full['id'])
                            let supplier = JSON.stringify(full).replaceAll('"', "'")

                            return `
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-primary btn-update"
                                        data-supplier="${supplier}"
                                        data-url="${edit_url}">
                                        <i class="ti ti-edit fs-4"></i>Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-delete"
                                        data-url="${del_url}">
                                        <i class="ti ti-trash fs-4"></i>Hapus
                                    </button>
                                </div>
                            `
                        },
                        title: "Aksi",
                        searchable: false,
                        orderable: false
                    }
                ]
            })
    </script>
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

        $(document).on("click", ".btn-update", function() {
            $("#modalUpdateSuplier").modal("show");
            let url = $(this).attr("data-url");
            let supplier_str = $(this).data("supplier");
            let supplier = JSON.parse(supplier_str.replaceAll("'", '"'))

            $("#modalUpdateSuplier").find("#edit-supplier-name").val(supplier.name);
            $("#modalUpdateSuplier").find("#edit-supplier-address").val(supplier.address);
            $("#form-update-supplier").attr("action", url);
        });
        $(document).on("click", ".btn-delete", function() {
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