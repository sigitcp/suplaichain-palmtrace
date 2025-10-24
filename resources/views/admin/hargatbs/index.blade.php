@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Harga TBS Mingguan</h4>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahHargaModal">
                + Tambah Harga
            </button>
        </div>

        <div class="card-body">
            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Tabel Data --}}
            <div class="table-responsive mt-3">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Harga per Kg (Rp)</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->tanggal->format('d M Y') }}</td>
                                <td>Rp {{ number_format($item->harga_per_kg, 2, ',', '.') }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editHargaModal{{ $item->id }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('harga-tbs.delete', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal Edit --}}
                            <div class="modal fade" id="editHargaModal{{ $item->id }}" tabindex="-1" aria-labelledby="editHargaModalLabel{{ $item->id }}" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">Edit Harga TBS</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{ route('harga-tbs.update', $item->id) }}" method="POST">
                                      @csrf
                                      <div class="mb-3">
                                        <label>Tanggal:</label>
                                        <input type="date" name="tanggal" class="form-control" value="{{ $item->tanggal->format('Y-m-d') }}" required>
                                      </div>
                                      <div class="mb-3">
                                        <label>Harga per Kg:</label>
                                        <input type="number" step="0.01" name="harga_per_kg" class="form-control" value="{{ $item->harga_per_kg }}" required>
                                      </div>
                                      <div class="text-end">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada data harga.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Grafik Harga --}}
            <div class="mt-5">
                <h5 class="text-center mb-3">Grafik Harga TBS Mingguan</h5>
                <canvas id="chartHargaTbs" height="120"></canvas>
            </div>

        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="tambahHargaModal" tabindex="-1" aria-labelledby="tambahHargaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Harga Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('harga-tbs.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label>Tanggal:</label>
            <input type="date" name="tanggal" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Harga per Kg:</label>
            <input type="number" step="0.01" name="harga_per_kg" class="form-control" required>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- ChartJS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartHargaTbs');
const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($data->pluck('tanggal')->map(fn($d) => $d->format('d M Y'))) !!},
        datasets: [{
            label: 'Harga per Kg (Rp)',
            data: {!! json_encode($data->pluck('harga_per_kg')) !!},
            borderWidth: 2,
            borderColor: '#198754',
            backgroundColor: 'rgba(25, 135, 84, 0.2)',
            fill: true,
            tension: 0.3,
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endsection
