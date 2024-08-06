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
                        <h4 class="fw-semibold mb-8">Daftar Produk dan Kategori</h4>
                        <p>List produk, kategori, dan unit yang ada di toko anda.</p>
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
            <div class="card-body d-flex flex-row justify-content-between">
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item">
                        <a
                            class="nav-link  {{ !request()->tab || request()->tab == 'product' ? 'active' : '' }}"
                            data-bs-toggle="tab"
                            href="#pane-product"
                            role="tab"
                            data-name="product"
                        >
                            <i class="ti ti-package"></i> <span>Produk</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->tab == 'category' ? 'active' : '' }}"
                            data-bs-toggle="tab"
                            href="#pane-category"
                            role="tab"
                            data-name="category"
                        >
                            <i class="ti ti-list"></i> <span>Kategori</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->tab == 'unit' ? 'active' : '' }}"
                            data-bs-toggle="tab"
                            href="#pane-unit"
                            role="tab"
                            data-name="unit"
                        >
                            <i class="ti ti-ruler"></i> <span>Satuan</span>
                        </a>
                    </li>
                </ul>

                @role('admin')
                    <div id="add-thing">
                        <div data-active="product">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Tambah Produk</a>
                        </div>
                        <div data-active="category" class="d-none">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddCategory">
                                Tambah Kategori
                            </button>
                        </div>
                        <div data-active="unit" class="d-none">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddUnit">
                                Tambah Satuan
                            </button>
                        </div>
                    </div>
                @endrole
            </div>
        </div>

        {{-- panes --}}
        <div class="tab-content border mt-2">
            <div class="tab-pane  {{ !request()->tab || request()->tab == 'product' ? 'active' : '' }}" id="pane-product" role="tabpanel">
                @include('dashboard.product.panes.product')
            </div>
            <div class="tab-pane {{ request()->tab == 'category' ? 'active' : '' }}" id="pane-category" role="tabpanel" >
                @include('dashboard.product.panes.category')
            </div>
            <div class="tab-pane  {{ request()->tab == 'unit' ? 'active' : '' }}" id="pane-unit" role="tabpanel" >
                @include('dashboard.product.panes.unit')
            </div>
        </div>
        
        <x-dialog.delete title="Hapus" />
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
        $(document).ready(function() {
            $(document).on('shown.bs.tab', 'a[data-bs-toggle="tab"]', function (e) {
                const active_tab = $(this).data('name')
                updateBtnTab(active_tab)
            });

            const active_tab_on_init = $("[role=tablist] .nav-item .nav-link.active").data('name')
            updateBtnTab(active_tab_on_init)

            function updateBtnTab(active_tab) {
                $(`#add-thing > [data-active=${active_tab}]`).removeClass('d-none')
                $(`#add-thing > :not([data-active=${active_tab}])`).addClass('d-none')
            }
        })
    </script>
@endsection
