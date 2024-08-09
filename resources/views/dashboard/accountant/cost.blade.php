@php
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.dashboard')
@push("title")
    Beranda
@endpush
@section('content')
    @include('components.swal-message')
    @include('components.swal-toast')
    @include('dashboard.accountant.widget.cost-modal-create')
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Pengeluaran Lainnya</h4>
                        <p>Pengeluaran selain dari pembelian barang.</p>
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

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Data Pengeluaran Lain</h5>
                <button type="button" data-bs-toggle="modal" data-bs-target="#addCostModal" class="btn btn-primary">+ Tambah</button>
            </div>
            <div class="card-body table-responsive">
                @include('dashboard.accountant.widget.cost-dt-list-cost')
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/libs/apexchartjs/apexcharts.js')}}"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/datatables.min.js')}}"></script>
    <script src="{{asset('assets/libs/selectize/selectize.min.js')}}"></script>
    <script src="{{asset('assets/libs/momentjs/moment.min.js')}}"></script>
    <script src="{{asset('assets/libs/momentjs/moment-with-locales.min.js')}}"></script>
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
