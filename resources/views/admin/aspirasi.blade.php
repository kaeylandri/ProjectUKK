@extends('layouts.admin')
@section('title','Aspirasi Masuk')
@section('page-title','Aspirasi Masuk')

@section('content')
<style>
    .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .stat {
        background: #fff;
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .stat-num {
        font-size: 1.75rem;
        font-weight: 700;
        line-height: 1.2;
    }
    .stat-lbl {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 0.25rem;
    }
    .stat.yellow .stat-num { color: #eab308; }
    .stat.blue .stat-num { color: #3b82f6; }
    .stat.green .stat-num { color: #22c55e; }
    .stat.red .stat-num { color: #ef4444; }
    .stat.purple .stat-num { color: #a855f7; }
    
    .filter-container {
        background: #f8fafc;
        padding: 1rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-bottom: 1.5rem;
    }
    .form-control {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    .form-control:focus {
        border-color: #1a4f8a;
        outline: none;
        box-shadow: 0 0 0 3px rgba(26,79,138,0.1);
    }
    .card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .card-head {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    .card-head h2 {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
    }
    .tw {
        overflow-x: auto;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.875rem;
    }
    .table th {
        text-align: left;
        padding: 0.75rem 1rem;
        background: #f8fafc;
        font-weight: 600;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }
    .table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .b-lo { background: #dcfce7; color: #166534; }
    .b-med { background: #fef9c3; color: #854d0e; }
    .b-hi { background: #fee2e2; color: #991b1b; }
    .b-wait { background: #fef3c7; color: #92400e; }
    .b-proc { background: #dbeafe; color: #1e40af; }
    .b-done { background: #dcfce7; color: #166534; }
    .b-rej { background: #fee2e2; color: #991b1b; }
    .btn {
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        border: none;
        text-decoration: none;
        display: inline-block;
    }
    .btn-primary {
        background: #1a4f8a;
        color: #fff;
    }
    .btn-primary:hover {
        background: #163d6e;
    }
    .btn-secondary {
        background: #64748b;
        color: #fff;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.7rem;
    }
    .empty {
        text-align: center;
        padding: 2rem;
        color: #94a3b8;
    }
    .pg-wrap {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        font-size: 0.8rem;
    }
    .pg-wrap nav {
        display: inline-block;
    }
    .pg-wrap .pagination {
        display: flex;
        gap: 0.25rem;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .pg-wrap .pagination li a,
    .pg-wrap .pagination li span {
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        color: #1a4f8a;
        text-decoration: none;
    }
    .pg-wrap .pagination li.active span {
        background: #1a4f8a;
        color: #fff;
    }
    @media (max-width: 768px) {
        .stats {
            grid-template-columns: repeat(2, 1fr);
        }
        .table th, .table td {
            padding: 0.5rem;
        }
    }
</style>

<div class="stats">
    <div class="stat">
        <div class="stat-num">{{ $stats['total'] }}</div>
        <div class="stat-lbl">Total</div>
    </div>
    <div class="stat yellow">
        <div class="stat-num">{{ $stats['menunggu'] }}</div>
        <div class="stat-lbl">Menunggu</div>
    </div>
    <div class="stat blue">
        <div class="stat-num">{{ $stats['diproses'] }}</div>
        <div class="stat-lbl">Diproses</div>
    </div>
    <div class="stat green">
        <div class="stat-num">{{ $stats['selesai'] }}</div>
        <div class="stat-lbl">Selesai</div>
    </div>
    <div class="stat red">
        <div class="stat-num">{{ $stats['ditolak'] }}</div>
        <div class="stat-lbl">Ditolak</div>
    </div>
</div>

<div class="filter-container">
    <form method="GET" action="{{ route('admin.aspirasi') }}" id="filterForm">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:0.75rem;">
            <div>
                <label style="font-size:0.7rem; font-weight:600;">Cari Nama/Kelas</label>
                <input type="text" name="search" placeholder="Nama atau kelas..." value="{{ request('search') }}" class="form-control">
            </div>
            
            <div>
                <label style="font-size:0.7rem; font-weight:600;">NISN</label>
                <input type="text" name="nisn" placeholder="Cari NISN..." value="{{ request('nisn') }}" class="form-control" id="nisnInput">
                <small style="font-size:0.6rem; color:#64748b;">Masukkan sebagian atau seluruh NISN</small>
            </div>
            
            <div>
                <label style="font-size:0.7rem; font-weight:600;">Kategori</label>
                <select name="kategori" class="form-control">
                    <option value="">Semua Kategori</option>
                    @php
                        $defaultKategori = [
                            'Ruang Kelas', 'Laboratorium', 'Perpustakaan', 'Toilet / Kamar Mandi',
                            'Kantin', 'Aula / Gedung Serbaguna', 'Meja & Kursi', 'Papan Tulis',
                            'Proyektor / LCD', 'Komputer', 'AC / Kipas Angin', 'Lapangan Olahraga',
                            'Taman / Lingkungan', 'Parkir', 'Lainnya'
                        ];
                        $kategoriOptions = isset($kategoriList) ? $kategoriList : collect($defaultKategori);
                    @endphp
                    @foreach($kategoriOptions as $kategori)
                    <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                        {{ $kategori }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label style="font-size:0.7rem; font-weight:600;">Status</label>
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            
            <div>
                <label style="font-size:0.7rem; font-weight:600;">Prioritas</label>
                <select name="prioritas" class="form-control">
                    <option value="">Semua Prioritas</option>
                    <option value="tinggi" {{ request('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                    <option value="sedang" {{ request('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="rendah" {{ request('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                </select>
            </div>
            
            <div>
                <label style="font-size:0.7rem; font-weight:600;">Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control" id="tanggalInput" max="{{ date('Y-m-d') }}">
                <small style="font-size:0.6rem; color:#64748b;">Filter berdasarkan tanggal pembuatan</small>
            </div>
            
            <div>
                <label style="font-size:0.7rem; font-weight:600;">Bulan</label>
                <input type="month" name="bulan" value="{{ request('bulan') }}" class="form-control" id="bulanInput" max="{{ date('Y-m') }}">
                <small style="font-size:0.6rem; color:#64748b;">Filter berdasarkan bulan & tahun</small>
            </div>
        </div>
        
        <div style="display:grid; grid-template-columns:1fr 1fr auto; gap:0.75rem; margin-top:0.75rem;">
            <div>
                <label style="font-size:0.7rem; font-weight:600;">Dari Tanggal</label>
                <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal') }}" class="form-control" id="dariTanggalInput">
            </div>
            <div>
                <label style="font-size:0.7rem; font-weight:600;">Sampai Tanggal</label>
                <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal') }}" class="form-control" id="sampaiTanggalInput">
            </div>
            <div style="display:flex; gap:0.5rem; align-items:end;">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.aspirasi') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>
</div>

@if(request('kategori') || request('status') || request('prioritas') || request('search') || request('nisn') || request('tanggal') || request('bulan') || request('dari_tanggal') || request('sampai_tanggal'))
<div style="background: #e0f2fe; padding: 8px 12px; margin-bottom: 15px; border-radius: 8px; font-size: 12px; border-left: 4px solid #0284c7;">
    <strong>🔍 Filter Aktif:</strong>
    @if(request('search')) <span class="badge" style="background:#0284c7; color:white;">Nama/Kelas: {{ request('search') }}</span> @endif
    @if(request('nisn')) <span class="badge" style="background:#0284c7; color:white;">NISN: {{ request('nisn') }}</span> @endif
    @if(request('kategori')) <span class="badge" style="background:#0284c7; color:white;">Kategori: {{ request('kategori') }}</span> @endif
    @if(request('status')) <span class="badge" style="background:#0284c7; color:white;">Status: {{ request('status') }}</span> @endif
    @if(request('prioritas')) <span class="badge" style="background:#0284c7; color:white;">Prioritas: {{ request('prioritas') }}</span> @endif
    @if(request('tanggal')) <span class="badge" style="background:#0284c7; color:white;">Tanggal: {{ request('tanggal') }}</span> @endif
    @if(request('bulan')) <span class="badge" style="background:#0284c7; color:white;">Bulan: {{ request('bulan') }}</span> @endif
    @if(request('dari_tanggal') || request('sampai_tanggal')) 
        <span class="badge" style="background:#0284c7; color:white;">Range: {{ request('dari_tanggal') ?: 'awal' }} s/d {{ request('sampai_tanggal') ?: 'sekarang' }}</span>
    @endif
</div>
@endif

<div class="card">
    <div class="card-head">
        <h2>Daftar Aspirasi
            <span style="font-weight:400; color:#94a3b8; font-size:0.7rem;">({{ $aspirasi->total() }} data)</span>
        </h2>
    </div>
    
    @if($aspirasi->isEmpty())
    <div class="empty">
        <p>Tidak ada data sesuai filter.</p>
    </div>
    @else
    <div class="tw">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Siswa / NISN / Kelas</th>
                    <th>Kategori & Lokasi</th>
                    <th>Foto</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($aspirasi as $idx => $item)
            @php
                $pc = ['rendah'=>'b-lo', 'sedang'=>'b-med', 'tinggi'=>'b-hi'];
                $sc = ['menunggu'=>'b-wait', 'diproses'=>'b-proc', 'selesai'=>'b-done', 'ditolak'=>'b-rej'];
                $fotoUrl = $item->foto ? asset('storage/'.$item->foto) : '';
            @endphp
            <tr>
                <td style="color:#94a3b8; font-size:0.75rem;">{{ $aspirasi->firstItem() + $idx }}</td>
                <td>
                    <div style="font-weight:600; color:#1e293b;">{{ $item->nama_siswa }}</div>
                    <div style="font-size:0.7rem; color:#64748b;">NISN: {{ $item->nisn ?? '-' }}</div>
                    <div style="font-size:0.7rem; color:#94a3b8;">Kelas: {{ $item->kelas }}</div>
                </td>
                <td>
                    <div style="font-weight:500;">{{ $item->kategori_sarana }}</div>
                    <div style="font-size:0.7rem; color:#94a3b8;">{{ Str::limit($item->lokasi, 32) }}</div>
                </td>
                <td>
                    @if($fotoUrl)
                    <img src="{{ $fotoUrl }}"
                         style="width:40px; height:40px; object-fit:cover; border-radius:6px; cursor:pointer;"
                         onclick="bukaFoto('{{ $fotoUrl }}')" title="Klik untuk lihat foto">
                    @else
                    <span style="color:#cbd5e1;">—</span>
                    @endif
                </td>
                <td><span class="badge {{ $pc[$item->prioritas] ?? 'b-med' }}">{{ ucfirst($item->prioritas) }}</span></td>
                <td><span class="badge {{ $sc[$item->status] ?? 'b-wait' }}">{{ ucfirst($item->status) }}</span></td>
                <td style="font-size:0.7rem; color:#64748b; white-space:nowrap;">{{ $item->created_at->format('d/m/Y') }}</td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="bukaModal({{ $item->id }})">
                        Tanggapi
                    </button>
                </td>
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

@include('admin.partials.modal-umpan-balik')
@endsection

@push('scripts')
<script>
const aspirasi = {
    @foreach($aspirasi as $item)
    @php $fu = $item->foto ? asset('storage/'.$item->foto) : ''; @endphp
    {{ $item->id }}: {
        id:        {{ $item->id }},
        nama:      {!! json_encode($item->nama_siswa) !!},
        nisn:      {!! json_encode($item->nisn ?? '-') !!},
        kelas:     {!! json_encode($item->kelas) !!},
        kategori:  {!! json_encode($item->kategori_sarana) !!},
        lokasi:    {!! json_encode($item->lokasi) !!},
        deskripsi: {!! json_encode($item->deskripsi) !!},
        prioritas: {!! json_encode(ucfirst($item->prioritas)) !!},
        status:    {!! json_encode($item->status) !!},
        tanggal:   {!! json_encode($item->created_at->format('d M Y, H:i')) !!},
        umpanBalik:{!! json_encode($item->umpan_balik ?? '') !!},
        petugas:   {!! json_encode($item->petugas ?? '') !!},
        foto:      {!! json_encode($fu) !!}
    },
    @endforeach
};

function bukaFoto(url) {
    window.open(url, '_blank');
}

function bukaModal(id) {
    const data = aspirasi[id];
    if (!data) return;
    
    document.getElementById('modalNama').innerHTML = `<strong>${data.nama}</strong> <span style="font-size:0.75rem; color:#64748b;">(NISN: ${data.nisn})</span>`;
    document.getElementById('modalKelas').innerText = data.kelas;
    document.getElementById('modalKategori').innerText = data.kategori;
    document.getElementById('modalLokasi').innerText = data.lokasi;
    document.getElementById('modalDeskripsi').innerText = data.deskripsi;
    document.getElementById('modalTanggal').innerText = data.tanggal;
    
    let prioritasClass = 'b-med';
    if (data.prioritas === 'Tinggi') prioritasClass = 'b-hi';
    if (data.prioritas === 'Rendah') prioritasClass = 'b-lo';
    document.getElementById('modalPrioritas').innerHTML = `<span class="badge ${prioritasClass}">${data.prioritas}</span>`;
    
    let statusClass = 'b-wait';
    let statusText = 'Menunggu';
    if (data.status === 'diproses') { statusClass = 'b-proc'; statusText = 'Diproses'; }
    else if (data.status === 'selesai') { statusClass = 'b-done'; statusText = 'Selesai'; }
    else if (data.status === 'ditolak') { statusClass = 'b-rej'; statusText = 'Ditolak'; }
    document.getElementById('modalStatus').innerHTML = `<span class="badge ${statusClass}">${statusText}</span>`;
    
    if (data.foto && data.foto !== '') {
        document.getElementById('modalFoto').innerHTML = `<img src="${data.foto}" style="max-width:100%; max-height:200px; border-radius:8px;">`;
    } else {
        document.getElementById('modalFoto').innerHTML = '<span style="color:#94a3b8;">Tidak ada foto</span>';
    }
    
    if (data.umpanBalik && data.umpanBalik !== '') {
        document.getElementById('modalUmpanBalik').innerHTML = `
            <div style="background:#f1f5f9; padding:0.75rem; border-radius:8px;">
                <div style="font-size:0.75rem;">${data.umpanBalik}</div>
                <div style="font-size:0.65rem; color:#94a3b8; margin-top:0.25rem;">Petugas: ${data.petugas || '-'}</div>
            </div>
        `;
    } else {
        document.getElementById('modalUmpanBalik').innerHTML = '<span style="color:#94a3b8;">Belum ada umpan balik</span>';
    }
    
    document.getElementById('aspirasiId').value = id;
    document.getElementById('modalOverlay').style.display = 'flex';
}

function tutupModal() {
    document.getElementById('modalOverlay').style.display = 'none';
}

document.getElementById('modalForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const id = document.getElementById('aspirasiId').value;
    const status = document.getElementById('statusSelect').value;
    const umpanBalik = document.getElementById('umpanBalik').value;
    
    if (!umpanBalik.trim()) {
        alert('Umpan balik wajib diisi!');
        return;
    }
    
    if (umpanBalik.trim().length < 10) {
        alert('Umpan balik minimal 10 karakter!');
        return;
    }
    
    try {
        const response = await fetch(`/admin/aspirasi/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ 
                status: status, 
                umpan_balik: umpanBalik.trim() 
            })
        });
        const result = await response.json();
        if (result.success) {
            alert('Berhasil menyimpan umpan balik!');
            location.reload();
        } else if (result.errors) {
            alert('Gagal: ' + Object.values(result.errors).join(', '));
        } else {
            alert('Gagal: ' + (result.message || 'Terjadi kesalahan'));
        }
    } catch (error) {
        alert('Terjadi kesalahan: ' + error.message);
    }
});

document.getElementById('filterForm')?.addEventListener('submit', function(e) {
    const nisn = document.getElementById('nisnInput')?.value;
    const dariTanggal = document.getElementById('dariTanggalInput')?.value;
    const sampaiTanggal = document.getElementById('sampaiTanggalInput')?.value;
    
    if (nisn && !/^\d*$/.test(nisn)) {
        e.preventDefault();
        alert('NISN harus berupa angka!');
        return false;
    }
    
    if (dariTanggal && sampaiTanggal && dariTanggal > sampaiTanggal) {
        e.preventDefault();
        alert('Tanggal "Dari" tidak boleh lebih besar dari "Sampai"!');
        return false;
    }
});

document.getElementById('filterForm')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        this.submit();
    }
});
</script>
@endpush