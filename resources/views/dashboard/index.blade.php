@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="fas fa-users text-blue-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500">Total Peminjam</p>
                <p class="text-2xl font-bold">{{ $totalPeminjam }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <i class="fas fa-tools text-green-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500">Total Peralatan</p>
                <p class="text-2xl font-bold">{{ $totalPeralatan }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full">
                <i class="fas fa-hand-holding text-yellow-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500">Total Peminjaman</p>
                <p class="text-2xl font-bold">{{ $totalPeminjaman }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 bg-red-100 rounded-full">
                <i class="fas fa-clock text-red-600 text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500">Sedang Dipinjam</p>
                <p class="text-2xl font-bold">{{ $sedangDipinjam }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b">
        <h3 class="text-lg font-semibold">Peminjaman Terbaru</h3>
    </div>
    <div class="p-6">
        <table class="w-full">
            <thead>
                <tr class="text-left border-b">
                    <th class="pb-2">Peminjam</th>
                    <th class="pb-2">Peralatan</th>
                    <th class="pb-2">Tanggal Pinjam</th>
                    <th class="pb-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentPeminjaman as $item)
                <tr class="border-b">
                    <td class="py-2">{{ $item->peminjam->nama }}</td>
                    <td class="py-2">{{ $item->peralatan->nama }}</td>
                    <td class="py-2">{{ $item->tanggal_pinjam }}</td>
                    <td class="py-2">
                        @if($item->status == 'dipinjam')
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">Dipinjam</span>
                        @else
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Dikembalikan</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection