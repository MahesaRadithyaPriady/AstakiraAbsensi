<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>404 - Halaman Tidak Ditemukan</title>

    @vite(['resources/css/admin-login.css', 'resources/js/admin-login.js'])
</head>
<body class="min-h-screen bg-off-white">
    <div class="flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-md text-center">
            <div class="rounded-2xl bg-white shadow-xl shadow-primary-500/10 overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-brand-blue to-deep-blue"></div>

                <div class="px-8 py-12">
                    <div class="mb-6 flex justify-center">
                        <span class="text-7xl font-bold text-brand-blue">404</span>
                    </div>

                    <h1 class="text-2xl font-bold text-navy">Halaman Tidak Ditemukan</h1>
                    <p class="mt-2 text-sm text-slate-500">
                        Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan.
                    </p>

                    <a href="/administrator/login"
                       class="mt-8 inline-flex items-center justify-center gap-2 rounded-xl bg-brand-blue px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-primary-500/30 transition-all hover:bg-deep-blue active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-brand-blue focus:ring-offset-2">
                        <i data-lucide="arrow-left" class="h-4 w-4"></i>
                        <span>Kembali ke Login</span>
                    </a>
                </div>
            </div>

            <p class="mt-6 text-xs text-slate-400">
                &copy; {{ date('Y') }} Astakira Media. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
