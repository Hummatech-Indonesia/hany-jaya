@extends('dashboard.layouts.dashboard')
@push("title")
    Kasir
@endpush
@section('content')
    <div class="container-fluid">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Kasir</h4>
                        <p>List kasir di toko anda.</p>
                        @role('admin')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddCashier">
                                Tambah Kasir
                            </button>
                        @endrole
                        @include('dashboard.cashier.widgets.modal-create')
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
                <table class="table align-middle" id="tb-list-cashier"></table>
            </div>
        </div>
        @include('dashboard.cashier.widgets.modal-edit')
        <x-dialog.delete title="Hapus Kasir" />
    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.css">
@endsection
@section('script')
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.js"></script>
    <script>
        let cashier_datatable = $('#tb-list-cashier').DataTable({
            processing: true,
            serverSide: true,
            order: [[1, 'asc']],
            ajax: {
                url: "{{route('data-table.list-cashier')}}"
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    title: "No",
                    orderable: false,
                    searchable: false
                }, {
                    data: "name",
                    title: "Nama"
                }, {
                    data: "email",
                    title: "Email"
                }, 
                @role('admin')
                {
                    mRender: (data, type, full) => {
                        let edit_url = "{{route('admin.cashiers.update', 'selected_id')}}"
                        edit_url = edit_url.replace('selected_id', full['id'])
                        let del_url = "{{route('admin.cashiers.destroy', 'selected_id')}}"
                        del_url = del_url.replace('selected_id', full['id'])
                        
                        return `
                            <div class="action-btn">
                                <a href="#" data-url="${edit_url}"
                                    data-name="${full['name']}" data-email="${full['email']}"
                                    class="btn btn-sm btn-primary btn-update ms-2">
                                    <i class="fs-4 ti ti-edit"></i> Edit
                                </a>
                                <a href="#" data-url="${del_url}"
                                    class="btn btn-sm btn-danger btn-delete ms-2">
                                    <i class="ti ti-trash"></i> Hapus
                                </a>
                            </div>
                        `
                    },
                    title: "Aksi",
                }
                @endrole
            ]
        })



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

        // validasi form 
        $(document).on("click", ".btn-tambah", function(e) {
            e.preventDefault();
            let listId = ['#cashier-name', '#cashier-email'];
            let listMessage = ['Nama harus diisi', 'Email harus diisi'];
            if (validate(listId, listMessage)) {
                return;
            }
            $("#form-add-cashier").submit();
        });
        $(document).on("click", ".btn-edit", function(e) {
            e.preventDefault();
            let listId = ['#edit-cashier-name', '#edit-cashier-email'];
            let listMessage = ['Nama harus diisi', 'Email harus diisi'];
            if (validate(listId, listMessage)) {
                return;
            }
            $("#form-update").submit();
        });

        // set autofocus 
        $("#modalAddCashier").on("shown.bs.modal", function() {
            $("#cashier-name").focus();
        });
        $("#modalEditCashier").on("shown.bs.modal", function() {
            $("#edit-cashier-name").focus();
        });

        // clear error message 
        $("#modalAddCashier").on("hidden.bs.modal", function() {
            $("#cashier-name").removeClass("is-invalid");
            $('#cashier-name').next().remove();
            $("#cashier-email").removeClass("is-invalid");
            $("#cashier-email").next().remove();
        });
        $("#modalEditCashier").on("hidden.bs.modal", function() {
            $("#edit-cashier-name").removeClass("is-invalid");
            $("#edit-cashier-name").next().remove();
            $("#edit-cashier-email").removeClass("is-invalid");
            $("#edit-cashier-email").next().remove();
        });

        $(document).on("click", ".btn-delete", function() {
            $("#delete-modal").modal("show");

            let url = $(this).attr("data-url");
            $("#form-delete").attr("action", url);
        });
        $(document).on("click", ".btn-update", function() {
            $("#modalEditCashier").modal("show");


            let url = $(this).attr("data-url");
            let name = $(this).attr("data-name");
            let email = $(this).attr("data-email");
            $("#form-update").attr("action", url);
            $('#edit-cashier-name').val(name);
            $('#edit-cashier-email').val(email);
        });
    </script>
@endsection
