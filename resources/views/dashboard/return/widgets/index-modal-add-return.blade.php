<div class="modal modal-lg fade" id="modalAddReturn">
    <div class="modal-dialog">
        <form action="{{ route('admin.purchases.return') }}" action="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5>Tambah Data Retur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body mb-0 pb-0">
                <div class="form-group mb-3">
                    <label for="invoice">No. Invoice</label>
                    <div class="d-flex gap-3">
                        <input type="text" name="invoice" id="invoice" placeholder="No. Invoice" class="form-control w-100">
                        <button type="button" class="btn btn-secondary" id="btn-search-invoice"><i class="ti ti-search"></i></button>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="note">Catatan</label>
                    <textarea type="text" name="note" id="note" placeholder="Catatan" class="form-control"></textarea>
                </div>
                <div class="tb-product">
                    <label>Produk</label>
                    <table class="table align-middle table-striped text-center">
                        <thead>
                            <tr>
                                <th style="width: 50px">#</th>
                                <th style="width: 200px">Produk</th>
                                <th style="width: 100px">Qty Dibeli</th>
                                <th style="width: 200px">Qty Dikembalikan</th>
                            </tr>
                        </thead>
                        <tbody id="tb-product-list">
                            <tr>
                                <td colspan="4" class="text-center text-muted">-- no invoice tidak ditemukan --</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" type="button" data-bs-dismiss="modal">Tutup</button>
                <button class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </div>
</div>

@push('custom-script')
    {{-- <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script> --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '#btn-search-invoice', function() {
                const products = [
                    {
                        name: 'Produk Kesatu',
                        qty: 10,
                        code: 'A2T43',
                    }, {
                        name: 'Produk Kedua',
                        qty: 24,
                        code: 'T5AAT',
                    },
                ]

                let product_html = ''
                products.forEach((product, index) => {
                    product_html += `<tr>
                        <th>${index+1}</th>
                        <td>${product.name} (${product.code})</td>
                        <td>${product.qty}</td>
                        <td>
                            <input class="form-control bg-white qty-back" data-max="${product.qty}" />
                            <input type="hidden" name="qty_return[]" value="" />
                        </td>
                    </tr>`
                })
                $('#tb-product-list').html(product_html)
            })

            $(document).on('input', '.qty-back', function() {
                let qty = unformatNum($(this).val())
                let max = $(this).data('max')

                if(qty < 0) qty = 0
                if(qty > max) qty = max

                $(this).val(formatNum(qty, true))
                $(this).closest('tr').find('input[name=qty_return\\[\\]]').val(qty)
            })
        })
    </script>
@endpush