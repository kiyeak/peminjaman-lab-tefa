<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PeminjamController extends Controller
{
    public function index()
    {
        $peminjam = Peminjam::latest()->paginate(10);
        return view('peminjam.index', compact('peminjam'));
    }

    public function create()
    {
        return view('peminjam.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:peminjams',
            'password' => 'required|min:6',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'role' => 'required|in:admin,user',
        ]);

        Peminjam::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'role' => $request->role,
        ]);

        return redirect()->route('peminjam.index')->with('success', 'Peminjam berhasil ditambahkan');
    }

    public function show(Peminjam $peminjam)
    {
        return view('peminjam.show', compact('peminjam'));
    }

    public function edit(Peminjam $peminjam)
    {
        return view('peminjam.edit', compact('peminjam'));
    }

    public function update(Request $request, Peminjam $peminjam)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:peminjams,email,' . $peminjam->id,
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'role' => 'required|in:admin,user',
        ]);

        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $peminjam->update($data);
        return redirect()->route('peminjam.index')->with('success', 'Peminjam berhasil diupdate');
    }

    public function destroy(Peminjam $peminjam)
    {
        $peminjam->delete();
        return redirect()->route('peminjam.index')->with('success', 'Peminjam berhasil dihapus');
    }
}