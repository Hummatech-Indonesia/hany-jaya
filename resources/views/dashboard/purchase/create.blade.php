@extends('dashboard.layouts.dashboard') 
@push("title")
    Pembelian
@endpush
@section('content')
    @include('components.swal-message')
    <div class="container-fluid max-w-full">
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
                                    <label for="name" class="mb-2">Nama Distributor <small class="text-danger">*</small></label>
                                    <select name="supplier_id" id="supplier_id" class="form-control">
                                        <option value="">Pilih Distributor</option>
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
                                                hanya dapat dilakukan di distributor
                                                yang sama.
                                            </li>
                                            <li>
                                                Ketika distributor diganti, maka
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
                                <div>
                                    <table class="table align-middle text-break">
                                        <thead>
                                            <tr>
                                                <th width="300">Produk <span class="text-danger">*</span></th>
                                                <th width="150">Satuan <span class="text-danger">*</span></th>
                                                <th width="150">Harga per satuan <span class="text-danger">*</span></th>
                                                <th width="150">Jumlah <span class="text-danger">*</span></th>
                                                <th width="250">Total Harga <span class="text-danger">*</span></th>
                                                <th width="50">Aksi</th>
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
                            <div class="d-flex mt-3 gap-3">
                                <a href="{{route('admin.purchases.index')}}" class="btn btn-light">Kembali</a>
                                <button class="btn btn-info rounded-md px-4" type="submit">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.min.css"/>
@endsection
@include('components.swal-toast')
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script>
        $(document).ready(function() {
            let product_list = []
            let select_product_list = []
            let select_unit_list = []
            
            const selectize_supplier = $('#supplier_id').selectize({
                plugins: [],
                create: true,
                maxItems: 1,
                placeholder: "Pilih Distributor",
                onOptionAdd: function(value) {
                    let selected = this.options[value]
                    let text_str = selected.text.replace(/\s+/g, ' ').trim();
                    if(text_str == selected.value) createNewSupplier(value)
                },
            })
            const select_supplier = selectize_supplier[0].selectize

            function createNewSupplier(val) {
                $.ajax({
                    url: `{{ route('admin.supplier.store.ajax') }}`,
                    method: "POST",
                    data: {
                        name: val,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        select_supplier.updateOption(
                            val,
                            {
                                value: response.data.id,
                                text: response.data.name
                            }
                        )
                        select_supplier.setValue('')
                        select_supplier.setValue(response.data.id)
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON.message)
                    },
                });
            }

            $.ajax({
                url: `{{ route('product.list-search') }}`,
                type: "GET",
                success: function(response) {
                    product_list = response.data
                },
                error: function(xhr) {
                    product_list = [];
                },
            });


            function isCantAddProduct() {
                const supplier = select_supplier.getValue()
                const invoice = $('[name=invoice_number]').val()
                if(supplier && invoice) return 0
                return 1
            }
            
            $(document).on("click", "#btn-add-product", function () {
                if(isCantAddProduct()) {
                    Toaster('error', 'Supplier dan Kode Invoice harus diisi terlebih dahulu')
                    return;
                }
                let last_index = $('#tb-products tr[data-index]').last().data('index')

                let current_index = last_index ? last_index+1 : 1
                
                let str_products = '<option value="" selected disabled>-- pilih produk --</option>'
                product_list.forEach((data) => {
                    str_products += `<option value="${data.id}">${data.name} | ${data.code} | ${formatNum(data.quantity, true)} ${data.unit.name}</option>`
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

                select_product_list.push({})
                select_unit_list.push({})

                setSelectizeProduct(current_index-1)
                setSelectizeUnit(current_index-1)
            });

            function setSelectizeProduct(index) {
                const tr = $('#tb-products > tr[data-index]').last()
                const selectize_product = tr.find('.select_product').selectize({
                    create: false,
                    maxItems: 1,
                    placeholder: "Pilih Produk",
                    onChange: function(val) {
                        $(this['$input'][0].closest('[data-index]')).find('.price-per-unit').attr('data-price', 0)
                    }
                })

                const select_product = selectize_product[0].selectize
                select_product_list[index] = select_product
            }
            function setSelectizeUnit(index) {
                const tr = $('#tb-products > tr[data-index]').last()
                const selectize_unit = tr.find('#product_unit').selectize({
                    create: false,
                    maxItems: 1,
                    placeholder: "Pilih Satuan",
                    onChange: function (val) {
                        let item = this.options[val]
                        console.log(this['$input'][0].closest('[data-index]'))
                        $(this['$input'][0].closest('[data-index]')).find('.price-per-unit').attr('data-price', item.price)
                    }
                })

                const select_unit = selectize_unit[0].selectize
                select_unit_list[index] = select_unit
            }

            $(document).on("click", ".btn-delete", function() {
                $(this).parent().parent().remove()
            })

            $(document).on("change", ".select_product", function() {
                let index = $(this).closest('tr').data('index')
                let productId = $(this).val();
                let options = []
                let unit_input = $(this).parent().parent().find('#product_unit')
                
                $.ajax({
                    url: `{{ route('admin.product.unit.index', ['product' => '']) }}/${productId}`,
                    type: "GET",
                    success: function(response) {
                        response.data.forEach(function(item) {
                            options.push({
                                value: item.id,
                                text: item.unit,
                                price: item.price
                            })
                        });

                        select_unit_list[index-1].clear()
                        select_unit_list[index-1].clearOptions()
                        select_unit_list[index-1].addOption(options)
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
                if(unformatNum($(this).val()) > $(this).data('price')) Toaster('warning', 'Harga pembelian lebih mahal dari penjualan')
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
