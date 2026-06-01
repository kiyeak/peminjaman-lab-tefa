<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use App\Models\Peralatan;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $peminjaman = Peminjaman::with(['peminjam', 'peralatan'])
            ->when($search, function ($query, $search) {
                $query->whereHas('peminjam', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })->orWhereHas('peralatan', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('peminjaman.index', compact('peminjaman', 'search', 'status'));
    }

    public function create()
    {
        $peminjam = Peminjam::all();
        $peralatan = Peralatan::all();
        return view('peminjaman.create', compact('peminjam', 'peralatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjam_id' => 'required|exists:peminjams,id',
            'peralatan_id' => 'required|exists:peralatans,id',
            'tanggal_pinjam' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $peralatan = Peralatan::find($request->peralatan_id);
            if ($peralatan->stok <= 0) {
                return back()->withErrors(['peralatan_id' => 'Stok peralatan habis!']);
            }

            Peminjaman::create([
                'peminjam_id' => $request->peminjam_id,
                'peralatan_id' => $request->peralatan_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'status' => 'dipinjam',
                'keterangan' => $request->keterangan,
            ]);

            $peralatan->decrement('stok');
            DB::commit();

            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function show(Peminjaman $peminjaman)
    {
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        $peminjam = Peminjam::all();
        $peralatan = Peralatan::all();
        return view('peminjaman.edit', compact('peminjaman', 'peminjam', 'peralatan'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'peminjam_id' => 'required|exists:peminjams,id',
            'peralatan_id' => 'required|exists:peralatans,id',
            'tanggal_pinjam' => 'required|date',
            'status' => 'required|in:dipinjam,dikembalikan',
            'tanggal_kembali' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $peminjaman->update($request->all());
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diupdate');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        if ($peminjaman->status == 'dipinjam') {
            $peminjaman->peralatan->increment('stok');
        }
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus');
    }

    public function kembalikan($id)
    {
        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::findOrFail($id);
            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now()->toDateString(),
            ]);
            $peminjaman->peralatan->increment('stok');
            DB::commit();

            return redirect()->route('peminjaman.index')->with('success', 'Barang berhasil dikembalikan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan']);
        }
    }
}