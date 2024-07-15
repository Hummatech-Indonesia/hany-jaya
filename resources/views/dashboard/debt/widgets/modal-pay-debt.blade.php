<div class="modal" tabindex="-1" id="modal-debt-pay">
    <div class="modal-dialog">
        <form class="modal-content">
            <div class="modal-header">
                <h5>Pembayaran Piutang</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    @csrf
                    <div class="col-md-3 mb-md-3">
                        <label for="buyer_id">Pembeli</label> <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-9 mb-3">
                        <select name="buyer_id" id="buyer_id" class="form-select"></select>
                    </div>

                    <div class="col-md-3 mb-md-3">
                        <label for="debt">Total Hutang</label>
                    </div>
                    <div class="col-md-9 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">Rp</div>
                            <input type="text" class="form-control" id="debt" placeholder="Total Hutang" readonly>
                        </div>
                    </div>

                    <div class="col-md-3 mb-md-3">
                        <label for="pay">Dibayarkan <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-9 mb-3">
                        <div class="input-group">
                            <div class="input-group-text">Rp</div>
                            <input type="text" class="form-control" id="pay" name="pay" placeholder="Hutang Dibayarkan">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Bayar</button>
            </div>
        </div>
    </div>
</div>