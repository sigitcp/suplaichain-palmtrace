<!-- Modal -->
<div class="modal fade" id="detailLahanAddModal" tabindex="-1" aria-labelledby="detailLahanAddModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="detailLahanAddModalLabel">Kelola Detail Lahan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">
        <form action="{{ route('detail-lahan.simpan', ['lahanId' => $lahan->id]) }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="form-card text-start">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nama Pemilik/PIC: <span class="text-danger">*</span></label>
                <input type="text" name="penanggung_jawab" class="form-control"
                       value="{{ $detail->penanggung_jawab ?? '' }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Luas Kebun (Ha): <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="luas_kebun" class="form-control"
                       value="{{ $detail->luas_kebun ?? '' }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Sertifikat (PDF):</label>
                <input type="file" name="sertifikat" class="form-control">
                @if(!empty($detail->sertifikat))
                  <small class="text-muted">File saat ini: <a href="{{ asset('storage/' . $detail->sertifikat) }}" target="_blank">Lihat Sertifikat</a></small>
                @endif
              </div>

              <div class="col-md-6">
                <label class="form-label">File GeoJSON:</label>
                <input type="file" name="file_geojson" class="form-control">
                @if(!empty($detail->file_geojson))
                  <small class="text-muted">File saat ini: <a href="{{ asset('storage/' . $detail->file_geojson) }}" target="_blank">Lihat GeoJSON</a></small>
                @endif
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn rounded btn-danger" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn rounded btn-secondary">
              {{ isset($detail) ? 'Perbarui Detail' : 'Simpan Detail' }}
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
