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
                                <div class="col-12 mb-3">
                                    <div>Nama Produk</div>
                                    <div class="fw-semibold" id="name-product-detail"></div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div>Kode Produk</div>
                                    <div class="fw-semibold" id="code-product-detail"></div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div>Kategori</div>
                                    <div class="fw-semibold" id="category-detail"></div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div>Harga</div>
                                    <div class="fw-semibold" id="price-detail"></div>
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
                        <table class="table align-middle" style="min-width: 800px" id="tb-product-detail"></table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button data-url="#" id="btn-detail-delete" class="btn btn-light-danger btn-delete-icon btn-delete-product">Hapus</button>
                <a href="#" id="btn-detail-edit" class="btn btn-light-warning btn-update-icon">Ubah</a>
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
                let product = JSON.parse($(this).attr('data-product').replaceAll("'", '"'))
                let dt_url_detail = "{{ route('data-table.list-detail-product', 'selected_id') }}"
                dt_url_detail = dt_url_detail.replace('selected_id', product.id)

                let del_url = "{{ route('admin.products.destroy', 'selected_url') }}"
                let edit_url = "{{ route('admin.products.edit', 'selected_url') }}"
                del_url = del_url.replace('selected_url', product.id)
                edit_url = edit_url.replace('selected_url', product.id)
                $('#btn-detail-delete').attr('data-url', del_url)
                $('#btn-detail-edit').attr('href', edit_url)
                $(document).on('click', function() {
                    $('#modalDetailProduct').modal('hide')
                })

                let product_units = product.product_units
                
                if(product_detail_tb) {
                    product_detail_tb.destroy()
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
                            data: "name",
                            title: "Pembeli / Distributor",
                            searchable: true,
                            orderable: false
                        }, {
                            data: "address",
                            title: "Alamat"
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
                            render: (data, type, row) => {
                                const used_unit = product_units.find((d) => (d.unit.name == row['unit_name']))
                                let selling_price = used_unit && used_unit.selling_price ? used_unit.selling_price : 0
                                if(selling_price < data) return '<span class="text-danger">Rp '+formatNum(data, true)+"</span>"
                                return 'Rp '+formatNum(data, true)
                            }
                        }
                    ]
                })
            })
        })
    </script>
@endpush