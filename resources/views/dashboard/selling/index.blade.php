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
            <form id="myInput">
                <div class="">
                    <input type="text" class="form-control" name="code" id="code" placeholder="8996196005009">
                </div>
            </form>
            <form action="{{ route('cashier.selling.store') }}" method="post">
                @csrf
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
                                                    Rp.67.000
                                                </h6>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="">
                                    {{-- <div class="d-flex justify-content-between mt-3">
                                        <h6 style="font-weight: bold">Diskon</h6>
                                        <input type="text" class="form-control" style="width: 15rem">
                                    </div> --}}
                                    <div class="d-flex justify-content-between mt-3">
                                        <h6 style="font-weight: bold">Bayar</h6>
                                        <input type="text" name="pay" class="form-control" style="width: 15rem">
                                    </div>
                                    <div class="d-flex justify-content-between mt-3">
                                        <h6 style="font-weight: bold">Kembalian</h6>
                                        <input type="text" name="return" class="form-control" style="width: 15rem">
                                    </div>
                                    <div class="mt-3">
                                        <div class="" style="border: 1px solid gray"></div>
                                        <div class="mt-3" style="font-weight: bold">
                                            <h5>Data Pembeli</h5>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <h6 style="font-weight: bold" class="mt-3">Nama</h6>
                                            <input type="text" name="name" class="form-control" style="width: 15rem">
                                        </div>
                                        <div class="d-flex justify-content-between mt-3 mb-3">
                                            <h6 style="font-weight: bold" class="mt-3">Alamat</h6>
                                            <textarea name="address" class="form-control" id="" cols="30" rows="5" style="width: 20.4%"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <button class="btn btn-primary">
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
    </script>
@endsection
