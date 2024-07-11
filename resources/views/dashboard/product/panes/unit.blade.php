@include('dashboard.unit.widgets.modal-create')
@include('dashboard.unit.widgets.modal-update')

<div class="table-responsive">
    <table class="table align-middle table-striped table-hover w-100" id="tb-unit-list"></table>
</div>

@push('custom-script')
<script>
    $(document).ready(function() {

        let tb_unit = $('#tb-unit-list').DataTable({
            processing: true,
            serverSide: true,
            order: [[1, 'asc']],
            ajax: {
                url: "{{route('data-table.list-unit')}}"
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    title: "No",
                    searchable: false,
                    orderable: false
                }, {
                    data: "name",
                    title: "Satuan"
                }, 
                @role('admin')
                {
                    mRender: (data, type, full) => {
                        let string_data = JSON.stringify(full).replaceAll('"', "'")
                        let edit_url = "{{route('admin.units.edit', 'selected_id')}}"
                        edit_url = edit_url.replace("selected_id", full['id'])
                        let del_url = "{{route('admin.units.destroy', 'selected_id')}}"
                        del_url = del_url.replace("selected_id", full['id'])
                        return `
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-sm btn-light-primary btn-update-unit btn-update-icon" data-unit="${string_data}"
                                        data-url="${edit_url}">
                                        <i class="fs-4 ti ti-edit"></i>
                                    </button>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-sm btn-light-danger btn-delete-unit btn-delete-icon" data-url="${del_url}">
                                        <i class="fs-4 ti ti-trash"></i>
                                    </button>
                                </div>
                            </div>
                        `
                    },
                    title: "Aksi",
                    searchable: false,
                    orderable: false,
                    width: "15%"
                }
                @endrole
            ]
        })
    
        // set autofocus 
        $('#modalAddUnit').on('shown.bs.modal', function() {
            $('#name-unit').focus();
        })
        $('#modalUpdateUnit').on('shown.bs.modal', function() {
            $('#edit-name-unit').focus();
        })
    
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
    
        // validasi form 
        $(document).on('submit', '#form-create-unit', function(e) {
            e.preventDefault();
            let listId = ['#name-unit'];
            let listMessage = ['Nama Satuan tidak boleh kosong'];
            if (validate(listId, listMessage)) {
                return;
            }
            $(this).unbind('submit').submit();
        })
        $(document).on('submit', '#form-update-unit', function(e) {
            e.preventDefault();
            let listId = ['#edit-name-unit'];
            let listMessage = ['Nama Satuan tidak boleh kosong'];
            if (validate(listId, listMessage)) {
                return;
            }
            $(this).unbind('submit').submit();
        })
    
        // clear error message 
        $('#modalAddUnit').on('hidden.bs.modal', function() {
            $('#name-unit').removeClass('is-invalid')
            $('#name-unit').next().remove()
        })
        $('#modalUpdateUnit').on('hidden.bs.modal', function() {
            $('#edit-name-unit').removeClass('is-invalid')
            $('#edit-name-unit').next().remove()
        })
    
        $(document).on("click", ".btn-update-unit", function() {
            $("#modalUpdateUnit").modal("show");
            let url = $(this).attr("data-url");
            let stringify_unit = $(this).data("unit");
            let unit = JSON.parse(stringify_unit.replaceAll("'", '"'))
    
            $("#modalUpdateUnit").find("#edit-name-unit").val(unit.name);
            $("#form-update-unit").attr("action", url);
        });
        $(document).on("click", ".btn-delete-unit", function() {
            $('#delete-title').html('Hapus Unit');
            $("#delete-modal").modal("show");
    
            let url = $(this).attr("data-url");
            $("#form-delete").attr("action", url);
        });
    })
</script>
@endpush