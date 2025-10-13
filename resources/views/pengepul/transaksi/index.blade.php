@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">

    {{-- ✅ Alert Success & Error --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif


    {{-- =================================================== --}}
    {{-- 🟢 DAFTAR PETANI SIAP JUAL --}}
    {{-- =================================================== --}}
    <div class="col-sm-12 mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title" style="color: #858223;">Daftar Petani Siap Jual</h4>
                </div>
            </div>

            <div class="card-body">
                <div class="custom-datatable-entries">
                    <div class="table-responsive border-bottom my-3">
                        <table id="datatable1" class="table table-striped dataTable" data-toggle="data-table">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Petani</th>
                                    <th>Tanggal Penjualan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($penjualans as $index => $penjualan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $penjualan->petani->username ?? '-' }}</td>
                                    <td>{{ $penjualan->created_at->format('d M Y') }}</td>
                                    <td><span class="badge bg-warning text-dark">Menunggu Pembelian</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#beliModal{{ $penjualan->id }}">
                                            Beli
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Pembelian -->
                                <div class="modal fade" id="beliModal{{ $penjualan->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('pengepul.transaksi.store', $penjualan->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title">Input Pembelian</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nomor Armada</label>
                                                        <input type="text" name="nomor_armada" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal Jemput</label>
                                                        <input type="date" name="tanggal_jemput" class="form-control" required>
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
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-muted text-center py-3">
                                        <h5>Belum ada petani yang menjual hasil panen.</h5>
                                    </td>
                                </tr>
                            </tfoot>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>


    {{-- =================================================== --}}
    {{-- 🟤 RIWAYAT PEMBELIAN PENGEPUL --}}
    {{-- =================================================== --}}
    <div class="col-sm-12 mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title" style="color: #858223;">Riwayat Pembelian Saya</h4>
                </div>
            </div>

            <div class="card-body">
                <div class="custom-datatable-entries">
                    <div class="table-responsive border-bottom my-3">
                        <table id="datatable2" class="table table-striped dataTable" data-toggle="data-table">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Petani</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($riwayatPembelian as $index => $pembelian)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ optional($pembelian->penjualan->petani)->username ?? '-' }}</td>
                                    <td>
                                        @if ($pembelian->status == 'on_progress')
                                        <span class="badge bg-info">On Progress</span>
                                        @else
                                        <span class="badge bg-success">Selesai</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#detailModal{{ $pembelian->id }}">
                                            Detail
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Detail -->
                                <div class="modal fade" id="detailModal{{ $pembelian->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light">
                                                <h5 class="modal-title">Detail Pembelian</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                <p><strong>Nama Petani:</strong>
                                                    {{ optional($pembelian->penjualan->petani)->username ?? '-' }}
                                                </p>
                                                <p><strong>Tanggal Jemput:</strong>
                                                    {{ $pembelian->tanggal_jemput ? \Carbon\Carbon::parse($pembelian->tanggal_jemput)->format('d M Y') : '-' }}
                                                </p>
                                                <p><strong>Nomor Armada:</strong> {{ $pembelian->nomor_armada ?? '-' }}</p>
                                                <p><strong>Jumlah (Kg):</strong> {{ $pembelian->jumlah_kg ?? '-' }}</p>
                                                <p><strong>Harga per Kg:</strong>
                                                    {{ $pembelian->harga_perkg ? 'Rp ' . number_format($pembelian->harga_perkg, 0, ',', '.') : '-' }}
                                                </p>
                                                <p><strong>Total Harga:</strong>
                                                    {{ $pembelian->total_harga ? 'Rp ' . number_format($pembelian->total_harga, 0, ',', '.') : '-' }}
                                                </p>
                                                <p><strong>Kualitas:</strong> {{ ucfirst($pembelian->kualitas ?? '-') }}</p>
                                                <p><strong>Status:</strong> {{ ucfirst($pembelian->status) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-muted text-center py-3">
                                        <h5>Belum ada riwayat pembelian.</h5>
                                    </td>
                                </tr>
                            </tfoot>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection