<div class="modal modal-lg" id="selling-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">Keranjang</div>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">Nama</div>
                    <div class="col-8">: <span data-for="name"></span></div>
                </div>
                <div class="row">
                    <div class="col-4">Alamat</div>
                    <div class="col-8">: <span data-for="address"></span></div>
                </div>
                <div class="row">
                    <div class="col-4">Telp</div>
                    <div class="col-8">: <span data-for="phone"></span></div>
                </div>
                <table class="table table-responsive align-middle">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody data-for="product_list">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Bayar</button>
            </div>
        </div>
    </div>
</div>