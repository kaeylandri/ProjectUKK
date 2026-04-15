<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AspirasiController extends Controller
{
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak bisa membuat aspirasi.');
        }

        $kategoriList = [
            'Ruang Kelas', 'Laboratorium', 'Perpustakaan', 'Toilet / Kamar Mandi',
            'Kantin', 'Aula / Gedung Serbaguna', 'Meja & Kursi', 'Papan Tulis',
            'Proyektor / LCD', 'Komputer', 'AC / Kipas Angin', 'Lapangan Olahraga',
            'Taman / Lingkungan', 'Parkir', 'Lainnya'
        ];

        $prioritasList = [
            'rendah' => 'Rendah',
            'sedang' => 'Sedang',
            'tinggi' => 'Tinggi'
        ];

        return view('aspirasi.create', compact('kategoriList', 'prioritasList'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'Admin tidak bisa membuat aspirasi.');
        }

        $validator = Validator::make($request->all(), [
            'kategori_sarana'  => 'required|string|max:100',
            'lokasi'           => 'required|string|max:200',
            'deskripsi'        => 'required|string|min:20',
            'prioritas'        => 'required|in:rendah,sedang,tinggi',
            'foto'             => 'nullable|image|max:2048',
        ], [
            'kategori_sarana.required' => 'Kategori sarana wajib dipilih.',
            'lokasi.required'          => 'Lokasi wajib diisi.',
            'deskripsi.required'       => 'Deskripsi pengaduan wajib diisi.',
            'deskripsi.min'            => 'Deskripsi minimal 20 karakter.',
            'prioritas.required'       => 'Prioritas wajib dipilih.',
            'foto.image'               => 'File harus berupa gambar.',
            'foto.max'                 => 'Ukuran foto maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();
        
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('aspirasi', 'public');
        }

        Aspirasi::create([
            'user_id' => $user->id,
            'nisn' => $user->nisn,
            'nama_siswa' => $user->name,
            'kelas' => $user->kelas,
            'kategori_sarana' => $request->kategori_sarana,
            'lokasi' => $request->lokasi,
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath,
            'prioritas' => $request->prioritas,
            'status' => 'menunggu',
        ]);

        return redirect()->route('user.aspirasi.list')
            ->with('success', 'Aspirasi berhasil dikirim! Kami akan segera menindaklanjuti pengaduan Anda.');
    }

    public function index(Request $request)
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.aspirasi');
        }

        $user = Auth::user();
        $query = Aspirasi::where('user_id', $user->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('kategori_sarana', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        $aspirasi = $query->orderBy('created_at', 'desc')->paginate(10);
        $aspirasi->appends($request->query());

        $stats = [
            'total'    => Aspirasi::where('user_id', $user->id)->count(),
            'menunggu' => Aspirasi::where('user_id', $user->id)->where('status', 'menunggu')->count(),
            'diproses' => Aspirasi::where('user_id', $user->id)->where('status', 'diproses')->count(),
            'selesai'  => Aspirasi::where('user_id', $user->id)->where('status', 'selesai')->count(),
            'ditolak'  => Aspirasi::where('user_id', $user->id)->where('status', 'ditolak')->count(),
        ];

        $statusList = [
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];

        $prioritasList = [
            'rendah' => 'Rendah',
            'sedang' => 'Sedang',
            'tinggi' => 'Tinggi'
        ];

        return view('aspirasi.index', compact('aspirasi', 'stats', 'statusList', 'prioritasList'));
    }

    public function adminIndex(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $query = Aspirasi::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_siswa', 'like', '%' . $search . '%')
                  ->orWhere('kelas', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('nisn') && $request->nisn != '') {
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

        $perPage = $request->input('per_page', 15);
        $aspirasi = $query->orderBy('created_at', 'desc')->paginate($perPage);
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

        $statusList = [
            '' => 'Semua Status',
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];

        $prioritasList = [
            '' => 'Semua Prioritas',
            'rendah' => 'Rendah',
            'sedang' => 'Sedang',
            'tinggi' => 'Tinggi'
        ];

        $perPageOptions = [10, 15, 25, 50, 100];

        return view('admin.aspirasi', compact('aspirasi', 'stats', 'kategoriList', 'statusList', 'prioritasList', 'perPageOptions', 'perPage'));
    }

    public function updateStatus(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'umpan_balik' => 'required|string|min:10',
        ], [
            'umpan_balik.required' => 'Umpan balik wajib diisi.',
            'umpan_balik.min' => 'Umpan balik minimal 10 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $aspirasi = Aspirasi::findOrFail($id);
        $aspirasi->status = $request->status;
        $aspirasi->umpan_balik = $request->umpan_balik;
        $aspirasi->petugas = Auth::user()->name;
        $aspirasi->tanggal_umpan_balik = now();
        $aspirasi->save();

        $statusLabels = [
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak'
        ];

        $statusBadges = [
            'menunggu' => 'b-wait',
            'diproses' => 'b-proc',
            'selesai' => 'b-done',
            'ditolak' => 'b-rej'
        ];

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diupdate',
            'status_label' => $statusLabels[$aspirasi->status],
            'status_badge' => $statusBadges[$aspirasi->status],
            'umpan_balik' => $aspirasi->umpan_balik,
            'petugas' => $aspirasi->petugas,
            'tanggal' => $aspirasi->tanggal_umpan_balik->format('d/m/Y H:i')
        ]);
    }

    public function show(Aspirasi $aspirasi)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->isAdmin()) {
            return view('aspirasi.show', compact('aspirasi'));
        }

        if ($aspirasi->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('aspirasi.show', compact('aspirasi'));
    }

    public function update(Request $request, Aspirasi $aspirasi)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $validator = Validator::make($request->all(), [
            'status'      => 'required|in:menunggu,diproses,selesai,ditolak',
            'umpan_balik' => 'required|string|min:10',
            'petugas'     => 'required|string|max:100',
        ], [
            'status.required'      => 'Status wajib dipilih.',
            'umpan_balik.required' => 'Umpan balik wajib diisi.',
            'umpan_balik.min'      => 'Umpan balik minimal 10 karakter.',
            'petugas.required'     => 'Nama petugas wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $aspirasi->update([
            'status'             => $request->status,
            'umpan_balik'        => $request->umpan_balik,
            'petugas'            => $request->petugas,
            'tanggal_umpan_balik'=> now(),
        ]);

        return redirect()->route('admin.aspirasi')
            ->with('success', 'Umpan balik berhasil disimpan dan status telah diperbarui.');
    }

    public function destroy(Aspirasi $aspirasi)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $aspirasi->delete();

        return redirect()->route('admin.aspirasi')
            ->with('success', 'Aspirasi berhasil dihapus.');
    }

    public function bulkUpdateStatus(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:aspirasi,id',
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'umpan_balik' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $updated = Aspirasi::whereIn('id', $request->ids)->update([
            'status' => $request->status,
            'umpan_balik' => $request->umpan_balik,
            'petugas' => Auth::user()->name,
            'tanggal_umpan_balik' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$updated} aspirasi berhasil diupdate",
            'total_updated' => $updated
        ]);
    }

    public function export(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $query = Aspirasi::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_sarana', $request->kategori);
        }

        $aspirasi = $query->orderBy('created_at', 'desc')->get();

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

    public function debugFilter(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $results = [];
        
        $allNisn = Aspirasi::select('nisn', 'nama_siswa', 'id')
            ->whereNotNull('nisn')
            ->where('nisn', '!=', '')
            ->limit(20)
            ->get();
        $results['all_nisn'] = $allNisn;
        
        $minDate = Aspirasi::min('created_at');
        $maxDate = Aspirasi::max('created_at');
        $results['date_range'] = ['min' => $minDate, 'max' => $maxDate];
        
        $results['total_data'] = Aspirasi::count();
        
        $dateDistribution = Aspirasi::selectRaw('DATE(created_at) as tanggal, count(*) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->limit(10)
            ->get();
        $results['date_distribution'] = $dateDistribution;
        
        $results['kategori_list'] = Aspirasi::select('kategori_sarana')
            ->distinct()
            ->whereNotNull('kategori_sarana')
            ->pluck('kategori_sarana');
        
        return response()->json($results);
    }
}