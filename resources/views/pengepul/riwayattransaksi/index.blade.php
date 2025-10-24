@extends('layouts.master')

@section('container')
<div class="container-fluid py-5">
    <h3 class="mb-4 fw-bold text-success">
        <i class="bi bi-graph-up-arrow me-2"></i> Riwayat Transaksi Pengepul
    </h3>

    {{-- === Diagram Perbandingan Pembelian vs Penjualan === --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white fw-bold">
        Perbandingan Pembelian vs Penjualan per Bulan
        </div>
        <div class="card-body">
            <canvas id="chartTransaksi" height="120"></canvas>
        </div>
    </div>

    <div class="row g-4">
        {{-- === Riwayat Pembelian dari Petani === --}}
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white fw-bold">
                 Riwayat Pembelian dari Petani
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Tanggal</th>
                                <th>Nama Petani</th>
                                <th>TBS Baik (Kg)</th>
                                <th>TBS Reject (Kg)</th>
                                <th>Total (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayatPetani as $data)
                                <tr class="text-center">
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal_penimbangan)->format('d M Y') }}</td>
                                    <td>{{ $data->penawaran->petani->username ?? '-' }}</td>
                                    <td>{{ number_format($data->tbs_baik_kg, 0, ',', '.') }}</td>
                                    <td>{{ number_format($data->tbs_reject_kg, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($data->total_transaksi ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada transaksi pembelian</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- === Riwayat Penjualan ke PKS === --}}
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-warning fw-bold">
                Riwayat Penjualan ke PKS
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Tanggal</th>
                                <th>Nama PKS</th>
                                <th>Netto (Kg)</th>
                                <th>Harga/Kg</th>
                                <th>Total (Rp)</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayatPks as $data)
                                <tr class="text-center">
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal_penerimaan)->format('d M Y') }}</td>
                                    <td>{{ $data->penawaran->pks->username ?? '-' }}</td>
                                    <td>{{ number_format($data->netto, 0, ',', '.') }}</td>
                                    <td>{{ number_format($data->harga_beli_per_kg, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($data->total_transaksi, 0, ',', '.') }}</td>
                                    <td>{{ $data->catatan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada transaksi penjualan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- === Chart.js === --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartTransaksi');

const bulanLabels = [
    'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
    'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
];

// Pastikan data 12 bulan tersedia agar chart tidak error
const pembelianValues = {!! json_encode($pembelianValues ?? array_fill(0, 12, 0)) !!};
const penjualanValues = {!! json_encode($penjualanValues ?? array_fill(0, 12, 0)) !!};

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: bulanLabels,
        datasets: [
            {
                label: 'Pembelian dari Petani',
                data: pembelianValues,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Penjualan ke PKS',
                data: penjualanValues,
                backgroundColor: 'rgba(255, 206, 86, 0.7)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' },
            title: {
                display: true,
                text: 'Perbandingan Nilai Transaksi (Rp) per Bulan',
                font: { size: 14 }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>
@endsection
