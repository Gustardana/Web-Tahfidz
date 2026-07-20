<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-8 animate-fade-in-up">
    <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Assalamu'alaikum, <span class="text-emerald-600"><?= session()->get('nama_lengkap') ?></span>! 👋</h1>
    <p class="text-gray-500 mt-2 text-sm font-medium">Berikut adalah ringkasan aktivitas dan data Pesantren hari ini.</p>
</div>

<!-- Grid Metrik Utama -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Card 1: Total Santri -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100/60 flex items-center space-x-5 hover:shadow-md transition-shadow duration-300">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/30 transform -rotate-6">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Santri</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-1"><?= $total_santri ?? 0 ?></h3>
        </div>
    </div>

    <!-- Card 2: Asrama -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100/60 flex items-center space-x-5 hover:shadow-md transition-shadow duration-300">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-400 to-indigo-500 text-white flex items-center justify-center shadow-lg shadow-blue-500/30 transform rotate-3">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kamar/Asrama</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-1"><?= $total_pondokan ?? 0 ?></h3>
        </div>
    </div>

    <!-- Card 3: Halaqoh -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100/60 flex items-center space-x-5 hover:shadow-md transition-shadow duration-300">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 text-white flex items-center justify-center shadow-lg shadow-amber-500/30 transform -rotate-3">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Halaqoh</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-1"><?= $total_halaqoh ?? 0 ?></h3>
        </div>
    </div>

    <!-- Card 4: Keuangan -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100/60 flex items-center space-x-5 hover:shadow-md transition-shadow duration-300">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-400 to-pink-500 text-white flex items-center justify-center shadow-lg shadow-purple-500/30 transform rotate-6">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">SPP Bln Ini</p>
            <h3 class="text-xl font-bold text-gray-800 mt-1">Rp <?= number_format($pemasukan_bulan_ini ?? 0, 0, ',', '.') ?></h3>
        </div>
    </div>
</div>

<!-- Quick Access Area -->
<div class="bg-white rounded-3xl shadow-sm border border-gray-100/60 p-8 relative overflow-hidden">
    <!-- Dekorasi Akses Cepat -->
    <div class="absolute right-0 top-0 w-64 h-64 bg-emerald-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 transform translate-x-1/2 -translate-y-1/2"></div>
    
    <h2 class="text-xl font-bold text-gray-800 mb-6 relative z-10">Akses Modul Cepat</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 relative z-10">
        <a href="/santri" class="flex flex-col items-center justify-center p-6 rounded-2xl bg-gray-50/50 hover:bg-emerald-50 hover:border-emerald-100 border border-transparent transition-all duration-300 group transform hover:-translate-y-1">
            <div class="w-12 h-12 rounded-xl bg-white text-gray-400 group-hover:text-emerald-500 flex items-center justify-center mb-4 shadow-sm group-hover:shadow transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <span class="text-sm font-semibold text-gray-700 group-hover:text-emerald-700">Data Santri</span>
        </a>
        
        <a href="/donasi" class="flex flex-col items-center justify-center p-6 rounded-2xl bg-gray-50/50 hover:bg-emerald-50 hover:border-emerald-100 border border-transparent transition-all duration-300 group transform hover:-translate-y-1">
            <div class="w-12 h-12 rounded-xl bg-white text-gray-400 group-hover:text-emerald-500 flex items-center justify-center mb-4 shadow-sm group-hover:shadow transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            </div>
            <span class="text-sm font-semibold text-gray-700 group-hover:text-emerald-700">Scanner Pembayaran</span>
        </a>

        <!-- Menu lain bisa ditambahkan ke depannya (Mutabaah, dsb) -->
        <a href="#" class="flex flex-col items-center justify-center p-6 rounded-2xl bg-gray-50/50 hover:bg-emerald-50 hover:border-emerald-100 border border-transparent transition-all duration-300 group transform hover:-translate-y-1 opacity-60">
            <div class="w-12 h-12 rounded-xl bg-white text-gray-400 group-hover:text-emerald-500 flex items-center justify-center mb-4 shadow-sm group-hover:shadow transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
            <span class="text-sm font-semibold text-gray-700 group-hover:text-emerald-700">Setoran Hafalan</span>
        </a>
    </div>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
<?= $this->endSection() ?>
