@extends('dashboard.layouts.dashboard')
@push("title")
    Daftar Pembeli
@endpush
@section('content')
    @include('components.swal-message')
    @include('components.swal-toast')

    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Data Pembeli</h4>
                        <p>Daftar pembeli yang ada di toko anda.</p>
                        <button type="button" class="btn btn-primary" id="btn-open-add-buyer-modal">Tambah</button>
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

        @include('dashboard.buyers.widgets.index-dt-buyer-lists')
    </div>

    @include('dashboard.buyers.widgets.index-modal-add')
    @include('dashboard.buyers.widgets.index-modal-debt')
    @include('dashboard.buyers.widgets.index-modal-edit')
@endsection
@section('script')
    <script src="{{asset('assets/libs/apexchartjs/apexcharts.js')}}"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/datatables.min.js')}}"></script>
    <script src="{{asset('assets/libs/selectize/selectize.min.js')}}"></script>
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/css/icons.css')}}">
    <script src="{{asset('assets/libs/datatablesnet/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/datatables.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/libs/selectize/selectize.bootstrap5.min.css')}}"/>
@endsection
