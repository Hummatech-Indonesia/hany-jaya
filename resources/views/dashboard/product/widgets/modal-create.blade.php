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
                        <label for="categories" class="form-label fw-semibold">Nama Distributor</label>
                        <input name="name" type="text" class="form-control" id="categories"
                            placeholder="Pt Harapan Jaya" />
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="categories" class="form-label fw-semibold">Alamat</label>
                        <textarea name="address" placeholder="Jl Krajan Gampingan" class="form-control" id="" cols="30" rows="10"></textarea>
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
