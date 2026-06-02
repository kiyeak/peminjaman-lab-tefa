@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6 text-primary">Edit Peminjaman</h1>

    <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-darkGray mb-2">Peminjam <span class="text-primary">*</span></label>
                <select name="peminjam_id" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('peminjam_id') border-primary @enderror" 
                    required>
                    <option value="">Pilih Peminjam</option>
                    @foreach($peminjam as $item)
                        <option value="{{ $item->id }}" 
                            {{ old('peminjam_id', $peminjaman->peminjam_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->nama }} ({{ $item->email }}) - {{ ucfirst($item->role) }}
                        </option>
                    @endforeach
                </select>
                @error('peminjam_id')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Peralatan <span class="text-primary">*</span></label>
                <select name="peralatan_id" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('peralatan_id') border-primary @enderror" 
                    required>
                    <option value="">Pilih Peralatan</option>
                    @foreach($peralatan as $item)
                        <option value="{{ $item->id }}" 
                            {{ old('peralatan_id', $peminjaman->peralatan_id) == $item->id ? 'selected' : '' }}>
                            {{ $item->nama }} (Kode: {{ $item->kode }}) - Stok: {{ $item->stok }}
                        </option>
                    @endforeach
                </select>
                @error('peralatan_id')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Tanggal Pinjam <span class="text-primary">*</span></label>
                <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('tanggal_pinjam') border-primary @enderror" 
                    required>
                @error('tanggal_pinjam')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('tanggal_kembali') border-primary @enderror">
                <p class="text-xs text-mediumGray mt-1">Kosongkan jika barang belum dikembalikan</p>
                @error('tanggal_kembali')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Status <span class="text-primary">*</span></label>
                <select name="status" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('status') border-primary @enderror" 
                    required>
                    <option value="dipinjam" {{ old('status', $peminjaman->status) == 'dipinjam' ? 'selected' : '' }}>
                        🟡 Dipinjam
                    </option>
                    <option value="dikembalikan" {{ old('status', $peminjaman->status) == 'dikembalikan' ? 'selected' : '' }}>
                        🟢 Dikembalikan
                    </option>
                </select>
                @error('status')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-darkGray mb-2">Keterangan</label>
                <textarea name="keterangan" rows="3" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary @error('keterangan') border-primary @enderror">{{ old('keterangan', $peminjaman->keterangan) }}</textarea>
                @error('keterangan')
                    <p class="text-primary text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Warning jika mengubah status -->
        @if($peminjaman->status == 'dipinjam')
        <div class="mt-4 p-3 bg-primaryLight bg-opacity-10 border border-primary border-opacity-30 rounded-lg">
            <p class="text-primary text-sm">
                <i class="fas fa-exclamation-triangle"></i> 
                <strong>Perhatian:</strong> Jika Anda mengubah status menjadi "Dikembalikan", stok peralatan akan otomatis bertambah.
                Pastikan barang sudah benar-benar dikembalikan.
            </p>
        </div>
        @endif
        
        <div class="mt-6 flex space-x-2">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primaryLight transition">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('peminjaman.index') }}" class="bg-darkGray text-white px-6 py-2 rounded-lg hover:bg-mediumGray transition">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>

<!-- Info Detail Peminjaman -->
<div class="bg-primaryLight bg-opacity-5 rounded-lg shadow p-6 mt-6 border border-primary border-opacity-20">
    <h3 class="font-semibold text-lg mb-3 text-primary">Informasi Detail Peminjaman</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div>
            <span class="text-mediumGray">ID Peminjaman:</span>
            <span class="ml-2 font-mono text-darkGray font-semibold">{{ $peminjaman->id }}</span>
        </div>
        <div>
            <span class="text-mediumGray">Dibuat pada:</span>
            <span class="ml-2 text-darkGray">{{ $peminjaman->created_at->format('d/m/Y H:i:s') }}</span>
        </div>
        <div>
            <span class="text-mediumGray">Terakhir diupdate:</span>
            <span class="ml-2 text-darkGray">{{ $peminjaman->updated_at->format('d/m/Y H:i:s') }}</span>
        </div>
        <div>
            <span class="text-mediumGray">Durasi Peminjaman:</span>
            <span class="ml-2 text-darkGray font-semibold">
                @php
                    $start = new DateTime($peminjaman->tanggal_pinjam);
                    $end = $peminjaman->tanggal_kembali ? new DateTime($peminjaman->tanggal_kembali) : new DateTime();
                    $diff = $start->diff($end);
                @endphp
                {{ $diff->days }} hari
            </span>
        </div>
    </div>
    
    <!-- Tombol shortcut untuk pengembalian -->
    @if($peminjaman->status == 'dipinjam')
    <div class="mt-4 pt-4 border-t border-mediumGray border-opacity-30">
        <form action="{{ route('peminjaman.kembali', $peminjaman->id) }}" method="POST" class="inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryLight transition" 
                onclick="return confirm('Kembalikan barang ini? Stok akan otomatis bertambah.')">
                <i class="fas fa-undo"></i> Kembalikan Sekarang
            </button>
        </form>
        <p class="text-xs text-mediumGray mt-2">
            * Tombol ini akan mengubah status menjadi "Dikembalikan" dan mengatur tanggal kembali ke hari ini
        </p>
    </div>
    @endif
</div>
@endsection