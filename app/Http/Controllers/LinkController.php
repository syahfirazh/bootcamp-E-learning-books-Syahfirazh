<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class LinkController extends Controller
{
    /**
     * Menampilkan daftar seluruh buku digital di panel admin.
     */
    public function index(): View
    {
        // Mengambil data buku terbaru dan membaginya menjadi 10 data per halaman (pagination)
        $links = Link::latest()->paginate(10);
        
        // Merender tampilan tabel manajemen buku di admin
        return view('admin.links.index', compact('links'));
    }

    /**
     * Menampilkan formulir tambah buku digital baru.
     */
    public function create(): View
    {
        // Merender halaman formulir input buku baru
        return view('admin.links.create');
    }

    /**
     * Memproses dan menyimpan data buku digital baru ke database & storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input data: judul wajib, file PDF wajib (maks 10MB), dan gambar cover opsional (maks 2MB)
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'pdf_file' => 'required|file|mimes:pdf|max:10240', // Maksimal 10MB
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Menyimpan file PDF fisik ke folder 'storage/app/public/books_pdf'
        $pdfPath = $request->file('pdf_file')->store('books_pdf', 'public');

        // Pengecekan dan penyimpanan gambar cover jika diunggah
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books_covers', 'public');
        }

        // Menyimpan baris data baru ke tabel 'links'
        Link::create([
            'title' => $validated['title'],
            'pdf_file' => $pdfPath,
            'image' => $imagePath,
            'is_active' => $request->boolean('is_active'),
            'clicks' => 0, // Inisialisasi awal jumlah unduhan = 0
        ]);

        // Mengalihkan kembali ke halaman utama admin dengan pesan sukses
        return redirect()
            ->route('admin.links.index')
            ->with('success', 'Buku digital berhasil ditambahkan!');
    }

    /**
     * Menampilkan formulir edit buku berdasarkan data yang dipilih.
     */
    public function edit(Link $link): View
    {
        // Merender tampilan edit dengan membawa instance model $link yang dipilih
        return view('admin.links.edit', compact('link'));
    }

    /**
     * Memperbarui data buku digital yang sudah ada.
     */
    public function update(Request $request, Link $link): RedirectResponse
    {
        // Validasi input pembaruan data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Logika update PDF: Jika ada PDF baru, hapus PDF lama dari storage lalu simpan yang baru
        $pdfPath = $link->pdf_file;
        if ($request->hasFile('pdf_file')) {
            if ($link->pdf_file && Storage::disk('public')->exists($link->pdf_file)) {
                Storage::disk('public')->delete($link->pdf_file);
            }
            $pdfPath = $request->file('pdf_file')->store('books_pdf', 'public');
        }

        // Logika update Cover: Jika ada cover baru, hapus cover lama dari storage lalu simpan yang baru
        $imagePath = $link->image;
        if ($request->hasFile('image')) {
            if ($link->image && Storage::disk('public')->exists($link->image)) {
                Storage::disk('public')->delete($link->image);
            }
            $imagePath = $request->file('image')->store('books_covers', 'public');
        }

        // Memperbarui record data di database
        $link->update([
            'title' => $validated['title'],
            'pdf_file' => $pdfPath,
            'image' => $imagePath,
            'is_active' => $request->boolean('is_active'),
        ]);

        // Mengalihkan kembali ke halaman utama admin dengan pesan sukses
        return redirect()
            ->route('admin.links.index')
            ->with('success', 'Data buku berhasil diperbarui!');
    }

    /**
     * Menghapus data buku beserta berkas fisiknya dari sistem.
     */
    public function destroy(Link $link): RedirectResponse
    {
        // Menghapus berkas PDF fisik dari folder storage jika ada
        if ($link->pdf_file && Storage::disk('public')->exists($link->pdf_file)) {
            Storage::disk('public')->delete($link->pdf_file);
        }

        // Menghapus berkas gambar cover dari folder storage jika ada
        if ($link->image && Storage::disk('public')->exists($link->image)) {
            Storage::disk('public')->delete($link->image);
        }

        // Menghapus baris record dari database
        $link->delete();

        // Mengalihkan kembali ke halaman utama admin dengan pesan sukses
        return redirect()
            ->route('admin.links.index')
            ->with('success', 'Buku digital berhasil dihapus!');
    }
}