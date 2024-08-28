<table class="table align-middle" id="tb-list-cost"></table>

@push('custom-script')
    <script>
        $(document).ready(function() {
            const dt_list_cost = $('#tb-list-cost').DataTable({
                processing: true,
                serverSide: true,
                order: [[4, 'desc']],
                language: {
                    processing: `Memuat...`
                },
                ajax: {
                    url: "{{ route('data-table.list-cost') }}",
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        title: "No",
                        orderable: false,
                        searchable: false,
                    }, {
                        data: "loss_category.name",
                        title: "Jenis Pengeluaran",
                    }, {
                        data: "desc",
                        title: "Keterangan",
                    }, {
                        data: "price",
                        title: "Biaya",
                        render: (data, type) => {
                            return formatNum(data, true)
                        }
                    }, {
                        data: "created_at",
                        title: "Tanggal",
                        render: (data, type, row) => {
                            return moment(row['date'] ?? data).locale('id').format('LL')
                        },
                    }, {
                        title: "Aksi",
                        mRender: (data, type, row) => {
                            if(row['image']) return `<div class="d-flex align-items-center justify-content-center w-100">
                                <a href="/storage/${row['image']}" target="_blank" class="btn btn-primary-light btn-detail">
                                <i class="ti ti-photo"></i>
                            </a></div>`
                            return '<div class="text-center">-</div>'
                        },
                        searchable: false,
                        orderable: false
                    }
                ]
            })
        })
    </script>
@endpush