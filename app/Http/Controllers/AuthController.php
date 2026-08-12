<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller{
    /**
     * Menampilkan antarmuka form login.
     */
    public function showLoginForm(): View{
        return view('auth.login');
    }

    /**
     * Memproses verifikasi kredensial dan inisialisasi sesi.
     */
    public function login(Request $request): RedirectResponse{
        // 1. Validasi Input Form (Server-Side)
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Autentikasi Kredensial via Auth Guard
        if (Auth::attempt($credentials)) {
            // Mitigasi Keamanan: Regenerasi ID Sesi
            $request->session()->regenerate();

            // Redireksi ke rute yang dituju atau fallback ke dashboard admin
            return redirect()
                ->intended('admin/dashboard')
                ->with('success', 'Selamat datang kembali, Admin!');
        }

        // 3. Penanganan Jika Autentikasi Gagal
        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan tidak cocok.',
        ])->onlyInput('email');
    }

    /**
     * Memproses pencabutan otentikasi dan pemusnahan sesi (Logout).
     */
    public function logout(Request $request): RedirectResponse{
        // 1. Mencabut status autentikasi user
        Auth::logout();

        // 2. Pemusnahan data sesi dan regenerasi token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 3. Redireksi ke halaman login
        return redirect()->route('login');
    }
}