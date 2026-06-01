@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Tambah Peminjam</h1>

    <form action="{{ route('peminjam.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="nama" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Email</label>
                <input type="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Password</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">No HP</label>
                <input type="text" name="no_hp" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Alamat</label>
                <textarea name="alamat" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"></textarea>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Role</label>
                <select name="role" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
            <a href="{{ route('peminjam.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-700 ml-2">Batal</a>
        </div>
    </form>
</div>
@endsection