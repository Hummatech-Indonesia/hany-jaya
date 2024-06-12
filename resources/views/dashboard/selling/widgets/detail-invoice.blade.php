    <div class="modal fade" id="modalDetailHistory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalAddSuplierLabel" aria-hidden="true">
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
                                        <td id="name"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>: </td>
                                        <td id="address"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <table class="table search-table align-middle text-nowrap">
                            <thead class="header-item">
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Jumlah Produk</th>
                                <th>Potongan Harga</th>
                                <th>Harga</th>
                            </thead>
                            <tbody id="value_table">
                            </tbody>
                        </table>
                        <div class="">
                            <div class="">
                                <h6>Total Harga: Rp. <span id="price"></span></h6>
                                <h6>Uang Dibayar: Rp. <span id="pay"></span></h6>
                                <h6>Uang Kembalian: Rp. <span id="return"></span></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger text-danger font-medium waves-effect text-start"
                        data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit"
                        class="btn btn-light-primary text-primary font-medium waves-effect text-start">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
