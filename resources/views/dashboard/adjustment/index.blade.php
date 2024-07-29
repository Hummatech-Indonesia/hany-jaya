@extends('dashboard.layouts.dashboard') 
@push("title")
    Kategori
@endpush
@section('content')
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Penyesuaian Stok</h4>
                        <p>Riwayat perubahan stok produk.</p>
                        @role('admin')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modal-adjust-stock">
                                Sesuaikan Stok
                            </button>
                        @endrole
                        @include('dashboard.adjustment.widgets.modal-adjust-stock')
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
            <div class="card-body table-responsive">
                @include('dashboard.adjustment.widgets.dt-adjustment-histories')
            </div>
        </div>

        @include('dashboard.category.widgets.modal-update')
    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.min.css"/>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>
@endsection
