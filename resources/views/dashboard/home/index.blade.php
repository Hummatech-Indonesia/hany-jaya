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
    </div>
    <!--  Row 3 -->
    <div class="row">
        <!-- Weekly Stats -->
        <div class="col-lg-4 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <h5 class="card-title fw-semibold">Weekly Stats</h5>
                    <p class="card-subtitle mb-0">Average sales</p>
                    <div id="stats" class="my-4"></div>
                    <div class="position-relative">
                        <div class="d-flex align-items-center justify-content-between mb-7">
                            <div class="d-flex">
                                <div
                                    class="p-6 bg-light-primary rounded me-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-grid-dots text-primary fs-6"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fs-4 fw-semibold">Top Sales</h6>
                                    <p class="fs-3 mb-0">Johnathan Doe</p>
                                </div>
                            </div>
                            <div class="bg-light-primary badge">
                                <p class="fs-3 text-primary fw-semibold mb-0">+68</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-7">
                            <div class="d-flex">
                                <div
                                    class="p-6 bg-light-success rounded me-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-grid-dots text-success fs-6"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fs-4 fw-semibold">Best Seller</h6>
                                    <p class="fs-3 mb-0">MaterialPro Admin</p>
                                </div>
                            </div>
                            <div class="bg-light-success badge">
                                <p class="fs-3 text-success fw-semibold mb-0">+68</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex">
                                <div
                                    class="p-6 bg-light-danger rounded me-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-grid-dots text-danger fs-6"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fs-4 fw-semibold">Most Commented</h6>
                                    <p class="fs-3 mb-0">Ample Admin</p>
                                </div>
                            </div>
                            <div class="bg-light-danger badge">
                                <p class="fs-3 text-danger fw-semibold mb-0">+68</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                                {{ FormatedHelper::rupiahCurrency($buyer->sellings_sum_amount_price) }}</p>
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
@endsection
