<form action="" method="POST" id="form-update">
    @csrf
    @method('PATCH')
    <!-- Modal -->
    <div class="modal fade" id="modalPayDebt" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalAddSuplierLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Bayar Hutang
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12 mb-4">
                        <label for="pay_debt" class="form-label fw-semibold">Nominal</label>
                        <input name="pay_debt" type="text" class="form-control" id="pay_debt" placeholder="12000" />
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
