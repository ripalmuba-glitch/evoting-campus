@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold text-dark">Hasil Perolehan Suara</h3>
            <p class="text-muted small mb-0">Pantau statistik kemenangan kandidat secara realtime.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('results.index') }}" method="GET" class="row align-items-end">
                <div class="col-md-8 mb-3 mb-md-0">
                    <label class="form-label fw-bold text-muted small text-uppercase">Pilih Acara Pemilihan</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-filter text-primary"></i></span>
                        <select name="election_id" class="form-select form-select-lg bg-light border-start-0 ps-0" onchange="this.form.submit()" style="cursor: pointer;">
                            <option value="" disabled selected>-- Silakan Pilih Acara --</option>
                            @foreach($elections as $election)
                                <option value="{{ $election->id }}" {{ request('election_id') == $election->id ? 'selected' : '' }}>
                                    {{ $election->title }} ({{ $election->status == 'active' ? '🔴 Live' : '🔒 Selesai' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-grid">
                        <a href="{{ route('results.index') }}" class="btn btn-light btn-lg text-muted border">
                            <i class="fas fa-sync-alt me-2"></i> Reset Filter
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($selectedElection)

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="badge {{ $selectedElection->status == 'active' ? 'bg-success' : 'bg-secondary' }} px-3 py-2 rounded-pill">
                Status: {{ $selectedElection->status == 'active' ? 'Sedang Berlangsung' : 'Sudah Ditutup' }}
            </span>
        </div>
        <a href="{{ route('report.print', $selectedElection->id) }}" class="btn btn-danger shadow-sm rounded-pill px-4 fw-bold">
            <i class="fas fa-file-pdf me-2"></i> Download Laporan Resmi (PDF)
        </a>
    </div>

    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 border-0 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-2 rounded me-2"><i class="fas fa-chart-pie text-primary"></i></div>
                    <h6 class="fw-bold mb-0">Persentase Suara</h6>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center" style="position: relative; height: 320px;">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 border-0 d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-2 rounded me-2"><i class="fas fa-chart-bar text-success"></i></div>
                    <h6 class="fw-bold mb-0">Perbandingan Jumlah Suara</h6>
                </div>
                <div class="card-body">
                    <canvas id="barChart" style="max-height: 320px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0">Detail Peringkat Kandidat</h6>
            <small class="text-muted">Diurutkan berdasarkan suara terbanyak</small>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">Peringkat</th>
                        <th>Kandidat</th>
                        <th class="text-center">Total Suara</th>
                        <th class="text-end pe-4">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalVotes = array_sum($chartData); @endphp
                    @foreach($selectedElection->candidates as $index => $candidate)
                    <tr class="{{ $index == 0 ? 'bg-warning bg-opacity-10' : '' }}">
                        <td class="ps-4">
                            @if($index == 0)
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">
                                    <i class="fas fa-crown me-1"></i> JUARA 1
                                </span>
                            @else
                                <span class="fw-bold text-muted ms-2">#{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center py-2">
                                @if($candidate->photo)
                                    <img src="{{ asset('storage/' . $candidate->photo) }}" class="rounded-circle me-3 shadow-sm" width="50" height="50" style="object-fit: cover; border: 2px solid white;">
                                @else
                                    <div class="bg-secondary rounded-circle me-3 d-flex align-items-center justify-content-center text-white shadow-sm" style="width: 50px; height: 50px; border: 2px solid white;">
                                        {{ substr($candidate->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold text-dark">{{ $candidate->name }}</div>
                                    <div class="small text-muted" style="font-size: 0.75rem;">ID: CAN-{{ $candidate->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <h5 class="fw-bold mb-0 text-primary">{{ number_format($candidate->total_votes) }}</h5>
                            <small class="text-muted">Suara</small>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex align-items-center justify-content-end">
                                <span class="fw-bold me-2">{{ $totalVotes > 0 ? number_format(($candidate->total_votes / $totalVotes) * 100, 1) : 0 }}%</span>
                                <div class="progress" style="width: 60px; height: 6px;">
                                    <div class="progress-bar {{ $index == 0 ? 'bg-warning' : 'bg-primary' }}" role="progressbar" style="width: {{ $totalVotes > 0 ? ($candidate->total_votes / $totalVotes) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @else

    <div class="text-center py-5">
        <div class="mb-4">
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/analytics-3024847-2529063.png" width="300" class="opacity-75 img-fluid">
        </div>
        <h4 class="fw-bold text-dark">Data Belum Ditampilkan</h4>
        <p class="text-muted col-md-6 mx-auto">Silakan pilih salah satu acara pemilihan pada dropdown filter di atas untuk melihat grafik hasil voting.</p>
    </div>

    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if($selectedElection)
<script>
    const labels = {!! json_encode($chartLabels) !!};
    const dataVotes = {!! json_encode($chartData) !!};

    // Palet Warna Modern
    const backgroundColors = [
        '#4361ee', '#3f37c9', '#4895ef', '#f72585', '#7209b7', '#4cc9f0', '#fb5607', '#ff006e'
    ];

    // 1. Config Pie Chart
    const ctxPie = document.getElementById('pieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: dataVotes,
                backgroundColor: backgroundColors,
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%', // Membuat lubang tengah lebih besar (Donat style)
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
            }
        }
    });

    // 2. Config Bar Chart
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Suara',
                data: dataVotes,
                backgroundColor: '#4361ee',
                borderRadius: 8, // Sudut batang melengkung
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [5, 5], color: '#f0f0f0' },
                    ticks: { stepSize: 1 }
                },
                x: {
                    grid: { display: false }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endif

@endsection
