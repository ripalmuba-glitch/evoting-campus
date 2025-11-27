<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth; // PENTING: Untuk mengecek data user yang login

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | Controller ini menangani otentikasi pengguna untuk aplikasi dan
    | mengarahkan mereka ke layar beranda setelah login sukses.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware guest: User yang sudah login tidak boleh akses halaman login lagi
        $this->middleware('guest')->except('logout');

        // Middleware auth: Hanya user yang login yang bisa akses fungsi logout
        $this->middleware('auth')->only('logout');
    }

    /**
     * Tentukan tujuan redirect setelah login berdasarkan ROLE user.
     * Fungsi ini menggantikan properti $redirectTo.
     *
     * @return string
     */
    public function redirectTo()
    {
        // Cek apakah user memiliki role 'admin'
        if (Auth::user()->role === 'admin') {
            return '/admin/dashboard';
        }

        // Jika bukan admin (berarti voter), arahkan ke dashboard pemilih
        return '/voter/dashboard';
    }
}
