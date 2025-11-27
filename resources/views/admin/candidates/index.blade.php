@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4">
        <a href="{{ route('elections.index') }}" class="text-decoration-none text-muted small">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pemilihan
        </a>
        <div class="d-flex justify-content-between align-items-center mt-2">
            <div>
                <h3 class="fw-bold mb-0">Kandidat: {{ $election->title }}</h3>
                <p class="text-muted small">Kelola calon kandidat untuk pemilihan ini.</p>
            </div>
            <a href="{{ route('elections.candidates.create', $election->id) }}" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-user-plus me-2"></i> Tambah Kandidat
            </a>
        </div>
    </div>

    <div class="row">
        @forelse($candidates as $candidate)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="row g-0 h-100">
                    <div class="col-4 bg-light d-flex align-items-center justify-content-center overflow-hidden">
                        @if($candidate->photo)
                            <img src="{{ asset('storage/' . $candidate->photo) }}" class="img-fluid h-100 w-100" style="object-fit: cover;" alt="Foto">
                        @else
                            <i class="fas fa-user fa-3x text-muted"></i>
                        @endif
                    </div>
                    <div class="col-8">
                        <div class="card-body d-flex flex-column h-100">
                            <h5 class="card-title fw-bold mb-1">{{ $candidate->name }}</h5>
                            <p class="card-text text-muted small flex-grow-1" style="font-size: 0.85rem;">
                                {{ Str::limit($candidate->vision_mission, 80) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-2 border-top pt-2">
                                <small class="text-primary fw-bold">
                                    <i class="fas fa-vote-yea"></i> {{ $candidate->total_votes }} Suara
                                </small>
                                <form action="{{ route('elections.candidates.destroy', [$election->id, $candidate->id]) }}" method="POST" onsubmit="return confirm('Hapus kandidat ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm text-danger border-0 bg-transparent p-0">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="card border-0 shadow-sm p-5">
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/recruitment-agency-4438814-3718492.png" width="200" class="mx-auto mb-3 opacity-75">
                <h5>Belum ada kandidat</h5>
                <p class="text-muted">Silakan tambahkan kandidat pertama untuk pemilihan ini.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
