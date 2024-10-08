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
    <link rel="stylesheet" href="{{ asset('assets/libs/selectize/selectize.bootstrap5.min.css') }}"/>
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
        input.disabled, input.disabled:focus {
            background-color: var(--bs-secondary-bg);
        }
        .btn-disabled.disabled {
            background-color: var(--bs-gray-300);
            color: var(--bs-gray-800);
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
    <div class="page-wrapper show-sidebar mini-sidebar" id="main-wrapper" data-theme="blue_theme" data-layout="vertical" data-sidebartype="mini-sidebar"
    data-sidebar-position="fixed" data-header-position="static">
        @include('dashboard.layouts.sidebar')
            <!--  Main wrapper -->
            <div class="body-wrapper">
                <div class="bg-white">
                    @include('dashboard.layouts.cashier-header')
                    @include('dashboard.selling.widgets.cashier-shortcut-modal')
                    @include('dashboard.selling.widgets.cashier-update-price')
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
                                                <label for="cust-name" class="d-flex justify-content-between"><div class="fw-bolder"><i class="ti ti-user-circle text-primary"></i> Nama <span class="text-danger">*</span></div><span class="text-info fs-3">(f1)</span></label>
                                                <select name="name" class="" id="cust-name" tabindex="1">
                                                    <option value="">Pilih Pembeli</option>
                                                    @foreach ($buyers as $buyer)
                                                        <option value="{{ $buyer->name }} - {{ $buyer->address }}" data-name="{{ $buyer->name }}" data-debt="{{$buyer->debt}}" data-limit-debt="{{$buyer->limit_debt}}" data-has-exceeded-limit="{{$buyer->has_exceeded_the_limit}}" data-code="{{ $buyer->code }}" data-phone="{{$buyer->telp}}" data-address="{{ $buyer->address }}" data-id="{{$buyer->id}}">{{ $buyer->name }} - {{ $buyer->address }} ({{ $buyer->code }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="cust-address" class="d-flex justify-content-between"><div class="fw-bolder"><i class="ti ti-map-pin text-primary"></i> Alamat <span class="text-danger">*</span></div> <span class="text-info fs-3">(f2)</span></label>
                                                <input type="text" name="address" placeholder="Alamat Pembeli" class="form-control" id="cust-address" tabindex="2">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="code" class="d-flex justify-content-between"><div class="fw-bolder"><i class="ti ti-scan text-primary"></i> Kode Pembeli <span class="text-danger">*</span></div> <span class="text-info fs-3">(f3)</span></label>
                                                <input type="text" required name="code" placeholder="Kode Pembeli" class="form-control" id="code" tabindex="2">
                                            </div>
                                            <div class="form-group ">
                                                <label for="telp" class="d-flex justify-content-between"><div class="fw-bolder"><i class="ti ti-phone text-primary"></i> No. Telp</div> <span class="text-info fs-3">(f4)</span></label>
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
                                                    (f6)
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="row align-items-center mb-3">
                                                <div class="col-3">Metode <span class="text-danger">*</span></div>
                                                <div class="col-9">
                                                    <div class="d-flex gap-2">
                                                        {{-- <button type="button" data-check-id="tunai" class="btn-method btn btn-primary">Tunai</button>
                                                        <button type="button" data-check-id="hutang" class="btn-method btn btn-light-primary">Hutang</button> --}}
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
                                                <div>
                                                </div>
                                            </div>
                                            <div id="cash">
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-3">
                                                        <label for="formatted_pay" class="mb-2">Bayar <span class="text-danger">*</span></label>
                                                        <input type="hidden" id="pay" name="pay" class="mb-0">
                                                    </div>
                                                    <div class="col-9">
                                                        <div class="input-group mb-0">
                                                            <span class="input-group-text" id="basic-addon1">Rp</span>
                                                            <input type="text" placeholder="Uang Dibayar" min="0" id="formatted_pay" class="form-control format-number" aria-describedby="basic-addon1">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-center mb-3" id="return_pay">
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
                                                <div class="row align-items-center mb-3-" style="display: none">
                                                    <div class="col-3">
                                                        <label for="code_debt">Kode Toko</label>
                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" class="form-control mb-0" name="code_debt" id="code_debt">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <label for="print_type">Jenis Cetak (f7) <small class="text-danger">*</small></label>
                                                </div>
                                                <div class="col-9">
                                                    <select name="print_type" id="print_type" class="form-select">
                                                        <option value="struk">Struk</option>
                                                        <option value="nota">Nota</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="text-end text-primary">(alt+enter)</div>
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
                                                            <option value="{{ $product->code }}" data-product="{{ $product }}">{{ $product->name }} | {{ $product->code }} | {{ number_format($product->quantity, 0, ',', '.') }} {{ $product->unit->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div>
                                                (f5)
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border">
                                        <div class="card-header px-3 d-flex justify-content-between align-items-center">
                                            <div class="fw-bolder">
                                                <i class="ti ti-shopping-cart"></i> Keranjang <span class="text-danger">*</span>
                                            </div>
                                            <button type="button" id="btn-reset" class="btn btn-sm btn-danger">Reset</button>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="table-responsive border rounded">
                                                <table class="table text-break">
                                                    <thead>
                                                        <tr class="fs-4 fw-semibold">
                                                            <th style="min-width: 180px;">Produk</th>
                                                            <th style="min-width: 150px;">Stok</th>
                                                            <th style="min-width: 200px;">Jumlah</th>
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
    
    @include('components.swal-message')
    @include('dashboard.selling.widgets.cashier-supply-hist-modal')

    @include('layouts.script')
    <script src="{{ asset('assets/libs/selectize/selectize.min.js') }}"></script>
    <script src="{{ asset('assets/libs/axios/axios.min.js') }}"></script>
    <script src="{{asset('assets/libs/bootstrap-switch/dist/js/bootstrap-switch.min.js')}}"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>

    @include('components.swal-toast')
    @stack('custom-script')
    <script>
        var fn_focus_last = () => {}
        $(document).ready(function() {
            $(document).on('hide.bs.modal', '.modal', function() {
                setTimeout(() => {
                    fn_focus_last()
                }, 100)
            })

            function disableFunctionKeys(e) {
                var functionKeys = new Array(112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 123);
                if (functionKeys.indexOf(e.keyCode) > -1 || functionKeys.indexOf(e.which) > -1) {
                    e.preventDefault();
                }
            };

            $(document).on('keydown', disableFunctionKeys);

            changeMethod()

            let selected_products = []

            let cust_name_val = ""
            let product_val = ""

            function updateQty(e, adder) {
                var tr = e.closest('tr')
                var input = tr.find('.input-quantity')
                var value = unformatNum(input.val());
                value += adder
                if (value < 1) value = 1;
                input.val(formatNum(value));

                const qty_el = tr.find(`[name=quantity\\[\\]]`)
                qty_el.val(unformatNum(value))
                compareQtyWithStock(tr)
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

            $(document).on('click', 'button[type=submit]', function() {
                $('#selling-modal').modal('hide')
            })

            $(document).on('focus', 'input', function() {
                fn_focus_last = () => {$(this).focus()}
            })

            const selectize_cust = $('#cust-name').selectize({
                plugins: ['restore_on_backspace'],
                create: true,
                maxItems: 1,
                placeholder: "Pilih atau tambahkan pembeli",
                onFocus: () => {setSelectizeFocus('cust')}
            })

            const selectize_print_type = $('#print_type').selectize({
                maxItems: 1
            })

            const select_print_type = selectize_print_type[0].selectize

            const select_cust = selectize_cust[0].selectize

            const selectize_product = $('#product-code').selectize({
                placeholder: "Pilih produk",
                allowEmptyOption: true,
                maxItems: 1,
                selectOnTab: false,
                onChange: () => {
                    addNewProduct()
                    productFocus()
                },
                onFocus: () => {
                    setSelectizeFocus('product')
                }
            })
            const select_product = selectize_product[0].selectize

            select_product.setValue("")

            function removeFocusSelecProduct(e) {
                if(e.originalEvent.key.toLowerCase() == "tab") {
                    select_product.blur()
                    $(document).off('keydown', removeFocusSelecProduct)
                }
            }

            setTimeout(() => {
                select_product.focus()
                $(document).on('keydown', removeFocusSelecProduct)
            }, 100)

            select_product.$control_input.on('focus', function() {
                $(document).on('keydown', removeFocusSelecProduct)
            })
            select_product.$control_input.on('blur', function() {
                $(document).off('keydown', removeFocusSelecProduct)
            })

            function productFocus() {
                select_product.focus()
            }

            function setSelectizeFocus(type) {
                if(type === 'product') fn_focus_last = () => {select_product.focus()}
                if(type === 'cust') fn_focus_last = () => {select_cust.focus()}
            }
            
            let shortcuts = {
                'f1': function() { 
                    if(select_cust.isFocused) select_cust.blur()
                    else select_cust.focus()
                },
                'f2': function() { $('#cust-address').focus() },
                'f3': function() {$('#code').focus()},
                'f4': function() {$('#telp').focus()},
                'f5': function() { select_product.focus() },
                'f6': function() {shortcutChangeMethodHandler()},
                'f7': function() { select_print_type.focus() },
                'alt+enter': async function() {
                    const count_error = await checkIsHasError()
                    if(count_error != 0) return 

                    if(!$('#selling-modal').is(':visible')) $('#btn-open-modal').trigger('click')
                    else $('button[type=submit]').trigger('click')
                },
                'alt+backspace': function() {
                    let is_focus_input = $('#tb-product input:not([type=hidden]):focus')
                    if(is_focus_input.length !== 1) return
                    is_focus_input.each(function() {
                        const all_tr = $('#tb-product tr[data-index]')
                        const tr = $(this).closest('tr')
                        const del_button = tr.find('.delete_product')

                        $(function() {
                            const index = all_tr.index(tr)
                            if(all_tr.length === 1) select_product.focus()
                            else if(index == 0) $(all_tr[index+1]).find('[name=formatted_quantity\\[\\]]').focus()
                            else $(all_tr[index-1]).find('[name=formatted_quantity\\[\\]]').focus()
                        })

                        del_button.trigger('click')
                    })
                },
                'arrowup': function() {
                    let is_focus_input = $('#tb-product input:not([type=hidden]):focus')
                    if(is_focus_input.length !== 1) return

                    is_focus_input.each(function() {
                        const all_tr = $('#tb-product tr[data-index]')
                        const tr = $(this).closest('tr')
                        const index = all_tr.index(tr)
                        if (index == 0) {
                            return
                        }
                        $(all_tr[index-1]).find('[name=formatted_quantity\\[\\]]').focus()
                    })
                },
                'arrowdown': function() {
                    let is_focus_input = $('#tb-product input:not([type=hidden]):focus')
                    if(!is_focus_input.length) return
                    if(is_focus_input.length == 1) {
                        is_focus_input.each(function() {
                            const all_tr = $('#tb-product tr[data-index]')
                            const tr = $(this).closest('tr')
                            const index = all_tr.index(tr)
                            if (index == all_tr.length-1) {
                                return
                            }
                            $(all_tr[index+1]).find('[name=formatted_quantity\\[\\]]').focus()
                        })
                    }
                },
                'alt+h': function() {
                    let is_focus_input = $('#tb-product input:not([type=hidden]):focus')
                    if(is_focus_input.length !== 1) return
                    is_focus_input.each(function() {
                        const all_tr = $('#tb-product tr[data-index]')
                        const tr = $(this).closest('tr')
                        const show_button = tr.find('.btn-show-history')

                        show_button.trigger('click')
                    })
                },
                'alt+u': function() {
                    let is_focus_input = $('#tb-product input:not([type=hidden]):focus')
                    if(is_focus_input.length !== 1) return
                    is_focus_input.each(function() {
                        const all_tr = $('#tb-product tr[data-index]')
                        const tr = $(this).closest('tr')
                        const show_button = tr.find('.btn-show-modal-update')

                        show_button.trigger('click')
                    })
                },
            };

            function shortcutChangeMethodHandler() {
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
            }

            function checkShortcut(e) {
                var key = [];
                if (e.altKey) key.push('alt');
                if (e.ctrlKey || e.metaKey) key.push('ctrl');
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
                if($(this).closest('#modal-update-product').length !== 0) return;
                if (e.originalEvent.key === 'Enter' && e.originalEvent.altKey === false) {
                    e.preventDefault();
                    return false;
                }
            })

            $(document).on('change input', '#cust-name', function() {
                var selectedValue = select_cust.getValue();
                var selectedItem = select_cust.options[selectedValue];
                
                if(selectedItem) {
                    if(!selectedItem.address) cust_name_val = selectedValue
                    let address = selectedItem.address
                    let telp = selectedItem.phone
                    let name = selectedItem.name
                    let code = selectedItem.code
                    $('#cust-address').val(address)
                    $('#telp').val(telp)
                    $('#code').val(code)
                }
                
                if(selectedValue && selectedItem && (selectedItem && selectedValue == `${selectedItem.name} - ${selectedItem.address}`)) {
                    $('#cust-address').prop('readonly', true)
                    $('#cust-address').addClass('disabled')
                    $('#telp').prop('readonly', true)
                    $('#telp').addClass('disabled')
                    $('#code').prop('readonly', true)
                    $('#code').addClass('disabled')
                } else {
                    $('#cust-address').prop('readonly', false)
                    $('#cust-address').removeClass('disabled')
                    $('#telp').prop('readonly', false)
                    $('#telp').removeClass('disabled')
                    $('#code').prop('readonly', false)
                    $('#code').removeClass('disabled')
                }
                
                changeAllProductLastPrice()
                getUserIdByNameAddress()
                checkIsHasError()
            });

            $(document).on('change input', '#cust-address', function() {
                changeAllProductLastPrice()
                getUserIdByNameAddress()
                checkIsHasError()
            })

            var code_timeout

            $(document).on('input', '#code', function() {
                checkIsHasError()
            })

            async function getCodeRes() {
                const selected_option = select_cust.options[select_cust.getValue()]
                const buyer_id = selected_option && selected_option.id ? selected_option.id : null
                return await $.ajax({
                    url: "{{ route('find.buyer.check-code') }}",
                    method: "POST",
                    data: {
                        code: $('#code').val(),
                        buyer_id
                    }
                })
            }

            async function errorCode() {
                clearTimeout(code_timeout)
                return new Promise((resolve) => {
                    code_timeout = setTimeout(async () => {
                        try {
                            const a = await getCodeRes();

                            if (!a.data) {
                                resolve(1);
                                return;
                            }
                        } catch (error) {
                            resolve(1);
                            return;
                        }
                        
                        resolve(0);
                    }, 400);
                });
            }

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

            async function addNewProduct() {
                const product_code = select_product.getValue()
                if(!product_code) return;
                const product_data = select_product.options[product_code].product


                if(product_data.quantity < 1) {
                    Toaster('error', 'stok produk kosong')
                    select_product.setValue("")
                    return
                }

                const is_product_already_exist = $(`#tb-product tr[data-index][data-id=${product_data.id}]`)

                if(is_product_already_exist.length > 0) {
                    $(is_product_already_exist[0]).find('.btn-plus').trigger('click')

                    let data_check_product = {
                        id: product_data.id,
                        max: product_data.quantity
                    }
                    if(!selected_products.find(prod => prod.id == product_data.id)) selected_products.push(data_check_product)
                    select_product.setValue("")
                    compareQtyWithStock($(is_product_already_exist[0]))
                    changeTotalPrice()
                    checkIsHasError()
                    return ;
                }

                let str_res = JSON.stringify(product_data).replaceAll('"', "'");
                let data_check_product = {
                    id: product_data.id,
                    max: product_data.quantity
                }
                if(!selected_products.find(prod => prod.id == data_check_product.id)) selected_products.push(data_check_product)
                
                var product_units = '';
                var selected_price = 0;
                $('#tb-product tr th').parent().remove()
                var latest_index = $('#tb-product tr[data-index]').last().data('index')
                var current_index = latest_index ? latest_index+1 : 1
                var product_unit_id = 0
                
                $.each(product_data.product_units, function(index, productUnit) {
                    var selected = product_data.unit.id === productUnit.unit_id ? 'selected' : '';
                    if(product_data.unit.id === productUnit.unit_id) product_unit_id = productUnit.id
                    
                    if(selected == 'selected') product_unit_id = productUnit.id
                    product_units += `
                        <option value="${productUnit.id}" data-unit="${productUnit.unit.name}" id="selling-price-${productUnit.id}" data-selling-price="${productUnit.selling_price}" data-quantity-in-small-unit="${productUnit.quantity_in_small_unit}" data-quantity="${product_data.quantity}" ${selected}>
                            ${productUnit.unit.name}
                        </option>`;
                                            
                    if(product_data.unit.name === productUnit.unit.name) selected_price = productUnit.selling_price
                });

                const latest_buy = await getLatestBuy($('#cust-name').val(), $('#cust-address').val(), product_unit_id, false)
                const latest_price = (latest_buy && latest_buy.selling_price ? latest_buy.selling_price : false)
                const latest_qty = (latest_buy && latest_buy.quantity ? latest_buy.quantity : false)
                const latest_purchase_price = await getLatestPurchase(product_data.id, product_unit_id)
                var newRow = `
                    <tr data-index="${current_index}" data-id="${product_data.id}" data-product="${str_res}">
                        <td>
                            <div class="fw-semibold mb-0 text-start form-control border-0">
                                ${product_data.name} | ${product_data.code}
                            </div>
                            <input type="hidden" name="product_id[]" value="${product_data.id}"/>
                            <input type="hidden" name="quantity[]" value="1"/>
                            <input type="hidden" name="product_unit_price[]" value="${latest_price ? latest_price : selected_price}"/>
                            <input type="hidden" name="selling_price[]" value="${latest_price ? latest_price : selected_price}"/>
                        </td>
                        <td>
                            <div class="mb-0 text-start form-control border-0">
                                <span class="stock">${formatNum(Math.round(product_data.quantity), true)}</span> <span class="quantity_stock">${product_data.unit.name}</span>
                            </div>
                            <select name="product_unit_id[]" class="d-none form-control product-unit" tabindex="5">
                                ${product_units}
                            </select>
                        </td>
                        <td>
                            <div class="d-flex flex-row gap-2">
                                <button type="button" class="btn btn-sm btn-danger p-2 btn-minus">-</button>
                                <div>
                                    <input type="text" name="formatted_quantity[]" class="form-control format-number input-quantity" placeholder="Jumlah" min="1" value="1" tabindex="5"/>
                                    
                                </div>
                                <button type="button" class="btn btn-sm btn-success p-2 btn-plus">+</button>
                            </div>
                            {{-- ${latest_qty ? `<div class="ps-4 text-primary last_qty">${formatNum(latest_qty)}</div>` : ''} --}}
                        </td>
                        <td>
                            <input type="text" value="${formatNum((latest_price ? latest_price :selected_price), true)}" 
                                name="formatted_product_unit_price[]"
                                class="form-control format-number input-unit-price"
                                tabindex="5" data-unit-purchase="${latest_purchase_price}"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="Harga kurang dari harga beli" data-bs-trigger="manual"
                            />
                        </td>
                        <td>
                            <input type="text" value="${formatNum((latest_price ? latest_price : selected_price), true)}" name="formatted_selling_price[]" class="form-control format-number input-selling-price" readonly />
                        </td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center gap-1">
                                <button type="button" data-id="${current_index}" class="btn btn-danger delete_product"><i class="ti ti-trash"></i></button>
                                <button type="button" data-product-id="${product_data.id}" data-bs-toggle="modal" data-bs-target="#modal-supply-history" class="btn btn-info btn-show-history" ><i class="ti ti-list"></i></button>
                                <button type="button" data-product-id="${product_data.id}" data-product="${str_res}" class="btn btn-primary btn-show-modal-update"><i class="ti ti-edit"></i></button>
                            </div>
                        </td>
                    </tr>`;
                $('#tb-product').append(newRow);
                select_product.setValue("")
                compareQtyWithStock($(`#tb-product [data-index=${current_index}]`))
                changeTotalPrice()
                checkIsHasError()
            }

            $(document).on('input', '.format-number', function() {
                var value = unformatNum($(this).val())
                if(value < 0) $(this).val(0)
                $(this).val(formatNum($(this).val()))
            })

            $(document).on('input change', '.input-quantity', function() {
                const tr = $(this).closest('tr[data-index]')
                const data_index = tr.data('index')
                const qty_el = tr.find(`[name=quantity\\[\\]]`)
                qty_el.val(unformatNum($(this).val()))
                compareQtyWithStock(tr)
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
                    now_total_count += $(this).find('[name=quantity\\[\\]]').val() * selected_unit.data('quantity-in-small-unit')
                })

                let total_remain = this_product.max - now_total_count
                if(total_remain < (qty * converter)) {
                    const new_qty = Math.floor(total_remain/converter)
                    tr.find('[name=quantity\\[\\]]').val(new_qty)
                    tr.find('.input-quantity').val(formatNum(new_qty))
                }
            }

            $(document).on('input', '.input-unit-price', function() {
                const data_index = $(this).parent().parent().data('index')
                const price_el = $(`#tb-product tr[data-index=${data_index}] [name=product_unit_price\\[\\]]`)
                const max_price = parseFloat($(this).attr('data-unit-purchase'))
                const current_val = unformatNum($(this).val())

                price_el.val(current_val)
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
                row.find('.stock').html(formatNum(stock, true));
                row.find('.quantity_stock').html(unit);
                var quantity = row.find('.quantity').val();

                let last_price_el = row.find('.last_price')
                let last_qty_el = row.find('.last_qty')
                let cust_name = $('#cust-name').val()
                let cust_address = $('#cust-address').val()
                let product_unit_id = row.find('.product-unit').val()

                const latest_buy = await getLatestBuy(cust_name, cust_address, product_unit_id, false)
                const latest_price = (latest_buy && latest_buy.selling_price ? latest_buy.selling_price : false)
                const latest_qty = (latest_buy && latest_buy.quantity ? latest_buy.quantity : false)
                const latest_purchase_price = await getLatestPurchase(row.data('id') , product_unit_id)
                
                row.find('.input-unit-price').attr('data-unit-purchase', latest_purchase_price)
                row.find('.input-unit-price').val(formatNum((latest_price ? latest_price : selectedPrice), true));
                row.find('[name=product_unit_price\\[\\]]').val((latest_price ? latest_price : selectedPrice));
                row.find('.input-selling-price').val(formatNum((latest_price ? latest_price : selectedPrice), true));
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
                let tr = $(this).closest('tr')
                let product_id = tr.data('id')
                tr.remove()
                if($(`#tb-product [data-id=${product_id}]`).length == 0) {
                    let this_product = selected_products.find(prod => prod.id == product_id)
                    let index_product = selected_products.indexOf(this_product)
                    selected_products.splice(index_product, 1)
                }
                changeTotalPrice()
            })

            async function getLatestBuy(buyer_name, buyer_address, product_unit_id, price_only = true) {
                try {
                    const res = await axios.get(`{{ route('transaction.find-by-user-product') }}?buyer_name=${buyer_name}&buyer_address=${buyer_address}&product_unit_id=${product_unit_id}`);
                    if (res.data && res.data.data) {
                        return price_only ? res.data.data.selling_price : res.data.data;
                    } else {
                        return {};
                    }
                } catch (err) {
                    return {};
                }
            }


            async function getLatestPurchase(product_id, product_unit_id) {
                const obj_purchase = await axios.get(`{{ route('find.product.last-purchase') }}?product_id=${product_id}&product_unit_id=${product_unit_id}`)
                return obj_purchase.data.data
            }

            function changeAllProductLastPrice() {
                const cust_name = $('#cust-name').val()
                const cust_address = $('#cust-address').val()
                $('#tb-product tr[data-index]').each(async function(index) {
                    const product_unit_id = $(this).find('.product-unit').val();
                    const latest_buy = await getLatestBuy(cust_name, cust_address, product_unit_id, false)
                    const latest_price = (latest_buy && latest_buy.selling_price ? latest_buy.selling_price : false)
                    const latest_qty = (latest_buy && latest_buy.quantity ? latest_buy.quantity : false)
                    const last_price_el = $(this).find('.last_price')
                    const last_qty_el = $(this).find('.last_qty')

                    const orig_price = $(this).find('.product-unit :selected').data('selling-price')
                    const price = (latest_price ? latest_price : orig_price)
                    const qty = $(this).find('[name=quantity\\[\\]]').val()
                    const total = price * qty

                    $(this).find('.input-unit-price').val(formatNum(price, true))
                    $(this).find('[name=product_unit_price\\[\\]]').val(price)
                    $(this).find('[name=selling_price\\[\\]]').val(total)
                    $(this).find('input-selling-price').val(formatNum(total, true))
                    changeTotalPrice()
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
                    $('#formatted_return').val(formatNum(returnAmount, true));
                } else {
                    $('#return').val(0);
                    $('#formatted_return').val(0);
                }
                changeDebtValue()
                checkIsHasError()
            }

            $(document).on('click', '[name=status_payment\\[\\]]', function() {
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

                if($('#hutang').is(':checked') && $('#tunai').is(':checked')) $('#return_pay').hide()
                else $('#return_pay').show()

                if(!$('#hutang').is(':checked') && !$('#tunai').is(':checked')) {
                    $('[data-check-id=tunai]').removeClass('btn-light-primary')
                    $('[data-check-id=tunai]').addClass('btn-primary')
                    $(`#tunai`).prop('checked', true)
                    changeMethod()
                }
                checkIsHasError()
            }

            checkIsHasError()

            function checkProductPriceMoreThanPurchase() {
                const tr_el = document.querySelectorAll('#tb-product [data-index]')

                tr_el.forEach((el, index) => {
                    const input_unit_price_el = el.querySelector('.input-unit-price')
                    const max_price = parseFloat(input_unit_price_el.getAttribute('data-unit-purchase'))
                    const current_value = unformatNum(input_unit_price_el.value)

                    if(max_price >= current_value) {
                        input_unit_price_el.classList.add('is-invalid')
                        $(input_unit_price_el).tooltip('hide')
                        setTimeout(() => {
                            $(input_unit_price_el).tooltip('show')
                        }, 150);
                    } else {
                        input_unit_price_el.classList.remove('is-invalid')
                        $(input_unit_price_el).tooltip('hide')
                    }
                })
            }

            async function checkIsHasError() {
                let count_error = 0

                if(!$('#cust-name').val()) {
                    count_error++
                    $('#cust-name ~ .selectize-control').addClass('is-invalid')
                } else {
                    $('#cust-name ~ .selectize-control').removeClass('is-invalid')
                }

                if(!$('#cust-address').val()) {
                    count_error++
                    $('#cust-address').addClass('is-invalid')
                } else {
                    $('#cust-address').removeClass('is-invalid')
                }

                const code_already_used = await errorCode()
                count_error += code_already_used

                if(!$('#code').val() || code_already_used) {
                    count_error++
                    $('#code').addClass('is-invalid')
                } else {
                    $('#code').removeClass('is-invalid')
                }

                if($('#tb-product [data-index]').length < 1) count_error++
                count_error += paymentMethodError()

                checkProductPriceMoreThanPurchase()
                
                if(count_error == 0) {
                    $('button[type=submit]').removeClass('disabled')
                    $('#btn-open-modal').removeClass('disabled')
                    $('#btn-open-modal').removeClass('btn-disabled')
                    $('#btn-open-modal').addClass('btn-success')
                }
                else {
                    $('#btn-open-modal').addClass('btn-disabled')
                    $('#btn-open-modal').removeClass('btn-success')
                    $('button[type=submit]').addClass('disabled')
                    $('#btn-open-modal').addClass('disabled')
                }

                return count_error
            }

            function changeDebtValue() {
                if(!$('#hutang').is(':checked')) {
                    $('[name=debt]').val(0)
                    return
                }
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

            let timeout_input
            $(document).on('input', function() {
                clearTimeout(timeout_input)
                timeout_input = setTimeout(() => {
                    checkIsHasError()
                }, 300);
            })

            function paymentMethodError() {
                const data_store_code = "{{$store->code_debt}}"
                const total_must_paid = unformatNum($('#total_price').html().replace('Rp ', ''))
                const selected_buyer = select_cust.getValue()
                const data_buyer = select_cust.options[selected_buyer]

                const limit_debt = (data_buyer ? data_buyer.limitDebt : 1_000_000)
                const current_debt = (data_buyer ? data_buyer.debt : 0)
                const alreadyExceededLimit = (data_buyer ? data_buyer.hasExceededLimit : false)

                if(!$('#hutang').is(':checked')) {
                    const money_paid = $('#pay').val()
                    if(total_must_paid > parseFloat(money_paid)) {
                        $('#formatted_pay').addClass('is-invalid')
                        return 1
                    } 
                    $('#formatted_pay').removeClass('is-invalid')
                } else {
                    $('#formatted_pay').removeClass('is-invalid')
                    const new_debt = parseFloat($('[name=debt]').val()) ? parseFloat($('[name=debt]').val()) : 0
                    if(
                        ((limit_debt < (current_debt + new_debt)) || alreadyExceededLimit)
                    ) {
                        $('[name=code_debt]').closest('.row').show()
                        if($('[name=code_debt]').val() === data_store_code) $('[name=code_debt]').removeClass('is-invalid')
                        else {
                            $('[name=code_debt]').addClass('is-invalid')
                            return 1
                        }
                    } else {
                        $('[name=code_debt]').closest('.row').hide()
                    }
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
        })
    </script>
</body>
</html>