@php
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.dashboard')
@push("title")
    Riwayat Pembelian
@endpush
@section('content')
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Riwayat Pembelian</h4>
                        <p>Riwayat pembelian di toko anda.</p>
                        @role('admin')
                            <a href="{{ route('admin.purchases.create') }}">
                                <button type="button" class="btn btn-primary">
                                    Tambah Pembelian
                                </button>
                            </a>
                        @endrole
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
            <div class="card-body">
                <div class="alert alert-warning" role="alert">
                        Sebelum melakukan export / cetak data, pastikan kolom "entries per page" bernilai "semua" agar keseluruhan data tercetak.
                </div>
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-12 ms-auto">
                            <div class="d-flex align-items-center" id="input-date-group">
                                <div>Tanggal: </div>
                                <input type="text" id="input-date" class="form-control form-control-sm flex-fill w-100" value="" placeholder="Tanggal Pembelian">
                            </div>
                        </div>
                    </div>
                    <table class="table align-middle table-striped table-hover" id="tb-purchase"></table>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.selling.widgets.detail-purchase')
@endsection
@section('style')
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.css"> --}}
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/libs/daterangepicker/daterangepicker.css')}}">
@endsection
@section('script')
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script src="{{asset('assets/libs/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/datatables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.js"></script> --}}

    <script>
        const tb_purchasing = $('#tb-purchase').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Semua']],
            dom: "<'row mt-2 justify-content-between'<'col-md-auto me-auto'B><'col-md-auto ms-auto input-date-container'>><'row mt-2 justify-content-between'<'col-md-auto me-auto'l><'col-md-auto me-start'f>><'row mt-2 justify-content-md-center'<'col-12'rt>><'row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
            // dom: "<'row mt-2 justify-content-start'<'col-12'B>><'row mt-2 justify-content-between'<'col-md-auto me-auto'l><'col-md-auto me-start'f>><'row mt-2 justify-content-md-center'<'col-12'rt>><'row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ":not(:eq(4))"
                    }
                }, {
                    extend: 'csv',
                    exportOptions: {
                        columns: ":not(:eq(4))"
                    }
                }, {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ":not(:eq(4))"
                    }
                }
            ],
            initComplete: function() {
                let a = $('#input-date-group').detach()
                $('.input-date-container').append(a)
                $('.dt-buttons').addClass('btn-group-sm')
                $('#input-date').daterangepicker({
                    autoUpdateInput: false
                })
            },
            language: {
                processing: 'Memuat...'
            },
            ajax: {
                url: "{{route('data-table.list-purchase-history')}}"
            },
            order: [[2, 'desc']],
            columns: [
                {
                    data: 'DT_RowIndex',
                    title: 'No',
                    searchable: false,
                    orderable: false
                }, {
                    data: 'invoice_number',
                    title: "No. Invoice"
                }, {
                    data: "created_at",
                    title: "Tanggal",
                    render: (data, type, row) => {
                        return moment(data).locale('id').format('LL')
                    },
                }, {
                    data: "buy_price",
                    title: "Total Harga Beli",
                    render: (data, type, row) => {
                        return 'Rp '+formatNum(data)
                    }
                },
                @role('admin')
                {
                    mRender: (data, type, row) => {
                        let detail_string = JSON.stringify(row['list_products']).replaceAll('"', "'")
                        return `
                        <svg xmlns="http://www.w3.org/2000/svg" class="btn-detail"
                            data-detail-purchase="${detail_string}"
                            data-name="${row['user']['name']}"
                            data-invoice-number="${row['invoice_number']}"
                            data-price="${row['buy_price']}"
                            data-status_payment="${row['status_payment']}"
                            data-date="${row['created_at']}"
                            data-address="${row['supplier']['address']}" width="16" height="16"
                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path
                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                            <path
                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                        </svg>
                        `
                    }, title: 'Aksi'
                }
                @endrole
            ]
        })

        function updateDateRange(val) {
            $('#input-date').val(val)
            let url = "{{ route('data-table.list-purchase-history') }}"
            url = url+'?date='+$('#input-date').val();
            tb_purchasing.ajax.url(url).load()
        }

        $('#input-date').on('apply.daterangepicker hide.daterangepicker', function(ev, picker) {
            let val = picker.startDate.format('DD-MM-YYYY')+' s/d '+picker.endDate.format('DD-MM-YYYY')
            updateDateRange(val)
        })

        $(document).on("click", ".btn-detail", function() {
            $("#modalDetailHistory").modal("show");
            let detailPurchaseStr = $(this).data("detail-purchase");
            let detailPurchase
            if(typeof detailPurchaseStr == 'string') {
                detailPurchase = JSON.parse(detailPurchaseStr.replaceAll("'", '"'))
            } else {
                detailPurchase = detailPurchaseStr
            }
            let name = $(this).data('name');
            let invoice_number = $(this).data('invoice-number');
            let supplier = $(this).data('supplier');
            let price = $(this).data('price');
            let pay = $(this).data('pay');
            let date = $(this).data('date')
            console.log(detailPurchase);

            $('#name').html(name);
            $('#invoice_number').html(invoice_number);
            $('#buy_date').html(moment(date).locale('id').format("LL"));
            $('#price').html(formatNum(price));

            $('#value_table').empty();
            let total_price = 0
            $.each(detailPurchase, function(index, item) {
                $("#value_table").append(
                    `
                <tr class="search-items">
                    <td><h6 class="user-name mb-0">${index+1}</h6></td>
                    <td><h6 class="user-name mb-0">${item.product.name}</h6></td>
                    <td><h6 class="user-name mb-0">${item.quantity} ${item.product_unit.unit.name}</h6></td>
                    <td><h6 class="user-name mb-0">Rp ${formatNum(item.buy_price_per_unit)}</h6></td>
                    <td><h6 class="user-name mb-0">Rp ${formatNum(item.buy_price)}</h6></td>
                </tr>
                `
                );
            });

        });
        $(function() {
            // var yesterday = moment().subtract(1, 'days').format('MM/DD/YYYY');
            // var today = moment().format('MM/DD/YYYY');

            // $('#daterange').val(yesterday + ' - ' + today);

            $('#daterange').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
            });
        });
    </script>
@endsection
