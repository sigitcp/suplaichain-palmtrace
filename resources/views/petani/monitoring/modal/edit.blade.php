<div class="modal fade" id="panenEditModal{{ $panen->id }}" tabindex="-1" aria-labelledby="panenEditModalLabel{{ $panen->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="panenEditModalLabel{{ $panen->id }}">Edit Panen ({{ \Carbon\Carbon::parse($panen->tanggal_panen)->translatedFormat('d F Y') }})</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form action="{{ route('petani.monitoring.updatePanen', ['id' => $lahan->id, 'panen' => $panen->id]) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="form-card text-start">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Tanggal: <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_panen" class="form-control" value="{{ $panen->tanggal_panen }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Jumlah Pokok: <span class="text-danger">*</span></label>
                <input type="number" name="jumlah_pokok" class="form-control" value="{{ $panen->jumlah_pokok }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Rata-rata per Pokok: <span class="text-danger">*</span></label>
                <input type="number" name="jumlah_perpokok" class="form-control" value="{{ $panen->jumlah_perpokok }}" required>
              </div>

              <div class="col-md-6">
                <label class="form-label">Kualitas: <span class="text-danger">*</span></label>
                <select class="form-select" name="kualitas" required>
                  <option disabled>Pilih Kualitas</option>
                  <option value="baik" {{ $panen->kualitas == 'baik' ? 'selected' : '' }}>Baik</option>
                  <option value="cukup" {{ $panen->kualitas == 'cukup' ? 'selected' : '' }}>Cukup</option>
                  <option value="unggul" {{ $panen->kualitas == 'unggul' ? 'selected' : '' }}>Unggul</option>
                </select>
              </div>
            </div>
          </div>

          <div class="modal-footer mt-4">
            <button type="button" class="btn rounded btn-danger" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn rounded btn-secondary">Simpan Perubahan</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
