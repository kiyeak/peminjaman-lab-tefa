<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use App\Models\Peralatan;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPeminjam = Peminjam::count();
        $totalPeralatan = Peralatan::count();
        $totalPeminjaman = Peminjaman::count();
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $recentPeminjaman = Peminjaman::with(['peminjam', 'peralatan'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalPeminjam',
            'totalPeralatan',
            'totalPeminjaman',
            'sedangDipinjam',
            'recentPeminjaman'
        ));
    }
}