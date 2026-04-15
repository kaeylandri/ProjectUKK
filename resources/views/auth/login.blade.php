
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — Pengaduan Sarana SMKN 4 Bandung</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Inter',sans-serif;min-height:100vh;display:flex;background:#f1f5f9;}

/* LEFT SIDE */
.left{width:420px;background:linear-gradient(160deg,#1e3a5f 0%,#1a4f8a 60%,#1d6fa3 100%);
      display:flex;flex-direction:column;justify-content:space-between;padding:3rem 2.5rem;
      position:relative;overflow:hidden;flex-shrink:0;}
.left::before{content:'';position:absolute;width:340px;height:340px;border-radius:50%;
  background:rgba(255,255,255,.04);top:-80px;right:-80px;}
.left::after{content:'';position:absolute;width:200px;height:200px;border-radius:50%;
  background:rgba(255,255,255,.04);bottom:-40px;left:-60px;}
.left-top{position:relative;z-index:1;}
.school-icon{width:56px;height:56px;background:rgba(255,255,255,.15);border-radius:14px;
  display:flex;align-items:center;justify-content:center;margin-bottom:1.5rem;}
.school-icon svg{width:32px;height:32px;color:#fff;}
.left h1{font-size:1.55rem;font-weight:700;color:#fff;line-height:1.3;margin-bottom:.75rem;}
.left p{font-size:.875rem;color:rgba(255,255,255,.7);line-height:1.7;}
.left-feats{position:relative;z-index:1;display:flex;flex-direction:column;gap:.6rem;}
.feat{display:flex;align-items:center;gap:.7rem;background:rgba(255,255,255,.08);
  border:1px solid rgba(255,255,255,.1);border-radius:10px;padding:.65rem .9rem;
  color:rgba(255,255,255,.88);font-size:.82rem;}
.feat-dot{width:8px;height:8px;background:#4ade80;border-radius:50%;flex-shrink:0;}

/* RIGHT SIDE */
.right{flex:1;display:flex;align-items:center;justify-content:center;padding:2rem;}
.form-card{background:#fff;border-radius:16px;padding:2.5rem 2rem;width:100%;max-width:400px;
  box-shadow:0 4px 24px rgba(0,0,0,.06),0 1px 4px rgba(0,0,0,.04);}

/* LOGO */
.logo{
  display:flex;
  justify-content:center;
  margin-bottom:1rem;
}
.logo img{
  width:80px;
  height:auto;
}

.form-card h2{font-size:1.35rem;font-weight:700;color:#1e293b;margin-bottom:.3rem;}
.form-card .sub{font-size:.85rem;color:#94a3b8;margin-bottom:2rem;}
.fg{margin-bottom:1.1rem;}
.fg label{display:block;font-size:.8rem;font-weight:600;color:#475569;margin-bottom:.4rem;}
.info-text{font-size:.75rem;color:#64748b;margin-top:.25rem;display:flex;align-items:center;gap:.3rem;}
.info-text i{font-style:normal;}
.inp-wrap{position:relative;}
.inp-icon{position:absolute;left:.85rem;top:50%;transform:translateY(-50%);
  font-size:.9rem;opacity:.4;pointer-events:none;}
input[type=text],input[type=password]{width:100%;padding:.65rem 1rem .65rem 2.5rem;
  border:1.5px solid #e2e8f0;border-radius:8px;font-family:'Inter',sans-serif;
  font-size:.875rem;color:#1e293b;background:#f8fafc;transition:all .2s;outline:none;}
input[type=text]:focus,input[type=password]:focus{border-color:#1a4f8a;background:#fff;
  box-shadow:0 0 0 3px rgba(26,79,138,.08);}
.remember{display:flex;align-items:center;gap:.5rem;font-size:.82rem;color:#64748b;
  margin-bottom:1.4rem;}
.remember input{accent-color:#1a4f8a;width:15px;height:15px;cursor:pointer;}
.btn-login{width:100%;padding:.72rem;background:#1a4f8a;color:#fff;border:none;
  border-radius:8px;font-family:'Inter',sans-serif;font-size:.9rem;font-weight:600;
  cursor:pointer;transition:background .2s,transform .1s;}
.btn-login:hover{background:#163d6e;}
.btn-login:active{transform:scale(.99);}
.err{background:#fef2f2;border:1px solid #fecaca;color:#dc2626;border-radius:8px;
  padding:.65rem .9rem;font-size:.82rem;margin-bottom:1rem;display:flex;gap:.5rem;align-items:flex-start;}
.ok{background:#f0fdf4;border:1px solid #bbf7d0;color:#16a34a;border-radius:8px;
  padding:.65rem .9rem;font-size:.82rem;margin-bottom:1rem;}
.reg-link{text-align:center;margin-top:1.25rem;font-size:.82rem;color:#94a3b8;}
.reg-link a{color:#1a4f8a;font-weight:600;text-decoration:none;}
.reg-link a:hover{text-decoration:underline;}

@media(max-width:768px){.left{display:none;}.form-card{max-width:100%;}}
</style>
</head>

<body>

<div class="left">
  <div class="left-top">
    <div class="school-icon">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="currentColor">
        <rect x="8" y="28" width="48" height="28" rx="2"/>
        <polygon points="4,29 32,8 60,29"/>
      </svg>
    </div>
    <h1>Sistem Pengaduan<br>Sarana Sekolah</h1>
    <p>SMKN 4 Bandung — Laporkan kerusakan dan permasalahan sarana sekolah secara mudah dan cepat.</p>
  </div>

  <div class="left-feats">
    <div class="feat"><span class="feat-dot"></span>Pengaduan diproses 1–3 hari kerja</div>
    <div class="feat"><span class="feat-dot"></span>Pantau status secara real-time</div>
    <div class="feat"><span class="feat-dot"></span>Ditindaklanjuti langsung petugas</div>
  </div>
</div>

<div class="right">
  <div class="form-card">

    <!-- LOGO -->
    <div class="logo">
      <img src="{{ asset('images/logo.png') }}" alt="Logo SMKN 4 Bandung">
    </div>

    <h2>Selamat Datang</h2>
    <p class="sub">Masuk ke akun Anda untuk melanjutkan</p>

    @if(session('success'))
    <div class="ok">{{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="err"><span>⚠</span><span>{{ $errors->first() }}</span></div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
      @csrf

      <div class="fg">
        <label for="login"> <span style="color:#ef4444;">*</span></label>
        <div class="inp-wrap">
          <span class="inp-icon">👤</span>
          <input type="text" id="login" name="login"
            value="{{ old('login') }}" placeholder="Masukkan username atau NISN">
        </div>
        <div class="info-text">
          <i>ℹ️</i> <span>Admin: gunakan username | Siswa: gunakan NISN 10 digit</span>
        </div>
      </div>

      <div class="fg">
        <label for="password">Password</label>
        <div class="inp-wrap">
          <span class="inp-icon">🔒</span>
          <input type="password" id="password" name="password" placeholder="Masukkan password">
        </div>
      </div>

      <div class="remember">
        <input type="checkbox" id="remember" name="remember" value="1">
        <label for="remember" style="margin:0;font-weight:400;cursor:pointer;">Ingat saya</label>
      </div>

      <button type="submit" class="btn-login">Masuk</button>
    </form>

    <div class="reg-link">
      Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
    </div>

  </div>
</div>

</body>
</html>