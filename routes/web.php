<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// Import semua Controller yang dibutuhkan
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VoterController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\VoterManagementController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect halaman awal ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

/* --- ROUTE PUBLIK (BISA DIAKSES TANPA LOGIN) --- */
Route::get('/forgot-password-help', function () {
    return view('auth.passwords.help');
})->name('password.help');

// Matikan registrasi umum (register => false)
Auth::routes(['register' => false]);

// Grouping Middleware Auth (Harus Login Dulu)
Route::middleware(['auth'])->group(function () {

    /* =========================================
       AREA ADMIN
    ========================================= */

    // 1. Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // 2. Manajemen Pemilihan (CRUD Elections)
    Route::resource('admin/elections', ElectionController::class);

    // 3. Manajemen Kandidat (Nested Resource)
    // URL: /admin/elections/{id}/candidates/...
    Route::prefix('admin/elections/{election}')->name('elections.')->group(function () {
        Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');
        Route::get('/candidates/create', [CandidateController::class, 'create'])->name('candidates.create');
        Route::post('/candidates', [CandidateController::class, 'store'])->name('candidates.store');
        Route::delete('/candidates/{candidate}', [CandidateController::class, 'destroy'])->name('candidates.destroy');
    });

    // 4. Manajemen Pemilih (Voters) - INI YANG TADI ERROR
    Route::get('admin/voters', [VoterManagementController::class, 'index'])->name('voters.index');
    Route::post('admin/voters/import', [VoterManagementController::class, 'import'])->name('voters.import');
    Route::delete('admin/voters/{voter}', [VoterManagementController::class, 'destroy'])->name('voters.destroy');

    // Route Hasil Voting (Grafik)
    Route::get('admin/results', [ResultController::class, 'index'])->name('results.index');

    // 1. Route Profil (Bisa untuk Admin & Voter)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // 2. Route Data Kandidat (Menu Sidebar)
    // Kita arahkan ke halaman pemilihan kandidat
    Route::get('admin/candidates-browse', [ElectionController::class, 'browseCandidates'])->name('candidates.browse');

    // 3. Route Cetak Laporan PDF
    Route::get('admin/report/print/{election}', [ReportController::class, 'print'])->name('report.print');


    /* =========================================
       AREA PEMILIH (VOTER)
    ========================================= */
    Route::get('/voter/dashboard', [VoterController::class, 'dashboard'])->name('voter.dashboard');

    // Route Masuk Bilik Suara
    Route::get('/voter/election/{election}', [VoteController::class, 'show'])->name('voter.show');
    // Route Kirim Suara (Coblos)
    Route::post('/voter/election/{election}/vote', [VoteController::class, 'store'])->name('voter.store');

});
