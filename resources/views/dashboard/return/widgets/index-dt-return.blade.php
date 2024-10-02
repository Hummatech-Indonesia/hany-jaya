<div class="table-responsive">
    <table class="table align-middle table-striped table-hover" id="tb-returns"></table>
</div>

<div class="modal modal-lg fade" id="modal-detail" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Penjualan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label class="form-label">Alasan</label>
                    <div class="form-control">
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Libero maiores doloribus ex laudantium quasi et, impedit doloremque assumenda officiis facere voluptates voluptatum pariatur asperiores deleniti.
                    </div>
                </div>
                <label class="form-label">Detail Retur</label>
                <div class="table-responsive">
                    <table class="table align-middle table-striped table-hover" id="tb-detail-returns">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Dibeli</th>
                                <th>Jumlah Dikembalikan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="text-center text-muted">-- belum ada data --</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-script')
    <script>
        $(document).ready(function() {
            $('#tb-returns').DataTable({
                processing: true,
                serverSide: true,
                order: [[2, 'desc']],
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Semua']],
                dom: "<'row mt-2 justify-content-between'<'col-md-auto me-auto'B><'col-md-auto ms-auto input-date-container'>><'row mt-2 justify-content-between'<'col-md-auto me-auto'l><'col-md-auto me-start'f>><'row mt-2 justify-content-md-center'<'col-12'rt>><'row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
                buttons: [
                    {
                        extend: 'excel',
                        filename: 'Data Riwayat Penjualan - Hanny Jaya',
                        exportOptions: {
                            columns: ":not(:eq(6))"
                        }
                    }, {
                        extend: 'csv',
                        filename: 'Data Riwayat Penjualan - Hanny Jaya',
                        exportOptions: {
                            columns: ":not(:eq(6))"
                        }
                    }, {
                        extend: 'pdf',
                        filename: 'Data Riwayat Penjualan - Hanny Jaya',
                        exportOptions: {
                            columns: ":not(:eq(6))"
                        },
                        customize: function (doc) {
                            doc.content[1].table.widths = 
                                Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    }
                ],
                initComplete: function() {
                    $('.dt-buttons').addClass('btn-group-sm')
                },
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
                    },
                    {
                        data: "invoice_number",
                        title: "No. Invoice",
                    },
                    {
                        data: "created_at",
                        title: "Tanggal Beli",
                        render: (data, type, row) => {
                            return moment(data).locale('id').format('LL')
                        },
                    },
                    {
                        data: "created_at",
                        title: "Tanggal Retur",
                        render: (data, type, row) => {
                            return moment(data).locale('id').format('LL')
                        },
                    },
                    {
                        data: "buyer.name",
                        title: "Nama Pembeli",
                        render: (data, type, row) => {
                            return `${row.buyer.name} - ${row.buyer.address}`
                        }
                    }, 
                    {
                        data: "buyer.name",
                        title: "Alasan",
                        render: (data, type, row) => {
                            return `${row.buyer.name} - ${row.buyer.address}`
                        }
                    }, 
                    {
                        title: "Aksi",
                        render: (data, type, row) => {
                            return `
                            <button class="btn btn-primary" id="btn-detail" data-bs-toggle="modal" data-bs-target="#modal-detail"><i class="ti ti-eye"></i></button>
                            `
                        }
                    }
                ]
            })
        })
    </script>
@endpush