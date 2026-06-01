@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Data Peralatan</h1>
    <a href="{{ route('peralatan.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        <i class="fas fa-plus"></i> Tambah Peralatan
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($peralatan as $item)
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($item->gambar)
            <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                <i class="fas fa-camera text-gray-400 text-4xl"></i>
            </div>
        @endif
        <div class="p-4">
            <h3 class="font-bold text-lg">{{ $item->nama }}</h3>
            <p class="text-gray-600 text-sm">Kode: {{ $item->kode }}</p>
            <p class="text-sm mt-2">{{ Str::limit($item->deskripsi, 100) }}</p>
            <div class="mt-3 flex justify-between items-center">
                <span class="text-blue-600 font-bold">Stok: {{ $item->stok }}</span>
                <div class="space-x-2">
                    <a href="{{ route('peralatan.show', $item->id) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('peralatan.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-800">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('peralatan.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Yakin hapus?')">
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