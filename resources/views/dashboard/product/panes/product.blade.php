<div class="table-responsive">
    <table class="table align-middle table-striped table-hover w-100" id="product-table">
    </table>
</div>
@push('custom-script')
<script>  
    $(document).ready(function() {
        let product_datatable = $('#product-table').DataTable({
            processing: true,
            serverSide: true,
            order: [[2, 'asc']],
            language: {
                processing: `Memuat...`
            },
            ajax: {
                url: "{{ route('data-table.list-product') }}",
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    title: "No",
                    orderable: false,
                    searchable: false
                }, {
                    data: "image",
                    title: "Gambar",
                    orderable: false,
                    searchable: false,
                    render: (data, type, row) => {
                        return `<img src="{{ asset('storage') }}/${data}" alt="gambar produk" class="rounded" style="width: 75px;height: 75px;object-fit: cover"/>`
                    }
                }, {
                    data: "name",
                    title: "Nama",
                }, {
                    mRender: (data, type, full) => {
                        return full['quantity']+" "+full["unit"]["name"];
                    },
                    title: "Stok",
                }, {
                    data: "category.name",
                    title: "Kategori"
                }, {
                    mRender: (data, type, full) => {
                        let url_edit = "{{ route('admin.products.edit', 'selected_id') }}"
                        let url_destroy = "{{ route('admin.products.destroy', 'selected_id') }}"
                        url_edit = url_edit.replace('selected_id', full['id'])
                        url_destroy = url_destroy.replace('selected_id', full['id'])

                        return `<div class="d-flex gap-2">
                            <a href="${url_edit}" class="btn btn-light-primary btn-sm btn-update-icon"><i class="fs-4 ti ti-edit"></i></a>
                            <button data-url="${url_destroy}" class="btn btn-delete-product btn-light-danger btn-delete-icon btn-sm"><i class="fs-4 ti ti-trash"></i></button>
                        </div>`
                    },
                    title: "Aksi",
                    width: "15%",
                }
            ]
        })

        $(document).on("click", '.btn-delete-product', function() {
            $('#delete-title').html('Hapus Produk');
            $("#delete-modal").modal("show");

            let url = $(this).attr("data-url");
            $("#form-delete").attr("action", url);
        });
    })
</script>
@endpush