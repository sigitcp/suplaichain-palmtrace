@extends('layouts.master')

@section('container')
<div class="container-fluid content-inner py-3">
    <h4 class="mb-4">Penimbangan TBS</h4>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($penawaran->isEmpty())
        <div class="alert alert-info">Tidak ada penawaran TBS / penjualan petani yang belum selesai.</div>
    @else
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Petani</th>
                    <th>Estimasi (Kg)</th>
                    <th>Status</th>
                    <th>Sumber</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penawaran as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->petani->username ?? '-' }}</td>
                    <td>{{ number_format($item->estimasi_tbs_kg ?? 0, 2) }}</td>
                    <td>
                        <span class="badge 
                            @if($item->status == 'reserved' || $item->status == 'accepted') bg-warning text-dark 
                            @elseif($item->status == 'finish') bg-success 
                            @else bg-secondary @endif">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td>{{ $item instanceof \App\Models\PenawaranTbs ? 'Penawaran TBS' : 'Penjualan Petani' }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalPenimbangan{{ $item->id }}">
                            Input Penimbangan
                        </button>
                    </td>
                </tr>

                {{-- Modal Penimbangan --}}
                <div class="modal fade" id="modalPenimbangan{{ $item->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('pengepul.penimbangan.store') }}">
                            @csrf
                            @if($item instanceof \App\Models\PenawaranTbs)
                                <input type="hidden" name="penawaran_tbs_id" value="{{ $item->id }}">
                            @else
                                <input type="hidden" name="penjualan_id" value="{{ $item->id }}">
                            @endif
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Input Penimbangan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label>TBS Baik (Kg)</label>
                                        <input type="number" step="0.01" name="tbs_baik_kg" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Harga Baik per Kg</label>
                                        <input type="number" step="0.01" name="harga_baik_per_kg" class="form-control" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>TBS Reject (Kg)</label>
                                        <input type="number" step="0.01" name="tbs_reject_kg" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <label>Harga Reject per Kg</label>
                                        <input type="number" step="0.01" name="harga_reject_per_kg" class="form-control">
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
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
