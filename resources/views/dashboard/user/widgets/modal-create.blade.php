<form id="form-add-cashier" action="{{ route('admin.users.store') }}" method="POST">
    @csrf
    <!-- Modal -->
    <div class="modal fade" id="modalAddCashier" tabindex="-1"
        aria-labelledby="modalAddCashierLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        Tambah Pengguna
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12 mb-4">
                        <label for="cashier-name" class="form-label fw-semibold">Nama <small class="text-danger">*</small></label>
                        <input tabindex="1" name="name" id="cashier-name" type="text" class="form-control" autofocus="true" placeholder="Kasir"
                            value="{{ old('name') }}" />
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="roleCashier" class="form-label fw-semibold">Role <small class="text-danger">*</small></label>
                        <select tabindex="4" id="roleCashier" name="role[]" class="form-select role" aria-label="Default select example">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="cashier-email" class="form-label fw-semibold">Email <small class="text-danger">*</small></label>
                        <input tabindex="2" name="email" id="cashier-email" type="email" class="form-control" placeholder="kasir@gmail.com"
                            value="{{ old('email') }}" />
                    </div>
                    <div class="col-md-12 mb-4">
                        <label for="exampleInputPassword1" class="form-label fw-semibold">Password <small>(opsional)</small></label>
                        <input tabindex="3" name="password" type="password" class="form-control" value="{{ old('password') }}" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light font-medium waves-effect text-start"
                        data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button tabindex="5" type="submit"
                        class="btn btn-primary font-medium waves-effect text-start btn-tambah">
                        Tambah
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
