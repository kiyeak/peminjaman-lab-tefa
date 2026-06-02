@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-2xl font-bold mb-6 text-primary">Tambah Peminjaman</h1>

    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-darkGray mb-2">Peminjam <span class="text-primary">*</span></label>
                <select name="peminjam_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                    <option value="">Pilih Peminjam</option>
                    @foreach($peminjam as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }} ({{ $item->email }})</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Peralatan <span class="text-primary">*</span></label>
                <select name="peralatan_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" required>
                    <option value="">Pilih Peralatan</option>
                    @foreach($peralatan as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }} (Stok: {{ $item->stok }})</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Tanggal Pinjam <span class="text-primary">*</span></label>
                <input type="date" name="tanggal_pinjam" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" value="{{ date('Y-m-d') }}" required>
            </div>
            
            <div>
                <label class="block text-darkGray mb-2">Tanggal Kembali <span class="text-mediumGray text-sm">(Opsional)</span></label>
                <input type="date" name="tanggal_kembali" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" min="{{ date('Y-m-d') }}">
                <p class="text-xs text-mediumGray mt-1">Kosongkan jika barang belum dikembalikan</p>
            </div>
            
            <div class="md:col-span-2">
                <label class="block text-darkGray mb-2">Keterangan</label>
                <textarea name="keterangan" rows="3" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary" placeholder="Catatan tambahan (opsional)"></textarea>
            </div>
        </div>
        
        <div class="mt-6 flex space-x-2">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primaryLight transition">
                <i class="fas fa-save"></i> Simpan
            </button>
            <a href="{{ route('peminjaman.index') }}" class="bg-darkGray text-white px-6 py-2 rounded-lg hover:bg-mediumGray transition">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>

<!-- Informasi Tambahan -->
<div class="bg-primaryLight bg-opacity-10 border border-primary border-opacity-30 rounded-lg p-4 mt-6">
    <h3 class="font-semibold text-primary mb-2">
        <i class="fas fa-info-circle"></i> Informasi
    </h3>
    <ul class="text-sm text-darkGray space-y-1">
        <li>• Tanggal pinjam akan diisi otomatis dengan tanggal hari ini</li>
        <li>• Tanggal kembali bisa diisi nanti saat proses pengembalian barang</li>
        <li>• Stok peralatan akan berkurang secara otomatis saat peminjaman disimpan</li>
        <li>• Stok akan kembali bertambah saat barang dikembalikan</li>
    </ul>
</div>
@endsection