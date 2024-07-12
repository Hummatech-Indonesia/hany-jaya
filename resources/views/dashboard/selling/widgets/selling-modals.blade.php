<div class="modal modal-lg" id="selling-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bolder">Keranjang</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row p-3">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="fw-bolder">Nama</label>
                            <div class="form-control" data-for="name"></div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="fw-bolder">Alamat</label>
                            <div class="form-control" data-for="address"></div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="fw-bolder">No. Telp</label>
                            <div class="form-control" data-for="phone"></div>
                        </div>
                    </div>
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
            $('#selling-modal [data-for=phone]').html($('#telp').val() ? $('#telp').val() : '-')

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
                <tr></tr>
                <tr>
                    <td colspan="2"></td>
                    <th>Total</th>
                    <td>: ${$('#total_price').html()}</td>
                </tr>`
            if($('#tunai').is(':checked')) {
                product_el += `<tr>
                    <td colspan="2"></td>
                    <th>Dibayarkan</th>
                    <td>: Rp ${$('#formatted_pay').val()}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <th>Kembalian</th>
                    <td>: Rp ${$('#formatted_return').val()}</td>
                </tr>`
            }
            if($('#hutang').is(':checked')) {
                product_el += `<tr>
                    <td colspan="2"></td>
                    <th>Hutang</th>
                    <td>: Rp ${$('#formatted_debt').val()}</td>
                </tr>`
            }

            $('#selling-modal [data-for=product_list]').html(product_el)
        })
    </script>
@endpush