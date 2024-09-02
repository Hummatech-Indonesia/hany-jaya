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
                                <div class="col-md-6 mb-3">
                                    <label for="method" class="mb-2">Metode Pembayaran <small class="text-danger">*</small></label>
                                    <select name="method" id="method" class="form-select">
                                        <option value="" selected disabled>Pilih Metode Pembayaran</option>
                                        <option value="cash">Tunai</option>
                                        <option value="debt">Hutang</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3" id="method-debt">
                                    <label for="tempo" class="mb-2">Jatuh Tempo <small class="text-danger">*</small></label>
                                    <input type="date" name="tempo" class="form-control" placeholder="Tanggal Jatuh Tempo Pembayaran" id="tempo">
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
                                <div class="table-responsive">
                                    <table class="table text-break" style="min-width: 1000px">
                                        <thead>
                                            <tr>
                                                <th style="width:200px">Produk <span class="text-danger">*</span></th>
                                                <th style="width:250px">Harga Jual</th>
                                                <th style="width:250px">Harga per satuan <span class="text-danger">*</span></th>
                                                <th style="width:150px">Jumlah <span class="text-danger">*</span></th>
                                                <th style="width:250px">Total Harga <span class="text-danger">*</span></th>
                                                <th style="width:100px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody  id="tb-products">
                                            <tr>
                                                <th colspan="6" class="text-center text-muted text-bold">-- belum ada produk dipilih --</th>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th id="all_total_price">Rp 0</th>
                                                <th colspan="4"></th>
                                            </tr>
                                        </tfoot>
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
    <link rel="stylesheet" href="{{asset('assets/libs/selectize/selectize.bootstrap5.min.css')}}"/>
@endsection
@include('components.swal-toast')
@section('script')
    <script src="{{asset('assets/libs/selectize/selectize.min.js')}}"></script>
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

            $(document).on('change', '#method', function() {
                checkPayMethod()
            })
            checkPayMethod()

            function checkPayMethod() {
                const method = $('#method').val()
                if(method == 'debt') {
                    $('#method-debt').show()
                } else {
                    $('#method-debt').hide()
                }
            }

            $(document).on('click', 'button[type=submit]', function() {
                $('button[type=submit]').addClass('disabled')
            })

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
                        Toaster('success', response.meta.message)
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON.message)
                        Toaster('error', xhr.responseJSON.message)
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
                const method = $('#method').val()

                let error_count = 0

                if(!supplier) error_count++
                if(!invoice) error_count++
                if(!method) error_count++
                if(method == 'debt' &&!$('#tempo').val()) error_count++

                return error_count
            }
            
            $(document).on("click", "#btn-add-product", function () {
                if(isCantAddProduct()) {
                    Toaster('error', 'Distributor, invoice, dan pembayaran tidak boleh kosong')
                    return;
                }
                let last_index = $('#tb-products tr[data-index]').last().data('index')

                let current_index = last_index ? last_index+1 : 1
                
                let str_products = '<option value="" selected disabled>-- pilih produk --</option>'
                product_list.forEach((data) => {
                    str_data = JSON.stringify(data).replaceAll('"', "'")
                    str_products += `<option value="${data.id}" data-product="${str_data}">${data.name} | ${data.code} | ${formatNum(data.quantity, true)} ${data.unit.name}</option>`
                })

                let new_tr = `
                    <tr data-index="${current_index}">
                        <td>
                            <select name="product_id[]" style="width:200px" class="select_product form-select" required>${str_products}</select>
                            <input type="hidden" name="buy_price_per_unit[]" required />
                            <input type="hidden" name="quantity[]" required />
                            <input type="hidden" name="buy_price[]" required />
                            <select name="product_unit_id[]" class="form-select d-none" id="product_unit" required>
                                <option value="" selected disabled>-- pilih satuan --</option>
                            </select>
                        </td>
                        <td>
                            <div class="form-control border-0 sell_price">Rp 0</div>
                        </td>
                        <td>
                            <input 
                                type="text" class="form-control format-number price-per-unit"
                                placeholder="Harga beli persatuan" required/>
                            <div class="price-per-unit-alert" style="display: none;">
                                <span class="text-danger fs-3">lebih dari harga jual </span>
                                <a href="#" target="_blank" class="fs-3">produk</a>
                            </div>
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

                $(`tr[data-index=${current_index}] .price-per-unit`).tooltip()

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
                        let edit_url = "{{ route('admin.products.edit', 'selected_id') }}"
                        edit_url = edit_url.replace('selected_id', val)
                        $(this['$input'][0].closest('[data-index]')).find('.price-per-unit').attr('data-price', 0)
                        $(this['$input'][0].closest('[data-index]')).find('.price-per-unit price-per-unit-alert a').attr('href', edit_url)
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
                    onChange: function (val) {
                        let item = this.options[val]
                        if(item) $(this['$input'][0].closest('[data-index]')).find('.price-per-unit').attr('data-price', item.price)
                        if(item) $(this['$input'][0].closest('[data-index]')).find('.sell_price').html('Rp '+formatNum(item.price, true))
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

                select_unit_list[index-1].setValue('')
                select_unit_list[index-1].clearOptions()
                
                $.ajax({
                    url: `{{ route('admin.product.unit.index', ['product' => '']) }}/${productId}`,
                    type: "GET",
                    success: function(response) {
                        let selected_value
                        response.data.forEach(function(item, index) {
                            if(index === 0) selected_value = item.id
                            options.push({
                                value: item.id,
                                text: item.unit,
                                price: item.price
                            })
                        });

                        select_unit_list[index-1].addOption(options)
                        select_unit_list[index-1].setValue(selected_value)
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
                if(unformatNum($(this).val()) > parseFloat($(this).attr('data-price'))) {
                    $(this).closest('tr').find('.price-per-unit-alert').show()
                    $(this).addClass('is-invalid')
                } else {
                    $(this).closest('tr').find('.price-per-unit-alert').hide()
                    $(this).removeClass('is-invalid')
                }
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

                changeAllTotal()
            }

            function changeAllTotal() {
                let total = 0

                $('#tb-products tr[data-index]').each(function() {
                    total += unformatNum($(this).find('.buy-price').val())
                })

                $('#all_total_price').html('Rp '+formatNum(total, true))
            }

        })
    </script>
@endsection
