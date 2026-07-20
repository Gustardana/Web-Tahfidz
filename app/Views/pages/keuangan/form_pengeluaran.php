<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-8 animate-fade-in-up">
    <a href="<?= base_url('keuangan') ?>" class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-700 transition-colors mb-4">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Kas & Keuangan
    </a>
    <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Input Pengeluaran Kas</h1>
    <p class="text-gray-500 text-sm mt-2 font-medium">Catat pengeluaran operasional pondok.</p>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden animate-fade-in-up p-8 max-w-2xl" style="animation-delay: 0.1s;">
    
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm mb-6 border border-red-100 flex items-start">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('keuangan/pengeluaran/store') ?>" method="POST" class="space-y-6">
        <?= csrf_field() ?>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengeluaran *</label>
            <input type="date" name="tanggal" value="<?= old('tanggal', date('Y-m-d')) ?>" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none text-gray-600">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp) *</label>
            <input type="number" name="nominal" value="<?= old('nominal') ?>" placeholder="Contoh: 150000" min="1" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Rincian Pengeluaran *</label>
            <textarea name="keterangan" rows="3" placeholder="Contoh: Pembelian token listrik asrama putra" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none"><?= old('keterangan') ?></textarea>
        </div>

        <div class="flex justify-end mt-8 pt-4 border-t border-gray-100">
            <button type="submit" class="bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white px-8 py-3 rounded-xl font-semibold shadow-lg shadow-red-500/30 transition-all transform hover:-translate-y-0.5">
                Simpan Pengeluaran
            </button>
        </div>
    </form>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; transform: translateY(10px); }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
</style>
<?= $this->endSection() ?>
