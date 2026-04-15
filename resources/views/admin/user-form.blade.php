@extends('layouts.admin')
@section('title', $user ? 'Edit User' : 'Tambah User')
@section('page-title', $user ? 'Edit User' : 'Tambah User Baru')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-head">
        <h2>{{ $user ? 'Edit: '.$user->name : 'Form Tambah User Baru' }}</h2>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;
                    border-radius:8px;padding:.65rem .9rem;margin-bottom:1rem;font-size:.83rem;">
            <ul style="padding-left:1.1rem;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form action="{{ $user ? route('admin.users.update',$user) : route('admin.users.store') }}" method="POST">
            @csrf
            @if($user) @method('PUT') @endif

            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap <span class="req">*</span></label>
                    <input type="text" name="name" value="{{ old('name',$user?->name) }}" placeholder="Nama lengkap">
                </div>
                <div class="form-group">
                    <label>Username <span class="req">*</span></label>
                    <input type="text" name="username" value="{{ old('username',$user?->username) }}" placeholder="Username">
                </div>
            </div>

            <div class="form-group">
                <label>Email <span class="req">*</span></label>
                <input type="email" name="email" value="{{ old('email',$user?->email) }}" placeholder="email@contoh.com">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Password {{ $user ? '' : '' }} @if(!$user)<span class="req">*</span>@endif</label>
                    <input type="password" name="password" placeholder="{{ $user ? 'Kosongkan jika tidak diubah' : 'Min. 6 karakter' }}">
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Role <span class="req">*</span></label>
                    <select name="role">
                        <option value="user"  {{ old('role',$user?->role)=='user'  ?'selected':'' }}>Siswa</option>
                        <option value="admin" {{ old('role',$user?->role)=='admin' ?'selected':'' }}>Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kelas</label>
                    <select name="kelas">
                        <option value="">— Pilih Kelas —</option>
                        @foreach(['XII RPL 1','XII RPL 2','XII RPL 3','XII TOI 1','XII TOI 2','XII DKV 1','XII DKV 2','XII TAV 1','XII TAV 2','XII TAV 3','XII TKTL 1','XII TKTL 2'] as $k)
                        <option value="{{ $k }}" {{ old('kelas',$user?->kelas)==$k?'selected':'' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if($user)
            <div class="form-group">
                <label>Status Akun</label>
                <select name="is_active">
                    <option value="1" {{ old('is_active',$user->is_active?'1':'0')=='1'?'selected':'' }}>Aktif</option>
                    <option value="0" {{ old('is_active',$user->is_active?'1':'0')=='0'?'selected':'' }}>Nonaktif</option>
                </select>
            </div>
            @endif

            <div style="display:flex;gap:.6rem;padding-top:1rem;border-top:1px solid #f1f5f9;margin-top:.5rem;">
                <button type="submit" class="btn btn-success">
                    {{ $user ? 'Simpan Perubahan' : 'Tambah User' }}
                </button>
                <a href="{{ route('admin.users') }}" class="btn">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
