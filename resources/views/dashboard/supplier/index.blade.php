@extends('dashboard.layouts.dashboard') 
@push("title")
    Distributor
@endpush
@section('content')
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Distributor</h4>
                        <p>List distributor di toko anda.</p>
                        @role('admin')
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddSuplier">
                            Tambah Distributor
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
                <div class="alert alert-warning" role="alert">
                    Sebelum melakukan export / cetak data, pastikan kolom "entries per page" bernilai "semua" agar keseluruhan data tercetak.
                </div>
                <table class="table align-middle table-striped table-hover" id="tb-suppliers"></table>
            </div>
        </div>

        @include('dashboard.supplier.widgets.modal-update')

        <x-dialog.delete title="Hapus Distributor" />
    </div>
@endsection
@section('style')
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/libs/daterangepicker/daterangepicker.css')}}">
@endsection
@section('script')
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/forms/select2.init.js') }}"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/datatables.min.js"></script>
    

    <script>
        const datatable_supplier = $('#tb-suppliers').DataTable({
            processing: true,
            serverSide: true,
            order: [[1, 'asc']],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Semua']],
            dom: "<'row mt-2 justify-content-between'<'col-md-auto me-auto'B><'col-md-auto ms-auto input-date-container'>><'row mt-2 justify-content-between'<'col-md-auto me-auto'l><'col-md-auto me-start'f>><'row mt-2 justify-content-md-center'<'col-12'rt>><'row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ":not(:eq(3))"
                    }
                }, {
                    extend: 'csv',
                    exportOptions: {
                        columns: ":not(:eq(3))"
                    }
                }, {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ":not(:eq(3))"
                    }, customize: function (doc) {
                        doc.content[1].table.widths = 
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                    }
                }
            ],
            initComplete: function() {
                $('.dt-buttons').addClass('btn-group-sm')
            },
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
                    title: "Distributor",
                },  
                {
                    data: "address",
                    title: "Alamat",
                },
                {
                    mRender: (data, type, full) => {
                        let edit_url = "{{ route('admin.suppliers.update', 'selected_id') }}"
                        edit_url = edit_url.replace('selected_id', full['id'])
                        let del_url = "{{ route('admin.suppliers.destroy', 'selected_id') }}"
                        del_url = del_url.replace('selected_id', full['id'])
                        let supplier = JSON.stringify(full).replaceAll('"', "'")

                        return `
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-light btn-update btn-update-icon"
                                    data-supplier="${supplier}"
                                    data-url="${edit_url}">
                                    <i class="ti ti-edit fs-4"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-light btn-delete btn-delete-icon"
                                    data-url="${del_url}">
                                    <i class="ti ti-trash fs-4"></i>
                                </button>
                            </div>
                        `
                    },
                    title: "Aksi",
                    searchable: false,
                    orderable: false,
                    width: "15%"
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

            let isError = validate(['#supplier-name'], [
                'Nama distributor tidak boleh kosong.',
                'Alamat distributor tidak boleh kosong.'
            ])

            if (!isError) {
                $(this).closest('form').submit();
            }

            return false
        });
        $('.btn-edit').on('click', function(e) {
            e.preventDefault();

            let isError = validate(['#edit-supplier-name'], [
                'Nama distributor tidak boleh kosong.',
                'Alamat distributor tidak boleh kosong.'
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