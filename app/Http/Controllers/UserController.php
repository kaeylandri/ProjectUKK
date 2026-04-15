<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /* ── Dashboard ── */
    public function dashboard()
    {
        $user  = Auth::user();
        $stats = [
            'total'    => Aspirasi::where('user_id', $user->id)->count(),
            'menunggu' => Aspirasi::where('user_id', $user->id)->where('status', 'menunggu')->count(),
            'diproses' => Aspirasi::where('user_id', $user->id)->where('status', 'diproses')->count(),
            'selesai'  => Aspirasi::where('user_id', $user->id)->where('status', 'selesai')->count(),
        ];
        $recentAspirasi = Aspirasi::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')->limit(5)->get();

        return view('user.dashboard', compact('stats', 'recentAspirasi'));
    }

    
    public function createAspirasi()
    {
        return view('user.aspirasi-form');
    }


    public function storeAspirasi(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'kategori_sarana' => 'required|string|max:100',
            'lokasi'          => 'required|string|max:200',
            'deskripsi'       => 'required|string|min:20',
            'prioritas'       => 'required|in:rendah,sedang,tinggi',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'kategori_sarana.required' => 'Kategori sarana wajib dipilih.',
            'lokasi.required'          => 'Lokasi wajib diisi.',
            'deskripsi.required'       => 'Deskripsi pengaduan wajib diisi.',
            'deskripsi.min'            => 'Deskripsi minimal 20 karakter.',
            'prioritas.required'       => 'Prioritas wajib dipilih.',
            'foto.image'               => 'File harus berupa gambar.',
            'foto.mimes'               => 'Format gambar harus JPG, JPEG, atau PNG.',
            'foto.max'                 => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        
        $fotoPath = null;
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $fotoPath = $request->file('foto')->store('aspirasi', 'public');
        }

        Aspirasi::create([
            'user_id'         => $user->id,
            'nama_siswa'      => $user->name,
            'kelas'           => $user->kelas ?? '-',
            'kategori_sarana' => $request->kategori_sarana,
            'lokasi'          => $request->lokasi,
            'deskripsi'       => $request->deskripsi,
            'prioritas'       => $request->prioritas,
            'foto'            => $fotoPath,
        ]);

        return redirect()->route('user.aspirasi.list')
            ->with('success', 'Pengaduan berhasil dikirim! Kami akan segera menindaklanjuti.');
    }

    
    public function listAspirasi(Request $request)
    {
        $user  = Auth::user();
        $query = Aspirasi::where('user_id', $user->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $aspirasi = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('user.aspirasi-list', compact('aspirasi'));
    }

    
    public function showAspirasi(Aspirasi $aspirasi)
    {
        if ($aspirasi->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }
        return view('user.aspirasi-detail', compact('aspirasi'));
    }
}
