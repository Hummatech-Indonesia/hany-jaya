<div class="card card-body">
    <div class="table-responsive">
        <table class="table align-middle text-nowrap w-100" id="tb-debt-history">
        </table>
    </div>
</div>

@include('dashboard.debt.widgets.modal-debt-history-detail')

@push('custom-script')
    <script>
        let tb_debt_history = $('#tb-debt-history').DataTable({
            processing: true,
            serverSide: true,
            order: [[3, 'desc']],
            language: {
                processing: `Memuat...`
            },
            ajax: {
                url: "{{ route('data-table.list-debt-history') }}",
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    title: "No",
                    orderable: false,
                    searchable: false
                }, {
                    data: "buyer.name",
                    title: "Pembeli",
                }, {
                    data: "nominal",
                    title: "Nominal Hutang",
                    render: (data, type) => {
                        return 'Rp '+formatNum(data)
                    }
                }, {
                    data: "created_at",
                    title: "Tanggal",
                    render: (data, type, row) => {
                        return moment(data).locale('id').format('LL')
                    },
                }, {
                    data: "buyer.debt",
                    title: "Sisa Hutang",
                    render: (data, type) => {
                        return 'Rp '+formatNum(data)
                    }
                },
                {
                    mRender: (data, type, row) => {
                        return `<button type="button" class="btn btn-light btn-detail detail-history-debt" data-debt="${JSON.stringify(row).replaceAll('"', "'")}"><i class="ti ti-eye"></i></button>`
                    }, 
                    title: "Aksi",
                    orderable:false,
                    searchable: false
                }
            ]
        })
    </script>
@endpush