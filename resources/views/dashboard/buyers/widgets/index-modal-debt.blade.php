<div class="modal" id="modal-setting-debt" tabindex="-1">
    <div class="modal-dialog">
        <form action="" class="modal-content" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5>Ubah Data Limit Hutang Pembeli</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="limit_debt" class="form-label">Limit Hutang</label>
                    <div class="input-group">
                        <div class="input-group-text">Rp</div>
                        <input type="hidden" name="limit_debt"/>
                        <input type="text" class="form-control" id="limit_debt" placeholder="Limit Hutang Pembeli" />
                    </div>
                </div>
                <div class="form-group mb-2">
                    <label for="limit_time_debt" class="form-label">Limit Tenggat Pembayaran Hutang</label>
                    <div class="input-group">
                        <input type="hidden" name="limit_time_debt"/>
                        <input type="text" class="form-control" id="limit_time_debt" placeholder="Limit Tenggat Pembayaran Pembeli" />
                        <div class="input-group-text">Hari</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Ubah</button>
            </div>
        </form>
    </div>
</div>

@push('custom-script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn-setting-debt', function(){
                const data_buyer = JSON.parse($(this).data('buyer').replaceAll("'", '"'))

                $('#modal-setting-debt form').attr('action', $(this).data('url'))

                $('#modal-setting-debt form [name=name]').val(data_buyer.name)
                $('#modal-setting-debt form [name=code]').val(data_buyer.code)
                $('#modal-setting-debt form [name=address]').val(data_buyer.address)
                $('#modal-setting-debt form [name=telp]').val(data_buyer.telp)
                $('#modal-setting-debt form [name=limit_debt]').val(data_buyer.limit_debt)
                $('#modal-setting-debt form #limit_debt').val(formatNum(data_buyer.limit_debt))
                $('#modal-setting-debt form [name=limit_time_debt]').val(data_buyer.limit_time_debt)
                $('#modal-setting-debt form #limit_time_debt').val(formatNum(data_buyer.limit_time_debt))

                $('#modal-setting-debt').modal('show')
            })

            $(document).on('input', '#modal-setting-debt #limit_debt', function() {
                const unformatted_data = unformatNum($(this).val())

                if(unformatted_data < 0) $(this).val(0)

                $(this).val(formatNum($(this).val()))
                $('#modal-setting-debt [name=limit_debt]').val(unformatNum($(this).val()))
            })
            $(document).on('input', '#modal-setting-debt #limit_time_debt', function() {
                const unformatted_data = unformatNum($(this).val())

                if(unformatted_data < 0) $(this).val(0)

                $(this).val(formatNum($(this).val()))
                $('#modal-setting-debt [name=limit_time_debt]').val(unformatNum($(this).val()))
            })
        })
    </script>
@endpush