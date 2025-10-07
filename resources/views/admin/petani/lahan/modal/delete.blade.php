<div class="modal fade" id="lahanDeleteModal{{ $lahan->id }}" tabindex="-1" aria-labelledby="lahanDeleteModalLabel{{ $lahan->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="lahanDeleteModalLabel{{ $lahan->id }}">
          Hapus Akses Lahan <strong>({{ $lahan->nama_lahan }})</strong>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">
        <div class="text-center">
          <div class="mt-2 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M4 7h16" />
              <path d="M10 11v6" />
              <path d="M14 11v6" />
              <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
              <path d="M9 7V4a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
            </svg>
          </div>

          <h6 class="mb-2">Masukkan Nama Lahan</h6>
          <div class="row justify-content-center">
            <div class="col-md-6">
              <input type="text" class="form-control delete-input"
                     data-lahanname="{{ $lahan->nama_lahan }}"
                     placeholder="{{ $lahan->nama_lahan }}">
            </div>
            <h6 class="mt-2 mb-1">Sebagai validasi penghapusan lahan milik</h6>
            <h5 class="mb-1">({{ $lahan->user->username }})</h5>
            <h6>secara permanen</h6>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn rounded btn-secondary" data-bs-dismiss="modal">Batal</button>

        <form action="{{ route('lahan.destroy', ['id' => $lahan->id]) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <input type="hidden" name="nama_lahan" value="">
          <button type="submit" class="btn rounded btn-danger confirm-delete-btn" disabled>
            Hapus Permanen
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Script Validasi -->
<script>
  document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".delete-input").forEach(input => {
      input.addEventListener("input", function() {
        const lahanname = this.getAttribute("data-lahanname");
        const modal = this.closest(".modal");
        const confirmBtn = modal.querySelector(".confirm-delete-btn");
        const hiddenInput = modal.querySelector("input[name='nama_lahan']");

        confirmBtn.disabled = this.value.trim() !== lahanname;
        hiddenInput.value = this.value.trim();
      });
    });
  });
</script>
