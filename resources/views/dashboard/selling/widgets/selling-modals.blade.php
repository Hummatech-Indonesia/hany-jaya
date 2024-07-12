<div class="modal modal-lg" id="selling-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bolder">Keranjang</h5>
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

@push('custom-script')
    <script>
        $(document).on('click', '#btn-open-modal', function() {
            $('#selling-modal [data-for=name]').html($('#cust-name').val())
            $('#selling-modal [data-for=address]').html($('#cust-address').val())
            $('#selling-modal [data-for=phone]').html($('#telp').val())

            let product_el = ''
            
            $('#tb-product tr[data-index]').each(function() {
                let product = JSON.parse($(this).data('product').replaceAll("'", '"'))
                product_el += `
                <tr>
                    <th>${product.name} | ${product.code}</th>
                    <td>${$(this).find('.input-quantity').val()} ${$(this).find('.product-unit :selected').data('unit')}</td>
                    <td>Rp ${$(this).find('.input-unit-price').val()}</td>
                    <td>Rp ${$(this).find('.input-selling-price').val()}</td>
                </tr>
                `
            })

            product_el += `
                <tr>
                    <th colspan="3">Total</th>
                    <td>: ${$('#total_price').html()}</td>
                </tr>`
            if($('#tunai').is(':checked')) {
                product_el += `<tr>
                    <th colspan="3">Dibayarkan</th>
                    <td>: Rp ${$('#formatted_pay').val()}</td>
                </tr>
                <tr>
                    <th colspan="3">Kembalian</th>
                    <td>: Rp ${$('#formatted_return').val()}</td>
                </tr>`
            }
            if($('#hutang').is(':checked')) {
                product_el += `<tr>
                    <th colspan="3">Hutang</th>
                    <td>: Rp ${$('#formatted_debt').val()}</td>
                </tr>`
            }

            $('#selling-modal [data-for=product_list]').html(product_el)
        })
    </script>
@endpush