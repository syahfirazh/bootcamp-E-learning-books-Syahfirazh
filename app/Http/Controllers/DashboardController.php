<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // 1. DATA UNTUK SUMMARY CARDS
        $totalLinks = Link::count();
        $activeLinks = Link::where('is_active', true)->count();
        $totalClicks = Link::sum('clicks');
        $topLink = Link::orderByDesc('clicks')->first();

        // 2. DATA UNTUK GRAFIK (Ambil 5 Link Teratas)
        $top5Links = Link::orderByDesc('clicks')->take(5)->get();
        
        // Memisahkan Judul dan Angka Klik ke dalam array untuk dibaca oleh Chart.js
        $chartLabels = $top5Links->pluck('title')->toArray();
        $chartData = $top5Links->pluck('clicks')->toArray();

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