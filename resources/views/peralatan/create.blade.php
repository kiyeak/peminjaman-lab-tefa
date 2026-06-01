@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Tambah Peralatan</h1>

    <form action="{{ route('peralatan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 mb-2">Nama Peralatan</label>
                <input type="text" name="nama" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Kode Peralatan</label>
                <input type="text" name="kode" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Stok</label>
                <input type="number" name="stok" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" value="1" required>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Gambar</label>
                <input type="file" name="gambar" accept="image/*" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-700 mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"></textarea>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
            <a href="{{ route('peralatan.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-700 ml-2">Batal</a>
        </div>
    </form>
</div>
@endsection