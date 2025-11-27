@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-5 text-center">
                    <div class="mb-4 text-primary">
                        <i class="fas fa-headset fa-5x"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Lupa Password?</h3>
                    <p class="text-muted mb-4">
                        Karena alasan keamanan sistem pemilihan, fitur reset password mandiri dinonaktifkan.
                    </p>

                    <div class="alert alert-info border-0 text-start small">
                        <strong>Prosedur Reset Password:</strong>
                        <ul class="mb-0 mt-2 ps-3">
                            <li>Datang ke Sekretariat Panitia Pemilihan / BAAK.</li>
                            <li>Tunjukkan KTM (Kartu Tanda Mahasiswa) asli.</li>
                            <li>Admin akan memberikan password baru sementara.</li>
                        </ul>
                    </div>

                    <p class="fw-bold mt-4">Kontak Admin:</p>
                    <div class="d-grid gap-2">
                        <a href="https://wa.me/6281234567890" class="btn btn-success rounded-pill fw-bold">
                            <i class="fab fa-whatsapp me-2"></i> Chat WhatsApp Admin
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-light text-muted rounded-pill">
                            Kembali ke Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
