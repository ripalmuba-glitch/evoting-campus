@extends('layouts.app')
{{-- Kita pakai layout app default dulu, nanti bisa dicustom lagi --}}

@section('content')
<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h2 class="fw-bold text-dark">Halo, {{ Auth::user()->name }} 👋</h2>
            <p class="text-muted">Gunakan hak suaramu untuk masa depan yang lebih baik.</p>
        </div>
        <div class="col-md-4 text-end">
            <span class="badge bg-primary px-3 py-2 rounded-pill">Status: Pemilih Aktif</span>
        </div>
    </div>

    {{-- Alert jika belum memilih (Nanti kita buat logika ini lebih detail) --}}
    @if(!Auth::user()->is_voted)
    <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center" role="alert">
        <i class="fas fa-info-circle me-2 text-warning fs-4"></i>
        <div>
            <strong>Perhatian!</strong> Kamu belum menggunakan hak suara. Silakan pilih kandidat di bawah ini.
        </div>
    </div>
    @else
    <div class="alert alert-success border-0 shadow-sm" role="alert">
        <i class="fas fa-check-circle me-2"></i> Terimakasih, kamu sudah memberikan suara!
    </div>
    @endif

    <div class="row mt-5">
        <h4 class="fw-bold mb-3 border-start border-4 border-primary ps-3">Daftar Pemilihan Aktif</h4>

        @forelse($activeElections as $election)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100 hover-shadow transition-all">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="badge bg-light text-primary border border-primary">Aktif</span>
                            <small class="text-muted"><i class="far fa-clock"></i> Berakhir: {{ \Carbon\Carbon::parse($election->end_date)->format('d M Y') }}</small>
                        </div>
                        <h5 class="card-title fw-bold">{{ $election->title }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($election->description, 80) }}</p>

                        <a href="#" class="btn btn-primary w-100 mt-3 fw-bold">
                            <i class="fas fa-vote-yea me-2"></i> Mulai Voting
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" width="200" alt="Empty">
                <h5 class="mt-3 text-muted">Belum ada pemilihan yang aktif saat ini.</h5>
            </div>
        @endforelse
    </div>
</div>

<style>
    .hover-shadow:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .transition-all { transition: all 0.3s ease; }
</style>
@endsection
