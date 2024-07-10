<div class="table-responsive">
    <table class="table table-striped align-middle text-nowrap" id="tb-top-buyer"></table>
</div>

@push('custom-script')
    <script>
        $(document).ready(function() {
            let dt_top_buyer = $('#tb-top-buyer').DataTable({
                processing: true,
                serverSide: true,
                order: [[2, 'desc']],
                searching: false,
                paging: false,
                info: false,
                language: {
                    processing: `Memuat...`
                },
                ajax: {
                    url: "{{ route('data-table.list-high-transaction') }}",
                },
                columns: [
                    {
                        data: "name",
                        title: "Pelanggan"
                    }, {
                        data: "address",
                        title: "Alamat",
                    }, {
                        data: "total_price",
                        title: "Nominal Pembelian",
                        render: (data, type, row) => {
                            return 'Rp '+formatNum(data)
                        }
                    }, {
                        data: "total_transaction",
                        title: "Jumlah Transaksi",
                        render: (data, type, row) => {
                            return formatNum(data)
                        }
                    }
                ]
            })
        })
    </script>
@endpush