@php
    use App\Enums\StatusEnum;
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.cashier1')
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="mt-3">
        <div>
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
        <form action="{{ route('cashier.selling.store') }}" method="post">
            @csrf
            <div class="row rounded">
                <div class="col-12 col-md-4">
                    <div class="rounded shadow border p-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <h5>Kasir:</h5>
                            <p>{{ FormatedHelper::dateTimeFormat(now()) }}</p>
                        </div>
                        <h3 class="m-0">{{ auth()->user()->name }} ({{ auth()->user()->email }})</h3>
                    </div>
                    <div class="card shadow mb-3">
                        <div class="card-body px-3">
                            <h5>Pembeli:</h5>
                            <div class="form-group mb-2">
                                <label for="cust-name">Nama</label>
                                <div>
                                    <select name="name" class="form-control" id="cust-name">
                                        <option value="">Pilih Pembeli</option>
                                        @foreach ($buyers as $buyer)
                                            <option value="{{ $buyer->name }}" data-address="{{ $buyer->address }}" data-id="{{$buyer->id}}">{{ $buyer->name }} - {{ $buyer->address }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="cust-address">Alamat</label>
                                <input type="text" name="address" placeholder="Alamat Pembeli" class="form-control" id="cust-address">
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-3">
                        <div class="card-body px-3">
                            <h5>Pembayaran:</h5>
                            <div class="form-group mb-3">
                                <label>Metode</label>
                                <div class="d-flex flex-row gap-3">
                                    <div>
                                        <input type="radio" value="{{ StatusEnum::CASH->value }}" name="status_payment" id="tunai" class="me-2" selected>
                                        <label for="tunai">Tunai</label>
                                    </div>
                                    <div>
                                        <input type="radio" value="{{ StatusEnum::DEBT->value }}" name="status_payment" id="hutang" class="me-2">
                                        <label for="hutang">Hutang</label>
                                    </div>
                                </div>
                            </div>
                            <div id="cash">
                                <label for="pay" class="mb-2">Bayar: </label>
                                <input type="hidden" id="pay" name="pay">
                                <input type="hidden" id="return" name="return">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                    <input type="text" placeholder="10000" min="0" id="formatted_pay" class="form-control format-number" aria-describedby="basic-addon1">
                                </div>
                                <label for="return" class="mb-2">Kembali: </label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                    <input type="text" min="0" placeholder="5000" id="formatted_return" class="form-control" aria-describedby="basic-addon1" readonly>
                                </div>
                            </div>
                            <div id="code_debt">
                                <label for="">Masukkan Kode Toko: </label>
                                <input type="text" class="form-control" name="code_debt"
                                    id="">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-100 btn btn-lg btn-success">Bayar</button>
                </div>
                <div class="col-12 col-md-8">
                    <div class="bg-primary rounded p-3 mb-3 shadow">
                        <h5 class="text-light">Total:</h5>
                        <h3 class="text-light" id="total_price">Rp 0</h3>
                    </div>
                    <div class="card shadow border">
                        <div class="card-body">
                            <h5>Produk</h5>
                            <div class="row mb-3">
                                <div class="col-10">
                                    <div>
                                        <select id="product-code" class="select-product form-control">
                                            @foreach ($products as $product)
                                                <option value="" selected disabled>Pilih produk</option>
                                                <option value="{{ $product->code }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-primary" type="button" disabled id="btn-add-product">+ Tambah</button>
                                </div>
                            </div>
                            <div class="table-responsive border rounded">
                                <table class="table text-nowrap">
                                    <thead>
                                        <tr class="fs-4 fw-semibold">
                                            <th>Produk</th>
                                            <th>Stok</th>
                                            <th>Satuan</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tb-product">
                                        <tr>
                                            <th colspan="7" class="text-center text-muted">-- belum ada produk dipilih --</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#cust-name').select2({
                tags: true,
                placeholder: "Pilih atau tambahkan pembeli"
            })

            $('#product-code').select2({
                placeholder: "Pilih produk"
            })

            $(document).on('change input', '#cust-name', function() {
                if ($(this).val()) {
                    $('#productPage').removeClass('d-none');
                    $('#btn-add-product').removeAttr('disabled');
                } else {
                    $('#productPage').addClass('d-none');
                    $('#btn-add-product').attr('disabled', 'disabled');
                }

                let address = $(this).find(':selected').data('address')
                $('#cust-address').val(address)

                changeAllProductLastPrice()
            });

            $(document).on('change input', '#cust-address', function() {
                changeAllProductLastPrice()
            })

            $(document).on('click', '#btn-add-product', function() {
                const product_code = $('#product-code').val()
                if(!product_code) return;

                $.ajax({
                    url: "{{ route('cashier.show.product') }}",
                    type: "GET",
                    data: {
                        code: product_code
                    },
                    dataType: 'json',
                    success: async function(response) {
                        var product_units = '';
                        var selected_price = 0;
                        $('#tb-product tr th').parent().remove()
                        var latest_index = $('#tb-product tr[data-index]').last().data('index')
                        var current_index = latest_index ? latest_index+1 : 1
                        var product_unit_id = 0

                        $.each(response.data.product_units, function(index, productUnit) {
                            var selected = response.data.unit.name === productUnit.unit.name ? 'selected' : '';

                            if(selected == 'selected') product_unit_id = productUnit.id
                            product_units += `
                                <option value="${productUnit.id}" data-unit="${productUnit.unit.name}" id="selling-price-${productUnit.id}" data-selling-price="${productUnit.selling_price}" data-quantity-in-small-unit="${productUnit.quantity_in_small_unit}" data-quantity="${response.data.quantity}" ${selected}>
                                    ${productUnit.unit.name}
                                </option>`;
                                                    
                            if(response.data.unit.name === productUnit.unit.name) selected_price = productUnit.selling_price
                        });

                        const latest_price = await getLatestBuy($('#cust-name').val(), $('#cust-address').val(), product_unit_id)

                        var newRow = `
                            <tr data-index="${current_index}">
                                <td>
                                    <h6 class="fs-4 fw-semibold mb-0 text-start">
                                        ${response.data.name}
                                    </h6>
                                    <input type="hidden" name="product_id[]" value="${response.data.id}"/>
                                    <input type="hidden" name="quantity[]" value="1"/>
                                    <input type="hidden" name="product_unit_price[]" value="${selected_price}"/>
                                    <input type="hidden" name="selling_price[]" value="${selected_price}"/>
                                </td>
                                <td>
                                    <h6 class="fs-4 fw-semibold mb-0 text-start">
                                        <span class="stock">${Math.round(response.data.quantity)}</span> <span class="quantity_stock">${response.data.unit.name}</span>
                                    </h6>
                                </td>
                                <td>
                                    <select name="product_unit_id[]" class="form-control product-unit">
                                        ${product_units}
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="formatted_quantity[]" class="form-control format-number input-quantity" placeholder="Jumlah" min="1" value="1" />
                                </td>
                                <td>
                                    <input type="text" value="${formatNum(selected_price, true)}" name="formatted_product_unit_price[]" class="form-control format-number input-unit-price" />
                                    ${latest_price ? `<div class="text-primary last_price">Rp. ${formatNum(latest_price)}</div>` : '' }
                                </td>
                                <td>
                                    <input type="text" value="${formatNum(selected_price, true)}" name="formatted_selling_price[]" class="form-control format-number input-selling-price" readonly />
                                </td>
                                <td>
                                    <button type="button" data-id="${current_index}" class="btn btn-danger delete_product"><i class="ti ti-trash"></i></button>
                                </td>
                            </tr>`;
                        $('#tb-product').append(newRow);

                        changeTotalPrice();
                    },
                });
            })

            $(document).on('input', '.format-number', function() {
                var value = unformatNum($(this).val())
                if(value < 0) $(this).val(0)
                $(this).val(formatNum($(this).val()))
            })

            $(document).on('input change', '.input-quantity', function() {
                const data_index = $(this).parent().parent().data('index')
                const qty_el = $(`#tb-product tr[data-index=${data_index}] [name=quantity\\[\\]]`)
                qty_el.val(unformatNum($(this).val()))
                changeTotalPrice()
            })

            $(document).on('input change', '.input-unit-price', function() {
                const data_index = $(this).parent().parent().data('index')
                const price_el = $(`#tb-product tr[data-index=${data_index}] [name=product_unit_price\\[\\]]`)
                price_el.val(unformatNum($(this).val()))
                changeTotalPrice()
            })

            $('#tb-product').on('change', '.product-unit', async function() {
                var row = $(this).closest('tr');
                var selected = $(this).find(':selected')
                var selectedPrice = selected.data('selling-price');
                var quantity_in_small_unit = selected.data('quantity-in-small-unit');
                var quantity = selected.data('quantity');
                var unit = selected.data('unit');
                var stock = Math.round(quantity / quantity_in_small_unit);
                row.find('.stock').html(stock);
                row.find('.quantity_stock').html(unit);
                var quantity = row.find('.quantity').val();
                row.find('.input-unit-price').val(formatNum(selectedPrice));
                row.find('[name=product_unit_price\\[\\]]').val(selectedPrice);

                let last_price_el = row.find('.last_price')
                let cust_name = $('#cust-name').val()
                let cust_address = $('#cust-address').val()
                let product_unit_id = row.find('.product-unit').val()

                const latest_price = await getLatestBuy(cust_name, cust_address, product_unit_id)
                if(latest_price) {
                    if(last_price_el.length < 1) {
                        row.find('.input-unit-price').parent().append(`<div class="text-primary last_price">Rp ${formatNum(latest_price)}</div>`)
                    } else {
                        last_price_el.html('Rp '+formatNum(latest_price))
                    }
                } else if(!latest_price && last_price_el.length > 0) {
                    last_price_el.remove()
                }
                changeTotalPrice();
            });

            $(document).on('input change', '#formatted_pay', changeReturnAmount)

            $(document).on('click', '.delete_product', function() {
                let tr = $(this).parent().parent().remove()
                changeTotalPrice()
            })

            async function getLatestBuy(buyer_name, buyer_address, product_unit_id) {
                const obj_price = await axios.get(`{{ route('transaction.find-by-user-product') }}?buyer_name=${buyer_name}&buyer_address=${buyer_address}&product_unit_id=${product_unit_id}`)
                return (obj_price.data && obj_price.data.data) ? obj_price.data.data.product_unit_price : 0
            }

            function changeAllProductLastPrice() {
                const cust_name = $('#cust-name').val()
                const cust_address = $('#cust-address').val()
                $('#tb-product tr[data-index]').each(async function(index) {
                    const product_unit_id = $(this).find('.product-unit').val();
                    const latest_price = await getLatestBuy(cust_name, cust_address, product_unit_id)
                    const last_price_el = $(this).find('.last_price')
                    if(latest_price) {
                        if(last_price_el.length < 1) {
                            $(this).find('.input-unit-price').parent().append(`<div class="text-primary last_price">Rp ${formatNum(latest_price)}</div>`)
                        } else {
                            last_price_el.html('Rp '+formatNum(latest_price))
                        }
                    } else if(!latest_price && last_price_el.length > 0) {
                        last_price_el.remove()
                    }
                })
            }

            function changeTotalPrice() {
                const all_products = $('#tb-product tr[data-index]')
                let all_total = 0;
                all_products.each(function(index, product) {
                    const qty = $(this).find('[name=quantity\\[\\]]').val()
                    const price = $(this).find('[name=product_unit_price\\[\\]]').val()
                    const total = qty * price
                    all_total += total
                    $(this).find('[name=selling_price\\[\\]]').val(total)
                    $(this).find('.input-selling-price').val(formatNum(total))
                })

                $('#total_price').html('Rp '+formatNum(all_total))
                changeReturnAmount()
            }

            function changeReturnAmount() {
                var totalPrice = unformatNum($('#total_price').text().replace('Rp ', ''));
                var pay = unformatNum(formatNum($('#formatted_pay').val()));
                $('#pay').val(pay)
                var returnAmount = pay - totalPrice;
                if (!isNaN(returnAmount) && returnAmount >= 0) {
                    $('#return').val(returnAmount);
                    $('#formatted_return').val(formatNum(returnAmount));
                } else {
                    $('#return').val(0);
                    $('#formatted_return').val(0);
                }
            }

            $('#cash').hide();
            $('#code_debt').hide();

            $('input[name="status_payment"]').change(function() {
                if ($(this).val() === "{{ StatusEnum::CASH->value }}") {
                    $('#cash').show();
                    $('#code_debt').hide();
                } else {
                    $('#cash').hide();
                    $('#code_debt').show();
                }
            });
        })
    </script>
@endsection