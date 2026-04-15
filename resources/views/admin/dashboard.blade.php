@extends('layouts.admin')
@section('title','Dashboard')
@section('page-title','Dashboard Admin')

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
    .stat.orange .stat-num { color: #f97316; }
    .stat.teal .stat-num { color: #14b8a6; }
    
    .chart-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .chart-card {
        background: #fff;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .chart-title {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #1e293b;
        border-left: 3px solid #1a4f8a;
        padding-left: 0.75rem;
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
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.7rem;
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
    .empty {
        text-align: center;
        padding: 2rem;
        color: #94a3b8;
    }
    canvas {
        max-height: 300px;
        width: 100%;
    }
    @media (max-width: 768px) {
        .stats {
            grid-template-columns: repeat(2, 1fr);
        }
        .chart-container {
            grid-template-columns: 1fr;
        }
        .table th, .table td {
            padding: 0.5rem;
        }
    }
</style>

<div class="stats">
    <div class="stat">
        <div class="stat-num">{{ $stats['total'] }}</div>
        <div class="stat-lbl">Total Aspirasi</div>
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
    <div class="stat purple">
        <div class="stat-num">{{ $stats['users'] }}</div>
        <div class="stat-lbl">Total Siswa</div>
    </div>
</div>

<div class="chart-container">
    <div class="chart-card">
        <div class="chart-title">📊 Status Aspirasi</div>
        <canvas id="statusChart"></canvas>
    </div>
    <div class="chart-card">
        <div class="chart-title">⚡ Prioritas Aspirasi</div>
        <canvas id="prioritasChart"></canvas>
    </div>
    <div class="chart-card">
        <div class="chart-title">📈 Aspirasi per Bulan ({{ date('Y') }})</div>
        <canvas id="monthlyChart"></canvas>
    </div>
    <div class="chart-card">
        <div class="chart-title">🏷️ Top 5 Kategori Aspirasi</div>
        <canvas id="kategoriChart"></canvas>
    </div>
</div>

<div class="card">
    <div class="card-head">
        <h2>Aspirasi Terbaru</h2>
        <a href="{{ route('admin.aspirasi') }}" class="btn btn-primary btn-sm">Lihat Semua →</a>
    </div>
    @if($recentAspirasi->isEmpty())
    <div class="empty">
        <p>Belum ada aspirasi masuk.</p>
    </div>
    @else
    <div class="tw">
        <table class="table">
            <thead>
                <tr>
                    <th>Siswa / Kelas</th>
                    <th>Kategori</th>
                    <th>Foto</th>
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
                $fotoUrl = $item->foto ? asset('storage/'.$item->foto) : '';
            @endphp
            <tr>
                <td>
                    <div style="font-weight:600;color:#1e293b;">{{ $item->nama_siswa }}</div>
                    <div style="font-size:.75rem;color:#94a3b8;">{{ $item->kelas }}</div>
                </td>
                <td>{{ $item->kategori_sarana }}</td>
                <td>
                    @if($fotoUrl)
                    <img src="{{ $fotoUrl }}"
                         style="width:52px;height:40px;object-fit:cover;border:1px solid #e2e8f0;border-radius:6px;cursor:pointer;display:block;"
                         onclick="bukaFoto('{{ $fotoUrl }}')" title="Klik untuk lihat foto">
                    @else
                    <span style="color:#cbd5e1;font-size:.78rem;">—</span>
                    @endif
                </td>
                <td><span class="badge {{ $pc[$item->prioritas] ?? 'b-med' }}">{{ ucfirst($item->prioritas) }}</span></td>
                <td><span class="badge {{ $sc[$item->status] ?? 'b-wait' }}">{{ ucfirst($item->status) }}</span></td>
                <td style="font-size:.78rem;color:#64748b;white-space:nowrap;">{{ $item->created_at->format('d/m/Y') }}</td>
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
    @endif
</div>

@include('admin.partials.modal-umpan-balik')
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const aspirasi = {
    @foreach($recentAspirasi as $item)
    @php $fu = $item->foto ? asset('storage/'.$item->foto) : ''; @endphp
    {{ $item->id }}: {
        id:        {{ $item->id }},
        nama:      {!! json_encode($item->nama_siswa) !!},
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

@php
    $statusMenunggu = $stats['menunggu'] ?? 0;
    $statusDiproses = $stats['diproses'] ?? 0;
    $statusSelesai = $stats['selesai'] ?? 0;
    $statusDitolak = $stats['ditolak'] ?? 0;
@endphp

const dashboardData = {
    aspirasi_by_status: {
        menunggu: {{ $statusMenunggu }},
        diproses: {{ $statusDiproses }},
        selesai: {{ $statusSelesai }},
        ditolak: {{ $statusDitolak }}
    },
    aspirasi_by_prioritas: {
        rendah: {{ $prioritasRendah ?? 0 }},
        sedang: {{ $prioritasSedang ?? 0 }},
        tinggi: {{ $prioritasTinggi ?? 0 }}
    }
};

const monthlyData = @json($monthlyChartData ?? array_fill(0, 12, 0));
const kategoriLabels = @json($kategoriLabels ?? []);
const kategoriData = @json($kategoriData ?? []);

document.addEventListener('DOMContentLoaded', function() {
    const statusCtx = document.getElementById('statusChart')?.getContext('2d');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'],
                datasets: [{
                    data: [
                        dashboardData.aspirasi_by_status.menunggu,
                        dashboardData.aspirasi_by_status.diproses,
                        dashboardData.aspirasi_by_status.selesai,
                        dashboardData.aspirasi_by_status.ditolak
                    ],
                    backgroundColor: ['#eab308', '#3b82f6', '#22c55e', '#ef4444'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    const prioritasCtx = document.getElementById('prioritasChart')?.getContext('2d');
    if (prioritasCtx) {
        new Chart(prioritasCtx, {
            type: 'pie',
            data: {
                labels: ['Rendah', 'Sedang', 'Tinggi'],
                datasets: [{
                    data: [
                        dashboardData.aspirasi_by_prioritas.rendah,
                        dashboardData.aspirasi_by_prioritas.sedang,
                        dashboardData.aspirasi_by_prioritas.tinggi
                    ],
                    backgroundColor: ['#22c55e', '#eab308', '#ef4444'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    const monthlyCtx = document.getElementById('monthlyChart')?.getContext('2d');
    if (monthlyCtx) {
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Aspirasi',
                    data: monthlyData,
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderColor: '#3b82f6',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    }

    const kategoriCtx = document.getElementById('kategoriChart')?.getContext('2d');
    if (kategoriCtx && kategoriLabels.length > 0) {
        new Chart(kategoriCtx, {
            type: 'bar',
            data: {
                labels: kategoriLabels,
                datasets: [{
                    label: 'Jumlah Aspirasi',
                    data: kategoriData,
                    backgroundColor: '#8b5cf6',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    }
});

function bukaFoto(url) {
    window.open(url, '_blank');
}

function bukaModal(id) {
    const data = aspirasi[id];
    if (!data) return;
    
    document.getElementById('modalNama').innerHTML = `<strong>${data.nama}</strong>`;
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
</script>
@include('admin.partials.modal-js')
@endpush