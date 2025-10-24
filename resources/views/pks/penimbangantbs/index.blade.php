@extends('layouts.master')

@section('container')
<div class="container-fluid content-inner py-3">
    <h4 class="mb-4">Penimbangan TBS</h4>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($penawaran->isEmpty())
        <div class="alert alert-info">Tidak ada penawaran TBS yang disetujui / belum selesai ditimbang.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Pengepul</th>
                        <th>Estimasi (Kg)</th>
                        <th>Status</th>
                        <th>Tanggal Pengantaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penawaran as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->pengepul->username ?? '-' }}</td>
                        <td>{{ number_format($item->estimasi_tbs_kg, 2) }}</td>
                        <td>
                            <span class="badge 
                                @if($item->status == 'accepted') bg-warning text-dark
                                @elseif($item->status == 'completed') bg-success
                                @else bg-secondary @endif">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->tanggal_pengantaran ?? '-' }}</td>
                        <td>
                            @if($item->status == 'accepted')
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalPenimbangan{{ $item->id }}">
                                    Input Penimbangan
                                </button>
                            @else
                                <span class="text-muted">Selesai</span>
                            @endif
                        </td>
                    </tr>

                    {{-- Modal Penimbangan --}}
                    <div class="modal fade" id="modalPenimbangan{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('pks.penimbangantbs.store') }}">
                                @csrf
                                <input type="hidden" name="penawaran_pengepul_id" value="{{ $item->id }}">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Input Penimbangan TBS</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <label>Tanggal Penerimaan</label>
                                            <input type="date" name="tanggal_penerimaan" class="form-control" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>Bruto (Kg)</label>
                                            <input type="number" step="0.01" name="bruto" class="form-control" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>Tara (Kg)</label>
                                            <input type="number" step="0.01" name="tara" class="form-control" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>Netto (Kg)</label>
                                            <input type="number" step="0.01" name="netto" class="form-control" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>Harga Beli per Kg</label>
                                            <input type="number" step="0.01" name="harga_beli_per_kg" class="form-control" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>Potongan</label>
                                            <input type="number" step="0.01" name="potongan" class="form-control">
                                        </div>
                                        <div class="mb-2">
                                            <label>Total Transaksi</label>
                                            <input type="number" step="0.01" name="total_transaksi" class="form-control" required>
                                        </div>
                                        <div class="mb-2">
                                            <label>Catatan</label>
                                            <textarea name="catatan" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Simpan Penimbangan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- End Modal --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
