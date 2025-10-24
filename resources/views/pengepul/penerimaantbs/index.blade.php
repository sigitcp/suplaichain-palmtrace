@extends('layouts.master')

@section('container')
<div class="container-fluid content-inner py-3">
    <h4 class="mb-4">Penerimaan TBS oleh Pengepul</h4>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- ===================== PEMBUKAAN PENERIMAAN ===================== --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <strong>Pembukaan Penerimaan TBS</strong>
        </div>
        <div class="card-body">
            @if ($penerimaan && $penerimaan->status === 'open')
                {{-- Detail penerimaan yang sedang dibuka --}}
                <p class="mb-2"><strong>Status:</strong> 
                    <span class="badge bg-success">Sedang Dibuka</span>
                </p>
                <p><strong>Harga per Kg:</strong> Rp {{ number_format($penerimaan->harga_per_kg, 2, ',', '.') }}</p>
                <p><strong>Kapasitas:</strong> {{ number_format($penerimaan->kapasitas_kg) }} Kg</p>
                <p><strong>Tanggal Dibuka:</strong> {{ $penerimaan->created_at->format('d M Y H:i') }}</p>
                <p><strong>Syarat & Ketentuan:</strong><br>{{ $penerimaan->terms }}</p>

                {{-- Tombol Tutup Penerimaan --}}
                <form action="{{ route('pengepul.penerimaantbs.toggle') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-danger">Tutup Penerimaan</button>
                </form>

            @else
                {{-- Form untuk membuka penerimaan baru --}}
                <form action="{{ route('pengepul.penerimaantbs.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Harga per Kg (Rp)</label>
                            <input type="number" name="harga_per_kg" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kapasitas (Kg)</label>
                            <input type="number" name="kapasitas_kg" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Syarat & Ketentuan</label>
                            <textarea name="terms" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Buka Penerimaan</button>
                </form>
            @endif
        </div>
    </div>

    {{-- ===================== DAFTAR PETANI YANG MENAWARKAN TBS ===================== --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Daftar Petani yang Menawarkan TBS</strong>
        </div>
        <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Petani</th>
                        <th>Estimasi (Kg)</th>
                        <th>Jenis Pengiriman</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penawaranPetani as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->petani->username }}</td>
                            <td>{{ number_format($p->estimasi_tbs_kg, 2, ',', '.') }}</td>
                            <td>{{ $p->is_pickup ? 'Dijemput' : 'Diantar' }}</td>
                            <td>
                                {{ $p->is_pickup 
                                    ? ($p->tanggal_penjemputan ?? '-') 
                                    : ($p->tanggal_pengantaran ?? '-') }}
                            </td>
                            <td>
                                <span class="badge 
                                    @if($p->status == 'pending') bg-warning 
                                    @elseif($p->status == 'accepted') bg-success 
                                    @elseif($p->status == 'rejected') bg-danger 
                                    @else bg-secondary @endif">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td>
                                @if ($p->status == 'pending')
                                    @if($p->is_pickup)
                                        <button class="btn btn-success btn-sm" 
                                            data-bs-toggle="modal"
                                            data-bs-target="#pickupModal{{ $p->id }}">
                                            Input Jadwal Jemput
                                        </button>
                                    @else
                                        <form action="{{ route('pengepul.penerimaantbs.konfirmasi', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="accepted">
                                            <button class="btn btn-success btn-sm">Terima</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('pengepul.penerimaantbs.konfirmasi', $p->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button class="btn btn-danger btn-sm">Tolak</button>
                                    </form>
                                @else
                                    <span class="text-muted">Tidak ada aksi</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Modal penjemputan --}}
                        <div class="modal fade" id="pickupModal{{ $p->id }}" tabindex="-1" aria-labelledby="pickupModalLabel{{ $p->id }}" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <form action="{{ route('pengepul.penerimaantbs.konfirmasi', $p->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="accepted">
                                <div class="modal-header bg-success text-white">
                                  <h5 class="modal-title" id="pickupModalLabel{{ $p->id }}">Input Jadwal Penjemputan</h5>
                                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="mb-3">
                                    <label class="form-label">Tanggal Penjemputan</label>
                                    <input type="datetime-local" name="tanggal_penjemputan" class="form-control" required>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Nomor Armada Penjemputan</label>
                                    <input type="text" name="nomor_armada_penjemputan" class="form-control" required>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                  <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">Belum ada penawaran dari petani.</td></tr>
                    @endforelse
                </tbody>
            </table>
                                </div>
        </div>
    </div>
</div>
@endsection
