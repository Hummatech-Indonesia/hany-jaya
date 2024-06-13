<form action="" method="POST" id="form-update">
    @csrf
    @method('PUT')
    <!-- Modal -->
    <div class="modal fade" id="modalEditCashier" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalAddSuplierLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Edit Kasir
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12 mb-4">
                        <label for="name" class="form-label fw-semibold">Nama</label>
                        <input name="name" type="text" class="form-control" id="name" placeholder="Kasir" />
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input name="email" type="email" class="form-control" id="email" placeholder="kasir@gmail.com" value=""/>
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="exampleInputPassword1" class="form-label fw-semibold">Password (opsional)</label>
                        <input name="password" type="password" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger text-danger font-medium waves-effect text-start"
                        data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit"
                        class="btn btn-light-primary text-primary font-medium waves-effect text-start">
                        Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
