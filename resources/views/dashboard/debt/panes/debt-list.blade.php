<div class="card card-body">
    <div class="table-responsive">
        <div class="alert alert-warning" role="alert">
            Sebelum melakukan export / cetak data, pastikan kolom "entries per page" bernilai "semua" agar keseluruhan data tercetak.
        </div>
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
            dom: "<'row mt-2 justify-content-between'<'col-md-auto me-auto'B><'col-md-auto ms-auto input-date-container'>><'row mt-2 justify-content-between'<'col-md-auto me-auto'l><'col-md-auto me-start'f>><'row mt-2 justify-content-md-center'<'col-12'rt>><'row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Semua']],
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ":not(:eq(5))"
                    }
                }, {
                    extend: 'csv',
                    exportOptions: {
                        columns: ":not(:eq(5))"
                    }
                }, {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ":not(:eq(5))"
                    }
                }
            ],
            initComplete: function() {
                $('.dt-buttons').addClass('btn-group-sm')
            },
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