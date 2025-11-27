@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4">
        <a href="{{ route('elections.index') }}" class="text-decoration-none text-muted small">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h3 class="fw-bold mt-2">Buat Pemilihan Baru</h3>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('elections.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Pemilihan</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Contoh: Pemilihan Ketua BEM 2024" required>
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan tujuan pemilihan ini..."></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Waktu Mulai</label>
                        <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror" required>
                        @error('start_date') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Waktu Selesai</label>
                        <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror" required>
                        @error('end_date') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="reset" class="btn btn-light px-4">Reset</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan & Buat</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
