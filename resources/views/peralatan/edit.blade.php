@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6 text-primary">Edit Peralatan</h1>

    <form action="{{ route('peralatan.update', $peralatan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-darkGray mb-2">Nama Peralatan <span class="text-primary">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $peralatan->nama) }}" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('nama') border-primary @enderror" 
                    required>
                @error('nama')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Kode Peralatan <span class="text-primary">*</span></label>
                <input type="text" name="kode" value="{{ old('kode', $peralatan->kode) }}" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('kode') border-primary @enderror" 
                    required>
                @error('kode')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Stok <span class="text-primary">*</span></label>
                <input type="number" name="stok" value="{{ old('stok', $peralatan->stok) }}" 
                    min="0"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('stok') border-primary @enderror" 
                    required>
                @error('stok')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Gambar</label>
                
                <!-- Preview gambar lama -->
                @if($peralatan->gambar)
                    <div class="mb-3">
                        <p class="text-sm text-mediumGray mb-2">Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $peralatan->gambar) }}" 
                            class="w-32 h-32 object-cover rounded-lg border border-primary border-opacity-30">
                    </div>
                @endif
                
                <input type="file" name="gambar" accept="image/*" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('gambar') border-primary @enderror">
                <p class="text-xs text-mediumGray mt-1">Format: JPG, JPEG, PNG. Maks: 2MB</p>
                @error('gambar')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-darkGray mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="4" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('deskripsi') border-primary @enderror">{{ old('deskripsi', $peralatan->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mt-6 flex space-x-2">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primaryLight transition">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('peralatan.index') }}" class="bg-darkGray text-white px-6 py-2 rounded-lg hover:bg-mediumGray transition">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>

<!-- Info Detail Peralatan -->
<div class="bg-primaryLight bg-opacity-5 rounded-lg shadow p-6 mt-6 border border-primary border-opacity-20">
    <h3 class="font-semibold text-lg mb-3 text-primary">Informasi Lainnya</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
        <div>
            <span class="text-mediumGray">ID Peralatan:</span>
            <span class="ml-2 font-mono text-darkGray font-semibold">{{ $peralatan->id }}</span>
        </div>
        <div>
            <span class="text-mediumGray">Dibuat pada:</span>
            <span class="ml-2 text-darkGray">{{ $peralatan->created_at->format('d/m/Y H:i:s') }}</span>
        </div>
        <div>
            <span class="text-mediumGray">Terakhir diupdate:</span>
            <span class="ml-2 text-darkGray">{{ $peralatan->updated_at->format('d/m/Y H:i:s') }}</span>
        </div>
        <div>
            <span class="text-mediumGray">Total Peminjaman:</span>
            <span class="ml-2 font-semibold text-primary">{{ $peralatan->peminjaman->count() }}</span>
        </div>
    </div>
    
    <!-- Status Stok -->
    <div class="mt-4 pt-4 border-t border-mediumGray border-opacity-30">
        <div class="flex items-center space-x-2">
            <span class="text-mediumGray">Status Stok:</span>
            @if($peralatan->stok <= 0)
                <span class="bg-primary text-white px-2 py-1 rounded text-sm">Habis</span>
            @elseif($peralatan->stok <= 2)
                <span class="bg-primaryLight text-white px-2 py-1 rounded text-sm">Hampir Habis</span>
            @else
                <span class="bg-darkGray text-white px-2 py-1 rounded text-sm">Tersedia</span>
            @endif
        </div>
    </div>
</div>
@endsection