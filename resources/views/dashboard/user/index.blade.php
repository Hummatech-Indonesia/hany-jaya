@extends('dashboard.layouts.dashboard')
@push("title")
    Data Pengguna
@endpush
@section('content')
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Pengguna</h4>
                        <p>List pengguna aplikasi di toko anda.</p>
                        @role('admin')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddCashier">
                                Tambah Pengguna
                            </button>
                        @endrole
                        @include('dashboard.user.widgets.modal-create')
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
                <table class="table align-middle table-striped table-hover" id="tb-list-cashier"></table>
            </div>
        </div>
        @include('dashboard.user.widgets.modal-edit')
        <x-dialog.delete title="Hapus Kasir" />
    </div>
@endsection
@section('style')
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.min.css"/>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/datatables.min.js"></script>
    <script>

        const selectizeRole = $('#roleCashier').selectize({
            plugins: ["clear_button", "remove_button"],
            maxItems: null,
        });

        const selectizeRoleEdit = $('#roleCashierEdit').selectize({
            plugins: ["clear_button", "remove_button"],
            maxItems: null,
        });

        const select = {
            selectRole: selectizeRole[0].selectize,
            selectRoleEdit: selectizeRoleEdit[0].selectize
        }

        const pluck = (arr, key) => arr.map(i => i[key]);

        let cashier_datatable = $('#tb-list-cashier').DataTable({
            processing: true,
            serverSide: true,
            order: [[1, 'asc']],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Semua']],
            dom: "<'row mt-2 justify-content-between'<'col-md-auto me-auto'B><'col-md-auto ms-auto input-date-container'>><'row mt-2 justify-content-between'<'col-md-auto me-auto'l><'col-md-auto me-start'f>><'row mt-2 justify-content-md-center'<'col-12'rt>><'row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ":not(:eq(4))"
                    }
                }, {
                    extend: 'csv',
                    exportOptions: {
                        columns: ":not(:eq(4))"
                    }
                }, {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ":not(:eq(4))"
                    }
                }
            ],
            initComplete: function() {
                $('.dt-buttons').addClass('btn-group-sm')
            },
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
                {
                    title: "Role",
                    mRender: (data, type, full) => {
                        var roles = ''                        
                        full.roles.map((item) => {
                            roles += `<span class="badge ${item.name == 'admin' ? 'bg-primary' : 'bg-warning'} mx-1 my-1">${item.name}</span>`
                        })
                        return roles
                    },
                },
                @role('admin')
                {
                    mRender: (data, type, full) => {
                        let edit_url = "{{route('admin.users.update', 'selected_id')}}"
                        edit_url = edit_url.replace('selected_id', full['id'])
                        let del_url = "{{route('admin.users.destroy', 'selected_id')}}"
                        del_url = del_url.replace('selected_id', full['id'])
                        
                        return `
                            <div class="action-btn">
                                <a href="#" data-url="${edit_url}"
                                    data-name="${full['name']}" data-email="${full['email']}"
                                    data-role="${pluck(full.roles, 'name')}"
                                    class="btn btn-sm btn-light btn-update btn-update-icon">
                                    <i class="fs-4 ti ti-edit"></i>
                                </a>
                                <a href="#" data-url="${del_url}"
                                    class="btn btn-sm btn-light btn-delete btn-delete-icon">
                                    <i class="fs-4 ti ti-trash"></i>
                                </a>
                            </div>
                        `
                    },
                    title: "Aksi",
                    width: '15%'
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
            let listId = ['#cashier-name', '#cashier-email', '#roleCashier'];
            let listMessage = ['Nama harus diisi', 'Email harus diisi', 'Role harus diisi'];
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
            $("#role").removeClass("is-invalid");
            $("#role").next().remove();
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
            let roles = $(this).attr("data-role");
            
            $("#form-update").attr("action", url);
            $('#edit-cashier-name').val(name);
            $('#edit-cashier-email').val(email);
            
            console.log(roles)
            select.selectRoleEdit.setValue(roles.split(','));
        });
    </script>
@endsection
