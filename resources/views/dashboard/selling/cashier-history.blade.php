@php
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.cashier')
@section('content')
    <div class="container-fluid">
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
        <div class="widget-content searchable-container list mt-4">
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <th>#</th>
                            <th>No Invoice</th>
                            <th>Harga Total</th>
                            <th>Nama Pembeli</th>
                            <th>Tanggal Penjualan</th>
                            <th>Status Pembayaran</th>
                            <td>Aksi</td>
                        </thead>
                        <tbody>
                            @forelse ($histories as $index => $history)
                                <tr class="search-items">
                                    <td>
                                        {{ $index + 1 }}
                                    </td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ $history->invoice_number }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ FormatedHelper::rupiahCurrency($history->amount_price) }}
                                        </h6>
                                    </td>
                                    <td>
                                        <h6>{{ $history->buyer->name }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ FormatedHelper::dateTimeFormat($history->created_at) }}
                                        </h6>
                                    </td>
                                    <td>
                                        @if ($history->status_payment == 'debt')
                                            <h6>Hutang</h6>
                                        @else
                                            <h6>Tunai</h6>
                                        @endif
                                    </td>
                                    <td>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="btn-detail"
                                            data-detail-selling="{{ $history->detailSellings }}"
                                            data-name="{{ $history->buyer->name }}"
                                            data-price="{{ $history->amount_price }}" data-pay="{{ $history->pay }}"
                                            data-return="{{ $history->return }}"
                                            data-status_payment="{{ $history->status_payment }}"
                                            data-address="{{ $history->buyer->address }}" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                        </svg>
                                    </td>
                                </tr>
                            @empty
                                <p>Belum ada riwayat penjualan</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.selling.widgets.detail-invoice')
@endsection
@section('script')
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
            console.log(detailSellings);
            if (status_payment == 'debt') {
                $('.sembuyikan').hide();
            } else {
                $('#return').html(formatRupiah(returns));
                $('#pay').html(formatRupiah(pay));
            }

            $('#name').html(name);
            $('#price').html(formatRupiah(price));
            $('#address').html(address);

            detailSellings.forEach(function(item, index) {
                console.log(item);
                $("#value_table").append(
                    `
                <tr class="search-items">
                    <td>${index + 1}</td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams">${item.product.name}</h6></td>
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
