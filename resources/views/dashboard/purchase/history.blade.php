@php
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.dashboard')
@push("title")
    Riwayat Pembelian
@endpush
@section('content')
    @include('components.swal-message')
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
                        columns: ":not(:eq(5))"
                    }
                }, {
                    extend: 'csv',
                    exportOptions: {
                        columns: ":not(:eq(5))"
                    }
                }, {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ":not(:eq(5))"
                    },
                    customize: function (doc) {
                        doc.content[1].table.widths = 
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
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
            order: [[3, 'desc']],
            columns: [
                {
                    data: 'DT_RowIndex',
                    title: 'No',
                    searchable: false,
                    orderable: false
                }, {
                    data: 'supplier.name',
                    title: "Distributor"
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
                        <button type="button" class="btn btn-light btn-detail"
                            data-detail-purchase="${detail_string}"
                            data-name="${row['user']['name']}"
                            data-invoice-number="${row['invoice_number']}"
                            data-price="${row['buy_price']}"
                            data-status_payment="${row['status_payment']}"
                            data-date="${row['created_at']}"
                            data-address="${row['supplier']['address']}"
                            data-supplier-name="${row['supplier']['name']}"
                        >
                            <i class="ti ti-eye"></i>
                        </button>
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
            let supplier_name = $(this).data('supplier-name')
            console.log(detailPurchase);

            $('#name').html(name);
            $('#invoice_number').html(invoice_number);
            $('#buy_date').html(moment(date).locale('id').format("LL"));
            $('#price').html(formatNum(price));
            $('#supplier_name').html(supplier_name)

            $('#value_table').empty();
            let total_price = 0
            $.each(detailPurchase, function(index, item) {
                $("#value_table").append(
                    `
                <tr class="search-items">
                    <td><h6 class="user-name mb-0">${index+1}</h6></td>
                    <td><h6 class="user-name mb-0 text-truncate" style="max-width: 170px">${item.product.name}</h6></td>
                    <td><h6 class="user-name mb-0">${formatNum(item.quantity, true)} ${item.product_unit.unit.name}</h6></td>
                    <td><h6 class="user-name mb-0">Rp ${formatNum(item.buy_price_per_unit, true)}</h6></td>
                    <td><h6 class="user-name mb-0">Rp ${formatNum(item.buy_price, true)}</h6></td>
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
