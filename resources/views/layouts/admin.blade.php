<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','Admin') — SMKN 4 Bandung</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Inter',sans-serif;background:#f1f5f9;color:#1e293b;min-height:100vh;display:flex;font-size:.9rem;}

/* ── SIDEBAR ── */
.sb{width:220px;background:#1e293b;min-height:100vh;position:fixed;top:0;left:0;
  display:flex;flex-direction:column;z-index:100;}
.sb-brand{padding:1.1rem 1.2rem;border-bottom:1px solid rgba(255,255,255,.07);
  display:flex;align-items:center;gap:.75rem;}
.sb-brand svg{width:28px;height:28px;color:#60a5fa;flex-shrink:0;}
.sb-brand-txt .sn{font-size:.88rem;font-weight:700;color:#f1f5f9;line-height:1.2;}
.sb-brand-txt .ss{font-size:.65rem;color:#94a3b8;margin-top:.1rem;}
.sb-nav{flex:1;padding:.75rem 0;overflow-y:auto;}
.sb-section{font-size:.62rem;font-weight:600;text-transform:uppercase;
  letter-spacing:.08em;color:#475569;padding:.6rem 1.2rem .25rem;}
.sb-link{display:flex;align-items:center;gap:.6rem;padding:.55rem 1.1rem;
  color:#94a3b8;text-decoration:none;font-size:.84rem;font-weight:500;
  margin:.05rem .5rem;border-radius:7px;transition:all .15s;}
.sb-link:hover{background:rgba(255,255,255,.06);color:#e2e8f0;}
.sb-link.active{background:#1a4f8a;color:#fff;}
.sb-link .ic{font-size:.9rem;width:18px;text-align:center;flex-shrink:0;}
.sb-foot{padding:.85rem 1.1rem;border-top:1px solid rgba(255,255,255,.07);}
.sb-user{display:flex;align-items:center;gap:.6rem;margin-bottom:.6rem;}
.sb-avatar{width:32px;height:32px;background:linear-gradient(135deg,#1a4f8a,#1d6fa3);
  border-radius:50%;display:flex;align-items:center;justify-content:center;
  font-size:.75rem;font-weight:700;color:#fff;flex-shrink:0;}
.sb-user-info .un{font-size:.8rem;font-weight:600;color:#e2e8f0;
  white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:130px;}
.sb-user-info .ur{font-size:.65rem;color:#64748b;}
.btn-logout{width:100%;padding:.38rem;background:rgba(239,68,68,.12);
  border:1px solid rgba(239,68,68,.2);color:#fca5a5;border-radius:6px;
  cursor:pointer;font-family:'Inter',sans-serif;font-size:.78rem;font-weight:500;transition:all .2s;}
.btn-logout:hover{background:rgba(239,68,68,.25);color:#fff;}

/* ── MAIN ── */
.main{margin-left:220px;flex:1;display:flex;flex-direction:column;}
.topbar{background:#fff;border-bottom:1px solid #e2e8f0;padding:.75rem 1.75rem;
  display:flex;align-items:center;justify-content:space-between;
  position:sticky;top:0;z-index:50;}
.topbar-title{font-size:1rem;font-weight:700;color:#1e293b;}
.topbar-right{display:flex;align-items:center;gap:.75rem;}
.badge-admin{background:#dbeafe;color:#1d4ed8;padding:.2rem .65rem;
  border-radius:20px;font-size:.7rem;font-weight:600;}
.content{padding:1.5rem 1.75rem;}

/* ── ALERTS ── */
.alert-ok{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;
  border-radius:8px;padding:.65rem .9rem;font-size:.83rem;margin-bottom:1.1rem;
  display:flex;align-items:center;gap:.5rem;}
.alert-er{background:#fef2f2;border:1px solid #fecaca;color:#dc2626;
  border-radius:8px;padding:.65rem .9rem;font-size:.83rem;margin-bottom:1.1rem;
  display:flex;align-items:center;gap:.5rem;}

/* ── STATS ── */
.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));
  gap:.85rem;margin-bottom:1.5rem;}
.stat{background:#fff;border-radius:10px;padding:1rem 1.25rem;
  border:1px solid #e2e8f0;border-top:3px solid #1a4f8a;
  box-shadow:0 1px 3px rgba(0,0,0,.04);}
.stat.yellow{border-top-color:#f59e0b;}
.stat.blue  {border-top-color:#3b82f6;}
.stat.green {border-top-color:#16a34a;}
.stat.red   {border-top-color:#ef4444;}
.stat.purple{border-top-color:#8b5cf6;}
.stat-num{font-size:1.75rem;font-weight:700;color:#1e293b;line-height:1;}
.stat-lbl{font-size:.72rem;color:#94a3b8;margin-top:.25rem;font-weight:500;}

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
.b-admin{background:#dbeafe;color:#1e40af;}
.b-user {background:#f3f4f6;color:#374151;border:1px solid #d1d5db;}
.b-on  {background:#dcfce7;color:#166534;}
.b-off {background:#fee2e2;color:#991b1b;}

/* ── BUTTONS ── */
.btn{display:inline-flex;align-items:center;gap:.35rem;padding:.42rem .85rem;
  border-radius:7px;border:1.5px solid #e2e8f0;font-family:'Inter',sans-serif;
  font-size:.8rem;font-weight:500;cursor:pointer;text-decoration:none;
  background:#fff;color:#475569;transition:all .15s;}
.btn:hover{background:#f8fafc;border-color:#cbd5e1;}
.btn-primary{background:#1a4f8a;color:#fff;border-color:#1a4f8a;}
.btn-primary:hover{background:#163d6e;border-color:#163d6e;}
.btn-success{background:#16a34a;color:#fff;border-color:#16a34a;}
.btn-success:hover{background:#15803d;}
.btn-danger {background:#ef4444;color:#fff;border-color:#ef4444;}
.btn-danger:hover{background:#dc2626;}
.btn-warning{background:#f59e0b;color:#fff;border-color:#f59e0b;}
.btn-warning:hover{background:#d97706;}
.btn-sm{padding:.28rem .65rem;font-size:.75rem;border-radius:6px;}

/* ── FORM ── */
.form-group{margin-bottom:.9rem;}
.form-group label{display:block;font-size:.8rem;font-weight:600;color:#475569;margin-bottom:.35rem;}
.req{color:#ef4444;}
input[type=text],input[type=email],input[type=password],select,textarea{
  width:100%;padding:.6rem .85rem;border:1.5px solid #e2e8f0;border-radius:7px;
  font-family:'Inter',sans-serif;font-size:.875rem;color:#1e293b;background:#f8fafc;
  transition:all .2s;outline:none;}
input:focus,select:focus,textarea:focus{border-color:#1a4f8a;background:#fff;
  box-shadow:0 0 0 3px rgba(26,79,138,.08);}
textarea{resize:vertical;min-height:90px;}
.hint{font-size:.73rem;color:#94a3b8;margin-top:.25rem;}
.err-msg{font-size:.73rem;color:#ef4444;margin-top:.25rem;}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:.85rem;}
@media(max-width:600px){.form-row{grid-template-columns:1fr;}}

/* ── FILTER ── */
.filter-bar{display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:1.1rem;align-items:center;}
.filter-bar input,.filter-bar select{width:auto;padding:.45rem .7rem;font-size:.82rem;}

/* ── PAGINATION ── */
.pg-wrap{display:flex;justify-content:space-between;align-items:center;
  padding:.7rem 1.25rem;border-top:1px solid #f1f5f9;font-size:.78rem;color:#94a3b8;}
.pagination{display:flex;gap:.25rem;list-style:none;}
.pagination .page-link{display:inline-block;padding:.3rem .65rem;border-radius:6px;
  border:1.5px solid #e2e8f0;color:#1a4f8a;text-decoration:none;
  font-size:.75rem;font-weight:500;transition:all .15s;}
.pagination .active .page-link{background:#1a4f8a;color:#fff;border-color:#1a4f8a;}
.pagination .page-link:hover{background:#eff6ff;border-color:#bfdbfe;}

/* ── MODAL ── */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.5);
  z-index:200;align-items:flex-start;justify-content:center;
  padding:2rem 1rem;overflow-y:auto;backdrop-filter:blur(2px);}
.modal-overlay.open{display:flex;}
.modal-box{background:#fff;border-radius:12px;width:100%;max-width:560px;
  margin:auto;box-shadow:0 20px 60px rgba(0,0,0,.15);border:1px solid #e2e8f0;}
.modal-head{padding:.9rem 1.25rem;border-bottom:1px solid #f1f5f9;
  display:flex;justify-content:space-between;align-items:center;}
.modal-head h3{font-size:.95rem;font-weight:700;color:#1e293b;}
.modal-close{background:#f1f5f9;border:none;border-radius:6px;
  cursor:pointer;padding:.28rem .6rem;font-size:.85rem;color:#64748b;transition:background .15s;}
.modal-close:hover{background:#e2e8f0;}
.modal-body{padding:1.25rem;}
.modal-foot{padding:.85rem 1.25rem;border-top:1px solid #f1f5f9;
  display:flex;gap:.5rem;justify-content:flex-end;background:#fafafa;border-radius:0 0 12px 12px;}

/* ── DETAIL ROWS ── */
.detail-table{width:100%;font-size:.83rem;border-collapse:collapse;margin-bottom:.9rem;}
.detail-table tr:nth-child(odd) td:first-child{background:#f8fafc;}
.detail-table td{padding:.4rem .75rem;border:1px solid #f1f5f9;}
.detail-table td:first-child{width:120px;font-weight:600;color:#64748b;
  white-space:nowrap;font-size:.78rem;}
.detail-head td{background:#f1f5f9!important;font-size:.7rem;font-weight:700;
  text-transform:uppercase;letter-spacing:.05em;color:#94a3b8;}

/* ── FOTO ── */
.foto-wrap{border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;margin-bottom:.9rem;}
.foto-head{background:#f8fafc;padding:.4rem .75rem;border-bottom:1px solid #e2e8f0;
  display:flex;justify-content:space-between;align-items:center;}
.foto-head span{font-size:.73rem;font-weight:600;text-transform:uppercase;
  letter-spacing:.04em;color:#475569;}
.foto-head .foto-actions{display:flex;gap:.4rem;}
.foto-body{background:#1e293b;display:flex;align-items:center;
  justify-content:center;min-height:120px;cursor:pointer;padding:.5rem;}
.foto-body img{max-width:100%;max-height:240px;object-fit:contain;
  border-radius:4px;display:block;}
.foto-hint{padding:.28rem .75rem;background:#fafafa;border-top:1px solid #f1f5f9;
  font-size:.68rem;color:#94a3b8;}

/* ── FOTO FULLSCREEN ── */
.foto-fs{display:none;position:fixed;inset:0;background:rgba(0,0,0,.92);
  z-index:500;align-items:center;justify-content:center;flex-direction:column;}
.foto-fs.open{display:flex;}
.foto-fs-ctrl{position:absolute;top:.85rem;right:1rem;display:flex;gap:.5rem;}
.foto-fs img{max-width:92vw;max-height:88vh;object-fit:contain;
  border-radius:6px;box-shadow:0 4px 40px rgba(0,0,0,.5);}
.foto-fs p{color:rgba(255,255,255,.35);font-size:.72rem;margin-top:.6rem;}

/* ── EMPTY ── */
.empty{text-align:center;padding:3rem;color:#94a3b8;}
.empty p{font-size:.88rem;}
</style>
@stack('styles')
</head>
<body>

<aside class="sb">
  <div class="sb-brand">
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
    <div class="sb-brand-txt">
      <div class="sn">SMKN 4 Bandung</div>
      <div class="ss">Panel Administrator</div>
    </div>
  </div>

  <nav class="sb-nav">
    <div class="sb-section">Menu</div>
    <a href="{{ route('admin.dashboard') }}" class="sb-link {{ request()->routeIs('admin.dashboard')?'active':'' }}">
      <span class="ic">&#128202;</span> Dashboard
    </a>
    <a href="{{ route('admin.aspirasi') }}" class="sb-link {{ request()->routeIs('admin.aspirasi')?'active':'' }}">
      <span class="ic">&#128203;</span> Aspirasi Masuk
    </a>
    <div class="sb-section">Manajemen</div>
    <a href="{{ route('admin.users') }}" class="sb-link {{ request()->routeIs('admin.users*')?'active':'' }}">
      <span class="ic">&#128101;</span> Kelola User
    </a>
  </nav>

  <div class="sb-foot">
    <div class="sb-user">
      <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
      <div class="sb-user-info">
        <div class="un">{{ auth()->user()->name }}</div>
        <div class="ur">Administrator</div>
      </div>
    </div>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="btn-logout">&#x2192; Keluar</button>
    </form>
  </div>
</aside>

<div class="main">
  <header class="topbar">
    <div class="topbar-title">@yield('page-title','Dashboard')</div>
    <div class="topbar-right">
      <span style="font-size:.82rem;color:#64748b;">{{ auth()->user()->name }}</span>
      <span class="badge-admin">Admin</span>
    </div>
  </header>

  <div class="content">
    @if(session('success'))
    <div class="alert-ok">&#10003; {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert-er">&#9888; {{ session('error') }}</div>
    @endif
    @yield('content')
  </div>
</div>

@stack('scripts')
</body>
</html>
