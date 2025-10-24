@extends('layouts.master')

@section('container')
<div class="container mt-4">
    <h4 class="mb-4">Daftar PKS yang Sedang Membuka Penerimaan TBS</h4>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Bagian 1: PKS yang Masih Membuka Penerimaan --}}
    @if ($penerimaanPks->isEmpty())
    <div class="alert alert-warning">Tidak ada PKS yang sedang membuka penerimaan TBS.</div>
    @else
    <div class="table-responsive mb-5">
        <table class="table table-bordered align-middle">
            <thead class="table-primary">
                <tr>
                    <th>PKS</th>
                    <th>Harga per Kg</th>
                    <th>Kapasitas</th>
                    <th>Syarat & Ketentuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penerimaanPks as $item)
                <tr>
                    <td>{{ $item->pks->username ?? 'Tidak diketahui' }}</td>
                    <td>Rp {{ number_format($item->harga_per_kg, 0, ',', '.') }}</td>
                    <td>{{ $item->kapasitas_kg ?? '-' }} kg</td>
                    <td>{{ $item->terms ?? '-' }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#penawaranModal{{ $item->id }}">
                            <i class="bi bi-cash-stack me-1"></i> Buat Penawaran
                        </button>

                        {{-- Modal Form Penawaran --}}
                        <div class="modal fade" id="penawaranModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('pengepul.penawaranpks.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="pks_id" value="{{ $item->pks_user_id }}">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Buat Penawaran ke {{ $item->pks->username }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Estimasi TBS (Kg)</label>
                                                <input type="number" step="0.01" name="estimasi_tbs_kg" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nomor Armada</label>
                                                <input type="text" name="nomor_armada" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Pengantaran</label>
                                                <input type="date" name="tanggal_pengantaran" class="form-control" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nama Supir</label>
                                                <input type="text" name="nama_supir" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Varietas</label>
                                                <input type="text" name="varietas" class="form-control">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Foto TBS</label>
                                                <input type="file" name="foto_tbs[]" class="form-control" multiple required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Kirim Penawaran</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- End Modal --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Bagian 2: Riwayat Penawaran Pengepul --}}
    <h4 class="mb-3">Riwayat Penawaran TBS Anda</h4>

    @if ($penawaranSaya->isEmpty())
    <div class="alert alert-info">Belum ada penawaran TBS yang Anda kirim ke PKS.</div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                <th>Estimasi (kg)</th>
<th>Tanggal Pengantaran</th>
<th>Armada</th>
<th>Supir</th>
<th>Status</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($penawaranSaya as $penawaran)
                <tr>
                <td>{{ $penawaran->estimasi_tbs_kg }}</td>
<td>{{ $penawaran->tanggal_pengantaran ?? '-' }}</td>
<td>{{ $penawaran->nomor_armada ?? '-' }}</td>
<td>{{ $penawaran->nama_supir ?? '-' }}</td>
<td>
    @if ($penawaran->status == 'pending')
    <span class="badge bg-warning text-dark">Menunggu</span>
    @elseif ($penawaran->status == 'accepted')
    <span class="badge bg-success">Disetujui</span>
    @elseif ($penawaran->status == 'rejected')
    <span class="badge bg-danger">Ditolak</span>
    @elseif ($penawaran->status == 'completed')
    <span class="badge bg-secondary">Selesai</span>
    @else
    <span class="badge bg-light text-dark">{{ ucfirst($penawaran->status) }}</span>
    @endif
</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection