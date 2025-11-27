<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - e-Voting</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <div class="brand-icon">
                    <i class="fas fa-vote-yea"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold" style="color: var(--primary-color)">e-Voting</h5>
                    <small class="text-muted" style="font-size: 0.75rem;">Campus System</small>
                </div>
            </div>

            <div class="sidebar-menu">
                <ul>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                            <i class="fas fa-th-large"></i> Dashboard
                        </a>
                    </li>
                    <li class="mt-2 text-uppercase small text-muted fw-bold ps-3 mb-2" style="font-size: 0.7rem;">Master Data</li>
                    <li>
                        <a href="{{ route('elections.index') }}"><i class="fas fa-calendar-alt"></i> Data Pemilihan</a>
                    </li>
                    <li>
                        <a href="{{ route('candidates.browse') }}"><i class="fas fa-user-tie"></i> Data Kandidat</a>
                    </li>
                    <li>
                        <a href="{{ route('voters.index') }}"><i class="fas fa-users"></i> Data Pemilih</a>
                    </li>
                    <li class="mt-2 text-uppercase small text-muted fw-bold ps-3 mb-2" style="font-size: 0.7rem;">Laporan</li>
                    <li>
                        <a href="{{ route('results.index') }}"><i class="fas fa-chart-pie"></i> Hasil Voting</a>
                    </li>
                    <li>
                        <a href="{{ route('results.index') }}"><i class="fas fa-print"></i> Laporan & Hasil</a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-footer">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="d-flex align-items-center text-danger text-decoration-none fw-bold">
                    <i class="fas fa-sign-out-alt me-3"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </nav>

        <div id="content">
            <nav class="top-navbar">
                <button type="button" id="sidebarCollapse" class="btn btn-light shadow-sm text-primary">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-md-block">
                        <span class="d-block fw-bold small">{{ Auth::user()->name }}</span>
                        <span class="d-block text-muted" style="font-size: 0.75rem;">Administrator</span>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=4361ee&color=fff&rounded=true" width="40" height="40" class="shadow-sm rounded-circle">
                </div>
            </nav>

            <div class="p-4 flex-grow-1">
                @yield('content')
            </div>

            <div class="text-center py-3 text-muted small">
                &copy; {{ date('Y') }} e-Voting Campus. Built with Laravel 11.
            </div>
        </div>
    </div>

    <script type="module">
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle Sidebar
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const btn = document.getElementById('sidebarCollapse');
            btn.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                content.classList.toggle('active');
            });

            // SweetAlert PopUp (Jika ada pesan)
            @if (session('status'))
                Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session('status') }}', timer: 2000, showConfirmButton: false });
            @endif
        });
    </script>
</body>
</html>
