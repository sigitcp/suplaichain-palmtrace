<!-- Modal -->
<div class="modal fade" id="profilPengepulAddModal" tabindex="-1" aria-labelledby="profilPengepulAddModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="profilPengepulAddModalLabel">Kelola Profil Pengepul</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form action="{{ route('simpan-profil-pengepul', $user->id) }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="form-card text-start">
            <div class="row g-3">

              <div class="col-md-6">
                <label class="form-label">Nama Pengepul/Koperasi: <span class="text-danger">*</span></label>
                <input type="text" name="nama_koperasi" class="form-control" value="{{ $profil->nama_koperasi ?? '' }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Kapasitas Menampung TBS (Kg): <span class="text-danger">*</span></label>
                <input type="number" name="kapasitas_tbs" class="form-control" value="{{ $profil->kapasitas_tbs ?? '' }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Sertifikat (PDF):</label>
                <input type="file" name="sertifikat_koperasi" class="form-control">
                @if(!empty($profil) && $profil->sertifikat_koperasi)
                  <small class="text-muted">File saat ini:
                    <a href="{{ asset('storage/' . $profil->sertifikat_koperasi) }}" target="_blank">Lihat Sertifikat</a>
                  </small>
                @endif
              </div>

              <div class="col-md-6">
                <label class="form-label">Alamat: <span class="text-danger">*</span></label>
                <input type="text" name="alamat" class="form-control" value="{{ $profil->alamat ?? '' }}" required>
              </div>

              <div class="col-md-12">
                <label class="form-label">Link Google Maps:</label>
                <input type="url" name="gmaps_link" class="form-control"
                       value="{{ $profil->gmaps_link ?? '' }}" placeholder="https://maps.google.com/...">
              </div>

              <div class="col-md-6">
                <label class="form-label">Latitude: <span class="text-danger">*</span></label>
                <input type="text" name="latitude" class="form-control" value="{{ $profil->latitude ?? '' }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Longitude: <span class="text-danger">*</span></label>
                <input type="text" name="longitude" class="form-control" value="{{ $profil->longitude ?? '' }}" required>
              </div>

              <div class="col-md-12">
                <label class="form-label">Foto Kantor:</label>
                <input type="file" name="foto_kantor" class="form-control">
                @if(!empty($profil) && $profil->foto_kantor)
                  <small class="text-muted">File saat ini:
                    <a href="{{ asset('storage/' . $profil->foto_kantor) }}" target="_blank">Lihat Foto</a>
                  </small>
                @endif
              </div>

            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn rounded btn-danger" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn rounded btn-secondary">
              {{ isset($profil) ? 'Perbarui Profil' : 'Simpan Profil' }}
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
