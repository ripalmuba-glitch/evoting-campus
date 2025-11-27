@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4">
                <a href="{{ route('elections.candidates.index', $election->id) }}" class="text-decoration-none text-muted small">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <h3 class="fw-bold mt-2">Tambah Kandidat Baru</h3>
                <p class="text-muted small">Untuk: {{ $election->title }}</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form action="{{ route('elections.candidates.store', $election->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold">Nama Lengkap Kandidat</label>
                            <input type="text" name="name" class="form-control form-control-lg bg-light border-0" placeholder="Contoh: Budi Santoso" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Visi & Misi</label>
                            <textarea name="vision_mission" class="form-control bg-light border-0" rows="5" placeholder="Tuliskan visi dan misi kandidat di sini..." required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Foto Profil</label>
                            <div class="p-4 bg-light rounded-3 text-center border border-dashed">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                <p class="small text-muted mb-2">Format: JPG, PNG (Max 2MB)</p>
                                <input type="file" name="photo" class="form-control" required>
                            </div>
                            @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill fw-bold shadow-sm">
                                <i class="fas fa-save me-2"></i> Simpan Kandidat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
