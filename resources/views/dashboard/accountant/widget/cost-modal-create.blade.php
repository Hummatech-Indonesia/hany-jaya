<div class="modal fade" id="addCostModal">
    <div class="modal-dialog">
        <form class="modal-content" action="{{route('admin.costs.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5>Tambah Pengeluaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="date">Tanggal Pengeluaran <span class="text-danger">*</span></label>
                    <input type="date" name="date" id="date" placeholder="Tanggal" class="form-control" value='{{ date('Y-m-d') }}' required tabindex="1">
                </div>
                <div class="form-group mb-3">
                    <label for="category_id">Kategori Pengeluaran <span class="text-danger">*</span></label>
                    <select name="loss_category_id" id="category_id" required tabindex="2"></select>
                </div>
                <div class="form-group mb-3">
                    <label for="price">Biaya <span class="text-danger">*</span></label>
                    <input type="hidden" name="price" required>
                    <div class="input-group">
                        <div class="input-group-text">Rp</div>
                        <input type="text" id="price" placeholder="Harga" class="form-control" required tabindex="3">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="desc">Keterangan <span class="text-danger">*</span></label>
                    <textarea name="desc" id="desc" placeholder="Keterangan" class="form-control" required tabindex="4"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="image">Foto Nota</label>
                    <input type="file" name="image" id="iamge" class="form-control" accept=".jpg,.png,.jpeg" tabindex="5">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" tabindex="6">Tambah</button>
            </div>
        </form>
    </div>
</div>

@push('custom-script')
    <script>
        $(document).ready(function() {
            $(document).on('click', "[data-bs-target=\\#addCostModal]", function() {
                setTimeout(() => {
                    $('#date').focus()
                }, 500);
            })
            const selectize_category = $('#category_id').selectize({
                create: true,
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                placeholder: "Pilih Kategori",
                onOptionAdd: (val, data) => {
                    if(val == data.name) createNewCategory(val)
                }
            })
            const select_category = selectize_category[0].selectize

            getOtherCostCategory()
            function getOtherCostCategory() {
                $.ajax({
                    url: "{{route('cost.category.list-search')}}",
                    success: (res) => {
                        select_category.addOption(res.data)
                    }
                })
            }

            function createNewCategory(val) {
                $.ajax({
                    url: "{{route('api.cost.category.store.ajax')}}",
                    method: "POST",
                    data: {
                        name: val,
                        "_token": "{{csrf_token()}}"
                    },
                    success: (res) => {
                        select_category.updateOption(
                            val, res.data
                        )

                        select_category.setValue('')
                        select_category.setValue(res.data.id)
                        Toaster('success', res.message)
                    }
                })
            }

            $(document).on('input', '#price', function() {
                if(unformatNum($(this).val()) < 0) $(this).val(0)

                $(this).val(formatNum($(this).val()))

                $('[name=price]').val(unformatNum($(this).val()))
            })
        })
    </script>
@endpush