<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lab TEFA PPLG - Peminjaman Peralatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">Lab TEFA PPLG</a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">
                        <i class="fas fa-user"></i> {{ auth()->user()->nama }}
                        <span class="text-xs bg-gray-200 px-2 py-1 rounded">{{ auth()->user()->role }}</span>
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar & Content -->
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg min-h-screen">
            <nav class="mt-5">
                <a href="{{ route('dashboard') }}" class="block py-2 px-4 text-gray-700 hover:bg-blue-50">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('peminjam.index') }}" class="block py-2 px-4 text-gray-700 hover:bg-blue-50">
                    <i class="fas fa-users"></i> Data Peminjam
                </a>
                <a href="{{ route('peralatan.index') }}" class="block py-2 px-4 text-gray-700 hover:bg-blue-50">
                    <i class="fas fa-tools"></i> Data Peralatan
                </a>
                @endif
                <a href="{{ route('peminjaman.index') }}" class="block py-2 px-4 text-gray-700 hover:bg-blue-50">
                    <i class="fas fa-hand-holding"></i> Data Peminjaman
                </a>
            </nav>
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