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
                                <th>Sisa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center text-muted">-- belum ada data --</td>
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
                order: [[3, 'desc']],
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Semua']],
                dom: "<'row mt-2 justify-content-between'<'col-md-auto me-auto'B><'col-md-auto ms-auto input-date-container'>><'row mt-2 justify-content-between'<'col-md-auto me-auto'l><'col-md-auto me-start'f>><'row mt-2 justify-content-md-center'<'col-12'rt>><'row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
                buttons: [
                    {
                        extend: 'excel',
                        filename: 'Data Retur Penjualan - Hanny Jaya',
                        exportOptions: {
                            columns: ":not(:eq(6))"
                        }
                    }, {
                        extend: 'csv',
                        filename: 'Data Retur Penjualan - Hanny Jaya',
                        exportOptions: {
                            columns: ":not(:eq(6))"
                        }
                    }, {
                        extend: 'pdf',
                        filename: 'Data Retur Penjualan - Hanny Jaya',
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
                    url: "{{ route('data-table.list-retur') }}"
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        title: "No",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "selling.invoice_number",
                        title: "No. Invoice",
                    },
                    {
                        data: "selling.created_at",
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
                        data: "selling.buyer.name",
                        title: "Nama Pembeli",
                        render: (data, type, row) => {
                            return `${row.selling.buyer.name} - ${row.selling.buyer.address}`
                        }
                    }, 
                    {
                        title: "Aksi",
                        mRender: (data, type, row) => {
                            const str_detail = JSON.stringify(row.detail).replaceAll('"', '`')

                            return `
                            <button class="btn btn-primary" id="btn-detail" data-bs-toggle="modal" data-bs-target="#modal-detail" data-note="${row.note}" data-detail="${str_detail}"><i class="ti ti-eye"></i></button>
                            `
                        }
                    }
                ]
            })

            $(document).on('click', '#btn-detail', function() {
                const note = $(this).data('note')
                const detail = JSON.parse($(this).data('detail').replaceAll('`', '"'))

                let detail_tb = ''
                if(detail.length > 0) {
                    detail.forEach((data, index) => {
                        detail_tb += `
                            <tr>
                                <th>${index + 1}</th>
                                <td>${data.product.code} | ${data.product.name} (${data.product.unit.name})</td>
                                <td>${formatNum(data.old_quantity, true)}</td>
                                <td>${formatNum(data.new_quantity, true)}</td>
                                <td>${formatNum(data.old_quantity - data.new_quantity, true)}</td>
                            </tr>
                        `
                    });
                } else {
                    detail_tb += `
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data</td>
                        </tr>
                    `
                }

                $('#modal-detail .form-control').html(note)
                $('#modal-detail #tb-detail-returns tbody').html(detail_tb)
            })
        })
    </script>
@endpush