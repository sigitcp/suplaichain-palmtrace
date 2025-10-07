<!-- Modal -->
<div class="modal fade" id="lahanAddModal" tabindex="-1" aria-labelledby="lahanAddModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="lahanAddModalLabel">Tambah Lahan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">
        <form action="{{ route('lahan.store', ['userId' => $petani->id]) }}" method="POST">
          @csrf

          <div class="form-card text-start">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nama Lahan: <span class="text-danger">*</span></label>
                <input type="text" name="nama_lahan" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Alamat:  <span class="text-danger">*</span></label>
                <input type="text" name="alamat" class="form-control" required>
              </div>

              <div class="col-md-12">
                <label class="form-label">Link Google Maps:</label>
                <input type="url" name="gmaps_link" class="form-control" placeholder="https://maps.google.com/...">
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn rounded btn-danger" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn rounded btn-secondary">Simpan</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
