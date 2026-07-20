<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-end mb-8 animate-fade-in-up">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Mutabaah Hafalan</h1>
        <p class="text-gray-500 text-sm mt-2 font-medium">Catatan riwayat setoran hafalan harian santri.</p>
    </div>
    <a href="<?= base_url('mutabaah/create') ?>" class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg shadow-emerald-500/30 transition-all transform hover:-translate-y-0.5 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Input Setoran
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden animate-fade-in-up" style="animation-delay: 0.1s;">
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-emerald-50 text-emerald-600 p-4 text-sm border-b border-emerald-100 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Table Data -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Tanggal</th>
                    <th class="px-6 py-4 font-semibold">Nama Santri</th>
                    <th class="px-6 py-4 font-semibold">Surat / Juz</th>
                    <th class="px-6 py-4 font-semibold">Ayat</th>
                    <th class="px-6 py-4 font-semibold">Predikat</th>
                    <th class="px-6 py-4 font-semibold">Penyimak</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php if(empty($mutabaah)): ?>
                    <tr><td colspan="7" class="px-8 py-16 text-center text-gray-500">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <p class="text-base font-medium text-gray-800">Belum ada riwayat hafalan</p>
                    </td></tr>
                <?php else: ?>
                    <?php foreach($mutabaah as $m): ?>
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <td class="px-6 py-4 text-gray-500"><?= date('d M Y', strtotime($m['tanggal'])) ?></td>
                        <td class="px-6 py-4 font-semibold text-gray-800"><?= esc($m['nama_santri']) ?></td>
                        <td class="px-6 py-4 text-emerald-700 font-medium"><?= esc($m['surat']) ?></td>
                        <td class="px-6 py-4 text-gray-600"><?= $m['ayat_mulai'] ?> - <?= $m['ayat_selesai'] ?></td>
                        <td class="px-6 py-4">
                            <?php 
                                $color = 'gray';
                                if(strtolower($m['predikat']) == 'lancar' || strtolower($m['predikat']) == 'mumtaz') $color = 'emerald';
                                elseif(strtolower($m['predikat']) == 'mengulang') $color = 'red';
                                elseif(strtolower($m['predikat']) == 'kurang lancar') $color = 'amber';
                            ?>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-<?= $color ?>-100 text-<?= $color ?>-800 border border-<?= $color ?>-200">
                                <?= esc($m['predikat']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-xs"><?= esc($m['nama_ustadz'] ?? 'Admin') ?></td>
                        <td class="px-6 py-4 text-right">
                            <a href="<?= base_url('mutabaah/delete/'.$m['id']) ?>" onclick="return confirm('Hapus riwayat hafalan ini?');" class="text-red-600 hover:text-red-900 bg-white hover:bg-red-50 border border-gray-200 hover:border-red-200 px-3 py-1.5 rounded-lg text-sm font-medium transition-all opacity-0 group-hover:opacity-100">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; transform: translateY(10px); }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
</style>
<?= $this->endSection() ?>
