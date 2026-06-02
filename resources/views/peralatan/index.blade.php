@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-primary">Data Peralatan</h1>
    <a href="{{ route('peralatan.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryLight transition">
        <i class="fas fa-plus"></i> Tambah Peralatan
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($peralatan as $item)
    <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition border-t-4 border-primary">
        @if($item->gambar)
            <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-mediumGray bg-opacity-20 flex items-center justify-center">
                <i class="fas fa-camera text-mediumGray text-4xl"></i>
            </div>
        @endif
        <div class="p-4">
            <h3 class="font-bold text-lg text-primary">{{ $item->nama }}</h3>
            <p class="text-darkGray text-sm">Kode: {{ $item->kode }}</p>
            <p class="text-sm mt-2 text-darkGray">{{ Str::limit($item->deskripsi, 100) }}</p>
            <div class="mt-3 flex justify-between items-center">
                <span class="text-primary font-bold">Stok: {{ $item->stok }}</span>
                <div class="space-x-2">
                    <a href="{{ route('peralatan.show', $item->id) }}" class="text-primary hover:text-primaryLight">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('peralatan.edit', $item->id) }}" class="text-darkGray hover:text-mediumGray">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('peralatan.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-primary hover:text-primaryLight" onclick="return confirm('Yakin hapus?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-6">
    {{ $peralatan->links() }}
</div>
@endsection