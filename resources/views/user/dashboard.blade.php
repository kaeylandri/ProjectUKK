@extends('layouts.user')
@section('title','Dashboard')

@section('content')


<div class="welcome-banner">
    <div class="wb-left">
        <h2>Halo, {{ auth()->user()->name }} &#128075;</h2>
        <p>Kelas {{ auth()->user()->kelas ?? '-' }} &mdash; Sampaikan aspirasi dan pengaduan sarana sekolah di sini.</p>
    </div>
    <div class="wb-right">
        <a href="{{ route('user.aspirasi.create') }}" class="wb-btn wb-btn-primary">+ Buat Pengaduan</a>
        <a href="{{ route('user.aspirasi.list') }}"   class="wb-btn wb-btn-outline">Riwayat Saya</a>
    </div>
</div>


<div class="stats">
    <div class="stat">        <div class="stat-num">{{ $stats['total'] }}</div>  <div class="stat-lbl">Total Pengaduan</div></div>
    <div class="stat yellow"> <div class="stat-num">{{ $stats['menunggu'] }}</div><div class="stat-lbl">Menunggu</div></div>
    <div class="stat blue">   <div class="stat-num">{{ $stats['diproses'] }}</div><div class="stat-lbl">Diproses</div></div>
    <div class="stat green">  <div class="stat-num">{{ $stats['selesai'] }}</div> <div class="stat-lbl">Selesai</div></div>
</div>


<div class="card">
    <div class="card-head">
        <h2>Pengaduan Terbaru Saya</h2>
        <a href="{{ route('user.aspirasi.list') }}" class="btn btn-sm">Lihat Semua &#8594;</a>
    </div>
    @if($recentAspirasi->isEmpty())
    <div class="empty">
        <p style="margin-bottom:.85rem;">Anda belum pernah mengirimkan pengaduan.</p>
        <a href="{{ route('user.aspirasi.create') }}" class="btn btn-primary btn-sm">+ Buat Pengaduan Pertama</a>
    </div>
    @else
    <div class="tw">
        <table>
            <thead>
                <tr>
                    <th>Kategori Sarana</th>
                    <th>Lokasi</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($recentAspirasi as $item)
            @php
                $pc = ['rendah'=>'b-lo','sedang'=>'b-med','tinggi'=>'b-hi'];
                $sc = ['menunggu'=>'b-wait','diproses'=>'b-proc','selesai'=>'b-done','ditolak'=>'b-rej'];
            @endphp
            <tr>
                <td style="font-weight:600;">{{ $item->kategori_sarana }}</td>
                <td style="font-size:.8rem;color:#64748b;">{{ Str::limit($item->lokasi,30) }}</td>
                <td><span class="badge {{ $pc[$item->prioritas]??'' }}">{{ $item->prioritas_label }}</span></td>
                <td><span class="badge {{ $sc[$item->status]??'b-wait' }}">{{ $item->status_label }}</span></td>
                <td style="font-size:.78rem;color:#64748b;white-space:nowrap;">{{ $item->created_at->format('d/m/Y') }}</td>
                <td><a href="{{ route('user.aspirasi.show',$item) }}" class="btn btn-sm">Detail</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
