<div class="card card-body">
    <div class="table-responsive">
        <table class="table align-middle text-break w-100" id="tb-debt-list">
        </table>
    </div>
</div>

@push('custom-script')
    <script>
        let tb_debt_list = $('#tb-debt-list').DataTable({
            processing: true,
            serverSide: true,
            order: [[1, 'asc']],
            language: {
                processing: `Memuat...`
            },
            ajax: {
                url: "{{ route('data-table.list-debt') }}",
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    title: "No",
                    orderable: false,
                    searchable: false
                }, {
                    data: "buyer_name",
                    title: "Pembeli",
                }, {
                    data: "total_debt",
                    title: "Total Hutang",
                    render: (data, type) => {
                        return 'Rp '+formatNum(data)
                    }
                }, {
                    data: "total_pay_debt",
                    title: "Hutang Dibayar",
                    render: (data, type) => {
                        return 'Rp '+formatNum(data)
                    }
                }, {
                    data: "nominal_after_check",
                    title: "Sisa Hutang",
                    render: (data, type) => {
                        return 'Rp '+formatNum(data)
                    }
                },
                {
                    mRender: (data, type, row) => {
                        return '<button type="button" class="btn btn-primary"><i class="ti ti-list"></i></button>'
                    }, 
                    title: "Aksi",
                    orderable:false,
                    searchable: false
                }
            ]
        })
    </script>
@endpush