<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /* ── Dashboard ── */
    public function dashboard()
    {
        $stats = [
            'total'    => Aspirasi::count(),
            'menunggu' => Aspirasi::where('status', 'menunggu')->count(),
            'diproses' => Aspirasi::where('status', 'diproses')->count(),
            'selesai'  => Aspirasi::where('status', 'selesai')->count(),
            'ditolak'  => Aspirasi::where('status', 'ditolak')->count(),
            'users'    => User::where('role', 'user')->count(),
        ];

        $recentAspirasi = Aspirasi::with('user')
            ->orderBy('created_at', 'desc')->limit(5)->get();

        $dashboardData = $this->getDashboardData();

        return view('admin.dashboard', compact('stats', 'recentAspirasi', 'dashboardData'));
    }

    public function getDashboardData()
    {
        $statistics = [
            'total_aspirasi' => Aspirasi::count(),
            'total_users' => User::count(),
            'total_admin' => User::where('role', 'admin')->count(),
            'total_siswa' => User::where('role', 'user')->count(),
            
            'aspirasi_by_status' => [
                'menunggu' => Aspirasi::where('status', 'menunggu')->count(),
                'diproses' => Aspirasi::where('status', 'diproses')->count(),
                'selesai' => Aspirasi::where('status', 'selesai')->count(),
                'ditolak' => Aspirasi::where('status', 'ditolak')->count(),
            ],
            
            'aspirasi_by_prioritas' => [
                'rendah' => Aspirasi::where('prioritas', 'rendah')->count(),
                'sedang' => Aspirasi::where('prioritas', 'sedang')->count(),
                'tinggi' => Aspirasi::where('prioritas', 'tinggi')->count(),
            ],
            
            'aspirasi_by_kategori' => Aspirasi::select('kategori_sarana', DB::raw('count(*) as total'))
                ->groupBy('kategori_sarana')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get()
                ->toArray(),
            
            'aspirasi_per_bulan' => Aspirasi::select(
                    DB::raw('MONTH(created_at) as bulan'),
                    DB::raw('YEAR(created_at) as tahun'),
                    DB::raw('count(*) as total')
                )
                ->groupBy('tahun', 'bulan')
                ->orderBy('tahun', 'desc')
                ->orderBy('bulan', 'desc')
                ->limit(12)
                ->get()
                ->toArray(),
            
            'persentase_status' => [
                'menunggu' => 0,
                'diproses' => 0,
                'selesai' => 0,
                'ditolak' => 0,
            ]
        ];
        
        $total = $statistics['total_aspirasi'];
        if ($total > 0) {
            foreach ($statistics['persentase_status'] as $key => $value) {
                $statistics['persentase_status'][$key] = round(
                    ($statistics['aspirasi_by_status'][$key] / $total) * 100, 
                    2
                );
            }
        }
        
        return $statistics;
    }
    
    public function aspirasi(Request $request)
    {
        $query = Aspirasi::with('user');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('nama_siswa', 'like', "%{$s}%")
                  ->orWhere('kelas', 'like', "%{$s}%")
                  ->orWhere('kategori_sarana', 'like', "%{$s}%")
                  ->orWhere('lokasi', 'like', "%{$s}%");
            });
        }

        if ($request->filled('nisn')) {
            $nisn = trim($request->nisn);
            $query->where('nisn', 'LIKE', '%' . $nisn . '%');
        }

        if ($request->filled('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->filled('prioritas') && $request->prioritas != '') {
            $query->where('prioritas', $request->prioritas);
        }

        if ($request->filled('kategori') && $request->kategori != '') {
            $kategoriFilter = trim($request->kategori);
            $query->whereRaw('LOWER(TRIM(kategori_sarana)) = ?', [strtolower($kategoriFilter)]);
        }

        if ($request->filled('tanggal') && $request->tanggal != '') {
            $tanggal = date('Y-m-d', strtotime($request->tanggal));
            $query->whereDate('created_at', '=', $tanggal);
        }

        if ($request->filled('bulan') && $request->bulan != '') {
            $bulan = $request->bulan;
            $tahun = substr($bulan, 0, 4);
            $bulanNum = substr($bulan, 5, 2);
            $query->whereYear('created_at', '=', $tahun)
                  ->whereMonth('created_at', '=', $bulanNum);
        }

        if ($request->filled('dari_tanggal') && $request->dari_tanggal != '') {
            $dari = date('Y-m-d', strtotime($request->dari_tanggal));
            $query->whereDate('created_at', '>=', $dari);
        }
        
        if ($request->filled('sampai_tanggal') && $request->sampai_tanggal != '') {
            $sampai = date('Y-m-d', strtotime($request->sampai_tanggal));
            $query->whereDate('created_at', '<=', $sampai);
        }

        $aspirasi = $query->orderBy('created_at', 'desc')->paginate(15);
        $aspirasi->appends($request->query());

        $stats = [
            'total'    => Aspirasi::count(),
            'menunggu' => Aspirasi::where('status', 'menunggu')->count(),
            'diproses' => Aspirasi::where('status', 'diproses')->count(),
            'selesai'  => Aspirasi::where('status', 'selesai')->count(),
            'ditolak'  => Aspirasi::where('status', 'ditolak')->count(),
        ];

        $kategoriList = Aspirasi::select('kategori_sarana')
            ->distinct()
            ->whereNotNull('kategori_sarana')
            ->where('kategori_sarana', '!=', '')
            ->get()
            ->map(function($item) {
                return trim($item->kategori_sarana);
            })
            ->unique()
            ->sort()
            ->values();

        if ($kategoriList->isEmpty()) {
            $kategoriList = collect([
                'Ruang Kelas', 'Laboratorium', 'Perpustakaan', 'Toilet / Kamar Mandi',
                'Kantin', 'Aula / Gedung Serbaguna', 'Meja & Kursi', 'Papan Tulis',
                'Proyektor / LCD', 'Komputer', 'AC / Kipas Angin', 'Lapangan Olahraga',
                'Taman / Lingkungan', 'Parkir', 'Lainnya'
            ]);
        }

        $filterOptions = [
            'status' => [
                '' => 'Semua Status',
                'menunggu' => 'Menunggu',
                'diproses' => 'Diproses',
                'selesai' => 'Selesai',
                'ditolak' => 'Ditolak'
            ],
            'prioritas' => [
                '' => 'Semua Prioritas',
                'rendah' => 'Rendah',
                'sedang' => 'Sedang',
                'tinggi' => 'Tinggi'
            ],
            'limit' => [
                10 => '10 data',
                15 => '15 data',
                25 => '25 data',
                50 => '50 data',
                100 => '100 data'
            ],
            'sort_by' => [
                'created_at' => 'Tanggal',
                'nama_siswa' => 'Nama Siswa',
                'kategori_sarana' => 'Kategori',
                'prioritas' => 'Prioritas',
                'status' => 'Status'
            ],
            'sort_order' => [
                'desc' => 'Terbaru ke Terlama',
                'asc' => 'Terlama ke Terbaru'
            ]
        ];

        return view('admin.aspirasi', compact('aspirasi', 'stats', 'kategoriList', 'filterOptions'));
    }

    public function updateAspirasi(Request $request, Aspirasi $aspirasi)
    {
        $validator = Validator::make($request->all(), [
            'status'      => 'required|in:menunggu,diproses,selesai,ditolak',
            'umpan_balik' => 'required|string|min:10',
            'petugas'     => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $aspirasi->update([
            'status'              => $request->status,
            'umpan_balik'         => $request->umpan_balik,
            'petugas'             => $request->petugas,
            'tanggal_umpan_balik' => now(),
        ]);

        return redirect()->route('admin.aspirasi')
            ->with('success', 'Umpan balik berhasil disimpan dan status diperbarui.');
    }

    public function updateStatusAjax(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'umpan_balik' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $aspirasi = Aspirasi::findOrFail($id);
        $aspirasi->status = $request->status;
        $aspirasi->umpan_balik = $request->umpan_balik;
        $aspirasi->petugas = auth()->user()->name;
        $aspirasi->tanggal_umpan_balik = now();
        $aspirasi->save();

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diupdate',
            'status' => $aspirasi->status,
            'umpan_balik' => $aspirasi->umpan_balik,
            'petugas' => $aspirasi->petugas,
            'tanggal' => $aspirasi->tanggal_umpan_balik->format('d/m/Y H:i')
        ]);
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('username', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        $users->appends($request->query());
        
        $roleOptions = [
            '' => 'Semua Role',
            'admin' => 'Admin',
            'user' => 'Siswa'
        ];
        
        return view('admin.users', compact('users', 'roleOptions'));
    }

    public function createUser()
    {
        return view('admin.user-form', ['user' => null]);
    }

    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:admin,user',
            'kelas'    => 'nullable|string|max:30',
        ], [
            'username.unique'    => 'Username sudah digunakan.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name'      => $request->name,
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'role'      => $request->role,
            'kelas'     => $request->kelas,
            'is_active' => true,
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'User baru berhasil ditambahkan.');
    }

    public function editUser(User $user)
    {
        return view('admin.user-form', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:100',
            'username'  => 'required|string|max:50|unique:users,username,' . $user->id,
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|string|min:6|confirmed',
            'role'      => 'required|in:admin,user',
            'kelas'     => 'nullable|string|max:30',
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'username', 'email', 'role', 'kelas', 'is_active']);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
    }

    public function exportAspirasi()
    {
        $aspirasi = Aspirasi::with('user')->orderBy('created_at', 'desc')->get();
        
        $exportData = [
            'headers' => [
                'No', 'NISN', 'Nama Siswa', 'Kelas', 'Kategori', 'Lokasi',
                'Deskripsi', 'Prioritas', 'Status', 'Tanggal Dibuat',
                'Umpan Balik', 'Tanggal Umpan Balik', 'Petugas'
            ],
            'data' => []
        ];
        
        foreach ($aspirasi as $index => $item) {
            $exportData['data'][] = [
                $index + 1,
                $item->nisn ?? '-',
                $item->nama_siswa,
                $item->kelas,
                $item->kategori_sarana,
                $item->lokasi,
                $item->deskripsi,
                ucfirst($item->prioritas),
                ucfirst($item->status),
                $item->created_at->format('d/m/Y H:i'),
                $item->umpan_balik ?? '-',
                $item->tanggal_umpan_balik ? $item->tanggal_umpan_balik->format('d/m/Y H:i') : '-',
                $item->petugas ?? '-'
            ];
        }
        
        return response()->json($exportData);
    }
}