@extends('layouts.master')

@section('container')
<div class="container-fluid content-inner py-3">
    <h4 class="mb-3">Penawaran TBS Saya</h4>

    {{-- ========================================================= --}}
    {{-- Kondisi: Form hanya tampil jika tidak ada penawaran open/reserved --}}
    {{-- ========================================================= --}}
    @php
        $adaPenawaranAktif = $penawarans->whereIn('status', ['open', 'reserved'])->count() > 0;
    @endphp

    @if(!$adaPenawaranAktif)
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('petani.penawaran.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="estimasi_tbs_kg" class="form-label">Estimasi TBS (kg)</label>
                    <input type="number" name="estimasi_tbs_kg" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Pengiriman</label>
                    <select name="is_pickup" id="is_pickup" class="form-select" required>
                        <option value="">....</option>
                        <option value="0">Diantar oleh Petani</option>
                        <option value="1">Dijemput oleh Pengepul</option>
                    </select>
                </div>

                <div id="antar-fields" style="display:none;">
                    <div class="mb-3">
                        <label for="tanggal_pengantaran" class="form-label">Tanggal Pengantaran</label>
                        <input type="date" name="tanggal_pengantaran" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="nomor_armada_pengantaran" class="form-label">Nomor Armada Pengantaran</label>
                        <input type="text" name="nomor_armada_pengantaran" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Buka Penawaran</button>
            </form>
        </div>
    </div>
    @else
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> Anda masih memiliki penawaran yang <b>belum selesai</b>. 
        Anda hanya bisa membuka penawaran baru setelah status sebelumnya <b>finish</b>.
    </div>
    @endif

    {{-- ========================================================= --}}
    {{-- Daftar Penawaran --}}
    {{-- ========================================================= --}}
    <div class="card">
        <div class="card-body">
            <h5>Daftar Penawaran TBS</h5>
            <div class="table-responsive">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Estimasi (Kg)</th>
                            <th>Status</th>
                            <th>Jenis Pengiriman</th>
                            <th>Tanggal</th>
                            <th>Nomor Armada</th>
                            <th>Pembeli</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penawarans as $p)
                        <tr class="text-center align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->estimasi_tbs_kg }}</td>
                            <td>
                                @if ($p->status == 'open')
                                <span class="badge bg-warning text-dark">Open</span>
                                @elseif ($p->status == 'reserved')
                                <span class="badge bg-info text-dark">Reserved</span>
                                @elseif ($p->status == 'finish')
                                <span class="badge bg-success">Finish</span>
                                @endif
                            </td>

                            {{-- Jenis pengiriman --}}
                            <td>{{ $p->is_pickup ? 'Dijemput' : 'Diantar' }}</td>

                            {{-- Tanggal sesuai kondisi --}}
                            <td>
                                @if ($p->is_pickup)
                                {{ $p->tanggal_penjemputan ? date('d M Y', strtotime($p->tanggal_penjemputan)) : '-' }}
                                @else
                                {{ $p->tanggal_pengantaran ? date('d M Y', strtotime($p->tanggal_pengantaran)) : '-' }}
                                @endif
                            </td>

                            {{-- Nomor armada sesuai kondisi --}}
                            <td>
                                @if ($p->is_pickup)
                                {{ $p->nomor_armada_penjemputan ?? '-' }}
                                @else
                                {{ $p->nomor_armada_pengantaran ?? '-' }}
                                @endif
                            </td>

                            {{-- Nama pengepul jika sudah dibeli --}}
                            <td>
                                @if ($p->reserved_by_pengepul_id && $p->pengepul)
                                <a href="#" data-bs-toggle="modal" data-bs-target="#detailPengepul{{ $p->id }}">
                                    {{ $p->pengepul->username }}
                                </a>

                                {{-- Modal detail pengepul --}}
                                <div class="modal fade" id="detailPengepul{{ $p->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Pengepul</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                <p><strong>Nama:</strong> {{ $p->pengepul->username }}</p>
                                                <p><strong>No HP:</strong> {{ $p->pengepul->phone ?? '-' }}</p>
                                                <p><strong>Alamat:</strong> {{ $p->pengepul->alamat ?? '-' }}</p>
                                                <p><strong>Status Akun:</strong>
                                                    {{ $p->pengepul->verified ? 'Terverifikasi' : 'Belum Verifikasi' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <span class="text-muted">Belum ada pembeli</span>
                                @endif
                            </td>

                            {{-- Tombol Aksi: hanya tampil jika status open --}}
                            <td>
    @if ($p->status == 'open')
        <!-- Tombol untuk membuka modal konfirmasi -->
        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $p->id }}">
            Batalkan
        </button>

        <!-- Modal Konfirmasi -->
        <div class="modal fade" id="modalHapus{{ $p->id }}" tabindex="-1" aria-labelledby="modalHapusLabel{{ $p->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="modalHapusLabel{{ $p->id }}">Konfirmasi Pembatalan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin <b>membatalkan penawaran</b> 
                        <br>TBS dengan estimasi
                        <b>{{ $p->estimasi_tbs_kg }} kg</b>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('petani.penawaran.destroy', $p->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Ya, Batalkan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <span class="text-muted">Tidak ada aksi</span>
    @endif
</td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada penawaran TBS</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Script dinamis antar/jemput --}}
<script>
    document.getElementById('is_pickup').addEventListener('change', function() {
        document.getElementById('antar-fields').style.display = this.value == "0" ? 'block' : 'none';
    });
</script>
@endsection
