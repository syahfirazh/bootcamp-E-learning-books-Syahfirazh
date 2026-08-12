<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Area - Admin Perpustakaan Digital</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
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
</head>
<body class="admin-bg-aesthetic min-h-screen antialiased flex flex-col justify-center py-12 sm:px-6 lg:px-8">

    <div class="sm:mx-auto sm:w-full sm:max-w-md px-4">

        <!-- Header Brand -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-gradient-to-tr from-blue-600 via-indigo-600 to-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/25 mx-auto mb-4">
                <i data-lucide="shield-check" class="w-7 h-7"></i>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Login Administrator</h1>
            <p class="text-xs font-semibold text-slate-500 mt-1.5">Masuk untuk mengelola katalog e-book & perpustakaan digital</p>
        </div>

        <!-- Form Container Card -->
        <div class="bg-white/90 backdrop-blur-md rounded-3xl border border-slate-200/90 p-6 sm:p-8 shadow-xl shadow-slate-200/60">

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Display Alert Error -->
                @if($errors->any())
                    <div class="bg-rose-50 border border-rose-200/80 p-3.5 rounded-xl flex items-start gap-3 shadow-sm">
                        <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600 shrink-0 mt-0.5"></i>
                        <p class="text-xs font-bold text-rose-700 leading-snug">{{ $errors->first() }}</p>
                    </div>
                @endif

                <!-- Input Email -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">Alamat Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="admin@library.id"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 font-bold text-slate-800 text-xs transition-all placeholder:text-slate-400 shadow-sm">
                    </div>
                </div>

                <!-- Input Password -->
                <div class="space-y-1.5">
                    <label for="password" class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">Kata Sandi</label>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input type="password" id="password" name="password" required placeholder="••••••••"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 font-bold text-slate-800 text-xs transition-all placeholder:text-slate-400 shadow-sm">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-extrabold py-3 rounded-xl shadow-md shadow-blue-600/25 transition-all flex items-center justify-center gap-2 text-xs">
                        <span>Masuk Dashboard</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 stroke-[2.5]"></i>
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>