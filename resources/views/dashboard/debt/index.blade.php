@php
    use App\Helpers\FormatedHelper;
    use App\Enums\StatusDebt;
@endphp
@extends('dashboard.layouts.dashboard')
@push("title")
    Hutang Piutang
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
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Hutang Piutang</h4>
                        <p>Hutang piutang oleh pelanggan.</p>
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

        {{-- tab --}}
        <div class="card">
            <div class="card-body d-flex flex-row justify-content-between">
                <ul class="nav nav-pills align-items-center rounded flex-row" role="tablist">
                    <li class="nav-item">
                        <a
                            class="nav-link active"
                            data-bs-toggle="tab"
                            href="#pane-list"
                            role="tab"
                        >
                            <i class="ti ti-clipboard-list"></i> <span>Daftar Piutang</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-bs-toggle="tab"
                            href="#pane-history"
                            role="tab"
                        >
                            <i class="ti ti-history"></i> <span>Riwayat Piutang</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            data-bs-toggle="tab"
                            href="#pane-pay"
                            role="tab"
                        >
                            <i class="ti ti-credit-card"></i> <span>Pembayaran Piutang</span>
                        </a>
                    </li>
                </ul>
                <button data-bs-toggle="modal" data-bs-target="#modal-debt-pay" class="btn btn-primary">Pembayaran Piutang</button>
            </div>
        </div>
        {{-- panes --}}
        <div class="tab-content border mt-2">
            <div
                    class="tab-pane active"
                    id="pane-list"
                    role="tabpanel"
            >
                @include('dashboard.debt.panes.debt-list')
            </div>
            <div
                class="tab-pane"
                id="pane-history"
                role="tabpanel"
            >
                @include('dashboard.debt.panes.debt-history')
            </div>
            <div
                class="tab-pane"
                id="pane-pay"
                role="tabpanel"
            >
                @include('dashboard.debt.panes.debt-pay')
            </div>
        </div>
    </div>
    @include('dashboard.debt.widgets.detail-debt')
    @include('dashboard.debt.widgets.modal-pay-debt')
    @include('components.swal-success')
@endsection
@section('style')
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.min.css"/>
@endsection
@section('script')
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/datatables.min.js"></script>
    <script>
        $(".btn-detail").on("click", function() {
            $("#value_table").empty(); // Mengosongkan isi tabel sebelum menambahkan detail penjualan baru
            $("#modalDetailHistory").modal("show");
            let detailSellings = $(this).data("detail-selling");
            let price = $(this).data('price');
            $('#price').html(formatRupiah(price));
            detailSellings.forEach(function(item, index) {
                $("#value_table").append(
                    `
                <tr class="search-items">
                    <td>${index + 1}</td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams">${item.product.name}</h6></td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams">${item.quantity}</h6></td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams">RP. ${formatRupiah(item.nominal_discount)}</h6></td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams">Rp. ${formatRupiah(item.selling_price)}</h6></td>
                    <td><h6 class="user-name mb-0" data-name="Emma Adams"></h6></td>
                </tr>
                `
                );
            });
        });

        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan;
        }
    </script>
@endsection
