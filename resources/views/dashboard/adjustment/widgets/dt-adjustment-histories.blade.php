<table class="table align-middle" id="table-adjustment-history"></table>

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
                        render: (data, type, row) => {
                            return data + ' | ' + row.product.code
                        },
                    }, {
                        data: "note",
                        title: "Keterangan",
                    }, {
                        data: "old_stock",
                        title: "Stok Sebelumnya",
                        render: (data, type) => {
                            return formatNum(data, true)
                        }
                    }, {
                        data: "new_stock",
                        title: "Stok Baru",
                        render: (data, type, row) => {
                            return `<div>
                                <td>${formatNum(data, true)}</td>
                                    ${(row.new_stock > row.old_stock) ? `<td><i class="ti ti-arrow-up text-success"></i></td>` : `<td><i class="ti ti-arrow-down text-danger"></i></td>`}
                                </div>`;
                        }
                    }, {
                        data: "created_at",
                        title: "Tanggal",
                        render: (data, type, row) => {
                            return moment(data).locale('id').format('LL')
                        },
                    }, {
                        data: "user.name",
                        title: "User",
                        render: (data, type, row) => {
                            return data ?? '-'
                        },
                    }
                ]
            })
        })
    </script>
@endpush