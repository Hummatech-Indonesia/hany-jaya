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
                <div class="modal-body m-3">
                    <div class="form-group">
                        <label for="" class="form-label">Password Lama</label>
                        <input type="password" name="current_password" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Password Baru</label>
                        <input type="password" name="password" id="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary">Simpan</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
