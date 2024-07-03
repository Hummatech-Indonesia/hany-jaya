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
        <form action="" method="get" style="margin-bottom: 1rem">
            <div class="row justify-content-end">
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
        <div class="widget-content searchable-container list">
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            @role('admin')
                            <th>Aksi</th>
                            @endrole
                        </thead>
                        <tbody>
                            @forelse ($cashiers as $index => $cashier)
                                <tr class="search-items">
                                    <td>
                                        {{ $index + 1 }}
                                    </td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ $cashier->name }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ $cashier->email }}
                                        </h6>
                                    </td>
                                    @role('admin')

                                    <td>
                                        <div class="action-btn">
                                            <a href="#" data-url="{{ route('admin.cashiers.update', $cashier->id) }}"
                                                data-name="{{ $cashier->name }}" data-email="{{ $cashier->email }}"
                                                class="text-dark btn-update ms-2">
                                                <i class="fs-4 ti ti-edit text-warning"></i>
                                            </a>
                                            <a href="#" data-url="{{ route('admin.cashiers.destroy', $cashier->id) }}"
                                                class="text-dark btn-delete ms-2">
                                                <i class="ti ti-trash text-danger"></i>
                                            </a>
                                        </div>
                                    </td>
                                    @endrole
                                </tr>
                            @empty
                                <p>Data Kosong</p>
                            @endforelse

                        </tbody>
                    </table>
                    {{ $cashiers->links() }}
                </div>
            </div>
        </div>
        @include('dashboard.cashier.widgets.modal-edit')
        <x-dialog.delete title="Hapus Kasir" />
    </div>
@endsection
@section('script')
    <script>
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
        $(".btn-tambah").on("click", function(e) {
            e.preventDefault();
            let listId = ['#cashier-name', '#cashier-email'];
            let listMessage = ['Nama harus diisi', 'Email harus diisi'];
            if (validate(listId, listMessage)) {
                return;
            }
            $("#form-add-cashier").submit();
        });
        $(".btn-edit").on("click", function(e) {
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

        $(".btn-delete").on("click", function() {
            $("#delete-modal").modal("show");

            let url = $(this).attr("data-url");
            $("#form-delete").attr("action", url);
        });
        $(".btn-update").on("click", function() {
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
