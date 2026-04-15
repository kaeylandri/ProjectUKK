<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Siswa') — SMKN 4 Bandung</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Inter',sans-serif;background:#f1f5f9;color:#1e293b;font-size:.9rem;}

/* ── NAVBAR ── */
.navbar{background:#1e293b;height:54px;display:flex;align-items:center;
  justify-content:space-between;padding:0 1.75rem;
  box-shadow:0 2px 8px rgba(0,0,0,.15);position:sticky;top:0;z-index:100;}
.nav-brand{display:flex;align-items:center;gap:.65rem;text-decoration:none;}
.nav-brand svg{width:26px;height:26px;color:#60a5fa;flex-shrink:0;}
.nav-brand span{color:#f1f5f9;font-size:.88rem;font-weight:700;}
.nav-links{display:flex;gap:.1rem;}
.nav-links a{color:#94a3b8;text-decoration:none;font-size:.82rem;font-weight:500;
  padding:.38rem .75rem;border-radius:6px;transition:all .15s;}
.nav-links a:hover{background:rgba(255,255,255,.07);color:#e2e8f0;}
.nav-links a.active{background:#1a4f8a;color:#fff;}
.nav-right{display:flex;align-items:center;gap:.65rem;}
.nav-user{font-size:.8rem;color:#94a3b8;}
.nav-user strong{color:#e2e8f0;}
.btn-logout{background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);
  color:#94a3b8;border-radius:6px;padding:.28rem .65rem;cursor:pointer;
  font-family:'Inter',sans-serif;font-size:.76rem;transition:all .15s;}
.btn-logout:hover{background:rgba(239,68,68,.2);color:#fca5a5;border-color:rgba(239,68,68,.3);}

/* ── CONTAINER ── */
.container{max-width:980px;margin:0 auto;padding:1.5rem;}

/* ── PAGE HEADER ── */
.page-header{margin-bottom:1.4rem;}
.page-header h1{font-size:1.2rem;font-weight:700;color:#1e293b;}
.page-header p{font-size:.82rem;color:#64748b;margin-top:.2rem;}

/* ── WELCOME BANNER ── */
.welcome-banner{background:linear-gradient(135deg,#1e3a5f,#1a4f8a);
  border-radius:12px;padding:1.5rem 1.75rem;margin-bottom:1.5rem;
  display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;}
.wb-left h2{font-size:1.1rem;font-weight:700;color:#fff;margin-bottom:.3rem;}
.wb-left p{font-size:.82rem;color:rgba(255,255,255,.72);}
.wb-right{display:flex;gap:.6rem;flex-wrap:wrap;}
.wb-btn{padding:.5rem 1rem;border-radius:7px;font-family:'Inter',sans-serif;
  font-size:.82rem;font-weight:600;text-decoration:none;cursor:pointer;
  border:none;transition:all .15s;display:inline-flex;align-items:center;gap:.35rem;}
.wb-btn-primary{background:#fff;color:#1a4f8a;}
.wb-btn-primary:hover{background:#eff6ff;}
.wb-btn-outline{background:rgba(255,255,255,.12);color:#fff;border:1px solid rgba(255,255,255,.25);}
.wb-btn-outline:hover{background:rgba(255,255,255,.2);}

/* ── ALERTS ── */
.alert-ok{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;
  border-radius:8px;padding:.65rem .9rem;font-size:.83rem;margin-bottom:1.1rem;
  display:flex;align-items:center;gap:.5rem;}
.alert-er{background:#fef2f2;border:1px solid #fecaca;color:#dc2626;
  border-radius:8px;padding:.65rem .9rem;font-size:.83rem;margin-bottom:1.1rem;
  display:flex;align-items:center;gap:.5rem;}

/* ── STATS ── */
.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));
  gap:.85rem;margin-bottom:1.5rem;}
.stat{background:#fff;border-radius:10px;padding:.95rem 1.1rem;
  border:1px solid #e2e8f0;border-top:3px solid #1a4f8a;
  box-shadow:0 1px 3px rgba(0,0,0,.04);}
.stat.yellow{border-top-color:#f59e0b;}
.stat.blue  {border-top-color:#3b82f6;}
.stat.green {border-top-color:#16a34a;}
.stat-num{font-size:1.65rem;font-weight:700;color:#1e293b;line-height:1;}
.stat-lbl{font-size:.72rem;color:#94a3b8;margin-top:.2rem;font-weight:500;}

/* ── CARD ── */
.card{background:#fff;border-radius:10px;border:1px solid #e2e8f0;
  overflow:hidden;margin-bottom:1.25rem;box-shadow:0 1px 3px rgba(0,0,0,.04);}
.card-head{padding:.8rem 1.25rem;border-bottom:1px solid #f1f5f9;
  display:flex;align-items:center;justify-content:space-between;background:#fafafa;}
.card-head h2{font-size:.9rem;font-weight:700;color:#334155;}
.card-body{padding:1.25rem;}

/* ── TABLE ── */
.tw{overflow-x:auto;}
table{width:100%;border-collapse:collapse;font-size:.83rem;}
thead th{background:#f8fafc;padding:.6rem .9rem;text-align:left;font-size:.72rem;
  font-weight:600;text-transform:uppercase;letter-spacing:.04em;
  color:#64748b;border-bottom:1px solid #e2e8f0;}
tbody td{padding:.7rem .9rem;border-bottom:1px solid #f8fafc;vertical-align:middle;}
tbody tr:hover{background:#f8fafc;}
tbody tr:last-child td{border-bottom:none;}

/* ── BADGES ── */
.badge{display:inline-flex;align-items:center;gap:.3rem;padding:.22rem .65rem;
  border-radius:20px;font-size:.72rem;font-weight:600;}
.b-wait{background:#fef3c7;color:#92400e;}
.b-proc{background:#dbeafe;color:#1e40af;}
.b-done{background:#dcfce7;color:#166534;}
.b-rej {background:#fee2e2;color:#991b1b;}
.b-hi  {background:#fee2e2;color:#991b1b;}
.b-med {background:#fef3c7;color:#92400e;}
.b-lo  {background:#dcfce7;color:#166534;}

/* ── BUTTONS ── */
.btn{display:inline-flex;align-items:center;gap:.35rem;padding:.42rem .85rem;
  border-radius:7px;border:1.5px solid #e2e8f0;font-family:'Inter',sans-serif;
  font-size:.8rem;font-weight:500;cursor:pointer;text-decoration:none;
  background:#fff;color:#475569;transition:all .15s;}
.btn:hover{background:#f8fafc;border-color:#cbd5e1;}
.btn-primary{background:#1a4f8a;color:#fff;border-color:#1a4f8a;}
.btn-primary:hover{background:#163d6e;border-color:#163d6e;color:#fff;}
.btn-sm{padding:.28rem .65rem;font-size:.75rem;border-radius:6px;}

/* ── FORM ── */
.form-group{margin-bottom:.9rem;}
.form-group label{display:block;font-size:.8rem;font-weight:600;color:#475569;margin-bottom:.35rem;}
.req{color:#ef4444;}
input[type=text],select,textarea,input[type=file]{
  width:100%;padding:.6rem .85rem;border:1.5px solid #e2e8f0;border-radius:7px;
  font-family:'Inter',sans-serif;font-size:.875rem;color:#1e293b;background:#f8fafc;
  transition:all .2s;outline:none;}
input:focus,select:focus,textarea:focus{border-color:#1a4f8a;background:#fff;
  box-shadow:0 0 0 3px rgba(26,79,138,.08);}
textarea{resize:vertical;min-height:105px;}
input[type=file]{padding:.45rem .7rem;cursor:pointer;}
.err-msg{font-size:.73rem;color:#ef4444;margin-top:.25rem;}
.hint{font-size:.73rem;color:#94a3b8;margin-top:.25rem;}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:.85rem;}
@media(max-width:600px){.form-row{grid-template-columns:1fr;}}
.section-label{font-size:.73rem;font-weight:600;text-transform:uppercase;
  letter-spacing:.05em;color:#94a3b8;margin:.25rem 0 .75rem;
  padding-bottom:.45rem;border-bottom:1px solid #f1f5f9;}

/* ── PRIORITAS ── */
.pri-group{display:flex;gap:.65rem;flex-wrap:wrap;}
.pri-label{flex:1;min-width:130px;cursor:pointer;}
.pri-label input[type=radio]{display:none;}
.pri-box{border:1.5px solid #e2e8f0;border-radius:8px;padding:.65rem .8rem;
  background:#f8fafc;transition:all .15s;}
.pri-box:hover{border-color:#bfdbfe;background:#eff6ff;}
.pri-label input:checked + .pri-box{border-color:#1a4f8a;background:#eff6ff;}
.pri-box .pi{font-size:1.1rem;margin-bottom:.2rem;}
.pri-box .pt{font-weight:600;font-size:.83rem;color:#1e293b;}
.pri-box .pd{font-size:.7rem;color:#94a3b8;margin-top:.1rem;}

/* ── FOTO PREVIEW ── */
.foto-preview{margin-top:.5rem;display:none;}
.foto-preview img{max-width:180px;max-height:130px;border:1px solid #e2e8f0;
  border-radius:6px;display:block;}

/* ── DETAIL ── */
.detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
@media(max-width:640px){.detail-grid{grid-template-columns:1fr!important;}}
.detail-row{display:flex;padding:.5rem 0;border-bottom:1px solid #f8fafc;font-size:.84rem;}
.detail-row:last-child{border-bottom:none;}
.detail-label{width:145px;flex-shrink:0;color:#64748b;font-weight:600;font-size:.78rem;}

/* ── PAGINATION ── */
.pg-wrap{display:flex;justify-content:space-between;align-items:center;
  padding:.7rem 1.25rem;border-top:1px solid #f1f5f9;font-size:.78rem;color:#94a3b8;}
.pagination{display:flex;gap:.25rem;list-style:none;}
.pagination .page-link{display:inline-block;padding:.3rem .65rem;border-radius:6px;
  border:1.5px solid #e2e8f0;color:#1a4f8a;text-decoration:none;
  font-size:.75rem;font-weight:500;}
.pagination .active .page-link{background:#1a4f8a;color:#fff;border-color:#1a4f8a;}

/* ── EMPTY ── */
.empty{text-align:center;padding:3rem;color:#94a3b8;}
.empty p{font-size:.88rem;}

/* ── FOOTER ── */
.footer{text-align:center;padding:.9rem;font-size:.73rem;color:#94a3b8;
  border-top:1px solid #e2e8f0;background:#fff;margin-top:1.5rem;}
</style>
@stack('styles')
</head>
<body>

<nav class="navbar">
  <a href="{{ route('user.dashboard') }}" class="nav-brand">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="currentColor">
      <rect x="8" y="28" width="48" height="28" rx="2"/>
      <polygon points="4,29 32,8 60,29"/>
      <rect x="27" y="3" width="10" height="9" rx="1"/>
      <rect x="27" y="41" width="10" height="15" rx="1" fill="rgba(255,255,255,.9)"/>
      <rect x="12" y="33" width="8" height="7" rx="1" fill="rgba(255,255,255,.6)"/>
      <rect x="44" y="33" width="8" height="7" rx="1" fill="rgba(255,255,255,.6)"/>
      <rect x="12" y="44" width="8" height="7" rx="1" fill="rgba(255,255,255,.6)"/>
      <rect x="44" y="44" width="8" height="7" rx="1" fill="rgba(255,255,255,.6)"/>
    </svg>
    <span>SMKN 4 Bandung</span>
  </a>
  <div class="nav-links">
    <a href="{{ route('user.dashboard') }}"      class="{{ request()->routeIs('user.dashboard')?'active':'' }}">Dashboard</a>
    <a href="{{ route('user.aspirasi.create') }}" class="{{ request()->routeIs('user.aspirasi.create')?'active':'' }}">Buat Pengaduan</a>
    <a href="{{ route('user.aspirasi.list') }}"   class="{{ request()->routeIs('user.aspirasi.list')?'active':'' }}">Riwayat Saya</a>
  </div>
  <div class="nav-right">
    <div class="nav-user"><strong>{{ auth()->user()->name }}</strong></div>
    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
      @csrf
      <button type="submit" class="btn-logout">Keluar</button>
    </form>
  </div>
</nav>

<div class="container">
  @if(session('success'))
  <div class="alert-ok">&#10003; {{ session('success') }}</div>
  @endif
  @if(session('error'))
  <div class="alert-er">&#9888; {{ session('error') }}</div>
  @endif
  @yield('content')
</div>

<div class="footer">&copy; {{ date('Y') }} Sistem Pengaduan Sarana &middot; SMKN 4 Bandung</div>

@stack('scripts')
</body>
</html>
