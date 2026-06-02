<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lab TEFA PPLG - Peminjaman Peralatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#b6252a',
                        primaryLight: '#ed1e28',
                        darkGray: '#55565b',
                        mediumGray: '#959597',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">

    <!-- Sidebar & Content (tanpa navbar atas) -->
    <div class="flex min-h-screen">
        <!-- Sidebar dengan warna #b6252a -->
        <div class="w-64 bg-primary shadow-lg flex flex-col justify-between min-h-screen">
            <!-- Logo/Tulisan di atas -->
            <div class="pt-6 pb-4">
                <div class="text-center border-b border-white border-opacity-30 pb-4 mx-4">
                    <i class="fas fa-flask text-4xl text-white mb-2"></i>
                    <h1 class="text-white text-xl font-bold">Lab TEFA PPLG</h1>
                    <p class="text-white text-xs opacity-80">Peminjaman Peralatan</p>
                </div>
                
                <!-- Menu Navigasi -->
                <nav class="mt-6">
                    <a href="{{ route('dashboard') }}" class="flex items-center py-3 px-6 text-white hover:bg-primaryLight transition {{ request()->routeIs('dashboard') ? 'bg-primaryLight' : '' }}">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('peminjam.index') }}" class="flex items-center py-3 px-6 text-white hover:bg-primaryLight transition {{ request()->routeIs('peminjam.*') ? 'bg-primaryLight' : '' }}">
                        <i class="fas fa-users w-5"></i>
                        <span class="ml-3">Data Peminjam</span>
                    </a>
                    <a href="{{ route('peralatan.index') }}" class="flex items-center py-3 px-6 text-white hover:bg-primaryLight transition {{ request()->routeIs('peralatan.*') ? 'bg-primaryLight' : '' }}">
                        <i class="fas fa-tools w-5"></i>
                        <span class="ml-3">Data Peralatan</span>
                    </a>
                    @endif
                    <a href="{{ route('peminjaman.index') }}" class="flex items-center py-3 px-6 text-white hover:bg-primaryLight transition {{ request()->routeIs('peminjaman.*') ? 'bg-primaryLight' : '' }}">
                        <i class="fas fa-hand-holding w-5"></i>
                        <span class="ml-3">Data Peminjaman</span>
                    </a>
                </nav>
            </div>

            <!-- User & Logout di bagian bawah -->
            <div class="pb-6">
                <div class="border-t border-white border-opacity-30 pt-4 mx-4">
                    <div class="flex items-center px-4 py-2">
                        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-white text-sm font-semibold">{{ auth()->user()->nama }}</p>
                            <p class="text-white text-xs opacity-75">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="flex items-center w-full py-3 px-6 text-white hover:bg-primaryLight transition rounded-lg">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span class="ml-3">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

</body>
</html>