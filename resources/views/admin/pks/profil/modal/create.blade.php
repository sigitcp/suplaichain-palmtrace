<div class="modal fade" id="profilPksAddModal" tabindex="-1" aria-labelledby="profilPksAddModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="profilPksAddModalLabel">Kelola Profil PKS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form action="{{ route('simpan-profil-pks', $user->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-card text-start">
            <div class="row g-3">
              
              <div class="col-md-6">
                <label class="form-label">Nama PKS:</label>
                <input type="text" name="nama_pks" class="form-control" value="{{ $profil->nama_pks ?? '' }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Kapasitas TBS (Kg):</label>
                <input type="number" name="kapasitas_tbs_kg" class="form-control" value="{{ $profil->kapasitas_tbs_kg ?? '' }}">
              </div>

              <div class="col-md-12">
                <label class="form-label">Alamat:</label>
                <input type="text" name="alamat" class="form-control" value="{{ $profil->alamat ?? '' }}" required>
              </div>

              <div class="col-md-12">
                <label class="form-label">Link Google Maps:</label>
                <input type="url" name="gmap_link" class="form-control" value="{{ $profil->gmap_link ?? '' }}" placeholder="https://maps.google.com/...">
              </div>

              <div class="col-md-6">
                <label class="form-label">Latitude:</label>
                <input type="text" name="latitude" class="form-control" value="{{ $profil->latitude ?? '' }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Longitude:</label>
                <input type="text" name="longitude" class="form-control" value="{{ $profil->longitude ?? '' }}" required>
              </div>

              <div class="col-md-12">
                <label class="form-label">Foto Kantor:</label>
                <input type="file" name="foto_kantor" class="form-control">
                @if(isset($profil->foto_kantor))
                  <img src="{{ asset('storage/' . $profil->foto_kantor) }}" class="img-thumbnail mt-2" style="max-height: 120px;">
                @endif
              </div>

            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn rounded btn-danger" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn rounded btn-success">
              {{ isset($profil) ? 'Perbarui Profil' : 'Simpan Profil' }}
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
