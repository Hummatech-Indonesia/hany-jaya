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
    <style>
        .form-control:focus, .form-check-input:focus {
            box-shadow:0 0 0 .25rem rgba(93,135,255,.25)!important
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('favicon.ico') }}"
            alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('favicon.ico') }}"
            alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-theme="blue_theme" data-layout="vertical" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!--  Main wrapper -->
        <div class="body-wrapper mx-3">
            <div class="mt-3">
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
                                        <label for="cust-name" class="d-flex justify-content-between"><div>Nama</div><span class="text-info">(shift+n)</span></label>
                                        <select name="name" class="" id="cust-name" tabindex="1">
                                            <option value="">Pilih Pembeli</option>
                                            @foreach ($buyers as $buyer)
                                                <option value="{{ $buyer->name }}" data-address="{{ $buyer->address }}" data-id="{{$buyer->id}}">{{ $buyer->name }} - {{ $buyer->address }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="cust-address" class="d-flex justify-content-between"><div>Alamat</div> <span class="text-info">(shift+a)</span></label>
                                        <input type="text" name="address" placeholder="Alamat Pembeli" class="form-control" id="cust-address" tabindex="2">
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow mb-3">
                                <div class="card-body px-3">
                                    <h5>Pembayaran:</h5>
                                    <div class="">
                                        <label for="payment_method" class="d-flex justify-content-between mb-2"><div>Metode:</div><span class="text-info">(shift+m)</span></label>
                                        <input type="checkbox" id="payment_method" data-on-text="Tunai" data-off-text="Hutang" data-on-color="primary" data-off-color="success" >
                                    </div>
                                    <div class="d-none">
                                        <div class="form-check">
                                            <input type="radio" value="{{ StatusEnum::CASH->value }}" name="status_payment" id="tunai" class="form-check-input" checked>
                                            <label for="tunai" class="form-check-label">Tunai</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" value="{{ StatusEnum::DEBT->value }}" name="status_payment" id="hutang" class="form-check-input">
                                            <label for="hutang" class="form-check-label">Hutang</label>
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
                                    <div class="d-flex justify-content-between">
                                        <h5>Produk</h5>
                                        <div class="text-info">(shift+p)</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-10">
                                            <div>
                                                <select id="product-code" class="select-product form-control" tabindex="3">
                                                    @foreach ($products as $product)
                                                        <option value="" selected disabled>Pilih produk</option>
                                                        <option value="{{ $product->code }}">{{ $product->name }} | {{ $product->code }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-primary w-100" type="button" disabled id="btn-add-product" tabindex="4">+ Tambah</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive border rounded">
                                        <table class="table text-break">
                                            <thead>
                                                <tr class="fs-4 fw-semibold">
                                                    <th style="min-width: 200px;">Produk</th>
                                                    <th style="min-width: 150px;">Stok</th>
                                                    <th style="min-width: 150px;">Satuan</th>
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
                </form>
            </div>
        </div>
    </div>

    <!--  Customizer -->
    <a href="{{ route('home') }}" class="btn btn-primary p-3 rounded-circle d-flex align-items-center justify-content-center customizer-btn">
        <i class="ti ti-home fs-7" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Beranda"></i>
      </a>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!--  core files -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/js/app.init.js') }}"></script> -->
    <script src="{{ asset('assets/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <!--  current page js files -->
    <!-- <script src="{{ asset('assets/js/dashboard.js') }}"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{asset('assets/libs/bootstrap-switch/dist/js/bootstrap-switch.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="{{asset('assets/libs/sweetalert2/dist/sweetalert2.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#payment_method').bootstrapSwitch("state", true, true)

            $(document).on('switchChange.bootstrapSwitch', '#payment_method',function(e, data) {
                if(data) {
                    $('#tunai').prop('checked', true)
                    $('#hutang').prop('checked', false)
                } else {
                    $('#tunai').prop('checked', false)
                    $('#hutang').prop('checked', true)
                }

                changeMethod()
            })

            changeMethod()

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
                changeTotalPrice();
            }

            $(document).on('click', '.btn-plus', function() {
                updateQty($(this), 1);
            });
            $(document).on('click', '.btn-minus', function() {
                updateQty($(this), -1);
            });

            const selectize_cust = $('#cust-name').selectize({
                plugins: ['restore_on_backspace'],
                create: true,
                maxItems: 1,
                placeholder: "Pilih atau tambahkan pembeli",
            })

            const select_cust = selectize_cust[0].selectize
            select_cust.focus()

            const selectize_product = $('#product-code').selectize({
                plugins: ['restore_on_backspace'],
                placeholder: "Pilih produk",
                create: true,
                maxItems: 1
            })
            const select_product = selectize_product[0].selectize

            let shortcuts = {
                'shift+n': function() { select_cust.focus() },
                'shift+a': function() { $('#cust-address').focus() },
                'shift+p': function() { select_product.focus() },
                'shift+m': function() {
                    let val = $('#payment_method').bootstrapSwitch("state")
                    if(val) $('#payment_method').bootstrapSwitch("state", false)
                    else $('#payment_method').bootstrapSwitch("state", true)
                },
                'shift+enter': function() {$('form').submit()}
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
            });

            $(document).on('change input', '#cust-address', function() {
                changeAllProductLastPrice()
            })

            $(document).on('click', '#btn-add-product', function() {
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
                                    <button type="button" data-id="${current_index}" class="btn btn-light-danger text-danger delete_product" tabindex="5"><i class="ti ti-trash"></i></button>
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

            function changeMethod() {
                if ($('input[name="status_payment"]:checked').val() === "{{ StatusEnum::CASH->value }}") {
                    $('#cash').show();
                    $('#code_debt').hide();
                } else {
                    $('#cash').hide();
                    $('#code_debt').show();
                }
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