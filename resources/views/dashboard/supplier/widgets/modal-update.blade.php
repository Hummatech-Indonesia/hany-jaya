<form action="" id="form-update-supplier" method="POST">
    @method('PATCH') @csrf
    <!-- Modal -->
    <div
        class="modal fade"
        id="modalUpdateSuplier"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        tabindex="-1"
        aria-labelledby="modalAddSuplierLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Edit Distributor
                    </h4>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12 mb-4">
                        <label for="edit-supplier-name" class="form-label fw-semibold"
                            >Nama Distributor <small class="text-danger">*</small></label
                        >
                        <input
                        tabindex="1"
                            name="name"
                            type="text"
                            class="form-control"
                            id="edit-supplier-name"
                            placeholder="PT Harapan Baru"
                        />
                    </div>
                    <div class="col-md-12 mb-4">
                        <label
                            for="edit-supplier-address"
                            class="form-label fw-semibold"
                            >Alamat</label
                        >
                        <textarea
                        tabindex="2"
                            class="form-control"
                            name="address"
                            id="edit-supplier-address"
                            cols="20"
                            rows="4"
                            placeholder="Jl Soekarno Hatta No 9"
                        ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light font-medium waves-effect text-start"
                        data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit"
                    tabindex="3"
                        class="btn btn-primary font-medium waves-effect text-start btn-edit">
                        Ubah
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
