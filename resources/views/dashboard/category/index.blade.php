@extends('dashboard.layouts.dashboard') 
@push("title")
    Kategori
@endpush
@section('content')
    <div class="container-fluid">
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
        <form action="" method="get">
            <div class="row justify-content-end">
                <div class="col-3">
                    <input type="text" name="name" value="{{ Request::get('name') }}" class="form-control"
                        id="nametext" aria-describedby="name" placeholder="Name" />
                </div>
                <div class="col-1">
                    <button type="submit" class="btn btn-primary">Cari</button>
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
        <div class="widget-content searchable-container list mt-4">
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <th>#</th>
                            <th>Kategori</th>
                            <th>Total Produk</th>
                            @role('admin')
                                <td>Aksi</td>
                            @endrole
                        </thead>
                        <tbody>
                            @forelse ($categories as $index => $category)
                                <tr class="search-items">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ $category->name }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0">
                                            {{ $category->products ? count($category->products) : 0 }}
                                        </h6>
                                    </td>
                                    @role('admin')
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <button type="button" class="btn btn-sm btn-primary btn-update" data-category="{{ $category }}"
                                                    data-url="{{ route('admin.categories.update', $category->id) }}">
                                                        <i class="fs-4 ti ti-edit"></i> <span class="d-none d-md-inline">Edit</span>
                                                    </button>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete" data-url="{{ route('admin.categories.destroy', $category->id) }}">
                                                        <i class="fs-4 ti ti-trash"></i> <span class="d-none d-md-inline">Hapus</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    @endrole
                                </tr>
                            @empty
                                <p>Kategori masih kosong</p>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
        @include('dashboard.category.widgets.modal-update')

        <x-dialog.delete title="Hapus Karton" />
    </div>
@endsection
@section('script')
    <script>
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

        $(".btn-update").on("click", function() {
            $("#modalUpdateCategory").modal("show");
            let url = $(this).attr("data-url");
            let category = $(this).data("category");

            $("#modalUpdateCategory").find("#edit-name-category").val(category.name);
            $("#form-update-category").attr("action", url);
        });
        $(".btn-delete").on("click", function() {
            $("#delete-modal").modal("show");

            let url = $(this).attr("data-url");
            $("#form-delete").attr("action", url);
        });
    </script>
@endsection
