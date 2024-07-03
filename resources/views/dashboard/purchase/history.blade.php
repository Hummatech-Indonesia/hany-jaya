@php
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.dashboard')
@push("title")
    Riwayat Pembelian
@endpush
@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Riwayat Pembelian</h4>
                        <p>Riwayat pembelian di toko anda.</p>
                        @role('admin')
                            <a href="{{ route('admin.purchases.create') }}">
                                <button type="button" class="btn btn-primary">
                                    Tambah Pembelian
                                </button>
                            </a>
                        @endrole
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
        <div class="row">
            <div class="col-12">
                <form action="" method="get">
                    <div class="d-flex flex-row gap-2 justify-content-end">
                        <div class="col-md-3 col-sm-5">
                            <input type="text" name="name" value="{{ Request::get('name') }}" class="form-control"
                                id="nametext" aria-describedby="name" placeholder="Name" />
                        </div>
                        <div class="col-md-3 col-sm-5">
                            <input type="text" class="form-control" value="{{ Request::get('daterange') }}" id="daterange"
                                name="daterange" value="" />
                        </div>
                        <button type="submit" class="btn btn-primary">Cari</button>
                        
                    </div>
                </form>
            </div>
        </div>
        <div class="widget-content searchable-container list mt-4">
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table search-table align-middle text-nowrap">
                        <thead class="header-item">
                            <th>#</th>
                            <th>No Invoice</th>
                            <th>Total Harga Beli</th>
                            <th>Tanggal Pembelian</th>
                            <td>Detail</td>
                        </thead>
                        <tbody>
                            @forelse ($purchases as $index => $purchase)
                                <tr class="search-items">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ $purchase->invoice_number }}
                                        </h6>
                                    </td>
                                    <td>{{ FormatedHelper::rupiahCurrency($purchase->buy_price) }}</td>
                                    <td>
                                        <h6 class="user-name mb-0" data-name="Emma Adams">
                                            {{ FormatedHelper::dateTimeFormat($purchase->created_at) }}
                                        </h6>
                                    </td>
                                    <td><svg xmlns="http://www.w3.org/2000/svg" class="btn-detail"
                                            data-detail-purchase="{{ $purchase->detailPurchase }}"
                                            data-name="{{ $purchase->user->name }}"
                                            data-invoice-number="{{ $purchase->invoice_number }}"
                                            data-price="{{ $purchase->buy_price }}"
                                            data-status_payment="{{ $purchase->status_payment }}"
                                            data-address="{{ $purchase->supplier->address }}" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                        </svg></td>
                                </tr>
                            @empty
                                <p>Data pembelian masih kosong</p>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $purchases->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.selling.widgets.detail-purchase')
@endsection
@section('script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(".btn-detail").on("click", function() {
            $("#modalDetailHistory").modal("show");
            let detailPurchase = $(this).data("detail-purchase");
            let name = $(this).data('name');
            let invoice_number = $(this).data('invoice-number');
            let supplier = $(this).data('supplier');
            let price = $(this).data('price');
            let pay = $(this).data('pay');
            console.log(detailPurchase.product.name);
            console.log(name, price)

            $('#name').html(name);
            $('#invoice_number').html(invoice_number);
            $('#price').html(price.toLocaleString());

            $('#value_table').empty();
            console.log(detailPurchase);
            // $.each(detailPurchase, function(index, item) {
                $("#value_table").append(
                    `
                <tr class="search-items">
                    <td><h6 class="user-name mb-0">1</h6></td>
                    <td><h6 class="user-name mb-0">${detailPurchase.product.name}</h6></td>
                    <td><h6 class="user-name mb-0">${detailPurchase.product_unit.unit.name}</h6></td>
                    <td><h6 class="user-name mb-0">${detailPurchase.quantity}</h6></td>
                    <td><h6 class="user-name mb-0">Rp. 100.000</h6></td>
                    <td><h6 class="user-name mb-0">Rp. 100.000</h6></td>
                    <td><h6 class="user-name mb-0"></h6></td>
                </tr>
                `
                );
            // });

        });
        $(function() {
            // var yesterday = moment().subtract(1, 'days').format('MM/DD/YYYY');
            // var today = moment().format('MM/DD/YYYY');

            // $('#daterange').val(yesterday + ' - ' + today);

            $('#daterange').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
            });
        });
    </script>
@endsection
