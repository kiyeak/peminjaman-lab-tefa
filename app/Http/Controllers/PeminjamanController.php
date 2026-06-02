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
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam', // VALIDASI BARU
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $peralatan = Peralatan::find($request->peralatan_id);
            
            // Cek stok hanya jika status dipinjam
            if (empty($request->tanggal_kembali) && $peralatan->stok <= 0) {
                return back()->withErrors(['peralatan_id' => 'Stok peralatan habis!']);
            }

            // Tentukan status berdasarkan tanggal_kembali
            $status = empty($request->tanggal_kembali) ? 'dipinjam' : 'dikembalikan';

            Peminjaman::create([
                'peminjam_id' => $request->peminjam_id,
                'peralatan_id' => $request->peralatan_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali, // TAMBAHKAN INI
                'status' => $status,
                'keterangan' => $request->keterangan,
            ]);

            // Kurangi stok hanya jika status dipinjam
            if ($status == 'dipinjam') {
                $peralatan->decrement('stok');
            }
            
            DB::commit();

            $message = $status == 'dipinjam' 
                ? 'Peminjaman berhasil ditambahkan' 
                : 'Data pengembalian berhasil dicatat';
                
            return redirect()->route('peminjaman.index')->with('success', $message);
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
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $oldStatus = $peminjaman->status;
            $oldPeralatanId = $peminjaman->peralatan_id;
            
            // Update data
            $peminjaman->update([
                'peminjam_id' => $request->peminjam_id,
                'peralatan_id' => $request->peralatan_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => $request->status,
                'keterangan' => $request->keterangan,
            ]);
            
            // Handle stok jika peralatan berubah atau status berubah
            if ($oldPeralatanId != $request->peralatan_id) {
                // Kembalikan stok ke peralatan lama jika statusnya dipinjam
                if ($oldStatus == 'dipinjam') {
                    $oldPeralatan = Peralatan::find($oldPeralatanId);
                    $oldPeralatan->increment('stok');
                }
                
                // Kurangi stok peralatan baru jika status dipinjam
                if ($request->status == 'dipinjam') {
                    $newPeralatan = Peralatan::find($request->peralatan_id);
                    if ($newPeralatan->stok <= 0) {
                        throw new \Exception('Stok peralatan baru habis!');
                    }
                    $newPeralatan->decrement('stok');
                }
            } else {
                // Peralatan sama, cek perubahan status
                if ($oldStatus == 'dipinjam' && $request->status == 'dikembalikan') {
                    $peminjaman->peralatan->increment('stok');
                } elseif ($oldStatus == 'dikembalikan' && $request->status == 'dipinjam') {
                    if ($peminjaman->peralatan->stok <= 0) {
                        throw new \Exception('Stok peralatan habis!');
                    }
                    $peminjaman->peralatan->decrement('stok');
                }
            }
            
            DB::commit();
            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy(Peminjaman $peminjaman)
    {
        DB::beginTransaction();
        try {
            if ($peminjaman->status == 'dipinjam') {
                $peminjaman->peralatan->increment('stok');
            }
            $peminjaman->delete();
            DB::commit();
            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus']);
        }
    }

    public function kembalikan($id)
    {
        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::findOrFail($id);
            
            // Cek apakah sudah dikembalikan
            if ($peminjaman->status == 'dikembalikan') {
                return back()->withErrors(['error' => 'Barang sudah dikembalikan sebelumnya']);
            }
            
            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now()->toDateString(),
            ]);
            $peminjaman->peralatan->increment('stok');
            DB::commit();

            return redirect()->route('peminjaman.index')->with('success', 'Barang berhasil dikembalikan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}