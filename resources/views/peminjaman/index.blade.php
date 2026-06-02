@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6 flex-wrap gap-4">
    <h1 class="text-2xl font-bold text-primary">Data Peminjaman</h1>
    <div class="flex space-x-2">
        <a href="{{ route('export.excel') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryLight transition">
            <i class="fas fa-file-excel"></i> Export CSV
        </a>
        <a href="{{ route('export.pdf') }}" class="bg-darkGray text-white px-4 py-2 rounded-lg hover:bg-mediumGray transition">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        <a href="{{ route('peminjaman.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryLight transition">
            <i class="fas fa-plus"></i> Tambah Peminjaman
        </a>
    </div>
</div>

<!-- Search & Filter -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-4">
        <input type="text" name="search" placeholder="Cari peminjam atau peralatan..." value="{{ request('search') }}" class="flex-1 px-3 py-2 border rounded-lg focus:outline-none focus:border-primary">
        <select name="status" class="px-3 py-2 border rounded-lg focus:outline-none focus:border-primary">
            <option value="">Semua Status</option>
            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
            <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
        </select>
        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryLight transition">Filter</button>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-primary text-white">
            <tr class="text-left">
                <th class="px-6 py-3">No</th>
                <th class="px-6 py-3">Peminjam</th>
                <th class="px-6 py-3">Peralatan</th>
                <th class="px-6 py-3">Tgl Pinjam</th>
                <th class="px-6 py-3">Tgl Kembali</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($peminjaman as $item)
            <tr>
                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                <td class="px-6 py-4">{{ $item->peminjam->nama }}</td>
                <td class="px-6 py-4">{{ $item->peralatan->nama }}</td>
                <td class="px-6 py-4">{{ $item->tanggal_pinjam }}</td>
                <td class="px-6 py-4">{{ $item->tanggal_kembali ?? '-' }}</td>
                <td class="px-6 py-4">
                    @if($item->status == 'dipinjam')
                        <span class="bg-primaryLight text-white px-2 py-1 rounded text-sm">Dipinjam</span>
                    @else
                        <span class="bg-mediumGray text-white px-2 py-1 rounded text-sm">Dikembalikan</span>
                    @endif
                </td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('peminjaman.show', $item->id) }}" class="text-primary hover:text-primaryLight">
                        <i class="fas fa-eye"></i>
                    </a>
                    @if($item->status == 'dipinjam')
                    <form action="{{ route('peminjaman.kembali', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-darkGray hover:text-mediumGray" onclick="return confirm('Kembalikan barang?')">
                            <i class="fas fa-undo"></i>
                        </button>
                    </form>
                    @endif
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('peminjaman.edit', $item->id) }}" class="text-darkGray hover:text-mediumGray">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('peminjaman.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-primary hover:text-primaryLight" onclick="return confirm('Yakin hapus?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @endif
                </td>
             </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $peminjaman->links() }}
</div>
@endsection