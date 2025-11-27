@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-0 fw-bold text-dark">Dashboard Overview</h3>
            <p class="text-muted small mb-0">Pantau aktivitas pemilihan secara realtime.</p>
        </div>
        <a href="{{ route('elections.create') }}" class="btn btn-primary shadow-sm px-4 rounded-pill">
            <i class="fas fa-plus fa-sm text-white-50 me-2"></i> Buat Pemilihan
        </a>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label mb-1">Total Pemilih</div>
                        <h2 class="stat-number">{{ $totalVoters }}</h2>
                    </div>
                    <div class="icon-box bg-primary-soft">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
                <div class="mt-3 text-muted small">
                    <span class="text-success fw-bold"><i class="fas fa-arrow-up"></i> 12%</span> dari bulan lalu
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label mb-1">Total Kandidat</div>
                        <h2 class="stat-number">{{ $totalCandidates }}</h2>
                    </div>
                    <div class="icon-box bg-success-soft">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
                <div class="mt-3 text-muted small">
                    <span class="text-primary fw-bold">Siap Dipilih</span> di periode ini
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label mb-1">Event Aktif</div>
                        <h2 class="stat-number">{{ $totalElections }}</h2>
                    </div>
                    <div class="icon-box bg-warning-soft">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
                <div class="mt-3 text-muted small">
                    <span class="text-danger fw-bold">Segera Berakhir</span> dalam 3 hari
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card custom-table-card h-100">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-dark">Statistik Partisipasi</h6>
                    <select class="form-select form-select-sm w-auto border-0 bg-light">
                        <option>Tahun Ini</option>
                        <option>Bulan Ini</option>
                    </select>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center bg-light rounded" style="height: 300px;">
                        <div class="text-center text-muted">
                            <i class="fas fa-chart-area fa-3x mb-3 opacity-25"></i>
                            <p class="small">Grafik akan muncul saat data voting tersedia.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card custom-table-card h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="m-0 fw-bold text-dark">Panduan Cepat</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action p-3 d-flex align-items-center gap-3 border-light">
                            <div class="bg-primary-soft rounded p-2"><i class="fas fa-plus text-primary"></i></div>
                            <div>
                                <h6 class="mb-0 small fw-bold">Buat Event Baru</h6>
                                <p class="mb-0 text-muted" style="font-size: 0.7rem;">Atur jadwal & kandidat.</p>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action p-3 d-flex align-items-center gap-3 border-light">
                            <div class="bg-success-soft rounded p-2"><i class="fas fa-file-excel text-success"></i></div>
                            <div>
                                <h6 class="mb-0 small fw-bold">Import Pemilih</h6>
                                <p class="mb-0 text-muted" style="font-size: 0.7rem;">Upload data dari Excel.</p>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action p-3 d-flex align-items-center gap-3 border-light">
                            <div class="bg-warning-soft rounded p-2"><i class="fas fa-eye text-warning"></i></div>
                            <div>
                                <h6 class="mb-0 small fw-bold">Monitor Live</h6>
                                <p class="mb-0 text-muted" style="font-size: 0.7rem;">Pantau hasil voting.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card custom-table-card">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-dark">Status Pemilihan Terbaru</h6>
                    <a href="{{ route('elections.index') }}" class="btn btn-sm btn-light text-primary fw-bold">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Nama Event</th>
                                <th>Tanggal Mulai</th>
                                <th>Status</th>
                                <th>Partisipan</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($totalElections > 0 ? range(1,1) : [] as $dummy)
                            {{-- Ini hanya dummy row jika ada data --}}
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle me-2" style="width:10px; height:10px;"></div>
                                        <span class="fw-bold">Pemilihan Ketua BEM 2024</span>
                                    </div>
                                </td>
                                <td>24 Nov 2024</td>
                                <td><span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Aktif</span></td>
                                <td>
                                    <div class="progress" style="height: 6px; width: 100px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 45%"></div>
                                    </div>
                                    <small class="text-muted" style="font-size: 0.7rem;">45% Masuk</small>
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-light border"><i class="fas fa-ellipsis-v"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/folder-is-empty-4064360-3363921.png" width="100" class="mb-3 opacity-50">
                                    <p class="small mb-0">Belum ada data pemilihan.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
