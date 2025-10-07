<!-- Modal Tambah Panen -->
<div class="modal fade" id="panenAddModal" tabindex="-1" aria-labelledby="panenAddModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="panenAddModalLabel">Tambah Panen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form action="{{ route('petani.monitoring.storePanen', $lahan->id) }}" method="POST">
          @csrf

          <div class="form-card text-start">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Tanggal: <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_panen" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Jumlah Pokok: <span class="text-danger">*</span></label>
                <input type="number" name="jumlah_pokok" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Rata-rata per Pokok: <span class="text-danger">*</span></label>
                <input type="number" name="jumlah_perpokok" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Kualitas: <span class="text-danger">*</span></label>
                <select class="form-select" name="kualitas" required>
                  <option value="" disabled selected>Pilih Kualitas</option>
                  <option value="baik">Baik</option>
                  <option value="cukup">Cukup</option>
                  <option value="unggul">Unggul</option>
                </select>
              </div>
            </div>
          </div>

          <div class="modal-footer mt-4">
            <button type="button" class="btn rounded btn-danger" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn rounded btn-secondary">Simpan</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
