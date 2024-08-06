@php
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.dashboard')
@push("title")
    Riwayat Penjualan
@endpush
@section('content')
    <div class="container-fluid max-w-full">
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
        @include('dashboard.selling.widgets.dt-selling-history')
    </div>
    @include('dashboard.selling.widgets.detail-invoice')
@endsection
@section('style')
<link href="{{asset('assets/libs/datatablesnet/datatables.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/libs/daterangepicker/daterangepicker.css')}}">
@endsection
@section('script')
    <script src="{{asset('assets/libs/momentjs/moment.min.js')}}"></script>
    <script src="{{asset('assets/libs/momentjs/moment-with-locales.min.js')}}"></script>
    <script src="{{asset('assets/libs/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    
    <script src="{{asset('assets/libs/datatablesnet/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/datatables.min.js')}}"></script>
    
    
@endsection
