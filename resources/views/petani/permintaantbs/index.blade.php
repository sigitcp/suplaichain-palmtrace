@extends('layouts.master')

@section('container')
<div class="container-fluid content-inner py-3">
    <h4 class="mb-4">Daftar Pengepul yang Membuka Penerimaan TBS</h4>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Bagian 1: Pengepul yang Masih Membuka Penerimaan --}}
    @if ($penerimaanTerbuka->isEmpty())
    <div class="alert alert-warning">Tidak ada pengepul yang sedang membuka penerimaan TBS.</div>
    @else
    <div class="table-responsive mb-5">
        <table class="table table-bordered align-middle">
            <thead class="table-success">
                <tr>
                    <th>Pengepul</th>
                    <th>Harga per Kg</th>
                    <th>Kapasitas</th>
                    <th>Syarat & Ketentuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penerimaanTerbuka as $item)
                <tr>
                    <td>{{ $item->pengepul->name ?? 'Tidak diketahui' }}</td>
                    <td>Rp {{ number_format($item->harga_per_kg, 0, ',', '.') }}</td>
                    <td>{{ $item->kapasitas_kg ?? '-' }} kg</td>
                    <td>{{ $item->terms ?? '-' }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#jualModal{{ $item->id }}">
                            <i class="bi bi-cash-stack me-1"></i> Jual ke Pengepul
                        </button>

                        <!-- Modal Form -->
                        <div class="modal fade" id="jualModal{{ $item->id }}" tabindex="-1" aria-labelledby="jualModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('petani.permintaantbs.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="pembukaan_penerimaan_id" value="{{ $item->id }}">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title" id="jualModalLabel{{ $item->id }}">
                                                Jual ke {{ $item->pengepul->username }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Estimasi TBS (kg)</label>
                                                <input type="number" name="estimasi_tbs_kg" class="form-control" required min="1" placeholder="Masukkan estimasi berat TBS">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Metode Pengiriman</label>
                                                <select name="is_pickup" class="form-select metode-pengiriman" data-id="{{ $item->id }}" required>
                                                    <option value="">-- Pilih Metode --</option>
                                                    <option value="0">Diantar oleh Petani</option>
                                                    <option value="1">Dijemput oleh Pengepul</option>
                                                </select>
                                            </div>

                                            {{-- Form Diantar --}}
                                            <div class="form-diantar form-section{{ $item->id }} d-none">
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Pengantaran</label>
                                                    <input type="date" name="tanggal_pengantaran" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nomor Armada Pengantaran</label>
                                                    <input type="text" name="nomor_armada_pengantaran" class="form-control" placeholder="Opsional">
                                                </div>
                                            </div>

                                            {{-- Form Dijemput --}}
                                            <div class="form-dijemput form-section{{ $item->id }} d-none">
                                                <p class="text-muted small mb-0">
                                                    *Pengepul akan mengatur jadwal penjemputan dan armada setelah penawaran diterima.
                                                </p>
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
                        <!-- End Modal -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Bagian 2: Riwayat Penawaran Petani --}}
    <h4 class="mb-3">Riwayat Penawaran TBS Anda</h4>

    @if ($penawaranSaya->isEmpty())
    <div class="alert alert-info">Belum ada penawaran TBS yang Anda kirim ke pengepul.</div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Pengepul</th>
                    <th>Estimasi (kg)</th>
                    <th>Metode</th>
                    <th>Tanggal Pengantaran / Penjemputan</th>
                    <th>Armada</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penawaranSaya as $penawaran)
                <tr>
                    <td>{{ $penawaran->pengepul->username ?? 'Tidak diketahui' }}</td>
                    <td>{{ $penawaran->estimasi_tbs_kg }}</td>
                    <td>
                        @if ($penawaran->is_pickup)
                        Dijemput Pengepul
                        @else
                        Diantar Petani
                        @endif
                    </td>
                    <td>
                        @if ($penawaran->is_pickup)
                        {{ $penawaran->tanggal_penjemputan ?? '-' }}
                        @else
                        {{ $penawaran->tanggal_pengantaran ?? '-' }}
                        @endif
                    </td>
                    <td>
                        @if ($penawaran->is_pickup)
                        {{ $penawaran->nomor_armada_penjemputan ?? '-' }}
                        @else
                        {{ $penawaran->nomor_armada_pengantaran ?? '-' }}
                        @endif
                    </td>
                    <td>
                        @if ($penawaran->status == 'pending')
                        <span class="badge bg-warning text-dark">Menunggu</span>
                        @elseif ($penawaran->status == 'accepted')
                        <span class="badge bg-success">Disetujui</span>
                        @elseif ($penawaran->status == 'rejected')
                        <span class="badge bg-danger">Ditolak</span>
                        @elseif ($penawaran->status == 'finish')
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

{{-- Script: Form dinamis antar/jemput --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.metode-pengiriman').forEach(select => {
            select.addEventListener('change', function() {
                const id = this.dataset.id;
                const value = this.value;

                const formDiantar = document.querySelector('.form-diantar.form-section' + id);
                const formDijemput = document.querySelector('.form-dijemput.form-section' + id);

                formDiantar.classList.add('d-none');
                formDijemput.classList.add('d-none');

                if (value === '0') {
                    formDiantar.classList.remove('d-none');
                } else if (value === '1') {
                    formDijemput.classList.remove('d-none');
                }
            });
        });
    });
</script>
@endsection