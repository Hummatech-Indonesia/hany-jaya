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
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="type">Tipe Laporan</label>
                    <select name="type" id="type" class="form-select">
                        <option value="" selected disabled>-- pilih tipe laporan --</option>
                        <option value="yearly">Tahunan</option>
                        <option value="monthly">Bulanan</option>
                    </select>
                </div>
                <div class="row" id="detail-type">
                    <div class="col" data-type="yearly">
                        <div class="form-group mb-3">
                            <label for="year">Tahun</label>
                            <select name="year" id="year" class="form-select">
                                <option value="" selected disabled>-- pilih tahun --</option>
                            </select>
                        </div>
                    </div>
                    <div class="col" data-type="monthly">
                        <div class="form-group mb-3">
                            <label for="month">Bulan</label>
                            <select name="month" id="month" class="form-select">
                                <option value="" selected disabled>-- pilih bulan --</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
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
