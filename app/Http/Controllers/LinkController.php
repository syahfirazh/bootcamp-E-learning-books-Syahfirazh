<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class LinkController extends Controller
{
    public function index(): View
    {
        $links = Link::latest()->paginate(10);
        return view('admin.links.index', compact('links'));
    }

    public function create(): View
    {
        return view('admin.links.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'pdf_file' => 'required|file|mimes:pdf|max:10240', // Maksimal 10MB
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $pdfPath = $request->file('pdf_file')->store('books_pdf', 'public');

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books_covers', 'public');
        }

        Link::create([
            'title' => $validated['title'],
            'pdf_file' => $pdfPath,
            'image' => $imagePath,
            'is_active' => $request->boolean('is_active'),
            'clicks' => 0,
        ]);

        return redirect()
            ->route('admin.links.index')
            ->with('success', 'Buku digital berhasil ditambahkan!');
    }

    public function edit(Link $link): View
    {
        return view('admin.links.edit', compact('link'));
    }

    public function update(Request $request, Link $link): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $pdfPath = $link->pdf_file;
        if ($request->hasFile('pdf_file')) {
            if ($link->pdf_file && Storage::disk('public')->exists($link->pdf_file)) {
                Storage::disk('public')->delete($link->pdf_file);
            }
            $pdfPath = $request->file('pdf_file')->store('books_pdf', 'public');
        }

        $imagePath = $link->image;
        if ($request->hasFile('image')) {
            if ($link->image && Storage::disk('public')->exists($link->image)) {
                Storage::disk('public')->delete($link->image);
            }
            $imagePath = $request->file('image')->store('books_covers', 'public');
        }

        $link->update([
            'title' => $validated['title'],
            'pdf_file' => $pdfPath,
            'image' => $imagePath,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.links.index')
            ->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy(Link $link): RedirectResponse
    {
        if ($link->pdf_file && Storage::disk('public')->exists($link->pdf_file)) {
            Storage::disk('public')->delete($link->pdf_file);
        }

        if ($link->image && Storage::disk('public')->exists($link->image)) {
            Storage::disk('public')->delete($link->image);
        }

        $link->delete();

        return redirect()
            ->route('admin.links.index')
            ->with('success', 'Buku digital berhasil dihapus!');
    }
}