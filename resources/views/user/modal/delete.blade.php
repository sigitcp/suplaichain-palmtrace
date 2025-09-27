<!-- Modal -->
<div class="modal fade" id="userDeleteModal" tabindex="-1" aria-labelledby="userDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"> <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="userDeleteModalLabel">Hapus Akses User</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> <!-- Body -->
            <div class="modal-body">
                <div class="text-center">
                    <div class="mt-2 mb-3">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="90"  height="90"  viewBox="0 0 24 24"  fill="red"  class="icon icon-tabler icons-tabler-filled icon-tabler-alert-triangle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 1.67c.955 0 1.845 .467 2.39 1.247l.105 .16l8.114 13.548a2.914 2.914 0 0 1 -2.307 4.363l-.195 .008h-16.225a2.914 2.914 0 0 1 -2.582 -4.2l.099 -.185l8.11 -13.538a2.914 2.914 0 0 1 2.491 -1.403zm.01 13.33l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007zm-.01 -7a1 1 0 0 0 -.993 .883l-.007 .117v4l.007 .117a1 1 0 0 0 1.986 0l.007 -.117v-4l-.007 -.117a1 1 0 0 0 -.993 -.883z" /></svg>
                    </div>
                    <h6 class="mb-2">Anda yakin ingin menghapus akses admin</h6>
                    <h5><strong>(Anna Sthesia)</strong></h5>
                    <h6 class="mt-2">secara permanen</h6>
                </div>
            </div> <!-- Footer -->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn rounded btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn rounded btn-danger" data-bs-toggle="modal"
                data-bs-target="#userDeleteValidationModal">Hapus</button>
            </div>

        </div>
    </div>
</div>

@include('user.modal.deletevalidation')