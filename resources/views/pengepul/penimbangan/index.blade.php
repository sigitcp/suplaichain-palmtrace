@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">

    <div class="row justify-content-center">
        <div class="col-sm-12 mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title" style="color: #858223;">Daftar Penimbangan Barang</h4>
                    </div>
                </div>

                <div class="card-body">
                    <div class="custom-datatable-entries">
                        <div class="table-responsive border-bottom my-3">
                            <table id="datatable1" class="table table-striped dataTable text-center align-middle" data-toggle="data-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Petani</th>
                                        <th>Nomor Armada</th>
                                        <th>Tanggal Jemput</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pembelians as $index => $pembelian)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $pembelian->penjualan->petani->username ?? '-' }}</td>
                                            <td>{{ $pembelian->nomor_armada }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pembelian->tanggal_jemput)->format('d M Y') }}</td>
                                            <td>
                                                <span class="badge bg-info text-dark">Dalam Proses</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#penimbanganModal{{ $pembelian->id }}">
                                                    Input Hasil
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Penimbangan -->
                                        <div class="modal fade" id="penimbanganModal{{ $pembelian->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="{{ route('pengepul.penimbangan.update', $pembelian->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header bg-light">
                                                            <h5 class="modal-title">Input Hasil Penimbangan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Jumlah (Kg)</label>
                                                                <input type="number" name="jumlah_kg" class="form-control" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Harga per Kg (Rp)</label>
                                                                <input type="number" name="harga_perkg" class="form-control" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Kualitas</label>
                                                                <select name="kualitas" class="form-select" required>
                                                                    <option value="">-- Pilih Kualitas --</option>
                                                                    <option value="sangat baik">Sangat Baik</option>
                                                                    <option value="baik">Baik</option>
                                                                    <option value="cukup">Cukup</option>
                                                                    <option value="kurang">Kurang</option>
                                                                </select>
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
                                                <td colspan="6" class="text-muted text-center py-3">
                                                    <h5>Belum ada transaksi yang perlu ditimbang.</h5>
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

</div>

@endsection
