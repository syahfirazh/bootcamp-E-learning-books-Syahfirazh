<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard analitik admin beserta statistik dan data grafik.
     */
    public function index(): View
    {
        // 1. LOGIKA DATA UNTUK SUMMARY CARDS
        
        // Menghitung akumulasi total seluruh koleksi buku yang tersimpan di database
        $totalLinks = Link::count();
        
        // Menghitung jumlah buku yang berstatus aktif/terpublikasi saja
        $activeLinks = Link::where('is_active', true)->count();
        
        // Menghitung akumulasi total seluruh angka unduhan/klik dari semua buku
        $totalClicks = Link::sum('clicks');
        
        // Mengambil 1 buku dengan jumlah unduhan terbanyak sebagai buku terfavorit
        $topLink = Link::orderByDesc('clicks')->first();

        // 2. LOGIKA DATA UNTUK GRAFIK ANALITIK (Chart.js)
        
        // Mengambil 5 buku dengan peringkat unduhan tertinggi
        $top5Links = Link::orderByDesc('clicks')->take(5)->get();
        
        // Memisahkan judul buku menjadi array string untuk digunakan sebagai label sumbu X/kategori grafik
        $chartLabels = $top5Links->pluck('title')->toArray();
        
        // Memisahkan nilai unduhan menjadi array angka untuk digunakan sebagai data batang/diagram grafik
        $chartData = $top5Links->pluck('clicks')->toArray();

        // Merender tampilan dashboard admin dengan mengirimkan seluruh variabel statistik yang telah diolah
        return view('admin.dashboard', compact(
            'totalLinks', 
            'activeLinks', 
            'totalClicks', 
            'topLink', 
            'chartLabels', 
            'chartData'
        ));
    }
}