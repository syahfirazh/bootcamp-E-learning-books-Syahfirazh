@extends('layouts.app')

@section('title', 'Tambah Buku Baru - Admin Dashboard')

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

<div class="max-w-3xl mx-auto space-y-6 p-2 sm:p-4 rounded-3xl admin-bg-aesthetic">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white/90 backdrop-blur-md p-5 sm:p-6 rounded-3xl border border-slate-200/90 shadow-md shadow-slate-200/50">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                {{-- Tombol navigasi kembali ke halaman daftar koleksi buku --}}
                <a href="{{ route('admin.links.index') }}" class="bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-600 p-2 rounded-xl border border-slate-200/80 transition-all shadow-sm">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <span>Tambah Buku Baru</span>
            </h1>
            <p class="text-xs font-semibold text-slate-500 mt-1 pl-11">Unggah berkas e-book PDF dan sampul baru ke katalog perpustakaan.</p>
        </div>
    </div>

    <!-- Container Form Utama -->
    <div class="bg-white/90 backdrop-blur-md rounded-3xl border border-slate-200/90 shadow-lg shadow-slate-200/60 p-6 sm:p-8">

        {{-- Form pengiriman data dengan enctype multipart/form-data wajib untuk mendukung pengunggahan berkas PDF & Cover --}}
        <form action="{{ route('admin.links.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            {{-- Token pengaman CSRF --}}
            @csrf

            <!-- Field 1: Judul Buku -->
            <div class="space-y-2">
                <label for="title" class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">Judul Buku Digital <span class="text-rose-500">*</span></label>
                {{-- Input teks judul buku dengan fitur old('title') untuk mempertahankan input jika validasi server gagal --}}
                <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: Pemrograman Web dengan Laravel 11" required
                       class="w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 font-bold text-slate-800 placeholder-slate-400 text-sm transition-all shadow-sm">
                {{-- Menampilkan umpan balik error validasi khusus untuk field judul --}}
                @error('title')
                    <p class="text-xs font-bold text-rose-600 flex items-center gap-1 mt-1">
                        <i data-lucide="circle-alert" class="w-3.5 h-3.5"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Field 2: Upload File PDF Buku -->
            <div class="space-y-2">
                <label for="pdf_file" class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">Berkas E-Book (PDF) <span class="text-rose-500">*</span></label>
                
                <div class="relative">
                    {{-- Native input file PDF disembunyikan; memicu fungsi JavaScript handlePdfSelect() saat file dipilih --}}
                    <input type="file" id="pdf_file" name="pdf_file" accept=".pdf" required class="hidden" onchange="handlePdfSelect(this)">
                    
                    {{-- Custom trigger label untuk menggantikan tampilan tombol file bawaan browser --}}
                    <label for="pdf_file" class="flex items-center justify-between px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 hover:border-blue-400 transition-all shadow-sm">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-lg bg-rose-50 text-rose-600 border border-rose-200/60 flex items-center justify-center shrink-0">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                            </div>
                            <span id="pdf-filename" class="text-xs font-bold text-slate-500 truncate">Pilih berkas PDF (Maks. 10MB)...</span>
                        </div>
                        <span class="px-3 py-1.5 bg-slate-200/80 hover:bg-blue-600 hover:text-white text-slate-700 rounded-lg text-xs font-extrabold transition-all shrink-0">
                            Cari Berkas
                        </span>
                    </label>
                </div>

                {{-- Menampilkan pesan error validasi jika berkas PDF tidak valid atau melebihi kapasitas limit --}}
                @error('pdf_file')
                    <p class="text-xs font-bold text-rose-600 flex items-center gap-1 mt-1">
                        <i data-lucide="circle-alert" class="w-3.5 h-3.5"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Field 3: Custom Drag & Drop Cover Image -->
            <div class="space-y-2">
                <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">Sampul / Cover Buku <span class="text-slate-400 font-semibold">(Opsional)</span></label>

                <div id="preview-wrapper" class="relative overflow-hidden rounded-2xl border border-dashed border-slate-300 bg-slate-50/60 transition-all hover:bg-slate-50 hover:border-blue-400">

                    <!-- Area Drag & Drop (State Kosong) -->
                    <div id="preview-empty" class="flex flex-col items-center justify-center gap-2 py-8 px-6 cursor-pointer">
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 border border-blue-200/60 flex items-center justify-center shadow-sm">
                            <i data-lucide="book-plus" class="w-6 h-6"></i>
                        </div>
                        <p class="text-xs font-extrabold text-slate-800 mt-1">Klik atau seret gambar cover ke sini</p>
                        <p class="text-[11px] font-semibold text-slate-400">Rasio Portrait (3:4) Disarankan • Format: JPG, PNG, WEBP (Maks. 2MB)</p>
                    </div>

                    <!-- Area Pratinjau Terisi (State Aktif) -->
                    {{-- Container JS yang akan dimunculkan saat gambar cover diunggah oleh user --}}
                    <div id="preview-filled" class="hidden">
                        <div class="p-4 bg-slate-100 flex items-center justify-center">
                            <img id="preview-img" src="" alt="Pratinjau Berkas" class="max-h-60 object-contain rounded-lg border border-slate-200 shadow-md">
                        </div>
                        <div class="flex justify-between items-center p-3.5 bg-white border-t border-slate-200">
                            <p id="preview-file-name" class="text-xs font-extrabold text-slate-800 truncate max-w-[200px]">nama-file.png</p>
                            <button type="button" id="preview-remove" class="text-xs text-rose-600 hover:text-rose-700 bg-rose-50 font-extrabold px-3 py-1.5 rounded-lg border border-rose-200/80 hover:bg-rose-100 transition-all flex items-center gap-1">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus Cover
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Native Input File (Disembunyikan) -->
                <input type="file" id="image" name="image" accept="image/*" class="hidden">

                {{-- Menampilkan pesan kesalahan jika terjadi eror validasi gambar --}}
                @error('image')
                    <p class="text-xs font-bold text-rose-600 flex items-center gap-1 mt-1">
                        <i data-lucide="circle-alert" class="w-3.5 h-3.5"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Field 4: Toggle Status Publikasi -->
            <div class="pt-2">
                <label for="is_active" class="cursor-pointer select-none">
                    <div class="flex items-center justify-between gap-4 bg-slate-50/80 border border-slate-200/80 rounded-2xl p-4 shadow-sm hover:border-blue-300 transition-all">
                        <div class="flex items-center gap-3">
                            <span class="bg-blue-50 text-blue-600 p-2.5 rounded-xl border border-blue-200/60 shadow-sm">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </span>
                            <div class="flex flex-col">
                                <span class="text-xs font-extrabold text-slate-900">Publikasikan Buku Ini</span>
                                <span id="is_active_hint" class="text-[11px] font-semibold text-slate-500">Buku akan langsung dapat diunduh di perpustakaan</span>
                            </div>
                        </div>
                        {{-- Checkbox status publikasi; aktif (checked) secara default untuk pembuatan buku baru --}}
                        <input type="checkbox" id="is_active" name="is_active" class="sr-only peer" checked>
                        <span class="relative w-11 h-6 bg-slate-300 peer-checked:bg-emerald-500 rounded-full border border-slate-300 transition-colors shrink-0 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:w-5 after:h-5 after:bg-white after:rounded-full after:border after:border-slate-300 transition-transform peer-checked:after:translate-x-5 shadow-inner"></span>
                    </div>
                </label>
            </div>

            <!-- Tombol Aksi Form -->
            <div class="pt-4 border-t border-slate-200/80 flex justify-end gap-3">
                <a href="{{ route('admin.links.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold py-2.5 px-5 rounded-xl border border-slate-200 text-xs transition-all">
                    Batal
                </a>
                {{-- Tombol submit untuk mengeksekusi penyimpanan data baru ke LinkController --}}
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-2.5 px-6 rounded-xl shadow-md shadow-blue-600/25 flex items-center gap-2 text-xs transition-all active:scale-95">
                    <i data-lucide="check" class="w-4 h-4 stroke-[2.5]"></i> Simpan Buku
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script Eksternal & Inline Helper -->
<script src="{{ asset('js/image-preview.js') }}"></script>
<script>
    // Logika JavaScript: Memperbarui nama file PDF pada UI saat user memilih file
    function handlePdfSelect(input) {
        const fileNameTarget = document.getElementById('pdf-filename');
        if (input.files && input.files[0]) {
            fileNameTarget.textContent = input.files[0].name;
            fileNameTarget.classList.remove('text-slate-500');
            fileNameTarget.classList.add('text-slate-800');
        } else {
            fileNameTarget.textContent = 'Pilih berkas PDF (Maks. 10MB)...';
            fileNameTarget.classList.remove('text-slate-800');
            fileNameTarget.classList.add('text-slate-500');
        }
    }

    // Logika JavaScript: Menyesuaikan teks petunjuk (hint) status publikasi berdasarkan toggle checkbox
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('is_active');
        const hint = document.getElementById('is_active_hint');

        if (toggle && hint) {
            const updateHint = () => {
                hint.textContent = toggle.checked
                    ? 'Buku akan langsung dapat diunduh di perpustakaan'
                    : 'Buku disembunyikan (simpan sebagai draf)';
            };
            toggle.addEventListener('change', updateHint);
            updateHint();
        }
    });
</script>
@endsection