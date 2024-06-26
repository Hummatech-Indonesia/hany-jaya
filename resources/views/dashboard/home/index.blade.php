@php
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card p-3">
                            <p class="fs-3">Total Penjualan</p>
                            <h4 class="fw-semibold fs-7">{{ $selling_count }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card p-3">
                            <p class="fs-3">Total Omset</p>
                            <h4 class="fw-semibold fs-7">{{ FormatedHelper::rupiahCurrency($selling_sum) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card p-3">
                            <p class="fs-3">Total Produk</p>
                            <h4 class="fw-semibold fs-7">{{ $product_count }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card p-3">
                            <p class="fs-3">Jumlah Piutang</p>
                            <h4 class="fw-semibold fs-7">{{ FormatedHelper::rupiahCurrency($debt) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Weekly Stats -->
            <div class="col-lg-4 d-flex align-items-strech">
                <div class="card" id="pieChart"></div>
            </div>
            <!-- Top Performers -->
            <div class="col-lg-8 d-flex align-items-strech">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle text-nowrap mb-0">
                                <thead>
                                    <tr class="text-muted fw-semibold">
                                        <th scope="col" class="ps-0">Username</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Nominal Pembelian</th>
                                        <th scope="col">Hutang</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top">
                                    @foreach ($buyers as $buyer)
                                        <tr>
                                            <td class="ps-0">
                                                <p class="fs-2 mb-0 text-muted">{{ $buyer->name }}</p>
                                            </td>
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
                let count = 0; // Inisialisasi count sebelum melakukan penambahan
                $.each(response, function(index, value) {
                    labels.push(value.name);
                    count = 0;
                    $.each(value.products, function(i, item) {
                        if (item.category_id === value.id) {
                            count += item.detail_sellings_count;
                        }
                    });
                    console.log(count);
                    series.push(count);

                    // Menambah total detail sellings count ke dalam series
                });

                // console.log(series);
                var options = {
                    series: series,
                    chart: {
                        width: 380,
                        type: 'pie',
                    },
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
