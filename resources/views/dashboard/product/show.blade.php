@extends('dashboard.layouts.dashboard')
@push("title")
    Produk
@endpush
@push('custom-style')
    <style>
        .nav-link.active {
            background-color: var(--bs-light-info)!important;
            color: var(--bs-info)!important
        }
    </style>
@endpush
@section('content')
    @include('components.swal-message')
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Detail Produk</h4>
                        <p>Detail dari produk <span class="fw-semibold">{{ $product->name }}</span>.</p>
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
    </div>
@endsection
@section('style')
<link href="{{asset('assets/libs/datatablesnet/datatables.min.css')}}" rel="stylesheet">
@endsection
@section('script')
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="{{asset('assets/libs/momentjs/moment.min.js')}}"></script>
    <script src="{{asset('assets/libs/momentjs/moment-with-locales.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/datatables.min.js')}}"></script>
    <script>
        $(document).on('shown.bs.tab', 'a[data-bs-toggle="tab"]', function (e) {
            const active_tab = $(this).data('name')
            $(`#add-thing > [data-active=${active_tab}]`).removeClass('d-none')
            $(`#add-thing > :not([data-active=${active_tab}])`).addClass('d-none')
        });
    </script>
@endsection
