<div class="modal fade" id="modal-update-product" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Ubah harga produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="product_id">
                <div class="input-group">
                    <div class="input-group-text">Rp</div>
                    <input type="text" id="price" class="form-control">
                </div>
                <input type="hidden" name="price">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">batal</button>
                <button type="button" class="btn btn-primary" id="btn-submit-update">Ubah</button>
            </div>
        </div>
    </div>
</div>

@push('custom-script')
<script>
    $(document).ready(function() {
        let edited_tr

        $(document).on('click', '.btn-show-modal-update', function() {
            let product = JSON.parse($(this).data('product').replaceAll("'", '"'))
            edited_tr = $(this).closest('tr')
            price = edited_tr.find('[name=product_unit_price\\[\\]]').val()
            $('#modal-update-product [name=product_id]').val(product.id)
            $('#modal-update-product [name=price]').val(price)
            $('#modal-update-product #price').val(formatNum(price))

            $('#modal-update-product').modal('show')
            setTimeout(() => {
                $('#modal-update-product #price').focus()
            }, 100);
        })

        $(document).on('input', '#modal-update-product #price', function() {
            let unformat_number = unformatNum($(this).val())

            if(unformat_number < 0) $(this).val(0)

            $(this).val(formatNum($(this).val()))
            $('#modal-update-product [name=price]').val(unformatNum($(this).val()))
        })

        $(document).on('keydown', function(e) {
            if(
                e.code.toLowerCase() === 'enter'
                && ($('#modal-update-product').is(':visible') ||
                $('#modal-update-product #price').is(':focus'))
            ) {
                $('#btn-submit-update').trigger('click')
            }
        })

        $(document).on('click', '#btn-submit-update', function() {
            $.ajax({
                url: "{{route('api.product.update.price.ajax')}}",
                method: "POST",
                data: {
                    product_id: $('#modal-update-product [name=product_id]').val(),
                    price: $('#modal-update-product [name=price]').val()
                },
                success: (res) => {
                    Toaster('success', res.message)
                    edited_tr.find('.input-unit-price').val(formatNum($('#modal-update-product #price').val()))
                    edited_tr.find('[name=product_unit_price\\[\\]]').val($('#modal-update-product [name=price]').val())
                    edited_tr.find('[name=quantity\\[\\]]').val()

                    const qty = edited_tr.find('[name=quantity\\[\\]]').val()
                    const price = edited_tr.find('[name=product_unit_price\\[\\]]').val()
                    const total = qty * price
                    edited_tr.find('[name=selling_price\\[\\]]').val(total)
                    edited_tr.find('.input-selling-price').val(formatNum(total, true))
                    setTotalPrice()
                    $('#modal-update-product').modal('hide')
                    setTimeout(() => {
                        fn_focus_last()
                    }, 100);
                }, error: (xhr) => {
                    Toaster('error', xhr.responseJSON.message)
                }
            })
        })

        function setTotalPrice() {
            let total = 0
            let tr = document.querySelectorAll('#tb-product > tr[data-index]')
            tr.forEach((el, index) => {
                const selling_price_input = el.querySelector('[name="selling_price[]"]')
                total += parseFloat(selling_price_input.value) || 0
            })

            $('#total_price').html('Rp '+formatNum(total))
        }

        function setUpdateTotalPrice(newangka) {
            let total = newangka
            $('#tb-product tr[data-index]').each(() => {
                total += $(this).find('[name=selling_price\\[\\]]').val()
            })

            $('#total_price').html('Rp '+formatNum(total))
        }
    })
</script>
@endpush