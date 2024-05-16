<form id="form-delete" action="" method="POST">
    @method('DELETE') @csrf
    <!-- sample modal content -->
    <div
        class="modal fade"
        id="delete-modal"
        tabindex="-1"
        aria-labelledby="mySmallModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="myModalLabel">{{ $title }}</h4>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus?</p>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-light-danger text-danger font-medium waves-effect"
                        data-bs-dismiss="modal"
                    >
                        Tutup
                    </button>
                    <button
                        type="submit"
                        class="btn btn-light-danger text-danger font-medium waves-effect"
                        data-bs-dismiss="modal"
                    >
                        Hapus
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</form>
