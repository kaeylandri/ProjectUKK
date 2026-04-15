<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Akun — SMKN 4 Bandung</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Inter',sans-serif;min-height:100vh;background:#f1f5f9;
  display:flex;align-items:center;justify-content:center;padding:2rem 1rem;}

.card{background:#fff;border-radius:16px;width:100%;max-width:620px;
  box-shadow:0 4px 24px rgba(0,0,0,.06),0 1px 4px rgba(0,0,0,.04);overflow:hidden;}

.card-top{background:linear-gradient(135deg,#1e3a5f,#1a4f8a);padding:1.75rem 2rem;
  display:flex;align-items:center;gap:1rem;}

.card-icon{
  width:50px;
  height:50px;
  background:rgba(255,255,255,.15);
  border-radius:12px;
  display:flex;
  align-items:center;
  justify-content:center;
  flex-shrink:0;
  overflow:hidden;
}

/* LOGO DI DALAM ICON */
.card-icon img{
  width:100%;
  height:100%;
  object-fit:contain;
}

.card-top-txt h1{font-size:1.1rem;font-weight:700;color:#fff;margin-bottom:.15rem;}
.card-top-txt p{font-size:.78rem;color:rgba(255,255,255,.7);}

.card-body{padding:1.75rem 2rem;}

.err-box{background:#fef2f2;border:1px solid #fecaca;color:#dc2626;border-radius:8px;
  padding:.65rem .9rem;font-size:.82rem;margin-bottom:1.1rem;}

.err-box ul{padding-left:1.1rem;}

.fg{margin-bottom:.95rem;}

.fg label{display:block;font-size:.8rem;font-weight:600;color:#475569;margin-bottom:.38rem;}

.req{color:#ef4444;}

.info-text{font-size:.72rem;color:#64748b;margin-top:.25rem;}

input[type=text],input[type=email],input[type=password],select{
  width:100%;padding:.62rem .85rem;border:1.5px solid #e2e8f0;border-radius:8px;
  font-family:'Inter',sans-serif;font-size:.875rem;color:#1e293b;background:#f8fafc;
  transition:all .2s;outline:none;}

input:focus,select:focus{border-color:#1a4f8a;background:#fff;
  box-shadow:0 0 0 3px rgba(26,79,138,.08);}

input.err,select.err{border-color:#ef4444;}

.err-msg{font-size:.75rem;color:#ef4444;margin-top:.25rem;}

.row2{display:grid;grid-template-columns:1fr 1fr;gap:.85rem;}

@media(max-width:480px){.row2{grid-template-columns:1fr;}}

.divider{font-size:.73rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;
  color:#94a3b8;margin:.25rem 0 .85rem;padding-bottom:.5rem;border-bottom:1px solid #f1f5f9;}

.btn-reg{width:100%;padding:.72rem;background:#1a4f8a;color:#fff;border:none;
  border-radius:8px;font-family:'Inter',sans-serif;font-size:.9rem;font-weight:600;
  cursor:pointer;transition:background .2s;margin-top:.25rem;}

.btn-reg:hover{background:#163d6e;}

.login-link{text-align:center;margin-top:1.1rem;font-size:.82rem;color:#94a3b8;}

.login-link a{color:#1a4f8a;font-weight:600;text-decoration:none;}

.login-link a:hover{text-decoration:underline;}
</style>
</head>

<body>

<div class="card">
  <div class="card-top">
    
    <!-- LOGO (GANTI ICON SVG) -->
    <div class="card-icon">
      <img src="{{ asset('images/logo.png') }}" alt="Logo SMKN 4 Bandung">
    </div>

    <div class="card-top-txt">
      <h1>Daftar Akun Siswa</h1>
      <p>SMKN 4 Bandung — Sistem Pengaduan Sarana</p>
    </div>
  </div>

  <div class="card-body">
    @if($errors->any())
    <div class="err-box">
      <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST">
      @csrf

      <div class="divider">Identitas Diri</div>

      <div class="fg">
        <label>Nama Lengkap <span class="req">*</span></label>
        <input type="text" name="name" class="{{ $errors->has('name')?'err':'' }}"
          value="{{ old('name') }}" placeholder="Nama lengkap sesuai kartu pelajar">
        @error('name')<div class="err-msg">{{ $message }}</div>@enderror
      </div>

      <!-- FIELD NISN BARU -->
      <div class="fg">
        <label>NISN <span class="req">*</span></label>
        <input type="text" name="nisn" class="{{ $errors->has('nisn')?'err':'' }}"
          value="{{ old('nisn') }}" placeholder="10 digit NISN" maxlength="10">
        <div class="info-text">⚠️ NISN harus terdiri dari 10 digit angka (digunakan untuk login)</div>
        @error('nisn')<div class="err-msg">{{ $message }}</div>@enderror
      </div>

      <div class="row2">
        <div class="fg">
          <label>Username <span class="req">*</span></label>
          <input type="text" name="username" class="{{ $errors->has('username')?'err':'' }}"
            value="{{ old('username') }}" placeholder="huruf & angka">
          @error('username')<div class="err-msg">{{ $message }}</div>@enderror
        </div>

        <div class="fg">
          <label>Kelas <span class="req">*</span></label>
          <select name="kelas" class="{{ $errors->has('kelas')?'err':'' }}">
            <option value="">— Pilih Kelas —</option>
            <option value="XII RPL 1" {{ old('kelas') == 'XII RPL 1' ? 'selected' : '' }}>XII RPL 1</option>
            <option value="XII RPL 2" {{ old('kelas') == 'XII RPL 2' ? 'selected' : '' }}>XII RPL 2</option>
            <option value="XII RPL 3" {{ old('kelas') == 'XII RPL 3' ? 'selected' : '' }}>XII RPL 3</option>
            <option value="XII RPL 4" {{ old('kelas') == 'XII RPL 4' ? 'selected' : '' }}>XII RPL 4</option>
            <option value="XII RPL 5" {{ old('kelas') == 'XII RPL 5' ? 'selected' : '' }}>XII RPL 5</option>
          </select>
          @error('kelas')<div class="err-msg">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="fg">
        <label>Email <span class="req">*</span></label>
        <input type="email" name="email" class="{{ $errors->has('email')?'err':'' }}"
          value="{{ old('email') }}" placeholder="email@contoh.com">
        @error('email')<div class="err-msg">{{ $message }}</div>@enderror
      </div>

      <div class="divider">Keamanan Akun</div>

      <div class="row2">
        <div class="fg">
          <label>Password <span class="req">*</span></label>
          <input type="password" name="password" class="{{ $errors->has('password')?'err':'' }}">
          <div class="info-text">Minimal 6 karakter</div>
          @error('password')<div class="err-msg">{{ $message }}</div>@enderror
        </div>

        <div class="fg">
          <label>Konfirmasi Password <span class="req">*</span></label>
          <input type="password" name="password_confirmation">
        </div>
      </div>

      <button type="submit" class="btn-reg">Buat Akun</button>
    </form>

    <div class="login-link">
      Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
  </div>
</div>

</body>
</html>