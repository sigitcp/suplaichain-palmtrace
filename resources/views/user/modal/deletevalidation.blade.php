<!-- Modal -->
<div class="modal fade" id="userDeleteValidationModal" tabindex="-1" aria-labelledby="userDeleteValidationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"> <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="userDeleteValidationModalLabel">Hapus Akses User</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> <!-- Body -->
            <div class="modal-body">
                <div class="text-center">
                    <div class="mt-2 mb-3">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="90"  height="90"  viewBox="0 0 24 24"  fill="none"  stroke="red"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                    </div>

                    <h6 class="mb-2">Masukan Nama User</h6>
                    <!-- Form input ditengah -->
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="validationDefault01" placeholder="Anna Sthesia">
                        </div>
                    </div>
                    <h6 class="mt-2 mb-4">Sebagai validasi penghapusan akun secara permanen</h6>

                    
                </div>

            </div> <!-- Footer -->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn rounded btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn rounded btn-danger" data-bs-toggle="modal"
                    data-bs-target="#userDeleteValidationModal">Hapus Permanen</button>
            </div>

        </div>
    </div>
</div>