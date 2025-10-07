<div class="modal fade" id="userDeleteValidationModal{{ $user->id }}" tabindex="-1" aria-labelledby="userDeleteValidationModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="userDeleteValidationModalLabel{{ $user->id }}">Hapus Akses User <strong>({{ $user->username }})</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <div class="text-center">
                    <div class="mt-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 7l16 0" />
                            <path d="M10 11l0 6" />
                            <path d="M14 11l0 6" />
                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                        </svg>
                    </div>

                    <h6 class="mb-2">Masukan Nama User</h6>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <!-- placeholder sesuai username -->
                            <input type="text" class="form-control delete-input"
                                data-username="{{ $user->username }}"
                                placeholder="{{ $user->username }}">
                        </div>
                    </div>
                    <h6 class="mt-2 mb-4">Sebagai validasi penghapusan akun secara permanen</h6>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn rounded btn-secondary" data-bs-dismiss="modal">Batal</button>

                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn rounded btn-danger confirm-delete-btn" disabled>
                        Hapus Permanen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".delete-input").forEach(input => {
            input.addEventListener("input", function() {
                const username = this.getAttribute("data-username");
                const modal = this.closest(".modal");
                const confirmBtn = modal.querySelector(".confirm-delete-btn");

                confirmBtn.disabled = this.value.trim() !== username;
            });
        });
    });
</script>