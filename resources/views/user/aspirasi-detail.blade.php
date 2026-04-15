@extends('layouts.user')
@section('title','Detail Pengaduan')

@section('content')
<div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem;">
    <a href="{{ route('user.aspirasi.list') }}" class="btn btn-sm">&#8592; Kembali</a>
    <div>
        <div class="page-header" style="margin:0;">
            <h1>Detail Pengaduan</h1>
        </div>
    </div>
</div>

@php
    $pc = ['rendah'=>'b-lo','sedang'=>'b-med','tinggi'=>'b-hi'];
    $sc = ['menunggu'=>'b-wait','diproses'=>'b-proc','selesai'=>'b-done','ditolak'=>'b-rej'];
@endphp

<div class="detail-grid">

    {{-- Kolom kiri --}}
    <div>
        <div class="card" style="margin-bottom:1rem;">
            <div class="card-head"><h2>Informasi Pengaduan</h2></div>
            <div class="card-body" style="padding-top:.75rem;padding-bottom:.75rem;">
                <div class="detail-row"><div class="detail-label">Nama Pelapor</div><div style="font-weight:600;">{{ $aspirasi->nama_siswa }}</div></div>
                <div class="detail-row"><div class="detail-label">Kelas</div><div>{{ $aspirasi->kelas }}</div></div>
                <div class="detail-row"><div class="detail-label">Kategori Sarana</div><div style="font-weight:600;">{{ $aspirasi->kategori_sarana }}</div></div>
                <div class="detail-row"><div class="detail-label">Lokasi</div><div>{{ $aspirasi->lokasi }}</div></div>
                <div class="detail-row">
                    <div class="detail-label">Prioritas</div>
                    <div><span class="badge {{ $pc[$aspirasi->prioritas]??'' }}">{{ $aspirasi->prioritas_label }}</span></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Status</div>
                    <div><span class="badge {{ $sc[$aspirasi->status]??'b-wait' }}">{{ $aspirasi->status_label }}</span></div>
                </div>
                <div class="detail-row"><div class="detail-label">Tanggal Kirim</div><div>{{ $aspirasi->created_at->format('d M Y, H:i') }}</div></div>
            </div>
        </div>

        @if($aspirasi->foto_url)
        <div class="card">
            <div class="card-head"><h2>&#128247; Foto Bukti</h2></div>
            <div class="card-body" style="padding:.75rem;">
                <img src="{{ $aspirasi->foto_url }}" alt="Foto Bukti"
                     style="width:100%;max-height:220px;object-fit:cover;border-radius:7px;
                            cursor:pointer;display:block;border:1px solid #e2e8f0;"
                     onclick="document.getElementById('fotoModal').style.display='flex'"
                     title="Klik untuk perbesar">
                <p style="font-size:.72rem;color:#94a3b8;margin-top:.4rem;text-align:center;">
                    Klik foto untuk memperbesar
                </p>
            </div>
        </div>
        @endif
    </div>

    {{-- Kolom kanan --}}
    <div>
        <div class="card" style="margin-bottom:1rem;">
            <div class="card-head"><h2>Deskripsi Masalah</h2></div>
            <div class="card-body">
                <p style="font-size:.88rem;line-height:1.75;white-space:pre-wrap;color:#334155;">{{ $aspirasi->deskripsi }}</p>
            </div>
        </div>

        @if($aspirasi->umpan_balik)
        <div class="card">
            <div class="card-head" style="background:#f0fdf4;border-bottom-color:#bbf7d0;">
                <h2 style="color:#166534;">&#10003; Umpan Balik Petugas</h2>
            </div>
            <div class="card-body">
                <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:.75rem;
                            padding-bottom:.75rem;border-bottom:1px solid #f1f5f9;">
                    <div style="width:32px;height:32px;background:#dcfce7;border-radius:50%;
                                display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0;">
                        &#128119;
                    </div>
                    <div>
                        <div style="font-weight:600;font-size:.88rem;">{{ $aspirasi->petugas }}</div>
                        <div style="font-size:.75rem;color:#94a3b8;">{{ $aspirasi->tanggal_umpan_balik?->format('d M Y, H:i') }}</div>
                    </div>
                </div>
                <p style="font-size:.88rem;line-height:1.75;white-space:pre-wrap;color:#334155;">{{ $aspirasi->umpan_balik }}</p>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-body" style="text-align:center;padding:2.5rem;">
                <div style="font-size:2rem;margin-bottom:.5rem;opacity:.3;">&#9203;</div>
                <div style="font-weight:600;color:#475569;margin-bottom:.3rem;">Menunggu Respons</div>
                <div style="font-size:.83rem;color:#94a3b8;">Pengaduan sedang dalam proses review oleh petugas.</div>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Modal foto fullscreen --}}
@if($aspirasi->foto_url)
<div id="fotoModal"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.9);
            z-index:300;align-items:center;justify-content:center;flex-direction:column;"
     onclick="this.style.display='none'">
    <img src="{{ $aspirasi->foto_url }}" alt="Foto"
         style="max-width:92vw;max-height:88vh;object-fit:contain;border-radius:6px;
                box-shadow:0 4px 40px rgba(0,0,0,.5);"
         onclick="event.stopPropagation()">
    <button onclick="document.getElementById('fotoModal').style.display='none'"
            style="position:absolute;top:.85rem;right:1rem;background:rgba(255,255,255,.12);
                   color:#fff;border:1px solid rgba(255,255,255,.2);border-radius:6px;
                   padding:.3rem .75rem;font-size:.82rem;cursor:pointer;font-family:'Inter',sans-serif;">
        &#x2715; Tutup
    </button>
    <p style="color:rgba(255,255,255,.35);font-size:.72rem;margin-top:.6rem;">Klik di luar foto untuk menutup</p>
</div>
@endif

@endsection
