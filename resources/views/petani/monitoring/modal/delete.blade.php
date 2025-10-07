<div class="modal fade" id="panenDeleteModal{{ $panen->id }}" tabindex="-1" aria-labelledby="panenDeleteModalLabel{{ $panen->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="panenDeleteModalLabel{{ $panen->id }}">
          Hapus Data Panen ({{ \Carbon\Carbon::parse($panen->tanggal_panen)->translatedFormat('d F Y') }})
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body text-center">
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

        <h6>Apakah Anda yakin ingin menghapus data panen tanggal</h6>
        <strong>{{ \Carbon\Carbon::parse($panen->tanggal_panen)->translatedFormat('d F Y') }}</strong> ?
      </div>

      <div class="modal-footer justify-content-center">
        <button type="button" class="btn rounded btn-secondary" data-bs-dismiss="modal">Batal</button>

        <form action="{{ route('petani.monitoring.deletePanen', ['id' => $lahan->id, 'panen' => $panen->id]) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn rounded btn-danger">
            Hapus Permanen
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
