@extends('layouts.master')
@section('container')

<div class="container-fluid content-inner py-3">
    <div class="row">
        <div class="col-sm-12">
            <h5 class="fw-bold mb-3 text-success">Riwayat Transaksi</h5>

            <!-- Chart Line -->
            <div class="card shadow-sm border-0 mb-4" style="background-color:#f3f8e5;">
                <div class="card-body">
                    <h6 class="fw-bold mb-3 text-secondary">Grafik Panen (Total Baik vs Total Reject)</h6>
                    <canvas id="riwayatChart" height="120"></canvas>
                </div>
            </div>

            <!-- Table Riwayat -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold text-secondary mb-3">Detail Transaksi</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle text-center">
                            <thead class="table-success">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>TBS Baik (Kg)</th>
                                    <th>Harga Baik (Rp)</th>
                                    <th>Total Baik (Rp)</th>
                                    <th>TBS Reject (Kg)</th>
                                    <th>Harga Reject (Rp)</th>
                                    <th>Total Reject (Rp)</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($riwayat as $r)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($r->tanggal_penimbangan)->format('d M Y') }}</td>
                                        <td>{{ number_format($r->tbs_baik_kg, 0, ',', '.') }}</td>
                                        <td>{{ number_format($r->harga_baik_per_kg, 0, ',', '.') }}</td>
                                        <td class="fw-bold text-success">{{ number_format($r->total_baik, 0, ',', '.') }}</td>
                                        <td>{{ number_format($r->tbs_reject_kg ?? 0, 0, ',', '.') }}</td>
                                        <td>{{ number_format($r->harga_reject_per_kg ?? 0, 0, ',', '.') }}</td>
                                        <td class="fw-bold text-danger">{{ number_format($r->total_reject ?? 0, 0, ',', '.') }}</td>
                                        <td>{{ $r->catatan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-muted">Belum ada data transaksi</td>
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

{{-- === ChartJS === --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('riwayatChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($labels) !!}, // tanggal penimbangan
        datasets: [
            {
                label: 'Total Baik (Rp)',
                data: {!! json_encode($dataBaik) !!},
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.2)',
                fill: true,
                tension: 0.4
            },
            {
                label: 'Total Reject (Rp)',
                data: {!! json_encode($dataReject) !!},
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.2)',
                fill: true,
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
                labels: { color: '#333' }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let val = context.parsed.y || 0;
                        return context.dataset.label + ': Rp ' + val.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            y: { 
                beginAtZero: true,
                title: { display: true, text: 'Total (Rp)' },
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            },
            x: { 
                title: { display: true, text: 'Tanggal Penimbangan' }
            }
        }
    }
});
</script>
@endsection

