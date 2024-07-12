@php
    use App\Enums\StatusEnum;
    use App\Helpers\FormatedHelper;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>

    <title>Hany Jaya - Kasir</title>
    <!--  Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--  Favicon -->
    <link rel="shortcut icon" type="image/png"
        href="{{asset('favicon.png')}}" />
    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/dist/assets/owl.carousel.min.css') }}" />

    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.min.css"/>
    <link rel="stylesheet" href="{{asset('assets/libs/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/libs/sweetalert2/dist/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/icons.css')}}">
    <style>
        .form-control:focus, .form-check-input:focus {
            box-shadow:0 0 0 .25rem rgba(93,135,255,.25)!important
        }
        .max-w-full {
            max-width: 100%!important;
        }
        .bootstrap-switch-wrapper {
            margin-bottom: 0;
        }
    </style>
</head>
<body  style="background: rgb(241 245 249)">
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('favicon.ico') }}"
            alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-theme="blue_theme">
        {{-- @include('dashboard.layouts.sidebar-cashier') --}}
            <!--  Main wrapper -->
            <div class="body-wrapper">
                <div class="bg-white">
                    @include('dashboard.layouts.cashier-header')
                </div>
                <div class="container-fluid max-w-full">
                    <div>
                        <form action="{{ route('cashier.selling.store') }}" method="post">
                            @csrf
                            <div class="row rounded">
                                <div class="col-12 col-md-4">
                                    <div class="bg-primary rounded p-3 mb-3 d-flex justify-content-between align-items-center">
                                        <h5 class="text-light mb-0">Total Harga</h5>
                                        <h3 class="text-light mb-0 fw-bolder" id="total_price">Rp 0</h3>
                                    </div>
                                    <div class="card mb-3">
                                        <div class="card-body p-3">
                                            <div class="form-group mb-3">
                                                <label for="cust-name" class="d-flex justify-content-between"><div class="fw-bolder"><i class="ti ti-user-circle text-primary"></i> Nama</div><span class="text-info fs-3">(shift+n)</span></label>
                                                <select name="name" class="" id="cust-name" tabindex="1">
                                                    <option value="">Pilih Pembeli</option>
                                                    @foreach ($buyers as $buyer)
                                                        <option value="{{ $buyer->name }}" data-address="{{ $buyer->address }}" data-id="{{$buyer->id}}">{{ $buyer->name }} - {{ $buyer->address }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="cust-address" class="d-flex justify-content-between"><div class="fw-bolder"><i class="ti ti-map-pin text-primary"></i> Alamat</div> <span class="text-info fs-3">(shift+a)</span></label>
                                                <input type="text" name="address" placeholder="Alamat Pembeli" class="form-control" id="cust-address" tabindex="2">
                                            </div>
                                            <div class="form-group ">
                                                <label for="telp" class="d-flex justify-content-between"><div class="fw-bolder"><i class="ti ti-phone text-primary"></i> No. Telp</div> <span class="text-info fs-3">(shift+t)</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text">+62</div>
                                                    <input type="text" name="telp" placeholder="No Telepon Pembeli" class="form-control" id="telp" tabindex="2">
                                                </div>
                                            </div>
                                            <div class="mt-2 text-center d-none" id="field-debt">
                                                <a href="" target="_blank">Lihat Hutang</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-3">
                                        <div class="card-header px-3">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="fw-bolder">
                                                    <i class="ti ti-credit-card"></i> Pembayaran
                                                </div>
                                                <div>
                                                    (shift+m)
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="row align-items-center mb-3">
                                                <div class="col-3">Metode</div>
                                                <div class="col-9">
                                                    <div class="d-flex gap-2">
                                                        <button type="button" data-check-id="tunai" class="btn-method btn btn-primary">Tunai</button>
                                                        <button type="button" data-check-id="hutang" class="btn-method btn btn-light-primary">Hutang</button>
                                                    </div>
                                                </div>
                                                <div class="d-none">
                                                    <div class="form-check">
                                                        <input type="checkbox" value="{{ StatusEnum::CASH->value }}" name="status_payment[]" id="tunai" class="form-check-input" checked>
                                                        <label for="tunai" class="form-check-label">Tunai</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" value="{{ StatusEnum::DEBT->value }}" name="status_payment[]" id="hutang" class="form-check-input" readonly>
                                                        <label for="hutang" class="form-check-label">Hutang</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="cash">
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-3">
                                                        <label for="formatted_pay" class="mb-2">Bayar</label>
                                                        <input type="hidden" id="pay" name="pay" class="mb-0">
                                                    </div>
                                                    <div class="col-9">
                                                        <div class="input-group mb-0">
                                                            <span class="input-group-text" id="basic-addon1">Rp</span>
                                                            <input type="text" placeholder="Uang Dibayar" min="0" id="formatted_pay" class="form-control format-number" aria-describedby="basic-addon1">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-3">
                                                        <label for="return" class="mb-2">Kembali</label>
                                                        <input type="hidden" id="return" name="return" class="mb-0">
                                                    </div>
                                                    <div class="col-9">
                                                        <div class="input-group mb-0">
                                                            <span class="input-group-text" id="basic-addon1">Rp</span>
                                                            <input type="text" min="0" placeholder="Uang Kembalian" id="formatted_return" class="form-control" aria-describedby="basic-addon1" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="code_debt">
                                                {{-- <div class="row align-items-center mb-3">
                                                    <div class="col-3">
                                                        <label for="">Kode Toko</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" class="form-control mb-0" name="code_debt" id="">
                                                    </div>
                                                </div> --}}
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-3">
                                                        <label for="">Hutang</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <div class="input-group">
                                                            <div class="input-group-text">Rp</div>
                                                            <input type="text" class="form-control mb-0" placeholder="Hutang" id="formatted_debt" readonly>
                                                            <input type="hidden" name="debt">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end text-primary">(shift+enter)</div>
                                            <button type="button" id="btn-open-modal" data-bs-toggle="modal" data-bs-target="#selling-modal" class="w-100 btn btn-lg btn-success"><i class="ti ti-shopping-cart"></i> Bayar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="card mb-3 border">
                                        <div class="card-body p-3 d-flex align-items-center gap-2">
                                            <div class="flex-1 w-100">
                                                <div>
                                                    <select id="product-code" class="select-product form-control" tabindex="3">
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->code }}">{{ $product->name }} | {{ $product->code }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div>
                                                (shift+p)
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border">
                                        <div class="card-header px-3 d-flex justify-content-between align-items-center">
                                            <div class="fw-bolder">
                                                <i class="ti ti-shopping-cart"></i> Keranjang
                                            </div>
                                            <button type="button" id="btn-reset" class="btn btn-sm btn-danger">Reset</button>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="table-responsive border rounded">
                                                <table class="table text-break">
                                                    <thead>
                                                        <tr class="fs-4 fw-semibold">
                                                            <th style="min-width: 180px;">Produk</th>
                                                            <th style="min-width: 120px;">Stok</th>
                                                            <th style="min-width: 120px;">Satuan</th>
                                                            <th style="min-width: 150px;">Jumlah</th>
                                                            <th style="min-width: 150px;">Harga</th>
                                                            <th style="min-width: 150px;">Total</th>
                                                            <th style="min-width: 100px;">Aksi</th>
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

                            @include('dashboard.selling.widgets.selling-modals')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
        <!--  Customizer -->
        <a href="{{ route('home') }}" class="btn btn-primary p-3 rounded-circle d-flex align-items-center justify-content-center customizer-btn">
            <i class="ti ti-home fs-7" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Beranda"></i>
        </a>

    @include('layouts.script')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"></script>
    <script src="{{asset('assets/libs/bootstrap-switch/dist/js/bootstrap-switch.min.js')}}"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>

    @include('components.swal-toast')
    @stack('custom-script')
    <script>
        $(document).ready(function() {

            changeMethod()

            let selected_products = []

            let cust_name_val = ""
            let product_val = ""

            function updateQty(e, adder) {
                var input = e.parent().find('input');
                var value = unformatNum(input.val());
                value += adder
                if (value < 1) value = 1;
                input.val(formatNum(value));

                const qty_el = e.parent().parent().find(`[name=quantity\\[\\]]`)
                qty_el.val(unformatNum(value))
                compareQtyWithStock(e.closest('tr[data-index]'))
                changeTotalPrice();
            }

            $(document).on('click', '.btn-plus', function() {
                updateQty($(this), 1);
            });
            $(document).on('click', '.btn-minus', function() {
                updateQty($(this), -1);
            });

            $(document).on('click', '#btn-reset', function() {
                $('#tb-product tr[data-index]').remove()
                changeTotalPrice()
            })

            const selectize_cust = $('#cust-name').selectize({
                plugins: ['restore_on_backspace'],
                create: true,
                maxItems: 1,
                placeholder: "Pilih atau tambahkan pembeli",
            })

            const select_cust = selectize_cust[0].selectize
            select_cust.focus()

            const selectize_product = $('#product-code').selectize({
                placeholder: "Pilih produk",
                allowEmptyOption: true,
                maxItems: 1,
                onChange: () => {
                    addNewProduct()
                }
            })
            const select_product = selectize_product[0].selectize

            select_product.setValue("")

            let shortcuts = {
                'shift+n': function() { select_cust.focus() },
                'shift+a': function() { $('#cust-address').focus() },
                'shift+p': function() { select_product.focus() },
                'shift+m': function() {
                    if($('#hutang').is(':checked')) {
                        $('#hutang').prop('checked', false)
                        $('[data-check-id=hutang]').removeClass('btn-primary')
                        $('[data-check-id=hutang]').addClass('btn-light-primary')
                        $('#tunai').prop('checked', true)
                        $('[data-check-id=tunai]').addClass('btn-primary')
                        $('[data-check-id=tunai]').removeClass('btn-light-primary')
                    } else {
                        $('#hutang').prop('checked', true)
                        $('[data-check-id=hutang]').addClass('btn-primary')
                        $('[data-check-id=hutang]').removeClass('btn-light-primary')
                        $('#tunai').prop('checked', false)
                        $('[data-check-id=tunai]').removeClass('btn-primary')
                        $('[data-check-id=tunai]').addClass('btn-light-primary')
                    }
                    changeMethod()
                },
                'shift+t': function() {$('#telp').focus()},
                'shift+enter': function() {
                    if(checkIsHasError() != 0) return 
                    $('#btn-open-modal').trigger('click')
                },
            };

            function checkShortcut(e) {
                var key = [];
                if (e.altKey) key.push('alt');
                if (e.ctrlKey) key.push('ctrl');
                if (e.shiftKey) key.push('shift');
                key.push(e.key.toLowerCase());

                return key.join('+');
            }

            $(document).keydown(function(e) {
                var shortcut = checkShortcut(e);
                if (shortcuts[shortcut]) {
                    e.preventDefault(); // Prevent default action
                    shortcuts[shortcut](); // Trigger shortcut action
                }
            });

            $(document).on('keydown', 'input', function(e) {
                if (e.originalEvent.key === 'Enter') {
                    e.preventDefault();
                    return false;
                }
            })

            $(document).on('change input', '#cust-name', function() {
                var selectedValue = select_cust.getValue();
                var selectedItem = select_cust.options[selectedValue];
                if(!selectedItem.address) cust_name_val = selectedValue
                if ($(this).val()) {
                    $('#btn-add-product').removeAttr('disabled');
                } else {
                    $('#btn-add-product').attr('disabled', 'disabled');
                }

                let address = selectedItem.address
                $('#cust-address').val(address)

                changeAllProductLastPrice()
                getUserIdByNameAddress()
                checkIsHasError()
            });

            $(document).on('change input', '#cust-address', function() {
                changeAllProductLastPrice()
                getUserIdByNameAddress()
                checkIsHasError()
            })

            async function getUserIdByNameAddress() {
                const user = await axios.get(`{{route('find.buyer.name-address')}}?name=${select_cust.getValue()}&address=${$('#cust-address').val()}`)
                if(user.data.data) {
                    let debt_detail = "{{url('cashier/debt')}}"+`/${user.data.data.id}`
                    $('#field-debt a').attr('href', debt_detail)
                    $('#field-debt').removeClass('d-none')
                } else {
                    $('#field-debt').attr('href', '#')
                    $('#field-debt').addClass('d-none')
                }
            }

            function addNewProduct() {
                const product_code = select_product.getValue()
                if(!product_code) return;

                $.ajax({
                    url: "{{ route('cashier.show.product') }}",
                    type: "GET",
                    data: {
                        code: product_code
                    },
                    dataType: 'json',
                    success: async function(response) {
                        if(response.data.quantity < 1) {
                            Toaster('error', 'stok produk kosong')
                            select_product.setValue("")
                            return
                        }

                        let str_res = JSON.stringify(response.data).replaceAll('"', "'");
                        let data_check_product = {
                            id: response.data.id,
                            max: response.data.quantity
                        }
                        if(!selected_products.find(prod => prod.id == data_check_product.id)) selected_products.push(data_check_product)

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
                            <tr data-index="${current_index}" data-id="${response.data.id}" data-product="${str_res}">
                                <td>
                                    <h6 class="fs-4 fw-semibold mb-0 text-start">
                                        ${response.data.name} | ${response.data.code}
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
                                    <select name="product_unit_id[]" class="form-control product-unit" tabindex="5">
                                        ${product_units}
                                    </select>
                                </td>
                                <td class="d-flex flex-row gap-2">
                                    <button type="button" class="btn btn-sm btn-danger p-2 btn-minus"  tabindex="5">-</button>
                                    <input type="text" name="formatted_quantity[]" class="form-control format-number input-quantity" placeholder="Jumlah" min="1" value="1" tabindex="5"/>
                                    <button type="button" class="btn btn-sm btn-success p-2 btn-plus" tabindex="5">+</button>
                                </td>
                                <td>
                                    <input type="text" value="${formatNum(selected_price, true)}" name="formatted_product_unit_price[]" class="form-control format-number input-unit-price" tabindex="5" />
                                    ${latest_price ? `<div class="text-primary last_price">Rp. ${formatNum(latest_price)}</div>` : '' }
                                </td>
                                <td>
                                    <input type="text" value="${formatNum(selected_price, true)}" name="formatted_selling_price[]" class="form-control format-number input-selling-price" readonly />
                                </td>
                                <td>
                                    <button type="button" data-id="${current_index}" class="btn btn-danger delete_product" tabindex="5"><i class="ti ti-trash"></i></button>
                                </td>
                            </tr>`;
                        $('#tb-product').append(newRow);
                        select_product.setValue("")
                        compareQtyWithStock($(`#tb-product [data-index=${current_index}]`))
                        changeTotalPrice()
                        checkIsHasError()
                    },
                });
            }

            $(document).on('input', '.format-number', function() {
                var value = unformatNum($(this).val())
                if(value < 0) $(this).val(0)
                $(this).val(formatNum($(this).val()))
            })

            $(document).on('input change', '.input-quantity', function() {
                const data_index = $(this).parent().parent().data('index')
                const qty_el = $(`#tb-product tr[data-index=${data_index}] [name=quantity\\[\\]]`)
                qty_el.val(unformatNum($(this).val()))
                compareQtyWithStock($(this).closest('tr[data-index]'))
                changeTotalPrice()
                checkIsHasError()
            })

            function compareQtyWithStock(tr) {
                const product_id = tr.data('id')
                const data_index = tr.data('index')
                const qty = tr.find('[name=quantity\\[\\]]').val()
                const converter = tr.find('.product-unit :selected').data('quantity-in-small-unit')
                const this_product = selected_products.find(prod => prod.id == product_id)
                let now_total_count = 0;

                const except_this_el = $(`#tb-product [data-id=${product_id}]:not([data-index=${data_index}])`)
                except_this_el.each(function() {
                    const selected_unit = $(this).find('.product-unit').find(':selected')
                    now_total_count = $(this).find('[name=quantity\\[\\]]').val() * selected_unit.data('quantity-in-small-unit')
                })

                let total_remain = this_product.max - now_total_count
                if(total_remain < (qty * converter)) {
                    const new_qty = Math.floor(total_remain/converter)
                    tr.find('[name=quantity\\[\\]]').val(new_qty)
                    tr.find('.input-quantity').val(formatNum(new_qty))
                }
            }

            $(document).on('input change', '.input-unit-price', function() {
                const data_index = $(this).parent().parent().data('index')
                const price_el = $(`#tb-product tr[data-index=${data_index}] [name=product_unit_price\\[\\]]`)
                price_el.val(unformatNum($(this).val()))
                changeTotalPrice()
                checkIsHasError()
            })

            $('#tb-product').on('change', '.product-unit', async function() {
                var row = $(this).closest('tr');
                var selected = $(this).find(':selected')
                var selectedPrice = selected.data('selling-price');
                var quantity_in_small_unit = selected.data('quantity-in-small-unit');
                var quantity = selected.data('quantity');
                var unit = selected.data('unit');
                var stock = Math.floor(quantity / quantity_in_small_unit);
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
                checkIsHasError()
            });

            $(document).on('input change', '#formatted_pay', changeReturnAmount)

            $(document).on('input change', '#formatted_debt', function() {
                $(this).val(formatNum($(this).val()))
                if($(this).val() < 0) $(this).val(0)
                $('[name=debt]').val(unformatNum($(this).val()))
            })

            $(document).on('click', '.delete_product', function() {
                let tr = $(this).parent().parent()
                let product_id = tr.data('id')
                tr.remove()
                console.log(selected_products)
                if($(`#tb-product [data-id=${product_id}]`).length == 0) {
                    let this_product = selected_products.find(prod => prod.id == product_id)
                    let index_product = selected_products.indexOf(this_product)
                    selected_products.splice(index_product, 1)
                }
                changeTotalPrice()
            })

            async function getLatestBuy(buyer_name, buyer_address, product_unit_id) {
                const obj_price = await axios.get(`{{ route('transaction.find-by-user-product') }}?buyer_name=${buyer_name}&buyer_address=${buyer_address}&product_unit_id=${product_unit_id}`)
                return (obj_price.data && obj_price.data.data) ? obj_price.data.data.selling_price : 0
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
                changeDebtValue()
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
                changeDebtValue()
                checkIsHasError()
            }

            $(document).on('click', '.btn-method', function() {
                let id = $(this).data('check-id')
                let is_checked = $(`#${id}`).is(':checked')
                if(!is_checked) {
                    $(this).removeClass('btn-light-primary')
                    $(this).addClass('btn-primary')
                    $(`#${id}`).prop('checked', true)
                } else {
                    $(this).addClass('btn-light-primary')
                    $(this).removeClass('btn-primary')
                    $(`#${id}`).prop('checked', false)
                }

                changeMethod()
                changeDebtValue()
                checkIsHasError()
            })

            function changeMethod() {
                if ($('#tunai').is(":checked")) $('#cash').show()
                else {
                    $('#cash').hide()
                    $('#formatted_pay').val(0)
                    $('#pay').val(0)
                    $('#formatted_return').val(0)
                    $('#return').val(0)
                }

                if($('#hutang').is(":checked")) {
                    $('#code_debt').show()
                    changeDebtValue()
                } else {
                    $('#code_debt').hide()
                    $('#formatted_debt').val(0)
                    $('[name=debt]').val()
                }

                if(!$('#hutang').is(':checked') && !$('#tunai').is(':checked')) {
                    $('[data-check-id=tunai]').removeClass('btn-light-primary')
                    $('[data-check-id=tunai]').addClass('btn-primary')
                    $(`#tunai`).prop('checked', true)
                    changeMethod()
                }
                checkIsHasError()
            }

            checkIsHasError()

            function checkIsHasError() {
                let count_error = 0

                if(!$('#cust-name').val()) count_error++
                if(!$('#cust-address').val()) count_error++
                if($('#tb-product [data-index]').length < 1) count_error++
                count_error += paymentMethodError()
                
                if(count_error == 0) {
                    $('button[type=submit]').removeClass('disabled')
                    $('#btn-open-modal').removeClass('disabled')
                }
                else {
                    $('button[type=submit]').addClass('disabled')
                    $('#btn-open-modal').addClass('disabled')
                }

                return count_error
            }

            function changeDebtValue() {
                if(!$('#hutang').is(':checked')) return
                const total_must_paid = unformatNum($('#total_price').html().replace('Rp ', ''))
                const paid = $('#pay').val()
                const debt = total_must_paid - paid
                if(debt < 0) {
                    $('[name=debt]').val(0)
                    $('#formatted_debt').val(0)
                } else {
                    $('[name=debt]').val(debt)
                    $('#formatted_debt').val(formatNum(debt))
                }
            }

            function paymentMethodError() {
                const total_must_paid = unformatNum($('#total_price').html().replace('Rp ', ''))
                if(!$('#hutang').is(':checked')) {
                    const money_paid = $('#pay').val()
                    if(total_must_paid > money_paid) return 1
                }
                return 0
            }

            function saveToLocal() {
                localStorage.setItem('cashier.name', select_cust.getValue())
                localStorage.setItem('cashier.address', $('#cust-address').val())
                localStorage.setItem('cashier.telp', $('#telp').val())
                localStorage.setItem('cashier.method', getSelectedMethod())
                localStorage.setItem('cashier.paid', $('#pay').val())
                localStorage.setItem('cashier.return', $('#return').val())
                localStorage.setItem('cashier.debt', $('[name=debt]').val())
                localStorage.setItem('cashier.products', getSelectedProduct())
            }

            function getSelectedProduct() {
                let products = []
            }

            function getSelectedMethod() {
                let methods = [];
                if($('#tunai').is(':checked')) methods.push('tunai')
                if($('#hutang').is(':checked')) methods.push('hutang')
                return JSON.stringify(methods)
            }

            @if ($errors->any())
                let msg = ''
                @foreach ($errors->all() as $error)
                    msg += `<li>{{$error}}</li>`
                @endforeach
                Swal.fire({
                    icon: "error",
                    html: `<ul>${msg}</ul>`,
                    timerProgressBar: true,
                });
            @endif
        })
    </script>
</body>
</html>