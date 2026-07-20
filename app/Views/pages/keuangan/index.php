<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 animate-fade-in-up space-y-4 md:space-y-0">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Kas & Keuangan</h1>
        <p class="text-gray-500 text-sm mt-2 font-medium">Rekapitulasi total Pemasukan (Donasi/SPP) dan Pengeluaran pondok.</p>
    </div>
    <div class="flex space-x-3">
        <a href="<?= base_url('keuangan/donasi/create') ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 flex items-center text-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Pemasukan
        </a>
        <a href="<?= base_url('keuangan/pengeluaran/create') ?>" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-xl font-medium shadow-lg shadow-red-500/30 transition-all transform hover:-translate-y-0.5 flex items-center text-sm">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
            Pengeluaran
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl text-sm mb-6 border border-emerald-100 flex items-center animate-fade-in-up">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fade-in-up" style="animation-delay: 0.1s;">
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center">
        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center mr-5">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Total Pemasukan</p>
            <h3 class="text-2xl font-bold text-gray-800">Rp <?= number_format($totalPemasukan, 0, ',', '.') ?></h3>
        </div>
    </div>
    
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-center">
        <div class="w-14 h-14 rounded-2xl bg-red-50 text-red-500 flex items-center justify-center mr-5">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500">Total Pengeluaran</p>
            <h3 class="text-2xl font-bold text-gray-800">Rp <?= number_format($totalPengeluaran, 0, ',', '.') ?></h3>
        </div>
    </div>

    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-6 shadow-lg shadow-emerald-500/20 text-white flex items-center">
        <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center mr-5 backdrop-blur-sm">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-medium text-emerald-100">Saldo Akhir (Kas)</p>
            <h3 class="text-2xl font-bold">Rp <?= number_format($saldoAkhir, 0, ',', '.') ?></h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-fade-in-up" style="animation-delay: 0.2s;">
    
    <!-- Tabel Pemasukan -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-lg font-bold text-gray-800">Riwayat Pemasukan</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Tgl / Ref</th>
                        <th class="px-6 py-3 font-semibold">Keterangan</th>
                        <th class="px-6 py-3 font-semibold text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <?php if(empty($donasi)): ?>
                        <tr><td colspan="3" class="px-6 py-8 text-center text-gray-400">Belum ada pemasukan</td></tr>
                    <?php else: ?>
                        <?php foreach($donasi as $d): ?>
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4 text-gray-500">
                                <?= date('d/m/Y', strtotime($d['created_at'])) ?><br>
                                <span class="text-xs text-blue-500 font-mono"><?= $d['order_id'] ?></span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                <?= esc($d['jenis_donasi']) ?>
                                <?php if($d['nama_santri']): ?>
                                    <span class="block text-xs text-gray-500 font-normal mt-0.5">Santri: <?= esc($d['nama_santri']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-right font-semibold text-blue-600">
                                + Rp <?= number_format($d['nominal'], 0, ',', '.') ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Pengeluaran -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-lg font-bold text-gray-800">Riwayat Pengeluaran</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Tanggal</th>
                        <th class="px-6 py-3 font-semibold">Keterangan</th>
                        <th class="px-6 py-3 font-semibold text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <?php if(empty($pengeluaran)): ?>
                        <tr><td colspan="3" class="px-6 py-8 text-center text-gray-400">Belum ada pengeluaran</td></tr>
                    <?php else: ?>
                        <?php foreach($pengeluaran as $p): ?>
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4 text-gray-500">
                                <?= date('d/m/Y', strtotime($p['tanggal'])) ?>
                                <span class="block text-xs text-gray-400 mt-0.5">Oleh: <?= esc($p['nama_user'] ?? 'Admin') ?></span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                <?= esc($p['keterangan']) ?>
                            </td>
                            <td class="px-6 py-4 text-right font-semibold text-red-600">
                                - Rp <?= number_format($p['nominal'], 0, ',', '.') ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; transform: translateY(10px); }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
</style>
<?= $this->endSection() ?>
