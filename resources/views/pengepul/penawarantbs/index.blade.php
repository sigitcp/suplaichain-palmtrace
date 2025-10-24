@extends('layouts.master')

@section('container')
<div class="container-fluid content-inner py-3">
    <h4 class="mb-3">Daftar Penawaran TBS dari Petani</h4>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Petani</th>
                        <th>Estimasi (Kg)</th>
                        <th>Pengiriman</th>
                        <th>Armada Petani</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penawarans as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->petani->username ?? '-' }}</td>
                            <td>{{ $p->estimasi_tbs_kg }}</td>
                            <td>{{ $p->is_pickup ? 'Dijemput oleh pengepul' : 'Diantar oleh petani' }}</td>
                            <td>{{ $p->nomor_armada_pengantaran ?? '-' }}</td>
                            <td><span class="badge bg-info text-dark">{{ ucfirst($p->status) }}</span></td>
                            <td>
                                @if ($p->status == 'open')
                                    {{-- Jika dijemput pengepul --}}
                                    @if ($p->is_pickup)
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#beliPickupModal{{ $p->id }}">
                                            Beli
                                        </button>

                                        {{-- Modal input tanggal & armada --}}
                                        <div class="modal fade" id="beliPickupModal{{ $p->id }}" tabindex="-1" aria-labelledby="beliPickupModalLabel{{ $p->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="beliPickupModalLabel{{ $p->id }}">Input Penjemputan TBS</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('pengepul.penawaran.reserve', $p->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Tanggal Penjemputan</label>
                                                                <input type="date" name="tanggal_penjemputan" class="form-control" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Nomor Armada Penjemputan</label>
                                                                <input type="text" name="nomor_armada_penjemputan" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-success">Simpan & Beli</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    {{-- Jika diantar petani --}}
                                    @else
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#beliAntarModal{{ $p->id }}">
                                            Beli
                                        </button>

                                        {{-- Modal konfirmasi pembelian --}}
                                        <div class="modal fade" id="beliAntarModal{{ $p->id }}" tabindex="-1" aria-labelledby="beliAntarModalLabel{{ $p->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success text-white">
                                                        <h5 class="modal-title" id="beliAntarModalLabel{{ $p->id }}">Konfirmasi Pembelian</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        Apakah Anda yakin ingin membeli penawaran dari
                                                        <br>
                                                        <b>{{ $p->petani->username ?? 'Petani' }}</b>
                                                        dengan estimasi <b>{{ $p->estimasi_tbs_kg }} kg</b>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('pengepul.penawaran.reserve', $p->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success">Ya, Beli</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <span class="text-muted">Tidak tersedia</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada penawaran terbuka</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
