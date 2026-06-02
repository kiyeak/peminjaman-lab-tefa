@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-primary">Data Peminjam</h1>
    <a href="{{ route('peminjam.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primaryLight transition">
        <i class="fas fa-plus"></i> Tambah Peminjam
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-primary text-white">
            <tr class="text-left">
                <th class="px-6 py-3">No</th>
                <th class="px-6 py-3">Nama</th>
                <th class="px-6 py-3">Email</th>
                <th class="px-6 py-3">No HP</th>
                <th class="px-6 py-3">Role</th>
                <th class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($peminjam as $item)
            <tr>
                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                <td class="px-6 py-4">{{ $item->nama }}</td>
                <td class="px-6 py-4">{{ $item->email }}</td>
                <td class="px-6 py-4">{{ $item->no_hp ?? '-' }}</td>
                <td class="px-6 py-4">
                    @if($item->role == 'admin')
                        <span class="bg-primaryLight text-white px-2 py-1 rounded text-sm">Admin</span>
                    @else
                        <span class="bg-darkGray text-white px-2 py-1 rounded text-sm">User</span>
                    @endif
                </td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('peminjam.show', $item->id) }}" class="text-primary hover:text-primaryLight">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('peminjam.edit', $item->id) }}" class="text-darkGray hover:text-mediumGray">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('peminjam.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-primary hover:text-primaryLight" onclick="return confirm('Yakin hapus?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
             </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $peminjam->links() }}
</div>
@endsection