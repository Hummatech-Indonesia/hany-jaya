@extends('dashboard.layouts.dashboard') @section('content')
    <div class="container-fluid">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Satuan</h4>
                        <p>List Satuan yang ada di toko anda.</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddSuplier">
                            Tambah Satuan
                        </button>
                        @include('dashboard.unit.widgets.modal-create')
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
        <div class="widget-content searchable-container list mt-4">
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <th>#</th>
                            <th>Kategori</th>
                            <td>Aksi</td>
                        </thead>
                        <tbody>
                            @forelse ($units as $index => $unit)
                                <tr class="search-items">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ $unit->name }}
                                        </h6>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <a class="dropdown-item btn-update" href="#"
                                                    data-unit="{{ $unit }}"
                                                    data-url="{{ route('admin.units.update', $unit->id) }}">
                                                    <i class="fs-4 ti ti-edit"></i>Edit
                                                </a>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <a class="dropdown-item btn-delete" href="#"
                                                    data-url="{{ route('admin.units.destroy', $unit->id) }}">
                                                    <i class="fs-4 ti ti-trash"></i>Delete
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <p>Kategori masih kosong</p>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $units->links() }}
                </div>
            </div>
        </div>
        @include('dashboard.unit.widgets.modal-update')

        <x-dialog.delete title="Hapus Satuan" />
    </div>
@endsection
@section('script')
    <script>
        $(".btn-update").on("click", function() {
            $("#modalUpdateUnit").modal("show");
            let url = $(this).attr("data-url");
            let unit = $(this).data("unit");

            $("#modalUpdateUnit").find("#input-name").val(unit.name);
            $("#form-update").attr("action", url);
        });
        $(".btn-delete").on("click", function() {
            $("#delete-modal").modal("show");

            let url = $(this).attr("data-url");
            $("#form-delete").attr("action", url);
        });
    </script>
@endsection
