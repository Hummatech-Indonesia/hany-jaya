<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{route('profile.change.password')}}" id="changePasswordForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Password Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Password Lama</label>
                        <input type="password" name="current_password" placeholder="Password Lama" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Password Baru</label>
                        <input type="password" name="password" placeholder="Password Baru" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="fw-semibold">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Password Baru" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
