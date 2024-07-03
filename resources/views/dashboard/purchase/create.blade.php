@extends('dashboard.layouts.dashboard') 
@push("title")
    Pembelian
@endpush
@section('content')
    <div class="container-fluid">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Pembelian</h4>
                        <p>Tambah pembelian pada toko anda.</p>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
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
                                    <label for="name" class="mb-2">Nama Pemasok <small class="text-danger">*</small></label>
                                    <select name="supplier_id" id="supplier_id" class="form-control">
                                        <option value="">Pilih Pemasok</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="mb-2">Kode Invoice <small class="text-danger">*</small></label>
                                    <input type="text" name="invoice_number" class="form-control" placeholder="HSN-2401" id="">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="alert alert-warning" role="alert">
                                        <strong>Informasi</strong>
                                        <ol class="mt-3">
                                            <li>
                                                Pembelian lebih dari satu produk
                                                hanya dapat dilakukan di pemasok
                                                yang sama.
                                            </li>
                                            <li>
                                                Ketika pemasok diganti, maka
                                                seluruh produk yang telah dimasukkan
                                                akan dihapus.
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="education_fields" class="my-1"></div>
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label class="mb-2" for="product_id" style="font-size: 0.8rem">Pilih
                                            Produk <small class="text-danger">*</small></label>
                                        <select name="product_id[]" class="select_product form-control" id="">
                                            <option value="">Pilih Produk</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label class="mb-2" for="product_unit_id" style="font-size: 0.8rem">Pilih
                                            Satuan <small class="text-danger">*</small></label>
                                        <select name="product_unit_id[]" class="form-control" id="product_unit_id">
                                            <option value="Pilih Satuan">
                                                Pilih Satuan
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label class="d-flex gap-2 align-items-center mb-2" style="font-size: 0.8rem">Harga
                                            Beli per Satuan <small class="text-danger">*</small></label>
                                        <input type="number" class="form-control price-per-unit" id="Age"
                                            name="buy_price_per_unit[]" placeholder="10" />
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label class="d-flex gap-2 align-items-center mb-2" style="font-size: 0.8rem">Jumlah
                                            Pembelian <small class="text-danger">*</small></label>
                                        <input type="number" class="form-control quantity" id="Age" name="quantity[]"
                                            placeholder="10" />
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label class="mb-2" for="" style="font-size: 0.8rem">Total Harga
                                        Pembelian <small class="text-danger">*</small></label>
                                    <div class="mb-3">
                                        <input readonly name="buy_price[]" type="number" class="form-control"
                                            value="0" />
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="" style="margin-top: 1.35rem">
                                        <button id="add_click"
                                            class="btn btn-success font-weight-medium waves-effect waves-light mt-2"
                                            type="button">
                                            <i class="ti ti-circle-plus fs-5"></i>
                                        </button>
                                    </div>
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
    @endsection @section('script')
    @include('dashboard.purchase.widgets.repeater')
    <script>
        $(document).ready(function() {
            $(".select_product").change(function() {
                var productId = $(this).val();
                $.ajax({
                    url: `{{ route('admin.product.unit.index', ['product' => '']) }}/${productId}`,
                    type: "GET",
                    success: function(response) {
                        console.log(response);
                        $("#product_unit_id").empty();
                        $("#product_unit_id").append(
                            '<option value="">Pilih Satuan</option>'
                        );
                        response.data.forEach(function(item) {
                            $("#product_unit_id").append(
                                `<option value="${item.id}">${item.unit}</option>`
                            );
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    },
                });
            });
        });

        $(document).ready(function() {
            $("#supplier_id").change(function() {
                // clear form cart
                $(".form-repeater").remove();
                $("#product_unit_id").empty();
                $("#product_unit_id").append(
                    '<option value="">Pilih Satuan</option>'
                );
                $("input[name='buy_price_per_unit[]']").val("");
                $("input[name='quantity[]']").val("");
                $("input[name='buy_price[]']").val("");

                var supplierId = $(this).val();
                $.ajax({
                    url: `{{ route('admin.supplier.product.index', ['supplier' => '']) }}/${supplierId}`,
                    type: "GET",
                    success: function(response) {
                        $(".select_product").empty();
                        $(".select_product").append(
                            '<option value="">Pilih Produk</option>'
                        );
                        response.data.forEach(function(item) {
                            $(".select_product").append(
                                `<option value="${item.product_id}">${item.product}</option>`
                            );
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    },
                });
            });

            $(".price-per-unit").on("input", function() {
                var pricePerUnit = $(this).val();
                var quantity = $(this)
                    .parent()
                    .parent()
                    .parent()
                    .find(".quantity")
                    .val();
                var totalPrice = pricePerUnit * quantity;
                $(this)
                    .parent()
                    .parent()
                    .parent()
                    .find('input[name="buy_price[]"]')
                    .val(totalPrice);
            });

            $(".quantity").on("input", function() {
                var quantity = $(this).val();
                var pricePerUnit = $(this)
                    .parent()
                    .parent()
                    .parent()
                    .find(".price-per-unit")
                    .val();
                var totalPrice = pricePerUnit * quantity;
                $(this)
                    .parent()
                    .parent()
                    .parent()
                    .find('input[name="buy_price[]"]')
                    .val(totalPrice);
            });
        });
    </script>
@endsection
