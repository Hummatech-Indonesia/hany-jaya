<!-- Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.update.profile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-2">
                        <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('assets/images/profile/user-1.jpg') }}"
                            alt="photo" class="img-fluid rounded-circle mb-2" style="object-fit: cover;"
                            width="150" height="150">

                        <div class="d-flex justify-content-center">
                            <input type="file" name="photo" id="" class="form-control w-50">
                        </div>
                    </div>
                    <div class="grid col-12">
                        <div class="row mb-2">

                            <div class="form-group col-6">
                                <label for="" class="form-label">Nama</label>
                                <input type="text" name="name" id="" class="form-control"
                                    value="{{ auth()->user()->name }}">
                            </div>
                            <div class="form-group col-6">
                                <label for="" class="form-label">Email</label>
                                <input type="email" name="email" id="" class="form-control"
                                    value="{{ auth()->user()->email }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
