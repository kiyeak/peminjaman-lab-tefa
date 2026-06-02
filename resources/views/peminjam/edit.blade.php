@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6 text-primary">Edit Peminjam</h1>

    <form action="{{ route('peminjam.update', $peminjam->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-darkGray mb-2">Nama Lengkap <span class="text-primary">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $peminjam->nama) }}" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('nama') border-primary @enderror" 
                    required>
                @error('nama')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Email <span class="text-primary">*</span></label>
                <input type="email" name="email" value="{{ old('email', $peminjam->email) }}" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('email') border-primary @enderror" 
                    required>
                @error('email')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Password <span class="text-mediumGray text-sm">(Kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('password') border-primary @enderror">
                @error('password')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-mediumGray mt-1">Minimal 6 karakter</p>
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $peminjam->no_hp) }}" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('no_hp') border-primary @enderror">
                @error('no_hp')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-darkGray mb-2">Alamat</label>
                <textarea name="alamat" rows="3" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('alamat') border-primary @enderror">{{ old('alamat', $peminjam->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Role <span class="text-primary">*</span></label>
                <select name="role" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('role') border-primary @enderror" 
                    required>
                    <option value="user" {{ old('role', $peminjam->role) == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $peminjam->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mt-6 flex space-x-2">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primaryLight transition">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('peminjam.index') }}" class="bg-darkGray text-white px-6 py-2 rounded-lg hover:bg-mediumGray transition">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>

<!-- Info Detail Peminjam -->
<div class="bg-primaryLight bg-opacity-5 rounded-lg shadow p-6 mt-6 border border-primary border-opacity-20">
    <h3 class="font-semibold text-lg mb-3 text-primary">Informasi Lainnya</h3>
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
            <span class="text-mediumGray">ID Peminjam:</span>
            <span class="ml-2 font-mono text-darkGray font-semibold">{{ $peminjam->id }}</span>
        </div>
        <div>
            <span class="text-mediumGray">Dibuat pada:</span>
            <span class="ml-2 text-darkGray">{{ $peminjam->created_at->format('d/m/Y H:i:s') }}</span>
        </div>
        <div>
            <span class="text-mediumGray">Terakhir diupdate:</span>
            <span class="ml-2 text-darkGray">{{ $peminjam->updated_at->format('d/m/Y H:i:s') }}</span>
        </div>
        <div>
            <span class="text-mediumGray">Total Peminjaman:</span>
            <span class="ml-2 font-semibold text-primary">{{ $peminjam->peminjaman->count() }}</span>
        </div>
    </div>
</div>
@endsection