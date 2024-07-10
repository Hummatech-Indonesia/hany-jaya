@php
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.dashboard')
@push("title")
    Beranda
@endpush
@section('content')
    <div class="container-fluid max-w-full">
        <div class="d-flex mb-4 justify-content-end">
            @include('dashboard.home.widgets.select-year')
        </div>
        @include('dashboard.home.widgets.scorecard')
        <div class="row">
            <!-- Weekly Stats -->
            <div class="col-lg-5 d-flex align-items-stretch mb-4">
                <div class="card w-100 h-100 mb-0">
                    <div class="card-header text-center bg-primary text-white">
                        <span class="fw-bolder">Jumlah Penjualan Per Kategori Produk</span>
                    </div>
                    <div class="card-body">
                        @include('dashboard.home.widgets.pie-product')
                    </div>
                </div>
            </div>
            <!-- Top Performers -->
            <div class="col-lg-7 d-flex d-none align-items-strech">
                @if($buyers->isEmpty())
                    <div class="card align-self-start w-100 bg-light-info shadow-none position-relative overflow-hidden">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h4 class="fw-semibold mb-8">Data Transaksi Masih Kosong</h4>
                                </div>
                                <div class="col-5">
                                    <img src="{{asset('assets/images/backgrounds/piggy.png')}}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card border w-100">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-striped table-hover text-center mb-0">
                                    <thead>
                                        <tr class="text-muted text-nowrap fw-semibold">
                                            <th>Username</th>
                                            <th>Alamat</th>
                                            <th>Nominal Pembelian</th>
                                            <th>Hutang</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-top">
                                        @foreach ($buyers as $buyer)
                                            <tr>
                                                <th>
                                                    <p class="fs-2 mb-0">{{ $buyer->name }}</p>
                                                </th>
                                                <td>
                                                    <p class="mb-0 fs-3">{{ $buyer->address }}</p>
                                                </td>
                                                <td>
                                                    <p class="mb-0 fs-3">
                                                        {{ FormatedHelper::rupiahCurrency($buyer->sellings_sum_amount_price) }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="fs-3 text-dark mb-0">
                                                        {{ FormatedHelper::rupiahCurrency($buyer->debt) }}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- top buyer --}}
            <div class="col-12 col-lg-7 align-items-strech mb-4">
                <div class="card w-100 h-100 mb-0">
                    <div class="card-header bg-primary text-white fw-bolder text-center">Pembeli Terbanyak</div>
                    <div class="card-body pt-0">
                        @include('dashboard.home.widgets.dt-top-buyer')
                    </div>
                </div>
            </div>

            {{-- sellings chart --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header fw-bolder text-center bg-primary text-white" id="selling-title">Penjualan Tahunan</div>
                    <div class="card-body">
                        @include('dashboard.home.widgets.chart-sellings')
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"></script>
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/css/icons.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.min.css"/>

    <style>
        .icon-head {
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 7rem;
            opacity: 20%;
        }
        .scorecard:hover {
            opacity: .7;
        }
    </style>
@endsection
