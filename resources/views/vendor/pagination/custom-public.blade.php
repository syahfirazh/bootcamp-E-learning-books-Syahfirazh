@if ($paginator->hasPages())
    <div class="w-full flex justify-between items-center mt-8 px-1 gap-4">
        
        <!-- Tombol Prev -->
        @if ($paginator->onFirstPage())
            <div class="p-2.5 bg-slate-100/60 text-slate-300 rounded-xl border border-slate-200/50 cursor-not-allowed select-none">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </div>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" 
               class="p-2.5 bg-white/90 hover:bg-blue-600 text-slate-700 hover:text-white rounded-xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-blue-600 transition-all active:scale-95 flex items-center justify-center">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </a>
        @endif

        <!-- Indikator Halaman -->
        <span class="font-extrabold text-slate-700 text-xs tracking-wider bg-white/90 backdrop-blur-md px-3.5 py-2 rounded-xl border border-slate-200/80 shadow-sm">
            Halaman {{ $paginator->currentPage() }} <span class="text-slate-400 font-semibold">dari {{ $paginator->lastPage() }}</span>
        </span>

        <!-- Tombol Next -->
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" 
               class="p-2.5 bg-white/90 hover:bg-blue-600 text-slate-700 hover:text-white rounded-xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-blue-600 transition-all active:scale-95 flex items-center justify-center">
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        @else
            <div class="p-2.5 bg-slate-100/60 text-slate-300 rounded-xl border border-slate-200/50 cursor-not-allowed select-none">
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </div>
        @endif
        
    </div>
@endif