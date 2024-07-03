<form action="" id="form-update-category" method="POST">
    @method('PUT') @csrf
    <!-- Modal -->
    <div class="modal fade" id="modalUpdateCategory"  tabindex="-1"
        aria-labelledby="modalAddSuplierLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Edit Kategori
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12 mb-4">
                        <label for="edit-name-category" class="form-label fw-semibold">Nama Kategori <small class="text-danger">*</small></label>
                        <input name="name" type="text" class="form-control" id="edit-name-category"
                            placeholder="Snack" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light font-medium waves-effect text-start"
                        data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit"
                        class="btn btn-primary font-medium waves-effect text-start btn-edit">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
