@extends('dashboard.layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Produk</h4>
                        <p>List produk yang ada di toko anda.</p>
                        <a href="{{ route('admin.products.create') }}">
                            <button type="button" class="btn btn-primary">
                                Tambah Produk
                            </button>
                        </a>
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
        <!--  Row 1 -->
        <div class="row mt-5">
            @forelse ($products as $product)
                <div class="col-lg-3">
                    <div class="card rounded-2 overflow-hidden hover-img">
                        <div class="position-relative">
                            <a href="javascript:void(0)">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                    class="card-img-top rounded-0 product-image" alt="..." height="150" />
                            </a>
                            @if ($product->quantity == 0)
                                <span
                                    class="badge bg-danger text-white fs-2 rounded-4 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0">Stok
                                    Habis</span>
                            @elseif($product->quantity <= 5)
                                <span
                                    class="badge bg-danger text-white fs-2 rounded-4 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0">Hampir
                                    Habis</span>
                            @endif
                        </div>
                        <div class="card-body px-4 py-3">
                            <div class="d-flex justify-content-between">
                                <span
                                    class="badge rounded-md bg-light-primary text-primary">{{ $product->category->name }}</span>
                                <p class="mb-0">{{ $product->quantity }} {{ $product->unit->name }}</p>
                            </div>
                            <a class="d-block my-2 fs-5 text-dark fw-semibold" href="#">{{ $product->name }}</a>
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" style="color: #5a6a85">
                                        <i class="fs-4 ti ti-edit"></i>Edit
                                    </a>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <a class="dropdown-item btn-delete" href="#"
                                        data-url="{{ route('admin.products.destroy', $product->id) }}">
                                        <i class="fs-4 ti ti-trash"></i>Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Produk Belum Tesedia</p>
            @endforelse
        </div>
        <x-dialog.delete title="Hapus Pemasok" />
    </div>
@endsection
@section('script')
    <script>
        $(".btn-delete").on("click", function() {
            $("#delete-modal").modal("show");

            let url = $(this).attr("data-url");
            $("#form-delete").attr("action", url);
        });
    </script>
@endsection
