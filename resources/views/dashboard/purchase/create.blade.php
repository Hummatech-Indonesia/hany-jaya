@extends('dashboard.layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Pembelian</h4>
                        <p>Tambah pembelian pada toko anda.</p>
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
        <!--  Row 1 -->
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card">
                    <div class="border-bottom title-part-padding">
                        <h4 class="card-title mb-0">Tambah Pembelian</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.purchases.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name">Nama Produk</label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option value="">Pilih Produk</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name">Nama Supplier</label>
                                    <select name="supplier_id" id="supplier_id" class="form-control">
                                        <option value="">Pilih Supplier</option>
                                        <option value="" id="supplier_id"></option>
                                    </select>
                                    @error('supplier_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name">Total Pembelian</label>
                                    <input type="number" name="quantity" id="" class="form-control"
                                        placeholder="20">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name">Harga Beli</label>
                                    <input type="number" name="buy_price" id="" class="form-control"
                                        placeholder="20.000">
                                </div>
                            </div>
                            <button class="btn btn-info rounded-md px-4 mt-3" type="submit">
                                Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#product_id').change(function() {
                console.log(productId);
                $.ajax({
                    url: `{{ route('admin.supplier.product.index', ['product' => '']) }}/${productId}`,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        $('#supplier_id')
                            .empty();
                        $('#supplier_id').append(
                            '<option value="">Pilih Supplier</option>'
                        );
                        response.data.forEach(function(item) {
                            $('#supplier_id').append(
                                `<option value="${item.supplier_id}">${item.supplier}</option>`
                            );
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
