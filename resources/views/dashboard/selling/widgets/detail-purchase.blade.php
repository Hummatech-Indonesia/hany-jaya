    <div class="modal fade" id="modalDetailHistory" tabindex="-1" aria-labelledby="modalAddSuplierLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Detail Pesanan
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12 mb-4">
                        <div class="">
                            <h5>Pembeli</h5>
                            <table class="table search-table align-middle text-nowrap">
                                <tbody>
                                    <tr>
                                        <th>Nama</th>
                                        <td>: </td>
                                        <td width="70%" id="name"></td>
                                    </tr>
                                    <tr>
                                        <th>Nomor Invoice</th>
                                        <td>: </td>
                                        <td width="70%" id="invoice_number"></td>
                                    </tr>
                                    {{-- <tr>
                                        <th></th>
                                        <td>: </td>
                                        <td width="70%" id="status"></td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        </div>
                        <table class="table search-table align-middle text-nowrap">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-light font-medium waves-effect text-start"
                        data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
