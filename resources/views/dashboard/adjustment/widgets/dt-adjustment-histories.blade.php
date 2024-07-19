<table class="table align-middle" id="table-adjustment-history"></table>

@push('custom-style')
    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/datatables.min.css" rel="stylesheet">
@endpush
@push('custom-script')
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            let tb_adjust_history = $('#table-adjustment-history').DataTable({
                processing: true,
                serverSide: true,
                order: [[5, 'desc']],
                language: {
                    processing: `Memuat...`
                },
                ajax: {
                    url: "{{ route('data-table.list-adjustment-history') }}",
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        title: "No",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "product.name",
                        title: "Produk",
                    }, {
                        data: "product.code",
                        title: "Kode Produk",
                    }, {
                        data: "old_stock",
                        title: "Stok Sebelumnya",
                        render: (data, type) => {
                            return formatNum(data, true)
                        }
                    }, {
                        data: "new_stock",
                        title: "Stok Baru",
                        render: (data, type) => {
                            return formatNum(data, true)
                        }
                    }, {
                        data: "created_at",
                        title: "Tanggal",
                        render: (data, type, row) => {
                            return moment(data).locale('id').format('LL')
                        },
                    }
                ]
            })
        })
    </script>
@endpush