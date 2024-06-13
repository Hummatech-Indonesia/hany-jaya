@php
    use App\Enums\StatusEnum;
@endphp
@extends('dashboard.layouts.cashier')
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
            <div class="col-9 mt-3">
                <div class="mb-3">
                    <form id="myInput">
                        <input type="text" class="form-control" name="code" id="code" placeholder="8996196005009" autofocus>
                        <span class="help-block"><small>Silakan memasukkan nama produk atau kode
                                produk.</small></span>
                    </form>
                </div>
            </div>
            <form action="{{ route('cashier.selling.store') }}" method="post">
                @csrf
                <div class="grid col-12">
                    <div class="row">
                        <div class="col-9 mt-3">
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
                                                                Harga
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
                                                        <h6 class="fs-4 fw-semibold mb-0 text-start" id="total_price">
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
                        <div class="col-3 mt-3">
                            <div class="mb-n5">
                                <div class="card p-4">
                                    <div class="">
                                        <h5 class="fw-bold text-dark">Data Pembeli</h5>
                                        <div>
                                            <label for="customer-name" class="mb-2">Nama: </label>
                                            <input id="customer-name" type="text" placeholder="Alfan" name="name"
                                                class="form-control mb-2">
                                            <label for="customer-address" class="mb-2">Alamat: </label>
                                            <textarea name="address" placeholder="Jl pemuda No. 29" id="customer-address" class="form-control" cols="30"
                                                rows="3"></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="">
                                        <p class="mb-2">Pilih Metode Pembayaran</p>
                                        <div class="d-flex flex-row gap-3">
                                            <div><input type="radio" value="{{ StatusEnum::CASH->value }}"
                                                    name="status_payment" style="margin-right: 3px;" id="tunai"><label
                                                    for="tunai">Tunai</label></div>
                                            <div><input type="radio" value="{{ StatusEnum::DEBT->value }}"
                                                    name="status_payment" style="margin-right: 3px;" id="hutang"><label
                                                    for="hutang">Hutang</label></div>
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
                                                aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div id="code_debt">
                                        <label for="">Masukkan Kode Toko: </label>
                                        <input type="text" class="form-control" name="code_debt" id="">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">
                                        Bayar
                                    </button>
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
    <script>
        $(document).ready(function() {
            $('#myInput').submit(function(event) {
                event.preventDefault();
                sendData();
                $('#code').val('')
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
                        // var total
                        var newRow = `<tr>
                        <td>
                            <h6 class="fs-4 fw-semibold mb-0 text-start">
                                ${response.data.name}
                            </h6>
                            <input type="hidden" name="product_id[]" value="${response.data.id}" readonly class="form-control" />
                        </td>
                        <td>
                            <h6 class="fs-4 fw-semibold mb-0 text-start">
                                <span class="stock">${response.data.quantity}</span> <span class="quantity_stock">${response.data.unit.name}</span>
                            </h6>
                        </td>
                        <td>
                            <select id="product_unit_${response.data.id}-${index}" name="product_unit_id[]" class="form-control product-unit">
                                <option value="">Pilih Satuan</option>`;
                        $.each(response.data.product_units, function(index, productUnit) {
                            var selected = index === 0 ? 'selected' :
                                '';
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
                            <input type="text" value="${response.data.product_units[0].selling_price}" name="selling_price[]" id="price-${response.data.id}-${index}" class="form-control selling-price" />
                        </td>
                        <td>
                            <a id="delete_column" class="btn btn-danger">-</a>
                        </td>
                    </tr>`;
                        $('#field').append(newRow);

                        $(document).on('click', '#delete_column', function() {
                            $(this).closest('tr')
                                .remove();
                        });
                        $('.quantity').keyup(function() {
                            var id = $(this).data('id')
                            var productId = $('#product_unit_' + id).val()
                            var price = $('#selling-price-' + productId).data('selling-price')

                            $('#price-' + id).val(price * $(this).val())

                            var sellingPrices = $('.selling-price').map(function() {
                                return parseFloat($(this).val());
                            }).get();

                            var countTotalPrice = 0;
                            $(sellingPrices).each(function(index, sellingPrice) {
                                countTotalPrice += sellingPrice;
                            });
                            $('#total_price').html(countTotalPrice);
                        })

                        index++;
                    },
                });
            }
            $('#field').on('change', '.product-unit', function() {
                var row = $(this).closest('tr');
                var selectedPrice = row.find('.product-unit option:selected').data('selling-price');
                var quantity_in_small_unit = row.find('.product-unit option:selected').data(
                    'quantity-in-small-unit');
                var quantity = row.find('.product-unit option:selected').data(
                    'quantity');
                var unit = row.find('.product-unit option:selected').data(
                    'unit');
                var stock = quantity / quantity_in_small_unit;
                $('.stock').html(stock);
                $('.quantity_stock').html(unit);
                var quantity = row.find('.quantity').val();
                var totalPrice = selectedPrice * quantity;
                var sellingPrices = $('.selling-price').map(function() {
                    return parseFloat($(this).val());
                }).get();

                var countTotalPrice = 0;
                $(sellingPrices).each(function(index, sellingPrice) {
                    countTotalPrice += sellingPrice;
                });
                $('#total_price').html(countTotalPrice);
                row.find('.selling-price').val(totalPrice);
            });
        });


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
    </script>
@endsection
