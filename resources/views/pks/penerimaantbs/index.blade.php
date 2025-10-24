@extends('layouts.master')

@section('container')
<div class="container-fluid content-inner py-3">
    <h4 class="mb-4">Penerimaan TBS oleh PKS</h4>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- PEMBUKAAN / DETAIL PENERIMAAN --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <strong>Pembukaan Penerimaan TBS</strong>
        </div>
        <div class="card-body">
            @if(!$penerimaan || $penerimaan->status == 'closed')
                {{-- Form membuka penerimaan --}}
                <form action="{{ route('pks.penerimaantbs.store') }}" method="POST">
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
            @else
                {{-- Detail penerimaan --}}
                <p><strong>Status:</strong>
                    <span class="badge {{ $penerimaan->status == 'open' ? 'bg-success' : 'bg-danger' }}">
                        {{ $penerimaan->status == 'open' ? 'Sedang Dibuka' : 'Ditutup' }}
                    </span>
                </p>
                <p><strong>Harga per Kg:</strong> Rp {{ number_format($penerimaan->harga_per_kg, 2, ',', '.') }}</p>
                <p><strong>Kapasitas:</strong> {{ number_format($penerimaan->kapasitas_kg) }} Kg</p>
                <p><strong>Tanggal Dibuka:</strong> {{ $penerimaan->created_at->format('d M Y H:i') }}</p>
                <p><strong>Syarat & Ketentuan:</strong><br>{{ $penerimaan->terms }}</p>

                {{-- Tombol tutup penerimaan --}}
                <form action="{{ route('pks.penerimaantbs.toggle') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-danger">Tutup Penerimaan</button>
                </form>
            @endif
        </div>
    </div>

    {{-- DAFTAR PENAWARAN PENGEPUL --}}
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Daftar Penawaran Pengepul</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pengepul</th>
                            <th>Estimasi (Kg)</th>
                            <th>Tanggal Pengantaran</th>
                            <th>Nomor Armada</th>
                            <th>Nama Supir</th>
                            <th>Varietas</th>
                            <th>Foto TBS</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penawaranPengepul as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->pengepul->username }}</td>
                            <td>{{ number_format($p->estimasi_tbs_kg, 2, ',', '.') }}</td>
                            <td>{{ $p->tanggal_pengantaran ?? '-' }}</td>
                            <td>{{ $p->nomor_armada ?? '-' }}</td>
                            <td>{{ $p->nama_supir ?? '-' }}</td>
                            <td>{{ $p->varietas ?? '-' }}</td>
                            <td>
                                @if($p->foto_tbs)
                                    @foreach(json_decode($p->foto_tbs, true) as $key => $foto)
                                        <!-- Thumbnail -->
                                        <img src="{{ asset('storage/'.$foto) }}" alt="Foto TBS" width="50"
                                             class="me-1 mb-1 rounded"
                                             data-bs-toggle="modal" data-bs-target="#fotoModal{{ $p->id }}{{ $key }}"
                                             style="cursor:pointer">

                                        <!-- Modal Foto -->
                                        <div class="modal fade" id="fotoModal{{ $p->id }}{{ $key }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Foto TBS</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('storage/'.$foto) }}" alt="Foto TBS" class="img-fluid rounded">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    -
                                @endif
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
                                @if($p->status == 'pending')
                                    <form action="{{ route('pks.penerimaantbs.konfirmasi', $p->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="accepted">
                                        <button class="btn btn-success btn-sm">Terima</button>
                                    </form>
                                    <form action="{{ route('pks.penerimaantbs.konfirmasi', $p->id) }}" method="POST" class="d-inline">
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
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">Belum ada penawaran dari pengepul.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
