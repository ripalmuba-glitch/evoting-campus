<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Pemilih - e-Voting Campus</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        /* Custom Style Khusus Halaman Voter */
        body { background-color: #f0f2f5; font-family: 'Poppins', sans-serif; }
        .voter-navbar { background: white; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 0.8rem 0; }

        .hero-section {
            background: linear-gradient(135deg, #4361ee 0%, #3f37c9 100%);
            color: white; border-radius: 20px; padding: 40px; margin-bottom: 30px;
            position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(67, 97, 238, 0.3);
        }
        .hero-bg-icon {
            position: absolute; right: -20px; bottom: -50px; font-size: 15rem; opacity: 0.1; color: white; transform: rotate(-15deg);
        }

        .election-card {
            border: none; border-radius: 16px; overflow: hidden; transition: all 0.3s ease; background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); height: 100%;
            display: flex; flex-direction: column;
        }
        .election-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }

        .status-badge {
            position: absolute; top: 20px; right: 20px; padding: 6px 14px;
            border-radius: 30px; font-weight: 600; font-size: 0.75rem; letter-spacing: 0.5px;
        }

        .icon-wrapper {
            width: 70px; height: 70px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px auto; background: #eaf0ff; color: #4361ee;
        }
    </style>
</head>
<body>

    <nav class="voter-navbar sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand fw-bold text-primary fs-4 d-flex align-items-center" href="#">
                <i class="fas fa-vote-yea me-2"></i>eVoting
            </a>
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 border-0 bg-transparent shadow-none" type="button" data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=4361ee&color=fff" class="rounded-circle shadow-sm" width="35" height="35">
                    <span class="d-none d-md-block fw-bold small text-dark">{{ Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-2 rounded-3">
                    <li><div class="dropdown-header">Menu Pengguna</div></li>
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2 text-muted"></i> Profil Saya</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger fw-bold" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">

        <div class="hero-section">
            <i class="fas fa-box-open hero-bg-icon"></i>
            <div class="row align-items-center position-relative">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h2>
                    <p class="mb-4 fs-6 opacity-75">Selamat datang di portal e-Voting. Pastikan Anda menggunakan hak suara dengan bijak, jujur, dan rahasia.</p>

                    @if(!Auth::user()->is_voted)
                        <div class="d-inline-flex align-items-center bg-white text-danger px-4 py-2 rounded-pill fw-bold shadow-sm" style="font-size: 0.9rem;">
                            <i class="fas fa-exclamation-circle me-2"></i> Status: BELUM MEMILIH
                        </div>
                    @else
                        <div class="d-inline-flex align-items-center bg-white text-success px-4 py-2 rounded-pill fw-bold shadow-sm" style="font-size: 0.9rem;">
                            <i class="fas fa-check-circle me-2"></i> Status: SUDAH MEMILIH
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4 mt-5">
            <h4 class="fw-bold text-dark border-start border-4 border-primary ps-3">Daftar Pemilihan Aktif</h4>
            <span class="badge bg-light text-muted border px-3 py-2 rounded-pill">
                <i class="far fa-clock me-1"></i> {{ now()->format('d M Y') }}
            </span>
        </div>

        <div class="row">
            @forelse($activeElections as $election)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="election-card position-relative p-4">

                        <span class="status-badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                            LIVE
                        </span>

                        <div class="icon-wrapper">
                            <i class="fas fa-bullhorn fs-2"></i>
                        </div>

                        <div class="text-center mb-3">
                            <h5 class="fw-bold text-dark mb-2">{{ $election->title }}</h5>
                            <p class="text-muted small mb-0">{{ Str::limit($election->description, 90) }}</p>
                        </div>

                        <hr class="border-light my-3">

                        <div class="d-flex justify-content-between text-muted small mb-2">
                            <span>Mulai:</span>
                            <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($election->start_date)->format('d M, H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted small mb-4">
                            <span>Selesai:</span>
                            <span class="fw-bold text-danger">{{ \Carbon\Carbon::parse($election->end_date)->format('d M, H:i') }}</span>
                        </div>

                        <div class="mt-auto">
                            @if(!Auth::user()->is_voted)
                                {{-- Jika BELUM memilih, tombol aktif menuju halaman bilik suara --}}
                                <a href="{{ route('voter.show', $election->id) }}" class="btn btn-primary w-100 py-2 rounded-pill fw-bold shadow-sm btn-vote-action">
                                    <i class="fas fa-vote-yea me-2"></i> MASUK BILIK SUARA
                                </a>
                            @else
                                {{-- Jika SUDAH memilih, tombol disabled --}}
                                <button class="btn btn-secondary w-100 py-2 rounded-pill fw-bold opacity-75" disabled>
                                    <i class="fas fa-lock me-2"></i> SUDAH MEMILIH
                                </button>
                                <div class="text-center mt-2">
                                    <small class="text-success fw-bold"><i class="fas fa-check-double me-1"></i> Suara terekam aman</small>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                        <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-box-468-1055745.png" width="150" class="mb-3 opacity-50">
                        <h5 class="mt-3 text-dark fw-bold">Tidak Ada Pemilihan Aktif</h5>
                        <p class="text-muted small">Saat ini belum ada jadwal pemilihan yang dibuka oleh panitia.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <footer class="text-center py-5 text-muted small mt-4">
            <p class="mb-0">&copy; {{ date('Y') }} e-Voting Campus System. Hak Cipta Dilindungi.</p>
            <p class="mb-0 opacity-75">Sistem Pemilihan Online yang Aman, Rahasia & Transparan.</p>
        </footer>

    </div>

    <script type="module">
        // Notifikasi Sukses
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 4000,
                showConfirmButton: false,
                backdrop: `rgba(0,0,123,0.4)`
            });
        @endif

        // Notifikasi Error
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Akses Ditolak',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33'
            });
        @endif
    </script>
</body>
</html>
