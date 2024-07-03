<form id="form-create-unit" action="{{ route('admin.units.store') }}" method="POST">
    @csrf
    <!-- Modal -->
    <div class="modal fade" id="modalAddUnit"  tabindex="-1"
        aria-labelledby="modalAddUnitLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Tambah Satuan
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12 mb-4">
                        <label for="name-unit" class="form-label fw-semibold">Nama Satuan <small class="text-danger">*</small></label>
                        <input tabindex="1" name="name" type="text" class="form-control" id="name-unit" placeholder="Karton" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light font-medium waves-effect text-start"
                        data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button tabindex="2" type="submit"
                        class="btn btn-primary font-medium waves-effect text-start btn-tambah">
                        Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
