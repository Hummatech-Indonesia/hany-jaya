<form action="" id="form-update-unit" method="POST">
    @method('PUT') @csrf
    <!-- Modal -->
    <div class="modal fade" id="modalUpdateUnit"  tabindex="-1"
        aria-labelledby="modalUpdateUnitLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Edit Satuan
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12 mb-4">
                        <label for="edit-name-unit" class="form-label fw-semibold">Nama Satuan <small class="text-danger">*</small></label>
                        <input name="name" type="text" class="form-control" id="edit-name-unit"
                            placeholder="Karton" />
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
