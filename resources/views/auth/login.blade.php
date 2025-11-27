<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - e-Voting Campus</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-image">
                <div class="login-overlay">
                    <h2 class="fw-bold">e-Voting Campus</h2>
                    <p class="mt-2">Sistem Pemilihan Online Kampus <br> Aman, Rahasia, Transparan.</p>
                </div>
            </div>

            <div class="login-form-section">
                <div class="mb-4">
                    <h3 class="fw-bold text-dark">Selamat Datang! 👋</h3>
                    <p class="text-muted">Silakan login untuk memberikan hak suara.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Email / NIM</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-start-0 @error('email') is-invalid @enderror" placeholder="Masukan email..." required autofocus>
                        </div>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control bg-light border-start-0 @error('password') is-invalid @enderror" placeholder="••••••••" required>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">MASUK SEKARANG</button>

                    <div class="text-center mt-3">
                        <a href="{{ route('password.help') }}" class="small text-muted text-decoration-none">Lupa password? Hubungi Admin.</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
