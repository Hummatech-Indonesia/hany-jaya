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
            <div class="col-12 mt-3">
                <div class="text-center mb-n5">
                    <div class="card">
                        <form action="{{ route('cashier.selling.store') }}" method="post">
                            @csrf
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
                                                <h6 class="fs-4 fw-semibold mb-0 text-start">
                                                    Rp.67.000
                                                </h6>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row">
                                    <button class="btn btn-primary">
                                        Bayar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
                                <span class="stock">${response.data.quantity}</span> <span class="quantity_stock">${response.data.unit.name}</span>
                            </h6>
                        </td>
                        <td>
                            <select id="product_unit_${response.data.id}" name="product_unit_id[]" class="form-control product-unit">
                                <option value="">Pilih Satuan</option>`;
                        $.each(response.data.product_units, function(index, productUnit) {
                            newRow += `<option value="${productUnit.id}" data-unit="${productUnit.unit.name}" id="selling-price-${productUnit.id}" data-selling-price="${productUnit.selling_price}" data-quantity-in-small-unit="${productUnit.quantity_in_small_unit}" data-quantity="${response.data.quantity}">
                            ${productUnit.unit.name}
                        </option>`;
                        });
                        newRow += `</select>
                        </td>
                        <td>
                            <input type="number" data-id="${response.data.id}" name="quantity[]" class="form-control quantity" placeholder="0" min="1" value="1" />
                        </td>
                        <td>
                            <input type="text" name="selling_price[]" id="price-${response.data.id}" class="form-control selling-price" />
                        </td>
                    </tr>`;
                        $('#field').append(newRow);

                        $('.quantity').keyup(function() {
                            var id = $(this).data('id')
                            var productId = $('#product_unit_' + id).val()
                            var price = $('#selling-price-' + productId).data('selling-price')

                            $('#price-' + id).val(price * $(this).val())
                        })
                    },
                });
            }
            $('#field').on('change', '.product-unit, .quantity', function() {
                var row = $(this).closest('tr');
                var selectedPrice = row.find('.product-unit option:selected').data('selling-price');
                var quantity_in_small_unit = row.find('.product-unit option:selected').data(
                    'quantity-in-small-unit');
                var quantity = row.find('.product-unit option:selected').data(
                    'quantity-in-small-unit');
                var unit = row.find('.product-unit option:selected').data(
                    'unit');
                var stock = quantity / quantity_in_small_unit;
                $('.stock').html(stock);
                $('.quantity_stock').html(unit);
                var quantity = row.find('.quantity').val();
                var totalPrice = selectedPrice * quantity;
                row.find('.selling-price').val(totalPrice);
            });
        });
    </script>
@endsection
