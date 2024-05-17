@extends('dashboard.layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Kasir</h4>
                        <p>List kasir di toko anda.</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddCashier">
                            Tambah Kasir
                        </button>
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

        <div class="widget-content searchable-container list">
            <!-- --------------------- start Contact ---------------- -->
            <div class="card card-body">
                <div class="row">
                    <div class="col-md-4 col-xl-3">
                        <form class="position-relative">
                            <input type="text" class="form-control product-search ps-5" id="input-search"
                                placeholder="Search Contacts..." />
                            <i
                                class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>
                    </div>
                    <div
                        class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                        <div class="action-btn show-btn" style="display: none">
                            <a href="javascript:void(0)"
                                class="delete-multiple btn-light-danger btn me-2 text-danger d-flex align-items-center font-medium">
                                <i class="ti ti-trash text-danger me-1 fs-5"></i>
                                Delete All Row
                            </a>
                        </div>
                        <a href="javascript:void(0)" id="btn-add-contact" class="btn btn-info d-flex align-items-center">
                            <i class="ti ti-users text-white me-1 fs-5"></i> Add
                            Contact
                        </a>
                    </div>
                </div>
            </div>
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Aksi</th>
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
                                    <td>
                                        <div class="action-btn">
                                            <a href="#" data-url="{{ route('admin.cashiers.update', $cashier->id) }}"
                                                data-name="{{ $cashier->name }}" data-email="{{ $cashier->email }}"
                                                class="text-dark btn-edit ms-2">
                                                <i class="fs-4 ti ti-edit"></i>
                                            </a>
                                            <a href="#" data-url="{{ route('admin.cashiers.destroy', $cashier->id) }}"
                                                class="text-dark btn-delete ms-2">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                        </div>
                                    </td>
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
        $(".btn-delete").on("click", function() {
            $("#delete-modal").modal("show");

            let url = $(this).attr("data-url");
            $("#form-delete").attr("action", url);
        });
        $(".btn-edit").on("click", function() {
            $("#modalEditCashier").modal("show");


            let url = $(this).attr("data-url");
            let name = $(this).attr("data-name");
            let email = $(this).attr("data-email");
            $("#form-update").attr("action", url);
            $('#name').val(name);
            $('#email').val(email);
        });
    </script>
@endsection
