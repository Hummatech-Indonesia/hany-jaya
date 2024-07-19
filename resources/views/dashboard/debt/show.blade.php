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
                        <p>Hutang piutang oleh <span class="fw-bolder">{{ $buyer->name }} - {{ $buyer->address }}</span>.</p>
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

        <div class="card overflow-hidden">
            <div class="card-body bg-primary py-3 text-light d-flex justify-content-between align-items-center">
                <div>Sisa Hutang:</div>
                <div class="fw-bolder fs-5">{{ FormatedHelper::rupiahCurrency($buyer->debt) }}</div>
            </div>
        </div>

        <div class="card">
            <div class="table-responsive card-body">
                <table class="table align-middle" id="tb-full-debt-history">
                </table>
            </div>
        </div>

    </div>
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
        $(document).ready(function() {
            const tb_unit = $('#tb-full-debt-history').DataTable({
                processing: true,
                serverSide: true,
                order: [[1, 'desc']],
                ajax: {
                    url: "{{route('data-table.list-detail-debt', $buyer->id)}}"
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        title: "No",
                        searchable: false,
                        orderable: false
                    }, {
                        data: "date",
                        title: "Tanggal",
                        render: (data, type) => {
                            return moment(data).format('DD MMMM YYYY')
                        }
                    }, {
                        data: "type",
                        title: "Jenis",
                        render: (data, type) => {
                            if(data == 'debt') return '<span class="badge bg-warning fs-2">Hutang</span>'
                            return '<span class="badge bg-primary fs-2">Pembayaran</span>'
                        }
                    }, {
                        data: "amount",
                        title: "Total",
                        render: (data, type) => {
                            return "Rp "+formatNum(data)
                        }
                    }
                ]
            })
        })
    </script>
@endsection