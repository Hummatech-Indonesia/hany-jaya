@extends('dashboard.layouts.dashboard')
@push("title")
    Produk
@endpush
@section('content')
    <div class="container-fluid">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Produk</h4>
                        <p>List produk yang ada di toko anda.</p>
                        @role('admin')
                            <a href="{{ route('admin.products.create') }}">
                                <button type="button" class="btn btn-primary">
                                    Tambah Produk
                                </button>
                            </a>
                        @endrole
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
        {{-- <div class="row">
            <div class="col-12">
                <form action="" method="get">
                    <div class="d-flex flex-row gap-2 justify-content-end">
                        <div class="col-md-4 col-sm-6">
                            <input type="text" name="name" value="{{ Request::get('name') }}" class="form-control"
                                id="nametext" aria-describedby="name" placeholder="Name" />
                        </div>
                        <button type="submit" class="btn btn-primary">Cari</button>
                        
                    </div>
                </form>
            </div>
        </div> --}}
        <!--  Row 1 -->

        <div class="table-responsive">
            <table class="table align-middle table-striped table-hover" id="product-table">
            </table>
        </div>
        <x-dialog.delete title="Hapus Pemasok" />
    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.css">
@endsection
@section('script')
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.js"></script>
    <script>
        
        $(document).ready(function() {
            let product_datatable = $('#product-table').DataTable({
                processing: true,
                serverSide: true,
                order: [[2, 'asc']],
                language: {
                    processing: `Memuat...`
                },
                ajax: {
                    url: "{{ route('data-table.list-product') }}",
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        title: "No",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "image",
                        title: "Gambar",
                        orderable: false,
                        searchable: false,
                        render: (data, type, row) => {
                            return `<img src="{{ asset('storage') }}/${data}" alt="gambar produk" class="rounded" style="width: 75px;height: 75px;object-fit: cover"/>`
                        }
                    }, {
                        data: "name",
                        title: "Nama",
                    }, {
                        mRender: (data, type, full) => {
                            return full['quantity']+" "+full["unit"]["name"];
                        },
                        title: "Stok",
                    }, {
                        data: "category.name",
                        title: "Kategori"
                    }, {
                        mRender: (data, type, full) => {
                            let url_edit = "{{ route('admin.products.edit', 'selected_id') }}"
                            let url_destroy = "{{ route('admin.products.destroy', 'selected_id') }}"
                            url_edit = url_edit.replace('selected_id', full['id'])
                            url_destroy = url_destroy.replace('selected_id', full['id'])

                            return `<div class="d-flex gap-2">
                                <a href="${url_edit}" class="btn btn-light btn-sm btn-update-icon"><i class="fs-4 ti ti-edit"></i></a>
                                <button data-url="${url_destroy}" class="btn btn-delete btn-light btn-delete-icon btn-sm"><i class="fs-4 ti ti-trash"></i></button>
                            </div>`
                        },
                        title: "Aksi",
                        width: "15%",
                    }
                ]
            })

            $(document).on("click", '.btn-delete', function() {
                $("#delete-modal").modal("show");
    
                let url = $(this).attr("data-url");
                $("#form-delete").attr("action", url);
            });
        })
    </script>
@endsection
