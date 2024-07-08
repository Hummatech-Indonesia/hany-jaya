@php
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.dashboard')
@push("title")
    Beranda
@endpush
@section('content')
    <div class="container-fluid max-w-full">
        <div class="row">
            <div class="col-lg-3">
                <div class="card bg-primary-subtle p-3 position-relative overflow-hidden">
                    <p class="fs-3">Total Penjualan</p>
                    <h4 class="fw-semibold fs-7">{{ $selling_count }}</h4>
                    <i class="ti ti-shopping-cart icon-head"></i>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card bg-info-subtle p-3 position-relative overflow-hidden">
                    <p class="fs-3">Total Omset</p>
                    <h4 class="fw-semibold fs-7">{{ FormatedHelper::rupiahCurrency($selling_sum) }}</h4>
                    <i class="ti ti-chart-line icon-head"></i>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card bg-success-subtle p-3 position-relative overflow-hidden">
                    <p class="fs-3">Total Produk</p>
                    <h4 class="fw-semibold fs-7">{{ $product_count }}</h4>
                    <i class="ti ti-package icon-head"></i>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card bg-warning-subtle p-3 position-relative overflow-hidden">
                    <p class="fs-3">Jumlah Piutang</p>
                    <h4 class="fw-semibold fs-7">{{ FormatedHelper::rupiahCurrency($debt) }}</h4>
                    <i class="ti ti-wallet icon-head"></i>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Weekly Stats -->
            <div class="col-lg-5 d-flex align-items-center">
                <div class="card w-100">
                    <div class="card-header text-center">
                        <span class="fw-bold">Jumlah Penjualan Per Kategori Produk</span>
                    </div>
                    <div class="card-body">
                        <div id="pieChart"></div>
                    </div>
                </div>
            </div>
            <!-- Top Performers -->
            <div class="col-lg-7 d-flex align-items-strech">
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
        </div>
    </div>

    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $.ajax({
            type: "GET",
            url: "{{ route('admin.get.category.ajax') }}",
            success: function(response) {
                let labels = [];
                let series = [];
                let colors = []
                let count = 0; // Inisialisasi count sebelum melakukan penambahan
                $.each(response, function(index, value) {
                    labels.push(value.name);
                    count = 0;
                    $.each(value.products, function(i, item) {
                        if (item.category_id === value.id) {
                            count += item.detail_sellings_count;
                        }
                    });
                    series.push(count);

                    // Menambah total detail sellings count ke dalam series
                });

                if(labels.length < 1) {
                    labels.push("kosong")
                    series.push(1)
                    colors.push("#aaaaaa")
                }

                var options = {
                    series: series,
                    chart: {
                        width: 300,
                        type: 'pie',
                    },
                    colors: colors,
                    labels: labels,
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#pieChart"), options);
                chart.render();

            }
        });
    </script>
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/css/icons.css')}}">
    <style>
        .icon-head {
            position: absolute;
            right: -20px;
            bottom: -20px;
            font-size: 7rem;
            opacity: 20%;
        }
    </style>
@endsection
