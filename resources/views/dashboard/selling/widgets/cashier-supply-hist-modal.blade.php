<div class="modal modal-lg" id="modal-supply-history" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Data Riwayat Produk</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body table-responsive">
                <div class="mb-3">
                    <h5>Riwayat Pembelian Terakhir</h5>
                    <table class="table align-middle" id="tb-supply-history"></table>
                </div>
                <div>
                    <h5>Riwayat Penjualan Terakhir</h5>
                    <table class="table align-middle" id="tb-selling-history"></table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-style')
    <link href="{{asset('assets/libs/datatablesnet/datatables.min.css')}}" rel="stylesheet">
@endpush
@push('custom-script')
    <script src="{{asset('assets/libs/momentjs/moment.min.js')}}"></script>
    <script src="{{asset('assets/libs/momentjs/moment-with-locales.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/libs/datatablesnet/datatables.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            let tb_hist_supply, tb_hist_sell
            
            function initDt(url_supply, url_sell) {
                tb_hist_supply = $('#tb-supply-history').DataTable({
                    processing: true,
                    serverSide: true,
                    pageLength: 3,
                    paging: true,
                    dom: 't',
                    searching: false,
                    order: [[1, 'desc']],
                    ajax: {
                        url: url_supply
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
                                return moment(data).format("DD MMMM YYYY")
                            }
                        }, {
                            data: "name",
                            title: "Pembeli",
                        }, {
                            data: "quantity",
                            title: "Jumlah",
                            render: (data, type, row) => {

                                return formatNum(data, true)+' '+row['unit_name']
                            }
                        }, {
                            data: "total_per_unit_price",
                            title: "Harga",
                            render: (data, type) => {
                                return 'Rp '+formatNum(data, true)
                            }
                        }, {
                            data: "total_price",
                            title: "Total",
                            render: (data, type) => {
                                return 'Rp '+formatNum(data, true)
                            }
                        }
                    ]
                })
                tb_hist_sell = $('#tb-selling-history').DataTable({
                    processing: true,
                    serverSide: true,
                    pageLength: 3,
                    paging: true,
                    searching: false,
                    dom: 't',
                    order: [[1, 'desc']],
                    ordering: false,
                    ajax: {
                        url: url_sell
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
                                return moment(data).format("DD MMMM YYYY")
                            }
                        }, {
                            data: "name",
                            title: "Distributor",
                        }, {
                            data: "quantity",
                            title: "Jumlah",
                            render: (data, type, row) => {

                                return formatNum(data, true)+' '+row['unit_name']
                            }
                        }, {
                            data: "total_per_unit_price",
                            title: "Harga",
                            render: (data, type) => {
                                return 'Rp '+formatNum(data, true)
                            }
                        }, {
                            data: "total_price",
                            title: "Total",
                            render: (data, type) => {
                                return 'Rp '+formatNum(data, true)
                            }
                        }
                    ]
                })
            }

            $(document).on('click', '.btn-show-history', function() {
                let product_id = $(this).data('product-id')
                let buyer_code = $('#code').val()

                let dt_url_supply = "{{ route('data-table.list-detail-product', 'selected_id') }}?type=purchase"
                dt_url_supply = dt_url_supply.replace('selected_id', product_id)

                let dt_url_sell = `{{ route('data-table.list-detail-product', 'selected_id') }}?type=selling&buyer_code=${buyer_code}`
                dt_url_sell = dt_url_sell.replace('selected_id', product_id)

                if(!tb_hist_supply) initDt(dt_url_supply, dt_url_sell)
                else {
                    tb_hist_supply.ajax.url(dt_url_supply).load()
                    tb_hist_sell.ajax.url(dt_url_sell).load()
                }
            })
        })
    </script>
@endpush