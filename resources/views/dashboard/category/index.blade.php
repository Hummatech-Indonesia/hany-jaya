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
                        <h4 class="fw-semibold mb-8">Kategori</h4>
                        <p>List kategori yang ada di toko anda.</p>
                        @role('admin')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalAddCategory">
                                Tambah Kategori
                            </button>
                        @endrole
                        @include('dashboard.category.widgets.modal-create')
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
        <div class="row mt-3">
            @if (session()->has('error'))
                <div class="col-12">
                    <x-alert-failed />
                </div>
            @endif
            @if ($errors->any())
                <div class="col-12">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <strong>Terjadi Kesalahan</strong>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                        </div>
                    </div>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="col-12">
                    <x-alert-success />
                </div>
            @endif
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table align-middle table-striped" id="tb-categories"></table>
            </div>
        </div>

        @include('dashboard.category.widgets.modal-update')

        <x-dialog.delete title="Hapus Karton" />
    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/libs/datatablesnet/datatables.min.css')}}">
@endsection
@section('script')
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/datatables.min.js')}}"></script>
@endsection
