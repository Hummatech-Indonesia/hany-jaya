<form action="{{ route('admin.suppliers.store') }}" method="POST">
    @csrf
    <!-- Modal -->
    <div class="modal fade" id="modalAddSuplier"  tabindex="-1"
        aria-labelledby="modalAddSuplierLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Tambah Distributor
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12 mb-4">
                        <label for="supplier-name" class="form-label fw-semibold">Nama Distributor <small class="text-danger">*</small></label>
                        <input tabindex="1" name="name" type="text" class="form-control" id="supplier-name"
                            placeholder="PT Harapan Baru" />
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="supplier-address" class="form-label fw-semibold">Alamat <small class="text-danger">*</small></label>
                        <textarea tabindex="2" class="form-control" name="address" id="supplier-address" cols="20" rows="4"
                            placeholder="Jl Soekarno Hatta No 9"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light font-medium waves-effect text-start"
                        data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button tabindex="3" type="submit"
                        class="btn btn-primary font-medium waves-effect text-start btn-tambah">
                        Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
