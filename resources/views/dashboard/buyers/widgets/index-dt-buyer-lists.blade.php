<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div class="alert alert-warning" role="alert">
                Sebelum melakukan export / cetak data, pastikan kolom "entries per page" bernilai "semua" agar keseluruhan data tercetak.
            </div>
            <table class="table align-middle table-hover w-100" id="buyer-table">
            </table>
        </div>
    </div>
</div>

@push('custom-script')
<script src="{{ asset('assets/js/number-format.js') }}"></script>
<script>  
    $(document).ready(function() {
        let product_datatable = $('#buyer-table').DataTable({
            processing: true,
            serverSide: true,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Semua']],
            dom: "<'row mt-2 justify-content-between'<'col-md-auto me-auto'B><'col-md-auto ms-auto custom-container'>><'row mt-2 justify-content-between'<'col-md-auto me-auto'l><'col-md-auto me-start'f>><'row mt-2 justify-content-md-center'<'col-12'rt>><'row mt-2 justify-content-between'<'col-md-auto me-auto'i><'col-md-auto ms-auto'p>>",
            order: [[1, 'asc']],
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ":not(:eq(7))"
                    }
                }, {
                    extend: 'csv',
                    exportOptions: {
                        columns: ":not(:eq(7))"
                    }
                }, {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ":not(:eq(7))"
                    }, customize: function (doc) {
                        doc.content[1].table.widths = 
                            Array(doc.content[1].table.body[0].length + 1).join('*').split('');
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
                url: "{{ route('data-table.list-buyer') }}",
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    title: "No.",
                    width: "5%",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "name",
                    title: "Nama",
                },
                {
                    data: "address",
                    title: "Alamat",
                },
                {
                    data: "code",
                    title: "Kode",
                    render: (data, type) => (!data ? '-': data)
                },
                {
                    data: "telp",
                    title: "No. Telp",
                    render: (data, type) => (!data ? '-' : data)
                },
                {
                    data: "limit_debt",
                    title: "Limit Hutang",
                    render: (data, type) => (!data ? '-' : 'Rp '+formatNum(data, true))
                },
                {
                    data: "limit_time_debt",
                    title: "Tenggat Hutang",
                    render: (data, type) => (!data ? '-' : formatNum(data, true)+' hari')
                },
                {
                    mRender: (data, type, full) => {
                        let url_edit = "{{ route('admin.buyers.update', 'selected_id') }}"
                        let url_destroy = "{{ route('admin.buyers.destroy', 'selected_id') }}"
                        url_edit = url_edit.replace('selected_id', full['id'])
                        url_destroy = url_destroy.replace('selected_id', full['id'])
                        let str_buyer = JSON.stringify(full).replaceAll('"', "'")

                        return `<div class="d-flex gap-2">
                            <button data-url="${url_destroy}" data-buyer="${str_buyer}" class="btn btn-detail btn-light-primary btn-setting-debt btn-sm"><i class="fs-4 ti ti-receipt-2"></i></button>
                            <button data-url="${url_edit}" data-buyer="${str_buyer}" class="btn btn-light-warning btn-edit btn-sm btn-update-icon"><i class="fs-4 ti ti-edit"></i></button>
                        </div>`
                    },
                    title: "Aksi",
                    width: "15%",
                    orderable: false,
                    searchable: false
                }
            ]
        })
    })
</script>
@endpush