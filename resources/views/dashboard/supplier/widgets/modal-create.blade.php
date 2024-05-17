<form action="{{ route('admin.suppliers.store') }}" method="POST">
    @csrf
    <!-- Modal -->
    <div class="modal fade" id="modalAddSuplier" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalAddSuplierLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Tambah Pemasok
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12 mb-4">
                        <label for="exampleInputPassword1" class="form-label fw-semibold">Nama Pemasok</label>
                        <input name="name" type="text" class="form-control" id="exampleInputtext"
                            placeholder="PT Harapan Baru" />
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="exampleInputPassword1" class="form-label fw-semibold">Alamat</label>
                        <textarea class="form-control" name="address" id="" cols="20" rows="4"
                            placeholder="Jl Soekarno Hatta No 9"></textarea>
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
