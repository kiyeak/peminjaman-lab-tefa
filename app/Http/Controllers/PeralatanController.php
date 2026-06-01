<?php

namespace App\Http\Controllers;

use App\Models\Peralatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeralatanController extends Controller
{
    public function index()
    {
        $peralatan = Peralatan::latest()->paginate(10);
        return view('peralatan.index', compact('peralatan'));
    }

    public function create()
    {
        return view('peralatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|unique:peralatans',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stok' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('peralatan', 'public');
        }

        Peralatan::create($data);
        return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil ditambahkan');
    }

    public function show(Peralatan $peralatan)
    {
        return view('peralatan.show', compact('peralatan'));
    }

    public function edit(Peralatan $peralatan)
    {
        return view('peralatan.edit', compact('peralatan'));
    }

    public function update(Request $request, Peralatan $peralatan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|unique:peralatans,kode,' . $peralatan->id,
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stok' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            if ($peralatan->gambar) {
                Storage::disk('public')->delete($peralatan->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('peralatan', 'public');
        }

        $peralatan->update($data);
        return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil diupdate');
    }

    public function destroy(Peralatan $peralatan)
    {
        if ($peralatan->gambar) {
            Storage::disk('public')->delete($peralatan->gambar);
        }
        $peralatan->delete();
        return redirect()->route('peralatan.index')->with('success', 'Peralatan berhasil dihapus');
    }
}