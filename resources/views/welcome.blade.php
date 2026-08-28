<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JejakBaik - Catat Langkah Literasimu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-50">

    <nav class="flex items-center justify-between px-8 py-6 bg-white/80 backdrop-blur-md sticky top-0 z-50 shadow-sm">
        <div class="text-2xl font-bold text-teal-600">Jejak<span class="text-slate-800">Baik</span></div>
        <div class="space-x-6 hidden md:block text-slate-600 font-medium">
            <a href="#fitur" class="hover:text-teal-600 transition">Fitur</a>
            <a href="#cara-kerja" class="hover:text-teal-600 transition">Cara Kerja</a>
            <a href="/panel/login" class="px-6 py-2 border-2 border-teal-600 text-teal-600 rounded-full hover:bg-teal-600 hover:text-white transition">Masuk</a>
        </div>
    </nav>

    <header class="relative px-8 py-20 lg:py-32 flex flex-col items-center text-center">
        <div class="max-w-4xl">
            <span class="bg-teal-100 text-teal-700 px-4 py-1 rounded-full text-sm font-semibold mb-6 inline-block">
                Aplikasi Jurnal Membaca Siswa
            </span>
            <h1 class="text-4xl md:text-6xl font-bold text-slate-900 leading-tight mb-6">
                Abadikan Setiap Halaman yang Kamu <span class="text-teal-600 underline decoration-wavy">Jelajahi</span>.
            </h1>
            <p class="text-lg text-slate-600 mb-10 max-w-2xl mx-auto">
                JejakBaik membantu siswa mencatat progres membaca, mendapatkan feedback guru, dan membangun kebiasaan literasi yang bermakna setiap hari.
            </p>
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="/admin/register" class="px-8 py-4 bg-teal-600 text-white rounded-xl font-bold shadow-lg shadow-teal-200 hover:bg-teal-700 hover:-translate-y-1 transition duration-300">
                    Mulai Mencatat Sekarang
                </a>
                <a href="#fitur" class="px-8 py-4 bg-white text-slate-700 border border-slate-200 rounded-xl font-bold hover:bg-slate-50 transition">
                    Lihat Fitur
                </a>
            </div>
        </div>
    </header>

    <section class="px-8 py-12">
        <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 bg-white p-10 rounded-3xl shadow-xl shadow-slate-200/50">
            <div class="text-center">
                <div class="text-3xl font-bold text-slate-900">1,200+</div>
                <div class="text-slate-500 text-sm">Buku Terdaftar</div>
            </div>
            <div class="text-center border-l border-slate-100">
                <div class="text-3xl font-bold text-slate-900">5,000+</div>
                <div class="text-slate-500 text-sm">Log Membaca</div>
            </div>
            <div class="text-center border-l border-slate-100">
                <div class="text-3xl font-bold text-slate-900">850+</div>
                <div class="text-slate-500 text-sm">Siswa Aktif</div>
            </div>
            <div class="text-center border-l border-slate-100">
                <div class="text-3xl font-bold text-teal-600">100%</div>
                <div class="text-slate-500 text-sm">Terverifikasi</div>
            </div>
        </div>
    </section>

    <section id="fitur" class="px-8 py-20 max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-16">Mengapa Pakai JejakBaik?</h2>
        <div class="grid md:grid-cols-3 gap-10">
            <div class="p-8 bg-teal-50 rounded-3xl border border-teal-100">
                <div class="w-12 h-12 bg-teal-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-teal-200 text-xl">📝</div>
                <h3 class="text-xl font-bold mb-3">Pencatatan Mudah</h3>
                <p class="text-slate-600 leading-relaxed">Catat halaman awal, akhir, dan rangkuman hanya dalam hitungan detik setelah membaca.</p>
            </div>
            <div class="p-8 bg-amber-50 rounded-3xl border border-amber-100">
                <div class="w-12 h-12 bg-amber-500 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-amber-200 text-xl">🎯</div>
                <h3 class="text-xl font-bold mb-3">Pantau Progres</h3>
                <p class="text-slate-600 leading-relaxed">Lihat seberapa jauh kamu melangkah dengan persentase progres yang otomatis terhitung.</p>
            </div>
            <div class="p-8 bg-indigo-50 rounded-3xl border border-indigo-100">
                <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-indigo-200 text-xl">💬</div>
                <h3 class="text-xl font-bold mb-3">Feedback Guru</h3>
                <p class="text-slate-600 leading-relaxed">Dapatkan catatan dan verifikasi langsung dari gurumu untuk setiap bacaanmu.</p>
            </div>
        </div>
    </section>

    <footer class="px-8 py-12 border-t border-slate-200 text-center">
        <p class="text-slate-400 text-sm">
            &copy; 2026 JejakBaik - Platform Literasi Digital. Dibuat dengan ❤️ untuk Pendidikan Indonesia.
        </p>
    </footer>

</body>
</html>