@extends('layouts.app')

@section('title', 'Edit Buku - Admin Dashboard')

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
                <a href="{{ route('admin.links.index') }}" class="bg-slate-100 hover:bg-blue-50 text-slate-700 hover:text-blue-600 p-2 rounded-xl border border-slate-200/80 transition-all shadow-sm">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
                <span>Edit Buku Digital</span>
            </h1>
            <p class="text-xs font-semibold text-slate-500 mt-1 pl-11">Perbarui informasi, berkas PDF, atau sampul buku perpustakaan.</p>
        </div>
    </div>

    <!-- Container Form Utama -->
    <div class="bg-white/90 backdrop-blur-md rounded-3xl border border-slate-200/90 shadow-lg shadow-slate-200/60 p-6 sm:p-8">

        <form action="{{ route('admin.links.update', $link->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Field: Judul Buku -->
            <div class="space-y-2">
                <label for="title" class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">Judul Buku Digital <span class="text-rose-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $link->title) }}" required
                       class="w-full px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 font-bold text-slate-800 placeholder-slate-400 text-sm transition-all shadow-sm">
                @error('title')
                    <p class="text-xs font-bold text-rose-600 flex items-center gap-1 mt-1"><i data-lucide="circle-alert" class="w-3.5 h-3.5"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Field: File PDF Buku -->
            <div class="space-y-3">
                <label for="pdf_file" class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">Berkas E-Book (PDF) <span class="text-slate-400 font-semibold">(Opsional)</span></label>
                
                <!-- Information Card: PDF Aktif Saat Ini -->
                <div class="p-3.5 border border-slate-200 rounded-xl bg-slate-50/80 flex items-center justify-between gap-3 shadow-sm">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="p-2 bg-rose-50 text-rose-600 rounded-lg border border-rose-200/60 shrink-0">
                            <i data-lucide="file-check-2" class="w-4 h-4"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Berkas PDF Saat Ini:</p>
                            <p class="text-xs font-bold text-slate-800 truncate">{{ basename($link->pdf_file) }}</p>
                        </div>
                    </div>
                    <a href="{{ asset('storage/' . $link->pdf_file) }}" target="_blank" class="px-3 py-1.5 bg-white hover:bg-slate-100 text-slate-700 rounded-lg border border-slate-200 text-xs font-bold shrink-0 transition-all shadow-sm flex items-center gap-1">
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i> Lihat
                    </a>
                </div>

                <!-- Input Upload PDF Baru -->
                <div class="relative">
                    <input type="file" id="pdf_file" name="pdf_file" accept=".pdf" class="hidden" onchange="handlePdfSelect(this)">
                    
                    <label for="pdf_file" class="flex items-center justify-between px-4 py-3 bg-slate-50/80 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 hover:border-blue-400 transition-all shadow-sm">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 border border-blue-200/60 flex items-center justify-center shrink-0">
                                <i data-lucide="upload" class="w-5 h-5"></i>
                            </div>
                            <span id="pdf-filename" class="text-xs font-bold text-slate-500 truncate">Pilih PDF baru jika ingin mengganti...</span>
                        </div>
                        <span class="px-3 py-1.5 bg-slate-200/80 hover:bg-blue-600 hover:text-white text-slate-700 rounded-lg text-xs font-extrabold transition-all shrink-0">
                            Ganti Berkas
                        </span>
                    </label>
                </div>

                @error('pdf_file')
                    <p class="text-xs font-bold text-rose-600 flex items-center gap-1 mt-1"><i data-lucide="circle-alert" class="w-3.5 h-3.5"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Field: Sampul / Cover Buku Saat Ini & Preview -->
            <div class="space-y-3">
                <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">Sampul / Cover Buku <span class="text-slate-400 font-semibold">(Opsional)</span></label>

                <!-- Information Card: Cover Aktif -->
                <div class="p-3.5 border border-slate-200 rounded-xl bg-slate-50/80 flex items-center gap-4 shadow-sm">
                    <div class="shrink-0">
                        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-1.5">Cover Saat Ini:</p>
                        @if($link->image)
                            <img src="{{ asset('storage/' . $link->image) }}" class="h-16 w-12 object-cover border border-slate-300 rounded-lg shadow-sm" alt="Cover Saat Ini">
                        @else
                            <div class="h-16 w-12 bg-slate-200 border border-slate-300 rounded-lg flex items-center justify-center text-slate-400">
                                <i data-lucide="book" class="w-6 h-6"></i>
                            </div>
                        @endif
                    </div>
                    <div class="text-xs text-slate-500 font-medium">
                        @if($link->image)
                            <span class="font-bold text-slate-700 block mb-0.5">Sudah ada cover terpasang.</span>
                            Pilih gambar baru di bawah jika ingin mengganti cover saat ini.
                        @else
                            <span class="font-bold text-amber-600 block mb-0.5">Belum ada cover.</span>
                            Tambahkan gambar cover untuk mempercantik tampilan buku.
                        @endif
                    </div>
                </div>

                <!-- Dropzone Cover Baru -->
                <div id="preview-wrapper" class="relative overflow-hidden rounded-2xl border border-dashed border-slate-300 bg-slate-50/60 transition-all hover:bg-slate-50 hover:border-blue-400">
                    <div id="preview-empty" class="flex flex-col items-center justify-center gap-2 py-6 px-6 cursor-pointer text-center">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 border border-blue-200/60 flex items-center justify-center shadow-sm">
                            <i data-lucide="image-plus" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="text-xs font-extrabold text-slate-800">Ganti Cover Baru?</p>
                            <p class="text-[11px] font-semibold text-slate-400 mt-0.5">Biarkan kosong jika tidak ingin mengubah cover.</p>
                        </div>
                    </div>

                    <div id="preview-filled" class="hidden">
                        <div class="p-4 bg-slate-100 flex items-center justify-center">
                            <img id="preview-img" src="" class="max-h-52 object-contain rounded-lg border border-slate-200 shadow-md" alt="Pratinjau Cover Baru">
                        </div>
                        <div class="flex justify-between items-center p-3.5 bg-white border-t border-slate-200">
                            <p id="preview-file-name" class="text-xs font-extrabold text-slate-800 truncate max-w-[200px]">nama-file.png</p>
                            <button type="button" id="preview-remove" class="text-xs text-rose-600 hover:text-rose-700 bg-rose-50 font-extrabold px-3 py-1.5 rounded-lg border border-rose-200/80 hover:bg-rose-100 transition-all">Batal Ganti</button>
                        </div>
                    </div>
                </div>

                <input type="file" id="image" name="image" accept="image/*" class="hidden">
                @error('image')
                    <p class="text-xs font-bold text-rose-600 flex items-center gap-1 mt-1"><i data-lucide="circle-alert" class="w-3.5 h-3.5"></i> {{ $message }}</p>
                @enderror
            </div>

            <!-- Field: Toggle Status Publikasi -->
            <div class="pt-2">
                <label for="is_active" class="cursor-pointer select-none">
                    <div class="flex items-center justify-between gap-4 bg-slate-50/80 border border-slate-200/80 rounded-2xl p-4 shadow-sm hover:border-blue-300 transition-all">
                        <div class="flex items-center gap-3">
                            <span class="bg-blue-50 text-blue-600 p-2.5 rounded-xl border border-blue-200/60 shadow-sm">
                                <i data-lucide="eye" class="w-5 h-5"></i>
                            </span>
                            <div class="flex flex-col">
                                <span class="text-xs font-extrabold text-slate-900">Publikasikan Buku Ini</span>
                                <span id="is_active_hint" class="text-[11px] font-semibold text-slate-500 mt-0.5">Buku akan langsung dapat diunduh di perpustakaan</span>
                            </div>
                        </div>

                        <input type="checkbox" id="is_active" name="is_active" class="sr-only peer" {{ old('is_active', $link->is_active) ? 'checked' : '' }}>
                        <span class="relative w-11 h-6 bg-slate-300 peer-checked:bg-emerald-500 rounded-full border border-slate-300 transition-colors shrink-0 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:w-5 after:h-5 after:bg-white after:rounded-full after:border after:border-slate-300 transition-transform peer-checked:after:translate-x-5 shadow-inner"></span>
                    </div>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-200/80">
                <a href="{{ route('admin.links.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold py-2.5 px-5 rounded-xl border border-slate-200 text-xs transition-all">Batal</a>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-2.5 px-6 rounded-xl shadow-md shadow-emerald-600/25 flex items-center gap-2 text-xs transition-all active:scale-95">
                    <i data-lucide="check-circle-2" class="w-4 h-4 stroke-[2.5]"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/image-preview.js') }}"></script>
<script>
    // Fungsi menampilkan nama berkas PDF baru yang dipilih
    function handlePdfSelect(input) {
        const fileNameTarget = document.getElementById('pdf-filename');
        if (input.files && input.files[0]) {
            fileNameTarget.textContent = input.files[0].name;
            fileNameTarget.classList.remove('text-slate-500');
            fileNameTarget.classList.add('text-slate-800');
        } else {
            fileNameTarget.textContent = 'Pilih PDF baru jika ingin mengganti...';
            fileNameTarget.classList.remove('text-slate-800');
            fileNameTarget.classList.add('text-slate-500');
        }
    }

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