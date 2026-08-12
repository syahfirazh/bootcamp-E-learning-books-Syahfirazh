<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Perpustakaan Digital')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Google Font Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f3f4f6;
            background-image: 
                radial-gradient(at 10% 10%, rgba(219, 234, 254, 0.6) 0px, transparent 50%),
                radial-gradient(at 90% 90%, rgba(254, 243, 199, 0.5) 0px, transparent 50%),
                radial-gradient(#cbd5e1 0.8px, transparent 0.8px);
            background-size: 100% 100%, 100% 100%, 18px 18px;
            background-attachment: fixed;
        }
    </style>
</head>

<body class="text-slate-800 antialiased selection:bg-blue-200 selection:text-blue-900 min-h-screen flex flex-col overflow-x-hidden">

    <!-- Responsive Modern Navbar -->
    <nav class="bg-slate-900/90 text-white shadow-lg sticky top-0 z-50 border-b border-slate-800 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">

                <!-- Logo & Brand -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <div class="bg-gradient-to-tr from-blue-600 via-indigo-600 to-amber-500 text-white p-2 sm:p-2.5 rounded-xl sm:rounded-2xl shadow-md shadow-blue-500/20">
                        <i data-lucide="library" class="w-5 h-5 sm:w-6 sm:h-6"></i>
                    </div>

                    <div class="flex flex-col">
                        <span class="font-extrabold text-base sm:text-lg tracking-tight bg-gradient-to-r from-white via-slate-100 to-blue-200 bg-clip-text text-transparent">
                            E-Library Admin
                        </span>
                        <span class="hidden sm:block text-[10px] text-blue-300 font-bold uppercase tracking-widest leading-none mt-0.5">
                            Perpustakaan Digital
                        </span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-1.5 sm:space-x-3">

                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="text-slate-300 hover:text-white hover:bg-white/10 transition-all duration-200 p-2 sm:px-3.5 sm:py-2 rounded-xl text-xs sm:text-sm font-bold flex items-center gap-2">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                        <span class="hidden md:inline">Dashboard</span>
                    </a>

                    <!-- Manage Links (Katalog Buku) -->
                    <a href="{{ route('admin.links.index') }}"
                        class="text-slate-300 hover:text-white hover:bg-white/10 transition-all duration-200 p-2 sm:px-3.5 sm:py-2 rounded-xl text-xs sm:text-sm font-bold flex items-center gap-2">
                        <i data-lucide="book-open" class="w-4 h-4"></i>
                        <span class="hidden md:inline">Katalog Buku</span>
                    </a>

                    <!-- Preview Public -->
                    <a href="{{ route('public.index') }}" target="_blank"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold px-3 py-2 sm:px-4 sm:py-2 rounded-xl text-xs transition-all duration-200 flex items-center gap-1.5 shadow-md shadow-blue-600/25 active:scale-95">
                        <span class="hidden sm:inline">Preview Publik</span>
                        <span class="sm:hidden">Preview</span>
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                    </a>

                    <!-- Form Logout -->
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit"
                                class="bg-rose-500/20 hover:bg-rose-500/30 text-rose-200 hover:text-rose-100 font-extrabold text-xs px-3 py-2 sm:px-4 sm:py-2 rounded-xl border border-rose-500/30 transition-all flex items-center gap-1.5 active:scale-95">
                            <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:py-8 px-4 sm:px-6 lg:px-8 flex-grow w-full">

        <!-- Alert Notification -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50/90 backdrop-blur-md text-emerald-800 font-bold rounded-2xl border border-emerald-200 shadow-sm flex items-center gap-3">
                <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                <span class="text-xs sm:text-sm">
                    {{ session('success') }}
                </span>
            </div>
        @endif

        @yield('content')

    </main>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-md border-t border-slate-200/80 text-center py-5 px-4 text-xs font-semibold text-slate-500 mt-auto">
        &copy; {{ date('Y') }} E-Library System &bull; Perpustakaan Digital Dashboard
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>