@extends('layouts.admin')
@section('title','Kelola User')
@section('page-title','Kelola User')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.75rem;margin-bottom:1.1rem;">
    <form method="GET" action="{{ route('admin.users') }}" class="filter-bar" style="margin:0;">
        <input type="text" name="search" placeholder="Cari nama, username..." value="{{ request('search') }}" style="min-width:180px;">
        <select name="role">
            <option value="">Semua Role</option>
            <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
            <option value="user"  {{ request('role')=='user' ?'selected':'' }}>Siswa</option>
        </select>
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        @if(request()->anyFilled(['search','role']))
        <a href="{{ route('admin.users') }}" class="btn btn-sm">&#x2715; Reset</a>
        @endif
    </form>
    <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm">+ Tambah User</a>
</div>

<div class="card">
    <div class="card-head">
        <h2>Daftar User
            <span style="font-weight:400;color:#94a3b8;font-size:.78rem;">({{ $users->total() }} data)</span>
        </h2>
    </div>
    @if($users->isEmpty())
    <div class="empty"><p>Belum ada user.</p></div>
    @else
    <div class="tw">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama / Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $idx => $user)
            <tr>
                <td style="color:#cbd5e1;font-size:.75rem;">{{ $users->firstItem()+$idx }}</td>
                <td>
                    <div style="font-weight:600;color:#1e293b;">{{ $user->name }}</div>
                    <div style="font-size:.75rem;color:#94a3b8;">@{{ $user->username }}</div>
                </td>
                <td style="font-size:.82rem;color:#475569;">{{ $user->email }}</td>
                <td>
                    @if($user->role === 'admin')
                    <span class="badge b-admin">Admin</span>
                    @else
                    <span class="badge b-user">Siswa</span>
                    @endif
                </td>
                <td style="font-size:.82rem;color:#64748b;">{{ $user->kelas ?? '—' }}</td>
                <td>
                    @if($user->is_active)
                    <span class="badge b-on">Aktif</span>
                    @else
                    <span class="badge b-off">Nonaktif</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex;gap:.4rem;flex-wrap:wrap;">
                        <a href="{{ route('admin.users.edit',$user) }}" class="btn btn-warning btn-sm">Edit</a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.delete',$user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="pg-wrap">
        <span>Menampilkan {{ $users->firstItem() }}&ndash;{{ $users->lastItem() }} dari {{ $users->total() }} data</span>
        {{ $users->appends(request()->query())->links() }}
    </div>
    @endif
    @endif
</div>
@endsection
