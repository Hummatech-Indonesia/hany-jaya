<form action="" id="form-update" method="POST">
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
                        <label for="input-name" class="form-label fw-semibold">Nama Pemasok</label>
                        <input name="name" type="text" class="form-control" id="input-name"
                            placeholder="PT Harapan Baru" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger text-danger font-medium waves-effect text-start"
                        data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit"
                        class="btn btn-light-primary text-primary font-medium waves-effect text-start">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
