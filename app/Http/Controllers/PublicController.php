<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class PublicController extends Controller
{
    public function index(): View
    {
        $links = Link::where('is_active', true)
                     ->latest() #(Diurutkan berdasarkan waktu ditambahkan terbaru)
                     ->paginate(10); 
                    #'paginate(10)' (Dibatasi 10 data per halaman untuk fungsionalitas pagination)
        return view('public.index', compact('links'));
    }

    public function redirect(Link $link): RedirectResponse
    {
        // 1. Tambah hitungan unduhan secara atomic
        $link->increment('clicks');

        // 2. Redirect langsung ke file PDF yang disimpan di storage public
        return redirect()->away(asset('storage/' . $link->pdf_file));
    }
}