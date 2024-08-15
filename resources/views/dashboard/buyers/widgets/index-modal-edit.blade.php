<div class="modal" id="modal-edit-buyer" tabindex="-1">
    <div class="modal-dialog">
        <form action="" class="modal-content" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5>Ubah Data Pembeli</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="name" class="form-label">Nama <small class="text-danger">*</small></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama Pembeli" required/>
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
            $(document).on('click', '.btn-edit', function(){
                const data_buyer = JSON.parse($(this).data('buyer').replaceAll("'", '"'))
                console.log(data_buyer)
                $('#modal-edit-buyer form').attr('action', $(this).data('url'))

                $('#modal-edit-buyer form [name=name]').val(data_buyer.name)
                $('#modal-edit-buyer form [name=code]').val(data_buyer.code)
                $('#modal-edit-buyer form [name=address]').val(data_buyer.address)
                $('#modal-edit-buyer form [name=telp]').val(data_buyer.telp)
                $('#modal-edit-buyer').modal('show')
            })
        })
    </script>
@endpush