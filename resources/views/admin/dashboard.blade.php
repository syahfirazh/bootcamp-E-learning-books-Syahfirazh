@extends('layouts.app')

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
    
    <!-- HEADER DASHBOARD -->
    <div class="bg-white/90 backdrop-blur-md p-6 rounded-3xl border border-slate-200/90 shadow-md shadow-slate-200/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="w-3 h-3 bg-blue-600 rounded-full inline-block animate-pulse"></span>
                Dashboard Analistik
            </h1>
            <p class="text-xs font-semibold text-slate-500 mt-1">Ringkasan statistik koleksi & aktivitas unduhan e-book perpustakaan Anda.</p>
        </div>
        {{-- Tombol navigasi cepat ke halaman pengelolaan katalog buku --}}
        <a href="{{ route('admin.links.index') }}" class="hidden sm:inline-flex bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-md shadow-blue-600/25 transition-all active:scale-95 items-center gap-2 text-xs">
            Kelola Buku Digital <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>

    <!-- 1. SUMMARY CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Card: Total Koleksi Buku -->
        <div class="bg-white/90 backdrop-blur-md border border-slate-200/90 rounded-3xl p-6 shadow-lg shadow-slate-200/60 relative overflow-hidden group hover:-translate-y-1 transition-all">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4 border border-blue-200/60">
                <i data-lucide="book-open" class="w-6 h-6"></i>
            </div>
            <i data-lucide="book-open" class="w-24 h-24 text-blue-500/5 absolute -bottom-6 -right-6 group-hover:scale-110 transition-transform"></i>
            <h3 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider mb-1 relative z-10">Total Koleksi Buku</h3>
            <div class="flex items-baseline gap-2 relative z-10">
                {{-- Logika Pencetakan Data: Menampilkan total seluruh buku dan total yang berstatus aktif/terpublikasi --}}
                <span class="text-4xl font-extrabold text-slate-900">{{ $totalLinks }}</span>
                <span class="text-xs font-bold text-slate-500">({{ $activeLinks }} Terpublikasi)</span>
            </div>
        </div>

        <!-- Card: Total Unduhan PDF -->
        <div class="bg-white/90 backdrop-blur-md border border-slate-200/90 rounded-3xl p-6 shadow-lg shadow-slate-200/60 relative overflow-hidden group hover:-translate-y-1 transition-all">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 border border-emerald-200/60">
                <i data-lucide="download-cloud" class="w-6 h-6"></i>
            </div>
            <i data-lucide="download-cloud" class="w-24 h-24 text-emerald-500/5 absolute -bottom-6 -right-6 group-hover:scale-110 transition-transform"></i>
            <h3 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider mb-1 relative z-10">Total Unduhan PDF</h3>
            {{-- Logika Format Angka: Memformat akumulasi angka klik/unduhan dengan pemisah ribuan --}}
            <span class="text-4xl font-extrabold text-slate-900 relative z-10">{{ number_format($totalClicks) }}</span>
        </div>

        <!-- Card: Buku Terfavorit -->
        <div class="bg-white/90 backdrop-blur-md border border-slate-200/90 rounded-3xl p-6 shadow-lg shadow-slate-200/60 relative overflow-hidden group hover:-translate-y-1 transition-all">
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mb-4 border border-amber-200/60">
                <i data-lucide="trophy" class="w-6 h-6"></i>
            </div>
            <i data-lucide="trophy" class="w-24 h-24 text-amber-500/5 absolute -bottom-6 -right-6 group-hover:scale-110 transition-transform"></i>
            <h3 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider mb-1 relative z-10">Buku Terfavorit</h3>
            {{-- Logika Kondisional: Mengecek apakah terdapat data buku dengan unduhan terbanyak ($topLink) --}}
            @if($topLink)
                <p class="text-lg font-extrabold text-slate-900 relative z-10 truncate mb-1" title="{{ $topLink->title }}">{{ $topLink->title }}</p>
                <p class="text-xs font-bold text-amber-800 bg-amber-100/80 border border-amber-200 inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg relative z-10">
                    <i data-lucide="arrow-down-to-line" class="w-3 h-3"></i> {{ number_format($topLink->clicks) }} Unduhan
                </p>
            @else
                {{-- Tampilan fallback jika belum ada data transaksi unduhan di database --}}
                <p class="text-lg font-extrabold text-slate-400 relative z-10">Belum ada data</p>
            @endif
        </div>

    </div>

    <!-- 2 & 3. CHARTS AREA -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Bar Chart (Top 5 Buku Terpopuler) -->
        <div class="bg-white/90 backdrop-blur-md border border-slate-200/90 rounded-3xl p-6 shadow-lg shadow-slate-200/60 flex flex-col">
            <div class="flex items-center justify-between border-b border-slate-200/80 pb-4 mb-6">
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i data-lucide="bar-chart-2" class="w-4 h-4 text-blue-600"></i>
                    Top 5 Buku Paling Banyak Diunduh
                </h3>
            </div>
            
            {{-- Container Canvas Chart.js --}}
            <div class="relative w-full h-72">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- Doughnut Chart (Distribusi Minat Pembaca) -->
        <div class="bg-white/90 backdrop-blur-md border border-slate-200/90 rounded-3xl p-6 shadow-lg shadow-slate-200/60 flex flex-col">
            <div class="flex items-center justify-between border-b border-slate-200/80 pb-4 mb-6">
                <h3 class="text-sm font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i data-lucide="pie-chart" class="w-4 h-4 text-indigo-600"></i>
                    Distribusi Minat Pembaca
                </h3>
            </div>
            
            {{-- Container Canvas Chart.js --}}
            <div class="relative w-full h-72 flex justify-center items-center">
                <canvas id="doughnutChart"></canvas>
            </div>
        </div>

    </div>
</div>

<!-- ========================================== -->
<!-- SCRIPT CHART.JS SOFT MODERN STYLE          -->
<!-- ========================================== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Logika Konversi Data: Mengubah array PHP ($chartLabels & $chartData) menjadi format JSON yang dapat dibaca JavaScript
    const chartLabels = @json($chartLabels);
    const chartData = @json($chartData);

    // Konfigurasi Palet Warna Grafik
    const bgColors = ['#3b82f6', '#10b981', '#f59e0b', '#f43f5e', '#6366f1'];
    const hoverBgColors = ['#2563eb', '#059669', '#d97706', '#e11d48', '#4f46e5'];

    // Konfigurasi Font bawaan Chart.js
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.font.weight = 'bold';
    Chart.defaults.color = '#64748b';

    // 1. Logika Inisialisasi Bar Chart (Grafik Batang)
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Jumlah Unduhan',
                data: chartData,
                backgroundColor: bgColors,
                hoverBackgroundColor: hoverBgColors,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { 
                        precision: 0,
                        font: { size: 11 }
                    },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: { font: { size: 11 } },
                    grid: { display: false }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    padding: 12,
                    cornerRadius: 12,
                    displayColors: false,
                }
            }
        }
    });

    // 2. Logika Inisialisasi Doughnut Chart (Grafik Lingkaran)
    const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
    new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartData,
                backgroundColor: bgColors,
                hoverBackgroundColor: hoverBgColors,
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: { 
                    position: 'right',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 15,
                        font: { size: 11 }
                    }
                },
                tooltip: {
                    padding: 12,
                    cornerRadius: 12,
                }
            }
        }
    });
</script>
@endsection