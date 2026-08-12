@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-wrap items-center justify-center sm:justify-between w-full gap-3 mt-2 mb-2">

        {{-- Responsive Mobile Info (Hanya tampil di HP) --}}
        <div class="w-full sm:hidden text-center mb-2">
            <p class="text-xs font-bold text-slate-700">
                Menampilkan <span class="text-blue-600 font-black">{{ $paginator->firstItem() }}</span> - <span class="text-blue-600 font-black">{{ $paginator->lastItem() }}</span> dari <span class="text-slate-900 font-black">{{ $paginator->total() }}</span>
            </p>
        </div>

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 bg-slate-100 text-slate-400 rounded-xl border-2 border-slate-900 shadow-[2px_2px_0px_0px_#0f172a] cursor-not-allowed text-xs sm:text-sm font-bold opacity-70 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                Prev
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-4 py-2 bg-white hover:bg-amber-200 text-slate-900 rounded-xl border-2 border-slate-900 shadow-[2px_2px_0px_0px_#0f172a] hover:translate-x-0.5 hover:translate-y-0.5 hover:shadow-none transition-all text-xs sm:text-sm font-bold flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                Prev
            </a>
        @endif

        {{-- Numbered Links (Tampil di Desktop & Tablet) --}}
        <div class="hidden sm:flex items-center gap-2">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-3 py-2 bg-white text-slate-900 rounded-xl border-2 border-slate-900 shadow-[2px_2px_0px_0px_#0f172a] text-sm font-black">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3.5 py-2 bg-blue-400 text-slate-950 rounded-xl border-2 border-slate-900 shadow-[2px_2px_0px_0px_#0f172a] text-sm font-black">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="px-3.5 py-2 bg-white hover:bg-blue-200 text-slate-900 rounded-xl border-2 border-slate-900 shadow-[2px_2px_0px_0px_#0f172a] hover:translate-x-0.5 hover:translate-y-0.5 hover:shadow-none transition-all text-sm font-bold">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-4 py-2 bg-white hover:bg-amber-200 text-slate-900 rounded-xl border-2 border-slate-900 shadow-[2px_2px_0px_0px_#0f172a] hover:translate-x-0.5 hover:translate-y-0.5 hover:shadow-none transition-all text-xs sm:text-sm font-bold flex items-center gap-1">
                Next
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            </a>
        @else
            <span class="px-4 py-2 bg-slate-100 text-slate-400 rounded-xl border-2 border-slate-900 shadow-[2px_2px_0px_0px_#0f172a] cursor-not-allowed text-xs sm:text-sm font-bold opacity-70 flex items-center gap-1">
                Next
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            </span>
        @endif
    </nav>
@endif