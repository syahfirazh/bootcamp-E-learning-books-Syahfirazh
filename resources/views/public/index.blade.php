<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Katalog Buku Digital</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f6f5f2;
            /* Background Aesthetic: Pola grid halus dengan sentuhan gradient lembut */
            background-image: 
                radial-gradient(at 0% 0%, rgba(224, 231, 255, 0.5) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(254, 243, 199, 0.4) 0px, transparent 50%),
                radial-gradient(#cbd5e1 0.75px, transparent 0.75px);
            background-size: 100% 100%, 100% 100%, 20px 20px;
            background-attachment: fixed;
        }

        /* Efek Book Spine (Ketebalan Buku) di Cover */
        .book-spine::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 5px;
            background: linear-gradient(to right, rgba(0,0,0,0.25), transparent);
            z-index: 10;
        }
    </style>
</head>

<body class="min-h-screen text-slate-800 pb-20 antialiased">

    <!-- HEADER NAVIGATION & BANNER (Glassmorphism Effect) -->
    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-30 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-tr from-blue-700 to-indigo-600 rounded-xl flex items-center justify-center text-white shadow-md shadow-blue-500/20">
                    <i data-lucide="book-open" class="w-5 h-5"></i>
                </div>
                <div>
                    <h1 class="text-base font-extrabold text-slate-900 leading-none tracking-tight">Perpustakaan Digital</h1>
                    <p class="text-[11px] font-medium text-slate-500 mt-1">Jelajahi koleksi buku & sumber daya digital</p>
                </div>
            </div>
            
            
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 pt-8">

        <!-- FITUR PENCARIAN BUKU -->
        <div class="bg-white/90 backdrop-blur-md p-3 md:p-4 rounded-2xl border border-slate-200/80 shadow-sm mb-8">
            <div class="relative flex items-center">
                <i data-lucide="search" class="w-5 h-5 text-slate-400 absolute left-4"></i>
                <input type="text" id="searchInput" onkeyup="filterBooks()" placeholder="Cari nama buku..." 
                    class="w-full pl-11 pr-28 py-3 bg-slate-50/80 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all">
                <button type="button" class="absolute right-2 px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-lg transition-colors shadow-sm">
                    Cari
                </button>
            </div>
        </div>

        <!-- HASIL KATALOG BUKU -->
        <div class="mb-5 flex items-center justify-between">
            <h2 class="text-sm font-extrabold text-slate-800 tracking-tight flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                <span>Daftar Buku Digital</span>
            </h2>
            <span class="text-xs font-semibold text-slate-500">Klik cover untuk mengunduh</span>
        </div>

        <div id="bookGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
            @foreach ($links as $link)
                <a href="{{ route('public.redirect', $link->id) }}" target="_blank" rel="noopener noreferrer"
                    class="book-card group bg-white/90 backdrop-blur-sm border border-slate-200/90 rounded-2xl overflow-hidden hover:shadow-2xl hover:shadow-blue-500/10 hover:border-blue-400/80 hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full relative">
                    
                    <!-- COVER BUKU -->
                    <div class="book-spine relative aspect-[3/4] w-full bg-slate-100 overflow-hidden border-b border-slate-100">
                        @if ($link->image)
                            <img src="{{ asset('storage/' . $link->image) }}" alt="{{ $link->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center p-4 text-center bg-gradient-to-br from-blue-50 via-indigo-50/50 to-slate-100">
                                <i data-lucide="book-marked" class="w-10 h-10 text-blue-600/40 mb-2"></i>
                                <span class="text-[10px] font-black uppercase text-blue-900/40 tracking-wider">E-Book</span>
                            </div>
                        @endif

                        <!-- BADGE LABEL E-BOOK -->
                        <span class="absolute top-2.5 right-2.5 px-2 py-0.5 bg-white/95 backdrop-blur-md border border-slate-200 text-[9px] font-extrabold text-slate-700 rounded-md shadow-sm">
                            PDF
                        </span>

                        <!-- OVERLAY ACTION HOVER -->
                        <div class="absolute inset-0 bg-slate-900/25 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[1px]">
                            <span class="p-3 bg-blue-600 text-white rounded-full shadow-lg transform translate-y-2 group-hover:translate-y-0 transition-transform">
                                <i data-lucide="download" class="w-4 h-4"></i>
                            </span>
                        </div>
                    </div>

                    <!-- DESKRIPSI DAN JUDUL -->
                    <div class="p-3.5 flex flex-col justify-between flex-1">
                        <div>
                            <h3 class="book-title font-bold text-slate-800 text-xs md:text-sm line-clamp-2 leading-snug group-hover:text-blue-600 transition-colors">
                                {{ $link->title }}
                            </h3>
                        </div>

                        <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between text-[11px]">
                            <span class="font-bold text-emerald-600 flex items-center gap-1">
                                <i data-lucide="arrow-down-circle" class="w-3.5 h-3.5"></i> Unduh
                            </span>
                            <i data-lucide="chevron-right" class="w-3.5 h-3.5 text-slate-400 group-hover:translate-x-0.5 transition-transform"></i>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8 w-full">
            {{ $links->links('vendor.pagination.custom-public') }}
        </div>

    </main>

    <!-- MODAL INFORMASI & KONTAK -->
   

    <script>
        lucide.createIcons();

        function filterBooks() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const bookCards = document.getElementsByClassName('book-card');

            for (let i = 0; i < bookCards.length; i++) {
                const title = bookCards[i].getElementsByClassName('book-title')[0].innerText.toLowerCase();
                if (title.includes(input)) {
                    bookCards[i].style.display = "";
                } else {
                    bookCards[i].style.display = "none";
                }
            }
        }

        const modal = document.getElementById('contact-modal');
        const modalContent = document.getElementById('modal-content');

        function openModal() {
            modal.classList.remove('hidden');
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('translate-y-full');
            });
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.add('opacity-0');
            modalContent.classList.add('translate-y-full');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }
    </script>
</body>

</html>