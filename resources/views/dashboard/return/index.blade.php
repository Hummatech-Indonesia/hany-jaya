@extends('dashboard.layouts.dashboard') 
@push("title")
    Retur Penjualan
@endpush
@section('content')
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Retur Penjualan</h4>
                        <p>Data retur oleh pelanggan</p>
                        @role('admin')
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddReturn">
                            Tambah Data Retur
                        </button>
                        @endrole
                        @include('dashboard.return.widgets.index-modal-add-return')
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
                <div class="alert alert-warning" role="alert">
                    Sebelum melakukan export / cetak data, pastikan kolom "entries per page" bernilai "semua" agar keseluruhan data tercetak.
                </div>
                @include('dashboard.return.widgets.index-dt-return')
            </div>
        </div>

        @include('components.swal-message')
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/js/number-format.js') }}"></script>
@endsection