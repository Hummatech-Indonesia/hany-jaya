<div class="modal modal-xl max-w-full fade" id="modalDetailProduct"  tabindex="-1"
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
                    <div class="col-md-4 col-lg-3">
                        <img id="img-detail" src="https://id-test-11.slatic.net/p/108b12bf39e6b2d8e83d44de08802466.jpg" alt="gambar produk"
                            class="rounded" style="width: 100%;aspect-ratio: 1/1;object-fit: cover" />

                            <div class="row mt-3">
                                <div class="col-12 mb-2">
                                    <label for="categories" class="form-label fw-semibold">Nama Produk</label>
                                    <input name="name" type="text" class="form-control" id="name-product-detail"
                                        placeholder="Pt Harapan Jaya" value="Kopi Bubuk" readonly />
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="categories" class="form-label fw-semibold">Kode Produk</label>
                                    <input name="name" type="text" class="form-control" id="code-product-detail"
                                        placeholder="Pt Harapan Jaya" value="Rp 10.000" readonly />
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="categories" class="form-label fw-semibold">Kategori</label>
                                    <input name="name" type="text" class="form-control" id="category-detail"
                                        placeholder="Pt Harapan Jaya" value="Minuman" readonly />
                                </div>
                                <div class="col-md-12 mt-3 d-none">
                                    <div class="table-responsive border">
                                        <table class="table">
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
                    <div class="col-md-8 col-lg-9 table-responsive">
                                <div class="fw-semibold">Riwayat Transaksi Produk</div>
                                <table class="table align-middle w-100 text-break" id="tb-product-detail"></table>
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

@push('custom-script')
    <script>
        $(document).ready(function() {
            let product_detail_tb = null
            $(document).on('click', '#product-table .btn-detail', function() {
                let product = JSON.parse($(this).data('product').replaceAll("'", '"'))
                let dt_url_detail = "{{ route('data-table.list-detail-product', 'selected_id') }}"
                dt_url_detail = dt_url_detail.replace('selected_id', product.id)
                
                if(product_detail_tb) {
                    product_detail_tb.ajax.url(dt_url_detail).load()
                    return
                }

                product_detail_tb = $('#tb-product-detail').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [[1, 'desc']],
                    ajax: {
                        url: dt_url_detail
                    },
                    columns: [
                        {
                            data: "DT_RowIndex",
                            title: "No",
                            searchable: false,
                            orderable: false
                        }, {
                            data: "date",
                            title: "Tanggal",
                            render: (data, type) => {
                                return moment(data).format("DD MMMM YYYY")
                            }
                        }, {
                            title: "Pembeli / Distributor",
                            mRender: (data, type, row) => {
                                if(row['type'] == 'buying') return row['supplier']
                                else return row['buyer']
                            },
                            searchable: false,
                            orderable: false
                        }, {
                            data: "type",
                            render: (data, type, row) => {
                                if(row['type'] == 'buying') return `<span class="badge bg-primary fs-2">Pembelian</span>`
                                else return `<span class="badge bg-success fs-2">Penjualan</span>`
                            },
                            title: 'Jenis'
                        }, {
                            data: "quantity",
                            title: "Jumlah",
                            render: (data, type, row) => {
                                return formatNum(data, true)+' '+row['unit_name']
                            }
                        }, {
                            data: "total_per_unit_price",
                            title: "Harga",
                            render: (data, type) => {
                                return 'Rp '+formatNum(data, true)
                            }
                        }, {
                            data: "total_price",
                            title: "Total",
                            render: (data, type) => {
                                return 'Rp '+formatNum(data, true)
                            }
                        }
                    ]
                })
            })
        })
    </script>
@endpush