@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">
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

    <div class="row justify-content-center">
        <div class="col-lg-12">

            {{-- Tombol Buat Penjualan --}}
            @if ($tampilPanen > 0 && !$penjualanAktif)
                <div class="text-center mb-3">
                    <form action="{{ route('petani.transaksi.store') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success px-4">Buat Penjualan</button>
                    </form>
                </div>
            @else
                <div class="text-center mb-3">
                    @if ($penjualanAktif)
                        <button class="btn btn-secondary px-4" disabled>Menunggu Transaksi Selesai</button>
                    @else
                        <button class="btn btn-secondary px-4" disabled>Tidak Ada Panen</button>
                    @endif
                </div>
            @endif

            {{-- Daftar Penjualan --}}
            {{-- Riwayat Penjualan (table bawah) --}}
        <div class="col-sm-12 mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Riwayat Penjualan</h4>
                    </div>
                </div>

                <div class="card-body">
                    <div class="custom-datatable-entries">
                        <div class="table-responsive border-bottom my-3">
                            <table id="datatable" class="table table-striped dataTable" data-toggle="data-table" aria-describedby="datatable_info">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Pembeli</th>
                                        <th>No HP</th>
                                        <th>Tanggal Jemput</th>
                                        <th>Status</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($penjualans as $i => $penjualan)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $penjualan->created_at->format('d M Y') }}</td>
                                            <td>{{ optional(optional($penjualan->pembelian)->pengepul)->username ?? '-' }}</td>
                                            <td>{{ optional(optional($penjualan->pembelian)->pengepul)->phone ?? '-' }}</td>
                                            <td>
                                                @if ($penjualan->pembelian && $penjualan->pembelian->tanggal_jemput)
                                                    {{ \Carbon\Carbon::parse($penjualan->pembelian->tanggal_jemput)->format('d M Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($penjualan->status == 'waiting')
                                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                                @elseif ($penjualan->status == 'accepted')
                                                    <span class="badge bg-info">Diterima</span>
                                                @elseif ($penjualan->status == 'finished')
                                                    <span class="badge bg-success">Selesai</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($penjualan->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($penjualan->pembelian)
                                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $penjualan->id }}">Detail</button>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>

                                        {{-- Modal Detail --}}
                                        @if ($penjualan->pembelian)
                                            <div class="modal fade" id="detailModal{{ $penjualan->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-light">
                                                            <h5 class="modal-title">Detail Transaksi</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Nama Pembeli:</strong> {{ optional(optional($penjualan->pembelian)->pengepul)->username ?? '-' }}</p>
                                                            <p><strong>No HP:</strong> {{ optional(optional($penjualan->pembelian)->pengepul)->phone ?? '-' }}</p>
                                                            <p><strong>Nomor Armada:</strong> {{ $penjualan->pembelian->nomor_armada ?? '-' }}</p>
                                                            <p><strong>Tanggal Jemput:</strong>
                                                                @if ($penjualan->pembelian->tanggal_jemput)
                                                                    {{ \Carbon\Carbon::parse($penjualan->pembelian->tanggal_jemput)->format('d M Y') }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </p>

                                                            @if ($penjualan->pembelian->status == 'selesai' || $penjualan->pembelian->status == 'finished')
                                                                <hr>
                                                                <p><strong>Jumlah (Kg):</strong> {{ $penjualan->pembelian->jumlah_kg }}</p>
                                                                <p><strong>Harga/kg:</strong> Rp {{ number_format($penjualan->pembelian->harga_perkg) }}</p>
                                                                <p><strong>Total Harga:</strong> Rp {{ number_format($penjualan->pembelian->total_harga) }}</p>
                                                                <p><strong>Kualitas:</strong> {{ ucfirst($penjualan->pembelian->kualitas) }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-muted py-3">Belum ada riwayat penjualan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        </div>
    </div>
</div>

@endsection
