@extends('dashboard.layouts.dashboard') 
@push("title")
    Kategori
@endpush
@section('content')
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Kategori</h4>
                        <p>List kategori yang ada di toko anda.</p>
                        @role('admin')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalAddCategory">
                                Tambah Kategori
                            </button>
                        @endrole
                        @include('dashboard.category.widgets.modal-create')
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
                <table class="table align-middle table-striped" id="tb-categories"></table>
            </div>
        </div>

        @include('dashboard.category.widgets.modal-update')

        <x-dialog.delete title="Hapus Karton" />
    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.css">
@endsection
@section('script')
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.js"></script>
    <script>

        $('#tb-categories').DataTable({
            processing: true,
            serverSide: true,
            language: {
                processing: "Memuat..."
            },
            ajax: {
                url: "{{route('data-table.list-category')}}"
            },
            order: [[1, 'asc']],
            columns: [
                {
                    data: 'DT_RowIndex',
                    title: 'No',
                    searchable: false,
                    orderable: false
                }, {
                    data: 'name',
                    title: "Kategori"
                }, {
                    data: "products_count",
                    title: "Total Produk"
                },
                @role('admin')
                {
                    mRender: (data, type, row) => {
                        let edit_url = "{{route('admin.categories.update', 'selected_id')}}"
                        edit_url = edit_url.replace('selected_id', row['id'])
                        let del_url = "{{route('admin.categories.destroy', 'selected_id')}}"
                        del_url = del_url.replace('selected_id', row['id'])
                        let category = JSON.stringify(row).replaceAll('"', "'")

                        return `
                        <div class="d-flex align-items-center gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-sm btn-light btn-update btn-update-icon" data-category="${category}"
                                data-url="${edit_url}">
                                    <i class="fs-4 ti ti-edit"></i>
                                </button>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-sm btn-light btn-delete btn-delete-icon" data-url="${del_url}">
                                    <i class="fs-4 ti ti-trash"></i>
                                </button>
                            </div>
                        </div>
                        `
                    },
                    title: 'Aksi',
                    searchable: false,
                    orderable: false,
                    width: '15%'
                }
                @endrole
            ]
        })

        // set autofocus 
        $("#modalAddCategory").on("shown.bs.modal", function() {
            $("#category-name").focus();
        });
        $("#modalUpdateCategory").on("shown.bs.modal", function() {
            $("#edit-name-category").focus();
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

        // validate form 
        $("#form-add-category").on("submit", function(e) {
            e.preventDefault();
            let listId = ["#category-name"];
            let listMessage = ["Nama kategori tidak boleh kosong"];
            if (validate(listId, listMessage)) {
                return;
            }
            $(this).unbind("submit").submit();
        });
        $("#form-update-category").on("submit", function(e) {
            e.preventDefault();
            let listId = ["#edit-name-category"];
            let listMessage = ["Nama kategori tidak boleh kosong"];
            if (validate(listId, listMessage)) {
                return;
            }
            $(this).unbind("submit").submit();
        });

        // clear error message 
        $("#modalAddCategory").on("hidden.bs.modal", function() {
            $("#category-name").removeClass("is-invalid");
            $("#category-name").next().remove();
        });
        $("#modalUpdateCategory").on("hidden.bs.modal", function() {
            $("#edit-name-category").removeClass("is-invalid");
            $("#edit-name-category").next().remove();
        });

        $(document).on("click", ".btn-update",function() {
            $("#modalUpdateCategory").modal("show");
            let url = $(this).attr("data-url");
            let category_str = $(this).data("category");
            let category = JSON.parse(category_str.replaceAll("'", '"'))

            $("#modalUpdateCategory").find("#edit-name-category").val(category.name);
            $("#form-update-category").attr("action", url);
        });
        $(document).on("click", ".btn-delete", function() {
            $("#delete-modal").modal("show");

            let url = $(this).attr("data-url");
            $("#form-delete").attr("action", url);
        });
    </script>
@endsection
