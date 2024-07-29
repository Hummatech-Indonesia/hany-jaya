<div class="modal" tabindex="-1" id="modal-adjust-stock">
    <div class="modal-dialog">
        <form method="post" class="modal-content" id="form-adjust-stock" action="#">
            <div class="modal-header">
                <h5>Sesuaikan Stok</h5>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @csrf
                <div class="form-group mb-3">
                    <label for="product_id" class="form-label">Produk <span class="text-danger">*</span></label>
                    <select name="product_id" id="product_id">
                        @foreach($products as $product)
                        <option value="" selected disabled></option>
                        <option value="{{$product->id}}" data-unit="{{$product->unit}}" data-product="{{$product}}">{{$product->name}} | {{$product->code}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="old_stock" class="form-label">Stok saat ini</label>
                    <input type="text" id="old_stock" class="form-control" placeholder="Stok saat ini" disabled>
                </div>
                <div class="form-group mb-3">
                    <label for="new_stock" class="form-label">Stok baru <span class="text-danger">*</span></label>
                    <input type="text" id="new_stock" class="form-control" placeholder="Stok baru" required>
                    <input type="hidden" name="new_stock" required>
                </div>
                <div class="form-group">
                    <label for="note" class="form-label">Catatan <span class="text-danger">*</span></label>
                    <textarea name="note" id="note" class="form-control" placeholder="Catatan" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Sesuaikan</button>
            </div>
        </form>
    </div>
</div>

@push('custom-script')
    <script>
        $(document).ready(function() {
            const selectize_product_id = $('#product_id').selectize({
                placeholder: 'Pilih Produk',
                onChange: () => {
                    onProductChange()
                }
            })
            const select_product_id = selectize_product_id[0].selectize

            function onProductChange() {
                const selected_product = select_product_id.getValue()
                const selected_data_product = select_product_id.options[selected_product]

                // change input value
                if(selected_product) {
                    $('#old_stock').val(formatNum(selected_data_product.product.quantity))
                    $('#new_stock').val(formatNum(selected_data_product.product.quantity))
                    $('[name=new_stock]').val(selected_data_product.product.quantity)
                } else {
                    $('#old_stock').val('')
                    $('#new_stock').val('')
                    $('[name=new_stock]').val('')
                }

                // change form url
                let form_url
                if(selected_product) {
                    form_url = "{{route('admin.adjustments.update-stock', 'selected_id')}}"
                    form_url = form_url.replace('selected_id', selected_data_product.product.id)
                } else {
                    form_url = "#"
                }
                $('#form-adjust-stock').attr('action', form_url)
            }

            $(document).on('input', '#new_stock', function() {
                if($(this).val() < 0) $(this).val(0)
                $(this).val(formatNum($(this).val()))
                $('[name=new_stock]').val(unformatNum($(this).val()))
            })
        })
    </script>
@endpush