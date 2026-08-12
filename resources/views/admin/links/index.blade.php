@extends('layouts.app')

@section('title', 'Katalog Buku - Admin Dashboard')

@section('content')
<style>
    /* Styling khusus background presentasi aesthetic (non-white full) */
    .admin-bg-aesthetic {
        background-color: #f3f4f6;
        background-image: 
            radial-gradient(at 10% 10%, rgba(219, 234, 254, 0.6) 0px, transparent 50%),
            radial-gradient(at 90% 90%, rgba(254, 243, 199, 0.5) 0px, transparent 50%),
            radial-gradient(#cbd5e1 0.8px, transparent 0.8px);
        background-size: 100% 100%, 100% 100%, 18px 18px;
    }
</style>

<div class="space-y-6 p-2 sm:p-4 rounded-3xl admin-bg-aesthetic">
    
    <!-- HEADER SECTION -->
    <div class="bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-slate-200/90 shadow-md shadow-slate-200/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 transition-all">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-gradient-to-tr from-blue-600 via-indigo-600 to-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/25 shrink-0">
                <i data-lucide="library" class="w-6 h-6"></i>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Kelola Buku Digital</h1>
                <p class="text-xs font-semibold text-slate-500 mt-0.5">Atur koleksi e-book, berkas PDF, dan tautan unduhan perpustakaan Anda.</p>
            </div>
        </div>
        
        <!-- TOMBOL TAMBAH BUKU -->
        <a href="{{ route('admin.links.create') }}"
           class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-bold py-3 px-5 rounded-xl shadow-md shadow-blue-600/25 hover:shadow-lg transition-all flex items-center justify-center gap-2 text-xs">
            <i data-lucide="plus" class="w-4 h-4 stroke-[2.5]"></i>
            Tambah Buku Baru
        </a>
    </div>

    <!-- DATA LIST CONTAINER -->
    <div class="bg-white/90 backdrop-blur-md rounded-3xl border border-slate-200/90 shadow-lg shadow-slate-200/60 overflow-hidden flex flex-col">
        
        <!-- TABLE HEADER (Desktop) -->
        <div class="hidden lg:grid grid-cols-12 gap-4 bg-slate-100/90 text-slate-500 px-6 py-3.5 border-b border-slate-200/80 text-[11px] font-extrabold uppercase tracking-wider">
            <div class="col-span-5">Cover & Detail Buku</div>
            <div class="col-span-2">Status Akses</div>
            <div class="col-span-3">Statistik Unduhan</div>
            <div class="col-span-2 text-right">Aksi</div>
        </div>

        <!-- TABLE BODY -->
        <div class="divide-y divide-slate-200/70 bg-white/60">
            @forelse($links as $link)
                <!-- GRID ROW -->
                <div class="flex flex-col lg:grid lg:grid-cols-12 gap-4 lg:gap-4 items-start lg:items-center p-4 sm:p-5 hover:bg-blue-50/50 transition-all group">
                    
                    <!-- 1. COVER & JUDUL BUKU -->
                    <div class="lg:col-span-5 flex items-center space-x-3.5 w-full min-w-0">
                        <!-- THUMBNAIL COVER BUKU (Style Portrait 3:4) -->
                        <div class="flex-shrink-0 h-16 w-12 bg-slate-100 border border-slate-300 rounded-xl overflow-hidden shadow-sm group-hover:shadow-md transition-shadow flex items-center justify-center relative">
                            @if($link->image)
                                <img src="{{ asset('storage/' . $link->image) }}" alt="{{ $link->title }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-blue-50 to-amber-50 text-blue-600/50">
                                    <i data-lucide="book-marked" class="w-5 h-5"></i>
                                </div>
                            @endif
                        </div>

                        <div class="overflow-hidden min-w-0 flex-1">
                            <h2 class="text-sm font-extrabold text-slate-900 group-hover:text-blue-600 transition-colors truncate leading-snug">
                                {{ $link->title }}
                            </h2>
                            <div class="text-xs font-semibold text-slate-500 truncate mt-1 flex items-center gap-1.5">
                                <i data-lucide="link-2" class="w-3.5 h-3.5 text-blue-500 shrink-0"></i>
                                <span class="truncate">{{ $link->url }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- STATUS & STATISTIK (MOBILE & DESKTOP) -->
                    <div class="flex flex-row lg:contents w-full gap-4 mt-1 lg:mt-0">
                        <!-- 2. STATUS -->
                        <div class="lg:col-span-2 flex flex-col lg:flex-row items-start lg:items-center flex-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 lg:hidden">Status</span>
                            @if($link->is_active)
                                <span class="px-3 py-1 inline-flex text-xs font-extrabold rounded-lg bg-emerald-100/80 text-emerald-800 border border-emerald-300/60 items-center gap-1.5 whitespace-nowrap shadow-sm">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> Publik
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs font-extrabold rounded-lg bg-slate-200/80 text-slate-700 border border-slate-300 items-center gap-1.5 whitespace-nowrap shadow-sm">
                                    <span class="w-2 h-2 bg-slate-400 rounded-full"></span> Draf
                                </span>
                            @endif
                        </div>
                        
                        <!-- 3. STATISTIK UNDUHAN -->
                        <div class="lg:col-span-3 flex flex-col lg:flex-row items-start lg:items-center flex-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 lg:hidden">Total Unduh</span>
                            <div class="inline-flex items-center px-3 py-1 rounded-xl bg-amber-50/80 border border-amber-200/80 text-xs font-extrabold text-slate-800 whitespace-nowrap gap-1.5 shadow-sm">
                                <i data-lucide="download-cloud" class="w-3.5 h-3.5 text-blue-600"></i>
                                <span>{{ number_format($link->clicks) }}</span>
                                <span class="text-slate-500 font-semibold text-[11px]">Unduhan</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 4. AKSI -->
                    <div class="lg:col-span-2 flex items-center justify-start lg:justify-end gap-2 w-full lg:w-auto mt-2 lg:mt-0 pt-3 lg:pt-0 border-t border-slate-200/60 lg:border-none">

                        <!-- TOMBOL EDIT -->
                        <a href="{{ route('admin.links.edit', $link->id) }}"
                           class="flex-1 lg:flex-none text-center px-3.5 py-2 bg-white hover:bg-blue-50 text-slate-800 hover:text-blue-600 rounded-xl border border-slate-300 text-xs font-extrabold transition-all shadow-sm flex items-center justify-center gap-1.5">
                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i> Edit
                        </a>

                        <!-- FORM HAPUS -->
                        <form action="{{ route('admin.links.destroy', $link->id) }}"
                              method="POST"
                              class="flex-1 lg:flex-none m-0"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini? File cover dan tautan akan dihapus secara permanen.');">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="w-full text-center px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-xl border border-rose-200 text-xs font-extrabold transition-all shadow-sm flex items-center justify-center gap-1.5">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus
                            </button>
                        </form>

                    </div>
                </div>
            @empty
                <!-- EMPTY STATE -->
                <div class="px-6 py-16 text-center">
                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto p-8 bg-white/80 rounded-3xl border border-dashed border-slate-300 shadow-sm">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-3">
                            <i data-lucide="book-open-check" class="w-6 h-6"></i>
                        </div>
                        <h3 class="text-sm font-extrabold text-slate-800">Belum ada koleksi buku</h3>
                        <p class="text-xs text-slate-500 mt-1 font-medium">Mulai dengan menambahkan data e-book baru ke perpustakaan digital Anda.</p>
                        
                        <a href="{{ route('admin.links.create') }}" class="mt-4 px-4 py-2 bg-blue-600 text-white font-bold text-xs rounded-xl hover:bg-blue-700 transition-colors shadow-md shadow-blue-500/20">
                            + Tambah Buku
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION SECTION -->
        @if($links->hasPages())
            <div class="bg-slate-100/70 border-t border-slate-200/80 px-6 py-4">
                {{ $links->links('vendor.pagination.custom') }}
            </div>
        @endif
        
    </div>
</div>
@endsection