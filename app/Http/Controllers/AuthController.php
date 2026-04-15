<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login'    => 'required|string', // field ini bisa username atau NISN
            'password' => 'required|string',
        ], [
            'login.required'    => 'Username atau NISN wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('login'));
        }

        $login = $request->login;
        $password = $request->password;

        // Cari user berdasarkan username atau NISN
        $user = \App\Models\User::where('username', $login)
            ->orWhere('nisn', $login)
            ->first();

        // Jika user tidak ditemukan
        if (!$user) {
            return redirect()->back()
                ->withErrors(['login' => 'Username/NISN atau password salah.'])
                ->withInput($request->only('login'));
        }

        // Cek status aktif
        if (!$user->is_active) {
            return redirect()->back()
                ->withErrors(['login' => 'Akun Anda tidak aktif. Hubungi administrator.'])
                ->withInput($request->only('login'));
        }

        // Tentukan credentials berdasarkan role
        $credentials = [];
        
        if ($user->isAdmin()) {
            // Admin login dengan username
            $credentials = [
                'username' => $login,
                'password' => $password,
            ];
        } else {
            // Siswa login dengan NISN
            $credentials = [
                'nisn' => $login,
                'password' => $password,
            ];
        }

        // Attempt login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        // Jika login gagal
        return redirect()->back()
            ->withErrors(['login' => 'Username/NISN atau password salah.'])
            ->withInput($request->only('login'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda berhasil keluar dari sistem.');
    }

    private function redirectByRole()
    {
        return Auth::user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
}