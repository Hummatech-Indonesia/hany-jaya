<div class="modal fade" id="modalDetailProduct"  tabindex="-1"
        aria-labelledby="modalDetailProductLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Detail Produk
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="img-detail" src="https://id-test-11.slatic.net/p/108b12bf39e6b2d8e83d44de08802466.jpg" alt="gambar produk"
                                class="rounded" style="width: 100%;height: 100%;object-fit: cover" />
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="categories" class="form-label fw-semibold">Nama Produk</label>
                                    <input name="name" type="text" class="form-control" id="name-product-detail"
                                        placeholder="Pt Harapan Jaya" value="Kopi Bubuk" readonly />
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="categories" class="form-label fw-semibold">Kode Produk</label>
                                    <input name="name" type="text" class="form-control" id="code-product-detail"
                                        placeholder="Pt Harapan Jaya" value="Rp 10.000" readonly />
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="categories" class="form-label fw-semibold">Kategori</label>
                                    <input name="name" type="text" class="form-control" id="category-detail"
                                        placeholder="Pt Harapan Jaya" value="Minuman" readonly />
                                </div>
                                <div class="col-md-12 mt-3">
                                    <table class="table border table-responsive">
                                        <thead>
                                            <th>No</th>
                                            <th>Stok/Satuan</th>
                                            <th>Harga</th>
                                        </thead>
                                        <tbody id="table-unit-detail">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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