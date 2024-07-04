    <div class="modal fade" id="modalDetailHistory" tabindex="-1" aria-labelledby="modalAddSuplierLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Detail Pesanan
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card bg-primary-subtle">
                        <div class="card-body">
                            <h5>Pembeli</h5>
                            <table class="table search-table align-middle text-nowrap table-primary">
                                <tbody>
                                    <tr>
                                        <th>Nama</th>
                                        <td>: </td>
                                        <td width="70%" id="name"></td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>: </td>
                                        <td width="70%" id="address"></td>
                                    </tr>
                                    <tr>
                                        <th>Status Pembayaran</th>
                                        <td>: </td>
                                        <td width="70%" id="status"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card bg-success-subtle">
                        <div class="card-body mb-0">
                            <table class="table search-table align-middle text-nowrap table-success">
                                <thead class="header-item">
                                    <th>#</th>
                                    <th>Nama Produk</th>
                                    <th>Satuan</th>
                                    <th>Jumlah Produk</th>
                                    <th>Potongan Harga</th>
                                    <th>Harga</th>
                                </thead>
                                <tbody id="value_table">
                                </tbody>
                                <tbody id="box_price">
                                    <tr>
                                        <td colspan="5" class="text-end fw-bold">Total Harga</td>
                                        <td>Rp. <span id="price">0</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-end fw-bold">Uang Dibayar</td>
                                        <td>Rp. <span id="pay">0</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-end fw-bold">Uang Kembalian</td>
                                        <td>Rp. <span id="return">0</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
