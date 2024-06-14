@php
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.dashboard')
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
                                    Tambah Produk
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
        <form action="" method="get">
            <div class="row justify-content-end">
                <div class="col-3">
                    <input type="text" name="name" value="{{ Request::get('name') }}" class="form-control"
                        id="nametext" aria-describedby="name" placeholder="Name" />
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" value="{{ Request::get('daterange') }}" id="daterange"
                        name="daterange" value="" />
                </div>
                <div class="col-1">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>
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
                                    <td>Detail</td>
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
@endsection
@section('script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
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
