@php
    use App\Helpers\FormatedHelper;
@endphp
@extends('dashboard.layouts.dashboard')
@push("title")
    Riwayat Penjualan
@endpush
@section('content')
    <div class="container-fluid max-w-full">
        <div class="card bg-light-info shadow-none position-relative overflow-hidden">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Riwayat Penjualan</h4>
                        <p>Riwayat Penjualan di toko anda.</p>
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
        <div class="widget-content searchable-container list mt-4">
            <div class="card card-body">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-0 col-md-8"></div>
                        <div class="col-12 col-md-4 d-flex align-items-center">
                            <div>Tanggal: </div>
                            <input type="text" id="input-date" class="form-control form-control-sm flex-fill w-100" value="" placeholder="Tanggal Pembelian">
                        </div>
                    </div>
                    <table class="table align-middle table-striped table-hover" id="tb-transaction-history"></table>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.selling.widgets.detail-invoice')
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.css">
    <link rel="stylesheet" href="{{asset('assets/libs/daterangepicker/daterangepicker.css')}}">
@endsection
@section('script')
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script src="{{asset('assets/libs/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('assets/js/number-format.js')}}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.js"></script>
    
    <script>

        $(document).ready(function() {
            const datatable_transaction = $('#tb-transaction-history').DataTable({
                processing: true,
                serverSide: true,
                order: [[2, 'desc']],
                language: {
                    processing: 'Memuat...'
                },
                ajax: {
                    url: "{{ route('data-table.list-transaction-history') }}"
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        title: "No",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "invoice_number",
                        title: "No. Invoice",
                    }, {
                        data: "created_at",
                        title: "Tanggal",
                        render: (data, type, row) => {
                            return moment(data).locale('id').format('LL')
                        },
                    }, {
                        data: "user.name",
                        title: "Nama Pembeli",
                    }, {
                        data: "status_payment",
                        title: "Status Pembayaran",
                        render: (data, type, row) => {
                            if(data == 'debt') return `<span class="badge bg-warning text-white">Hutang</span>`;
                            else return `<span class="badge bg-success text-white">Tunai</span>`;
                        }
                    }, {
                        mRender: (data, type, full) => {
                            return `<svg xmlns="http://www.w3.org/2000/svg" class="btn-detail"
                                data-detail-selling="${JSON.stringify(full['detail_sellings']).replaceAll('"', "'")}"
                                data-name="${full['buyer']['name']}"
                                data-price="${full['amount_price']}" data-pay="${full['pay']}"
                                data-return="${full['return']}"
                                data-status_payment="${full['status_payment']}"
                                data-address="${full['buyer']['address']}" width="16" height="16"
                                fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                <path
                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                <path
                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                            </svg>`
                        },
                        title: "Aksi",
                        searchable: false,
                        orderable: false
                    }
                ]
            })

            $('#input-date').daterangepicker({
                autoUpdateInput: false
            })

            $('#input-date').on('apply.daterangepicker hide.daterangepicker', function(ev, picker) {
                let val = picker.startDate.format('DD-MM-YYYY')+' s/d '+picker.endDate.format('DD-MM-YYYY')
                $('#input-date').val(val)
                let url = "{{ route('data-table.list-transaction-history') }}"
                url = url+'?date='+$('#input-date').val()
                datatable_transaction.ajax.url(url).load()
            })

            $(document).on("click", ".btn-detail", function() {
                $("#value_table").empty();
                $("#modalDetailHistory").modal("show");
                let detailSellings = JSON.parse($(this).data("detail-selling").replaceAll("'",'"'));
                let name = $(this).data('name');
                let returns = $(this).data('return');
                let address = $(this).data('address');
                let status_payment = $(this).data('status_payment');
                let price = $(this).data('price');
                let pay = $(this).data('pay');
                console.log(detailSellings);
                if (status_payment == 'debt') {
                    $('.sembuyikan').hide();
                } else {
                    $('.sembunyikan').show();
                    $('#return').html(formatNum(returns));
                    $('#pay').html(formatNum(pay));
                }
    
                $('#name').html(name);
                $('#price').html(formatNum(price));
                $('#address').html(address);
                if (status_payment == 'debt') {
                    $('#status').html('<span class="mb-1 badge font-medium bg-danger text-white">Hutang</span>');
                } else {
                    $('#status').html('<span class="mb-1 badge font-medium bg-success text-white">Tunai</span>');
                }
    
                detailSellings.forEach(function(item, index) {
                    console.log(item);
                    $("#value_table").append(
                        `
                    <tr class="search-items">
                        <td>${index + 1}</td>
                        <td><h6 class="user-name mb-0" data-name="Emma Adams">${item.product.name}</h6></td>
                        <td><h6 class="user-name mb-0" data-name="Emma Adams">${item.product_unit.unit.name}</h6></td>
                        <td><h6 class="user-name mb-0" data-name="Emma Adams">${item.quantity}</h6></td>
                        <td><h6 class="user-name mb-0" data-name="Emma Adams">RP. ${formatNum(item.nominal_discount)}</h6></td>
                        <td><h6 class="user-name mb-0" data-name="Emma Adams">Rp. ${formatNum(item.selling_price)}</h6></td>
                        <td><h6 class="user-name mb-0" data-name="Emma Adams"></h6></td>
                    </tr>
                    `
                    );
                });
            });
        })
    </script>
@endsection
