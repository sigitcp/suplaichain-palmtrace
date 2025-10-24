@extends('layouts.master')

@section('container')
<div class="container-fluid content-inner py-3">
    <h4 class="fw-bold mb-4">Riwayat Transaksi PKS</h4>

    {{-- Grafik Line --}}
    <div class="card mb-4">
        <div class="card-body">
            <canvas id="transaksiChart" height="100"></canvas>
        </div>
    </div>

    {{-- Tabel Riwayat Transaksi --}}
    <div class="card">
        <div class="card-header bg-success text-white fw-bold">
            Tabel Riwayat Transaksi Penimbangan PKS
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-success">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Penerimaan</th>
                            <th>Pengepul</th>
                            <th>Bruto (kg)</th>
                            <th>Tara (kg)</th>
                            <th>Netto (kg)</th>
                            <th>Harga/kg</th>
                            <th>Potongan</th>
                            <th>Total Transaksi</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi as $index => $t)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($t->tanggal_penerimaan)->format('d M Y') }}</td>
                                <td>{{ $t->penawaran->pengepul->username ?? '-' }}</td>
                                <td class="text-end">{{ number_format($t->bruto, 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($t->tara, 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($t->netto, 0, ',', '.') }}</td>
                                <td class="text-end">Rp{{ number_format($t->harga_beli_per_kg, 0, ',', '.') }}</td>
                                <td class="text-end">Rp{{ number_format($t->potongan, 0, ',', '.') }}</td>
                                <td class="text-end fw-bold">Rp{{ number_format($t->total_transaksi, 0, ',', '.') }}</td>
                                <td>{{ $t->catatan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Script untuk Grafik --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('transaksiChart').getContext('2d');
    const transaksiChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels->map(fn($item) => \Carbon\Carbon::createFromFormat('Y-m', $item)->translatedFormat('F Y'))),
            datasets: [{
                label: 'Total Transaksi (Rp)',
                data: @json($chartValues),
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.2)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointRadius: 4,
                pointBackgroundColor: '#198754',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: {
                    callbacks: {
                        label: (context) => 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw)
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: (value) => 'Rp ' + new Intl.NumberFormat('id-ID').format(value)
                    }
                }
            }
        }
    });
</script>
@endsection
