@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-primary">
        <div class="flex items-center">
            <div class="p-3 bg-primaryLight rounded-full bg-opacity-20">
                <i class="fas fa-users text-primary text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-mediumGray">Total Peminjam</p>
                <p class="text-2xl font-bold text-darkGray">{{ $totalPeminjam }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-primaryLight">
        <div class="flex items-center">
            <div class="p-3 bg-primaryLight rounded-full bg-opacity-20">
                <i class="fas fa-tools text-primaryLight text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-mediumGray">Total Peralatan</p>
                <p class="text-2xl font-bold text-darkGray">{{ $totalPeralatan }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-darkGray">
        <div class="flex items-center">
            <div class="p-3 bg-darkGray rounded-full bg-opacity-20">
                <i class="fas fa-hand-holding text-darkGray text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-mediumGray">Total Peminjaman</p>
                <p class="text-2xl font-bold text-darkGray">{{ $totalPeminjaman }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-t-4 border-mediumGray">
        <div class="flex items-center">
            <div class="p-3 bg-mediumGray rounded-full bg-opacity-20">
                <i class="fas fa-clock text-mediumGray text-2xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-mediumGray">Sedang Dipinjam</p>
                <p class="text-2xl font-bold text-darkGray">{{ $sedangDipinjam }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-mediumGray">
        <h3 class="text-lg font-semibold text-primary">Peminjaman Terbaru</h3>
    </div>
    <div class="p-6">
        <table class="w-full">
            <thead>
                <tr class="text-left border-b border-mediumGray">
                    <th class="pb-2 text-darkGray">Peminjam</th>
                    <th class="pb-2 text-darkGray">Peralatan</th>
                    <th class="pb-2 text-darkGray">Tanggal Pinjam</th>
                    <th class="pb-2 text-darkGray">Status</th>
                <tr>
            </thead>
            <tbody>
                @foreach($recentPeminjaman as $item)
                <tr class="border-b border-gray-200">
                    <td class="py-2 text-darkGray">{{ $item->peminjam->nama }}</td>
                    <td class="py-2 text-darkGray">{{ $item->peralatan->nama }}</td>
                    <td class="py-2 text-darkGray">{{ $item->tanggal_pinjam }}</td>
                    <td class="py-2">
                        @if($item->status == 'dipinjam')
                            <span class="bg-primaryLight text-white px-2 py-1 rounded text-sm">Dipinjam</span>
                        @else
                            <span class="bg-mediumGray text-white px-2 py-1 rounded text-sm">Dikembalikan</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection