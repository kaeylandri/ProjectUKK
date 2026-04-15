<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegister()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('user.dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:100',
            'nisn'      => 'required|string|size:10|unique:users|regex:/^[0-9]+$/', // NISN 10 digit angka
            'username'  => 'required|string|max:50|unique:users|alpha_num',
            'email'     => 'required|email|unique:users',
            'kelas'     => 'required|string|max:30',
            'password'  => 'required|string|min:6|confirmed',
        ], [
            'name.required'       => 'Nama lengkap wajib diisi.',
            'nisn.required'       => 'NISN wajib diisi.',
            'nisn.size'           => 'NISN harus terdiri dari 10 digit angka.',
            'nisn.unique'         => 'NISN sudah terdaftar.',
            'nisn.regex'          => 'NISN hanya boleh berisi angka.',
            'username.required'   => 'Username wajib diisi.',
            'username.unique'     => 'Username sudah digunakan, coba yang lain.',
            'username.alpha_num'  => 'Username hanya boleh huruf dan angka.',
            'email.required'      => 'Email wajib diisi.',
            'email.unique'        => 'Email sudah terdaftar.',
            'kelas.required'      => 'Kelas wajib dipilih.',
            'password.required'   => 'Password wajib diisi.',
            'password.min'        => 'Password minimal 6 karakter.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $user = User::create([
            'name'      => $request->name,
            'nisn'      => $request->nisn,
            'username'  => strtolower($request->username),
            'email'     => $request->email,
            'kelas'     => $request->kelas,
            'password'  => $request->password, // Karena di casts sudah 'hashed', akan otomatis di-hash
            'role'      => 'user',
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard')
            ->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->name . '.');
    }
}