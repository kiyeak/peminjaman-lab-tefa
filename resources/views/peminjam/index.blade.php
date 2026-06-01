@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Data Peminjam</h1>
    <a href="{{ route('peminjam.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        <i class="fas fa-plus"></i> Tambah Peminjam
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
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
            @foreach($peminjam as $index => $item)
            <tr>
                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                <td class="px-6 py-4">{{ $item->nama }}</td>
                <td class="px-6 py-4">{{ $item->email }}</td>
                <td class="px-6 py-4">{{ $item->no_hp ?? '-' }}</td>
                <td class="px-6 py-4">
                    @if($item->role == 'admin')
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Admin</span>
                    @else
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">User</span>
                    @endif
                </td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('peminjam.show', $item->id) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('peminjam.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-800">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('peminjam.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Yakin hapus?')">
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