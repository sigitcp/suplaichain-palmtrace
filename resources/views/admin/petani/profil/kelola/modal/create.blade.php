<div class="modal fade" id="profilPetaniAddModal" tabindex="-1" aria-labelledby="profilPetaniAddModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="profilPetaniAddModalLabel">Kelola Profil Petani</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form action="{{ route('simpan-profil-petani', $user->id) }}" method="POST">
          @csrf
          <div class="form-card text-start">
            <div class="row g-3">
              
              <div class="col-md-6">
                <label class="form-label">Nama Petani:</label>
                <input type="text" name="nama_petani" class="form-control" value="{{ $profil->nama_petani ?? '' }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Varietas Bibit:</label>
                <input type="text" name="varietas_bibit" class="form-control" value="{{ $profil->varietas_bibit ?? '' }}">
              </div>

              <div class="col-md-6">
                <label class="form-label">Luasan Lahan Total (Ha):</label>
                <input type="number" name="luasan_lahan_total" step="0.01" class="form-control" value="{{ $profil->luasan_lahan_total ?? '' }}">
              </div>

              <div class="col-md-6">
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
