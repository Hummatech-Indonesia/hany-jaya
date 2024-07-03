@php
    use App\Enums\StatusEnum;
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.cashier')
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="flex-col px-5 mt-5 pt-5 mx-0" style="width: 100%">
        <div class="row">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-12 mt-3">
                <form action="{{ route('cashier.selling.store') }}" method="post">
                    @csrf
                    <div class="grid col-12">
                        <div class="row">
                            <div class="col-9 mt-3" style="margin-bottom: 2rem">
                                <div class="mb-n5">
                                    <div class="card p-4">
                                        <h5 class="fw-bold text-dark">Data Pembeli</h5>
                                        <label for="customer-name" class="mb-2">Nama: </label>
                                        <select name="name" class="select2Input form-control" id="customer-name">
                                            <option value="">Pilih Pembeli</option>
                                            @foreach ($buyers as $buyer)
                                                <option value="{{ $buyer->name }}">{{ $buyer->name }}</option>
                                            @endforeach
                                        </select>

                                        <div class="">
                                            <div>
                                                <label for="customer-address" class="mb-2">Alamat: </label>
                                                <textarea name="address" placeholder="Jl pemuda No. 29" id="customer-address" class="form-control" cols="30"
                                                    rows="3"></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="mb-n5">
                                    <div class="card p-4">
                                        <div class="">
                                            <div class="d-flex justify-content-between">
                                                <h5>Data Kasir</h5>
                                                <p>{{ FormatedHelper::dateTimeFormat(now()) }}</p>
                                            </div>
                                            <div class="">
                                                <p class="font-bold"><span style="font-weight: 700"> Nama:</span>
                                                    {{ auth()->user()->name }}</p>
                                                <p class="font-bold"><span style="font-weight: 700"> Email:</span>
                                                    {{ auth()->user()->email }}</p>
                                            </div>
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <div class="card p-4" id="dataCustomer">
                                        <div class="">
                                            <div class="d-flex justify-content-between">
                                                <h5>Data Pembeli</h5>
                                                <p>{{ FormatedHelper::dateTimeFormat(now()) }}</p>
                                            </div>
                                            <div class="">
                                                <p class="font-bold"><span style="font-weight: 700" id="customerNama">
                                                        Nama:</span>
                                                </p>
                                                <p class="font-bold"><span style="font-weight: 700" id="customerAddress">
                                                        Alamat:</span>
                                                </p>
                                            </div>

                                            <div class="border-top">
                                                <p class="mb-2">Pilih Metode Pembayaran</p>
                                                <div class="d-flex flex-row gap-3">
                                                    <div><input type="radio" value="{{ StatusEnum::CASH->value }}"
                                                            name="status_payment" style="margin-right: 3px;"
                                                            id="tunai"><label for="tunai">Tunai</label></div>
                                                    <div><input type="radio" value="{{ StatusEnum::DEBT->value }}"
                                                            name="status_payment" style="margin-right: 3px;"
                                                            id="hutang"><label for="hutang">Hutang</label></div>
                                                </div>
                                                <br>
                                            </div>
                                            <div id="cash">
                                                <label for="pay" class="mb-2">Bayar: </label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                    <input type="number" placeholder="10000" min="0" id="pay"
                                                        name="pay" class="form-control" aria-label="Username"
                                                        aria-describedby="basic-addon1">
                                                </div>
                                                <label for="return" class="mb-2">Kembali: </label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                    <input type="number" min="0" placeholder="5000" id="return"
                                                        name="return" class="form-control" aria-label="Username"
                                                        aria-describedby="basic-addon1" readonly>
                                                </div>
                                            </div>
                                            <div id="code_debt">
                                                <label for="">Masukkan Kode Toko: </label>
                                                <input type="text" class="form-control" name="code_debt"
                                                    id="">
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-3">
                                                Bayar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5" id="productPage">
                                <div class="col-12 mt-3">
                                    <select name="code" class="select2 form-control" name="code" id="code">
                                        <option value="">Pilih Produk</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->code }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="mb-3">
                                        <span class="help-block"><small>Silakan memasukkan nama produk atau kode
                                                produk.</small></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="mb-n5">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive mb-4 border rounded-1">
                                                    <table class="table text-nowrap mb-0 align-middle">
                                                        <thead class="text-dark fs-4">
                                                            <tr>
                                                                <th>
                                                                    <h6 class="fs-4 fw-semibold mb-0 text-start">
                                                                        Produk
                                                                    </h6>
                                                                </th>
                                                                <th>
                                                                    <h6 class="fs-4 fw-semibold mb-0 text-start">
                                                                        Stok Produk Saat Ini
                                                                    </h6>
                                                                </th>
                                                                <th>
                                                                    <h6 class="fs-4 fw-semibold mb-0 text-start">
                                                                        Satuan
                                                                    </h6>
                                                                </th>
                                                                <th>
                                                                    <h6 class="fs-4 fw-semibold mb-0 text-start">
                                                                        Jumlah
                                                                    </h6>
                                                                </th>
                                                                <th>
                                                                    <h6 class="fs-4 fw-semibold mb-0 text-start">
                                                                        Harga Satuan
                                                                    </h6>
                                                                </th>
                                                                <th>
                                                                    <h6 class="fs-4 fw-semibold mb-0 text-start">
                                                                        Total Harga
                                                                    </h6>
                                                                </th>
                                                                <th>
                                                                    <h6 class="fs-4 fw-semibold mb-0 text-start">
                                                                        Aksi
                                                                    </h6>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="field">
                                                        </tbody>
                                                        <tr>
                                                            <td colspan="4">
                                                                <h6 class="fs-4 fw-semibold mb-0 text-center">
                                                                    Total Harga
                                                                </h6>
                                                            </td>
                                                            <td>
                                                                <h6 class="fs-4 fw-semibold mb-0 text-start"
                                                                    id="total_price">
                                                                    Rp.0
                                                                </h6>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
    @section('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $(".select2Input").select2({
                    tags: true,
                    placeholder: "Pilih atau tambahkan pembeli",
                });
            });

            $(".select2").select2({
                tags: false
            });

            $(document).ready(function() {
                $('#productPage').addClass('d-none');
                $('#customer-name').on('input', function() {
                    if ($('#customer-name').val()) {
                        $('#productPage').removeClass('d-none');
                    } else {
                        $('#productPage').addClass('d-none');
                    }
                });
            });


            $(document).ready(function() {
                $('#code').change(function(e) {
                    e.preventDefault();
                    console.log($('#code').val());
                    sendData();
                });
                var index = 1;

                function sendData() {
                    var code = $('#code').val();
                    $.ajax({
                        url: "{{ route('cashier.show.product') }}",
                        type: "GET",
                        data: {
                            code: code
                        },
                        dataType: 'json',
                        success: function(response) {
                            var newRow = `<tr>
                                                <td>
                                                    <h6 class="fs-4 fw-semibold mb-0 text-start">
                                                        ${response.data.name}
                                                    </h6>
                                                    <input type="hidden" name="product_id[]" value="${response.data.id}" readonly class="form-control" />
                                                </td>
                                                <td>
                                                    <h6 class="fs-4 fw-semibold mb-0 text-start">
                                                        <span class="stock">${Math.round(response.data.quantity)}</span> <span class="quantity_stock">${response.data.unit.name}</span>
                                                    </h6>
                                                </td>
                                                <td>
                                                    <select id="product_unit_${response.data.id}-${index}" name="product_unit_id[]" class="form-control product-unit">
                                                        <option value="">Pilih Satuan</option>`;
                            $.each(response.data.product_units, function(index, productUnit) {
                                var selected = response.data.unit.name === productUnit.unit.name ?
                                    'selected' : '';
                                newRow += `<option data-id="${response.data.id}-${index}" value="${productUnit.id}" data-unit="${productUnit.unit.name}" id="selling-price-${productUnit.id}" data-selling-price="${productUnit.selling_price}" data-quantity-in-small-unit="${productUnit.quantity_in_small_unit}" data-quantity="${response.data.quantity}" ${selected}>
                                                            ${productUnit.unit.name}
                                                        </option>`;
                            });
                            newRow += `</select>
                                                </td>
                                                <td>
                                                    <input type="number" data-id="${response.data.id}-${index}" name="quantity[]" class="form-control quantity" placeholder="0" min="1" value="1" />
                                                </td>
                                                <td>
                                                    <input type="text" value="${response.data.product_units[0].selling_price}" name="product_unit_price[]" id="unit-price-${response.data.id}-${index}" class="form-control unit-price" />
                                                </td>
                                                <td>
                                                    <input type="text" value="${response.data.product_units[0].selling_price}" name="selling_price[]" id="price-${response.data.id}-${index}" class="form-control selling-price" readonly />
                                                    </td>
                                                <td>
                                                    <a id="delete_column" class="btn btn-danger">-</a>
                                                </td>
                                                </tr>`;
                            $('#field').append(newRow);

                            updateTotalPrice();

                            $(document).on('click', '#delete_column', function() {
                                $(this).closest('tr').remove();
                                updateTotalPrice();
                            });
                            $('.quantity').keyup(function() {
                                updateRowPrice($(this));
                            });
                            var productUnit = 2;
                            var user = 3;
                            var result = productUnit / user;
                            $.ajax({
                                url: "{{ route('cashier.get.last.purchases', ['result' => '']) }}" +
                                    result,
                                type: "GET",
                                dataType: 'json',
                                success: function(response) {

                                }
                            });

                            index++;
                        },
                    });
                }

                $('#field').on('change', '.product-unit', function() {
                    var row = $(this).closest('tr');
                    var selectedPrice = row.find('.product-unit option:selected').data('selling-price');
                    var quantity_in_small_unit = row.find('.product-unit option:selected').data(
                        'quantity-in-small-unit');
                    var quantity = row.find('.product-unit option:selected').data('quantity');
                    var unit = row.find('.product-unit option:selected').data('unit');
                    var stock = Math.round(quantity / quantity_in_small_unit);
                    row.find('.stock').html(stock);
                    row.find('.quantity_stock').html(unit);
                    var quantity = row.find('.quantity').val();
                    var totalPrice = selectedPrice * quantity;
                    row.find('.unit-price').val(selectedPrice);
                    row.find('.selling-price').val(totalPrice);
                    updateTotalPrice();
                });

                function updateRowPrice(element) {
                    var id = element.data('id');
                    var productId = $('#product_unit_' + id).val();
                    var price = $('#unit-price-' + id).val(); // Mengambil harga satuan yang diubah
                    var totalPrice = price * element.val();
                    $('#price-' + id).val(totalPrice);
                    updateTotalPrice();
                }

                $('#field').on('keyup', '.unit-price', function() {
                    var row = $(this).closest('tr');
                    var quantity = row.find('.quantity').val();
                    var unitPrice = $(this).val();
                    var totalPrice = unitPrice * quantity;
                    row.find('.selling-price').val(totalPrice);
                    updateTotalPrice();
                });

                function updateTotalPrice() {
                    var sellingPrices = $('.selling-price').map(function() {
                        return parseFloat($(this).val());
                    }).get();

                    var countTotalPrice = 0;
                    $(sellingPrices).each(function(index, sellingPrice) {
                        countTotalPrice += sellingPrice;
                    });
                    $('#total_price').html('Rp.' + countTotalPrice);
                    updateReturnAmount();
                }

                $('#pay').keyup(function() {
                    updateReturnAmount();
                });

                function updateReturnAmount() {
                    var totalPrice = parseFloat($('#total_price').text().replace('Rp.', '').replace(',', ''));
                    var payment = parseFloat($('#pay').val());
                    var returnAmount = payment - totalPrice;
                    if (!isNaN(returnAmount) && returnAmount >= 0) {
                        $('#return').val(returnAmount);
                    } else {
                        $('#return').val(0);
                    }
                }

                $(document).ready(function() {
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
                });
            });
        </script>
    @endsection