@include('dashboard.category.widgets.modal-create')
@include('dashboard.category.widgets.modal-create')

<div class="table-responsive">
    <table class="table align-middle table-striped w-100" id="tb-categories"></table>
</div>

@include('dashboard.category.widgets.modal-update')

<x-dialog.delete title="Hapus Karton" />

@push('custom-script')
<script>

    $('#tb-categories').DataTable({
        processing: true,
        serverSide: true,
        language: {
            processing: "Memuat..."
        },
        ajax: {
            url: "{{route('data-table.list-category')}}"
        },
        order: [[1, 'asc']],
        columns: [
            {
                data: 'DT_RowIndex',
                title: 'No',
                searchable: false,
                orderable: false
            }, {
                data: 'name',
                title: "Kategori"
            }, {
                data: "products_count",
                title: "Total Produk"
            },
            @role('admin')
            {
                mRender: (data, type, row) => {
                    let edit_url = "{{route('admin.categories.update', 'selected_id')}}"
                    edit_url = edit_url.replace('selected_id', row['id'])
                    let del_url = "{{route('admin.categories.destroy', 'selected_id')}}"
                    del_url = del_url.replace('selected_id', row['id'])
                    let category = JSON.stringify(row).replaceAll('"', "'")

                    return `
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-light-primary btn-update-category btn-update-icon" data-category="${category}"
                            data-url="${edit_url}">
                                <i class="fs-4 ti ti-edit"></i>
                            </button>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-light-danger btn-delete-category btn-delete-icon" data-url="${del_url}">
                                <i class="fs-4 ti ti-trash"></i>
                            </button>
                        </div>
                    </div>
                    `
                },
                title: 'Aksi',
                searchable: false,
                orderable: false,
                width: '15%'
            }
            @endrole
        ]
    })

    // set autofocus 
    $("#modalAddCategory").on("shown.bs.modal", function() {
        $("#category-name").focus();
    });
    $("#modalUpdateCategory").on("shown.bs.modal", function() {
        $("#edit-name-category").focus();
    });

    function validate(listId, listMessage) {
        let countError = 0;
        listId.map(id => {
            let siblings = $(id).parent().children().length;
            if (($(id).val() == '' || $(id).val() == null) && siblings == 2) {
                $(id).addClass('is-invalid')
                $(id).parent().append(
                    '<small class="text-danger">' + listMessage[listId.indexOf(id)] + '</small>'
                )
                countError++;
            }
            if (($(id).val() == '' || $(id).val() == null) && siblings > 2) {
                countError = 1;
            }
        })

        return countError > 0 ? true : false;
    }

    // validate form 
    $("#form-add-category").on("submit", function(e) {
        e.preventDefault();
        let listId = ["#category-name"];
        let listMessage = ["Nama kategori tidak boleh kosong"];
        if (validate(listId, listMessage)) {
            return;
        }
        $(this).unbind("submit").submit();
    });
    $("#form-update-category").on("submit", function(e) {
        e.preventDefault();
        let listId = ["#edit-name-category"];
        let listMessage = ["Nama kategori tidak boleh kosong"];
        if (validate(listId, listMessage)) {
            return;
        }
        $(this).unbind("submit").submit();
    });

    // clear error message 
    $("#modalAddCategory").on("hidden.bs.modal", function() {
        $("#category-name").removeClass("is-invalid");
        $("#category-name").next().remove();
    });
    $("#modalUpdateCategory").on("hidden.bs.modal", function() {
        $("#edit-name-category").removeClass("is-invalid");
        $("#edit-name-category").next().remove();
    });

    $(document).on("click", ".btn-update-category",function() {
        $("#modalUpdateCategory").modal("show");
        let url = $(this).attr("data-url");
        let category_str = $(this).data("category");
        let category = JSON.parse(category_str.replaceAll("'", '"'))

        $("#modalUpdateCategory").find("#edit-name-category").val(category.name);
        $("#form-update-category").attr("action", url);
    });
    $(document).on("click", ".btn-delete-category", function() {
        $("#delete-modal").modal("show");

        let url = $(this).attr("data-url");
        $("#form-delete").attr("action", url);
    });
</script>
@endpush