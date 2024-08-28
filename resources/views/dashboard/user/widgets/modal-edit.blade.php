<form action="" method="POST" id="form-update">
    @csrf
    @method('PUT')
    <!-- Modal -->
    <div class="modal fade" id="modalEditCashier"  tabindex="-1"
        aria-labelledby="modalAddSuplierLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Edit Kasir
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12 mb-4">
                        <label for="edit-cashier-name" class="form-label fw-semibold">Nama <small class="text-danger">*</small></label>
                        <input name="name" autofocus="true" type="text" class="form-control" id="edit-cashier-name" placeholder="Kasir" />
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="roleCashierEdit" class="form-label fw-semibold">Role <small class="text-danger">*</small></label>
                        <select id="roleCashierEdit" name="role[]" class="form-select role" aria-label="Default select example">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="edit-cashier-email" class="form-label fw-semibold">Email <small class="text-danger">*</small></label>
                        <input name="email" type="email" class="form-control" id="edit-cashier-email" placeholder="kasir@gmail.com" value=""/>
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="edit-cashier-password" class="form-label fw-semibold">Password <small>(opsional)</small></label>
                        <input name="password" type="password" id="edit-cashier-password" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light font-medium waves-effect text-start"
                        data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit"
                    tabindex="4"
                        class="btn btn-primary font-medium waves-effect text-start btn-edit">
                        Ubah
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
