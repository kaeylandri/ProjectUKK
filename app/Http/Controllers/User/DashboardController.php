<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $aspirasi = Aspirasi::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => Aspirasi::where('user_id', Auth::id())->count(),
            'menunggu' => Aspirasi::where('user_id', Auth::id())->where('status', 'menunggu')->count(),
            'diproses' => Aspirasi::where('user_id', Auth::id())->where('status', 'diproses')->count(),
            'selesai' => Aspirasi::where('user_id', Auth::id())->where('status', 'selesai')->count(),
        ];

        return view('user.dashboard', compact('aspirasi', 'stats'));
    }
}