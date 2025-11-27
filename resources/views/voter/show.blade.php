@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <span class="badge bg-primary px-3 py-2 rounded-pill mb-2">BILIK SUARA DIGITAL</span>
        <h2 class="fw-bold">{{ $election->title }}</h2>
        <p class="text-muted col-md-8 mx-auto">{{ $election->description }}</p>
        <div class="alert alert-warning d-inline-block px-4 py-2 mt-2 rounded-pill shadow-sm">
            <i class="fas fa-lock me-2"></i> Pilihan Anda bersifat <strong>RAHASIA</strong> dan tidak dapat diubah setelah dikonfirmasi.
        </div>
    </div>

    <div class="row justify-content-center">
        @foreach($election->candidates as $candidate)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-lg candidate-card position-relative overflow-hidden">
                <div class="position-absolute top-0 start-0 bg-primary text-white fw-bold px-3 py-2 rounded-bottom-end" style="z-index: 10;">
                    No. {{ $loop->iteration }}
                </div>

                <div class="candidate-photo-wrapper bg-light">
                    @if($candidate->photo)
                        <img src="{{ asset('storage/' . $candidate->photo) }}" class="card-img-top candidate-img" alt="{{ $candidate->name }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 py-5">
                            <i class="fas fa-user fa-5x text-muted opacity-25"></i>
                        </div>
                    @endif
                </div>

                <div class="card-body text-center p-4 d-flex flex-column">
                    <h4 class="fw-bold mb-1">{{ $candidate->name }}</h4>
                    <hr class="mx-auto my-3 text-primary" style="width: 50px; opacity: 1; height: 3px;">

                    <div class="text-start mb-4 bg-light p-3 rounded small flex-grow-1">
                        <strong>Visi & Misi:</strong><br>
                        {!! nl2br(e($candidate->vision_mission)) !!}
                    </div>

                    <form action="{{ route('voter.store', $election->id) }}" method="POST" class="d-grid mt-auto vote-form">
                        @csrf
                        <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">

                        <button type="button" class="btn btn-outline-primary btn-lg fw-bold rounded-pill btn-vote" data-name="{{ $candidate->name }}">
                            <i class="fas fa-vote-yea me-2"></i> PILIH KANDIDAT INI
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('voter.dashboard') }}" class="text-muted text-decoration-none">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

{{-- Script SweetAlert untuk Konfirmasi --}}
<script type="module">
    document.addEventListener('DOMContentLoaded', function () {
        const voteButtons = document.querySelectorAll('.btn-vote');

        voteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('.vote-form');
                const name = this.getAttribute('data-name');

                Swal.fire({
                    title: 'Konfirmasi Pilihan?',
                    html: `Anda akan memilih <strong>${name}</strong>.<br>Tindakan ini tidak dapat dibatalkan!`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#4361ee',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Saya Yakin!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

<style>
    .candidate-img { height: 300px; object-fit: cover; object-position: top; transition: transform 0.3s; }
    .candidate-card:hover .candidate-img { transform: scale(1.05); }
    .candidate-card { transition: transform 0.3s; }
    .candidate-card:hover { transform: translateY(-10px); }
</style>
@endsection
