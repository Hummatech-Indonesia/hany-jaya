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
                    <div class="card-body d-flex justify-content-center align-items-center">
                        @include('dashboard.home.widgets.pie-product')
                    </div>
                </div>
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
    <script src="{{asset('assets/libs/apexchartjs/apexcharts.js')}}"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/datatables.min.js')}}"></script>
    <script src="{{asset('assets/libs/selectize/selectize.min.js')}}"></script>
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/css/icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/libs/datatablesnet/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/libs/selectize/selectize.bootstrap5.min.css')}}"/>

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
