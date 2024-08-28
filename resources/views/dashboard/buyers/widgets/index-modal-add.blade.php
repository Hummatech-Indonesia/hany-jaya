<div class="modal" id="modal-add-buyer" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.buyers.store') }}" class="modal-content" method="POST">
            @csrf
            <div class="modal-header">
                <h5>Tambah Data Pembeli</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="name" class="form-label">Nama <small class="text-danger">*</small></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama Pembeli" required foc/>
                </div>
                <div class="form-group mb-2">
                    <label for="code" class="form-label">Kode <small class="text-danger">*</small></label>
                    <input type="text" class="form-control" id="code" name="code" placeholder="Kode Pembeli" required />
                </div>
                <div class="form-group mb-2">
                    <label for="address" class="form-label">Alamat <small class="text-danger">*</small></label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Alamat Pembeli" required />
                </div>
                <div class="form-group mb-2">
                    <label for="telp" class="form-label">No. Telp</label>
                    <div class="input-group">
                        <div class="input-group-text">+62</div>
                        <input type="text" class="form-control" id="telp" name="telp" placeholder="No. Telp Pembeli" />
                    </div>
                </div>
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
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </div>
</div>

@push('custom-script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#btn-open-add-buyer-modal', function(){
                $('#modal-add-buyer').modal('show')
                $("#name").trigger('focus');
            })

            $(document).on('input', '#modal-add-buyer #limit_debt', function() {
                const unformatted_data = unformatNum($(this).val())

                if(unformatted_data < 0) $(this).val(0)

                $(this).val(formatNum($(this).val()))
                $('#modal-add-buyer [name=limit_debt]').val(unformatNum($(this).val()))
            })
            $(document).on('input', '#modal-add-buyer #limit_time_debt', function() {
                const unformatted_data = unformatNum($(this).val())

                if(unformatted_data < 0) $(this).val(0)

                $(this).val(formatNum($(this).val()))
                $('#modal-add-buyer [name=limit_time_debt]').val(unformatNum($(this).val()))
            })
        })
    </script>
@endpush