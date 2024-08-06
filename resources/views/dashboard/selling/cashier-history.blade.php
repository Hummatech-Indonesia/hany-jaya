@php
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.dashboard')
@section('content')
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Riwayat Penjualan</h4>
                        <p>Riwayat Penjualan di toko anda.</p>
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
        @include('dashboard.selling.widgets.dt-selling-history')
    </div>
    @include('dashboard.selling.widgets.detail-invoice')
@endsection
@section('style')
    <link href="{{asset('assets/libs/datatablesnet/datatables.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/libs/daterangepicker/daterangepicker.css')}}">
@endsection
@section('script')
    <script src="{{asset('assets/libs/momentjs/moment.min.js')}}"></script>
    <script src="{{asset('assets/libs/momentjs/moment-with-locales.min.js')}}"></script>
    <script src="{{asset('assets/libs/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    
    <script src="{{asset('assets/libs/datatablesnet/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/datatables.min.js')}}"></script>
    <script>
        $(".btn-detail").on("click", function() {
            $("#value_table").empty();
            $("#modalDetailHistory").modal("show");
            let detailSellings = $(this).data("detail-selling");
            let name = $(this).data('name');
            let returns = $(this).data('return');
            let address = $(this).data('address');
            let status_payment = $(this).data('status_payment');
            let price = $(this).data('price');
            let pay = $(this).data('pay');
            // if (status_payment == 'debt') {
            //     $('.sembuyikan').hide();
            // } else {
            //     $('.sembunyikan').show();
            //     $('#return').html(formatRupiah(returns));
            //     $('#pay').html(formatRupiah(pay));
            // }

            $('#name').html(name);
            $('#price').html(formatRupiah(price));
            $('#address').html(address);
            if (status_payment == 'debt') {
                $('#status').html('<span class="mb-1 badge font-medium bg-danger text-white">Hutang</span>');
                $('#box_price').html(
                    `<tr>
                        <td colspan="5" class="text-end fw-bold">Total Harga</td>
                        <td>Rp. <span id="price">${formatRupiah(price)}</span></td>
                    </tr>`
                );
            } else {
                $('#status').html('<span class="mb-1 badge font-medium bg-success text-white">Tunai</span>');
                $('.sembunyikan').show();
                $('#return').html(formatRupiah(returns));
                $('#pay').html(formatRupiah(pay));
                $('#box_price').html(
                    `<tr>
                    <td colspan="5" class="text-end fw-bold">Total Harga</td>
                    <td>Rp. <span id="price">${formatRupiah(price)}</span></td>
                </tr>
                <tr>
                    <td colspan="5" class="text-end fw-bold">Uang Dibayar</td>
                    <td>Rp. <span id="pay">${formatRupiah(pay)}</span></td>
                </tr>
                <tr>
                    <td colspan="5" class="text-end fw-bold">Uang Kembalian</td>
                    <td>Rp. <span id="return">${formatRupiah(returns)}</span></td>
                </tr>`
                );
            }

            detailSellings.forEach(function(item, index) {
                console.log(item);
                $("#value_table").append(
                    `
                <tr class="search-items">
                    <td>${index + 1}</td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams">${item.product.name}</h6></td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams">${item.product_unit.unit.name}</h6></td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams">${item.quantity}</h6></td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams">RP. ${formatRupiah(item.nominal_discount)}</h6></td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams">Rp. ${formatRupiah(item.selling_price)}</h6></td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams"></h6></td>
                </tr>
                `
                );
            });
        });

        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan;
        }
    </script>
@endsection
