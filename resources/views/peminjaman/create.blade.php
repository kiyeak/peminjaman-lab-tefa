@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Tambah Peminjaman</h1>

    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 mb-2">Peminjam</label>
                <select name="peminjam_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                    <option value="">Pilih Peminjam</option>
                    @foreach($peminjam as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }} ({{ $item->email }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Peralatan</label>
                <select name="peralatan_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                    <option value="">Pilih Peralatan</option>
                    @foreach($peralatan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }} (Stok: {{ $item->stok }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-2">Keterangan</label>
                <textarea name="keterangan" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"></textarea>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
            <a href="{{ route('peminjaman.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-700 ml-2">Batal</a>
        </div>
    </form>
</div>
@endsection