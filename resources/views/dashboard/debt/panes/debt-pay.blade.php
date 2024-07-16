<div class="card card-body">
    <div class="table-responsive">
        <table class="table align-middle text-break w-100" id="tb-debt-pay">
        </table>
    </div>
</div>


@push('custom-script')
    <script>
        let tb_debt_pay = $('#tb-debt-pay').DataTable({
            processing: true,
            serverSide: true,
            order: [[3, 'desc']],
            language: {
                processing: `Memuat...`
            },
            ajax: {
                url: "{{ route('data-table.list-pay-debt-history') }}",
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
                    data: "pay_debt",
                    title: "Nominal Dibayarkan",
                    render: (data, type) => {
                        return 'Rp '+formatNum(data)
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
    </script>
@endpush