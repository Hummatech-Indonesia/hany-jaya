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

                            <div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-bold">Produk</div>
                                    <button type="button" class="btn btn-success" id="btn-add-product">+ Tambah</button>
                                </div>
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>Produk <span class="text-danger">*</span></th>
                                                <th>Satuan <span class="text-danger">*</span></th>
                                                <th>Harga per satuan <span class="text-danger">*</span></th>
                                                <th>Jumlah <span class="text-danger">*</span></th>
                                                <th>Total Harga <span class="text-danger">*</span></th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody  id="tb-products">
                                            <tr>
                                                <th colspan="5" class="text-center text-muted text-bold">-- belum ada produk dipilih --</th>
                                            </tr>
                                        </tbody>
                                    </table>
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
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script>
        $(document).ready(function() {
            let product_list = []
            $(document).on('change', '#supplier_id',function() {
                $.ajax({
                    url: `{{ route('admin.supplier.product.index', ['supplier' => '']) }}/${$('#supplier_id').val()}`,
                    type: "GET",
                    success: function(response) {
                        product_list = response.data
                    },
                    error: function(xhr) {
                        product_list = [];
                    },
                });
            })
            
            $(document).on("click", "#btn-add-product", function () {
                if(!$('#supplier_id').val()) return;
                let last_index = $('#tb-products tr[data-index]').last().data('index')

                let current_index = last_index ? last_index+1 : 1
                
                let str_products = '<option value="" selected disabled>-- pilih produk --</option>'
                product_list.forEach((data) => {
                    str_products += `<option value="${data.product_id}">${data.product}</option>`
                })

                let new_tr = `
                    <tr data-index="${current_index}">
                        <td>
                            <select name="product_id[]" class="select_product form-select" required>${str_products}</select>
                            <input type="hidden" name="buy_price_per_unit[]" required />
                            <input type="hidden" name="quantity[]" required />
                            <input type="hidden" name="buy_price[]" required />
                        </td>
                        <td>
                            <select name="product_unit_id[]" class="form-select" id="product_unit" required>
                                <option value="" selected disabled>-- pilih satuan --</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control format-number price-per-unit" placeholder="Harga beli persatuan" required/>
                        </td>
                        <td>
                            <input type="text" class="form-control format-number quantity" placeholder="Jumlah dibeli" required/>
                        </td>
                        <td>
                            <input type="text" class="form-control format-number buy-price" placeholder="Jumlah dibeli" readonly required/>
                        </td>
                        <td><button type="button" class="btn btn-danger btn-delete">-</button></td>
                    </tr>
                `

                if(last_index) {
                    $('#tb-products').append(new_tr)
                } else {
                    $('#tb-products').html(new_tr)
                }
            });

            $(document).on("click", ".btn-delete", function() {
                $(this).parent().parent().remove()
            })

            $(document).on("change", ".select_product", function() {
                let productId = $(this).val();
                let options = `<option value="" disabled selected>-- pilih satuan --</option>`
                let unit_input = $(this).parent().parent().find('#product_unit')
                
                $.ajax({
                    url: `{{ route('admin.product.unit.index', ['product' => '']) }}/${productId}`,
                    type: "GET",
                    success: function(response) {
                        response.data.forEach(function(item) {
                            options += `<option value="${item.id}">${item.unit}</option>`
                        });
                        unit_input.html(options)
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    },
                });
            });

            $(document).on("input", ".format-number", function() {
                if(unformatNum($(this).val()) < 0) $(this).val(0)
                else $(this).val(formatNum($(this).val()))
            })

            $(document).on("input", ".price-per-unit", function() {
                let unformat_input = $(this).parent().parent().find('[name=buy_price_per_unit\\[\\]]')
                unformat_input.val(unformatNum($(this).val()))
                changeTotal($(this))
            })
            $(document).on("input", ".quantity", function() {
                let unformat_input = $(this).parent().parent().find('[name=quantity\\[\\]]')
                unformat_input.val(unformatNum($(this).val()))
                changeTotal($(this))
            })
            function changeTotal(el) {
                let tr = el.parent().parent()
                let price = unformatNum(tr.find(".price-per-unit").val())
                let qty = unformatNum(tr.find(".quantity").val())
                let total = price * qty
                tr.find('[name=buy_price\\[\\]]').val(total)
                tr.find('.buy-price').val(formatNum(total))
            }
        })
    </script>
@endsection
