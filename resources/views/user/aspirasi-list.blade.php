@extends('layouts.user')
@section('title','Riwayat Pengaduan')

@section('content')
<div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:.75rem;margin-bottom:1.25rem;">
    <div class="page-header" style="margin:0;">
        <h1>Riwayat Pengaduan Saya</h1>
        <p>Semua pengaduan yang pernah Anda kirimkan.</p>
    </div>
    <a href="{{ route('user.aspirasi.create') }}" class="btn btn-primary btn-sm">+ Buat Pengaduan</a>
</div>

<form method="GET" action="{{ route('user.aspirasi.list') }}" style="margin-bottom:1rem;">
    <select name="status" onchange="this.form.submit()"
            style="padding:.45rem .7rem;border:1.5px solid #e2e8f0;border-radius:7px;
                   font-family:'Inter',sans-serif;font-size:.83rem;background:#f8fafc;
                   color:#1e293b;outline:none;cursor:pointer;">
        <option value="">Semua Status</option>
        <option value="menunggu" {{ request('status')=='menunggu'?'selected':'' }}>Menunggu</option>
        <option value="diproses" {{ request('status')=='diproses'?'selected':'' }}>Diproses</option>
        <option value="selesai"  {{ request('status')=='selesai' ?'selected':'' }}>Selesai</option>
        <option value="ditolak"  {{ request('status')=='ditolak' ?'selected':'' }}>Ditolak</option>
    </select>
</form>

<div class="card">
    @if($aspirasi->isEmpty())
    <div class="empty">
        <p style="margin-bottom:.85rem;">Belum ada pengaduan.</p>
        <a href="{{ route('user.aspirasi.create') }}" class="btn btn-primary btn-sm">Buat Sekarang</a>
    </div>
    @else
    <div class="tw">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kategori Sarana</th>
                    <th>Lokasi</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($aspirasi as $idx => $item)
            @php
                $pc = ['rendah'=>'b-lo','sedang'=>'b-med','tinggi'=>'b-hi'];
                $sc = ['menunggu'=>'b-wait','diproses'=>'b-proc','selesai'=>'b-done','ditolak'=>'b-rej'];
            @endphp
            <tr>
                <td style="color:#cbd5e1;font-size:.75rem;">{{ $aspirasi->firstItem()+$idx }}</td>
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
    @if($aspirasi->hasPages())
    <div class="pg-wrap">
        <span>Menampilkan {{ $aspirasi->firstItem() }}&ndash;{{ $aspirasi->lastItem() }} dari {{ $aspirasi->total() }} data</span>
        {{ $aspirasi->appends(request()->query())->links() }}
    </div>
    @endif
    @endif
</div>
@endsection
