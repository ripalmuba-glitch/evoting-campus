@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <h3 class="fw-bold text-dark mb-4">Kelola Data Kandidat</h3>

    <div class="row">
        @foreach($elections as $election)
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold">{{ $election->title }}</h5>
                    <p class="text-muted small">{{ Str::limit($election->description, 60) }}</p>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">
                            {{ $election->candidates_count }} Kandidat
                        </span>
                        <a href="{{ route('elections.candidates.index', $election->id) }}" class="btn btn-primary rounded-pill btn-sm px-3 fw-bold">
                            Kelola <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
