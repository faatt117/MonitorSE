<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('beranda.register'); // Mengarahkan ke view register
    }

    // Proses registrasi
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email|unique:admin,email', // Email harus unik di tabel 'admin'
            'password' => 'required|string|min:6|confirmed', // Konfirmasi password
        ]);

        // Buat akun admin baru dan simpan ke database
        Admin::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')), // Hash password
        ]);

        // Redirect ke halaman login
        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('beranda.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Cek kredensial dan login jika benar
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/beranda'); // Arahkan ke halaman utama jika login sukses
        }

        // Kembali ke halaman login jika gagal
        return redirect()->route('login')->withErrors(['loginError' => 'Email atau password salah.']);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
