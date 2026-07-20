<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-8 animate-fade-in-up">
    <a href="<?= base_url('mutabaah') ?>" class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-700 transition-colors mb-4">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Riwayat Mutabaah
    </a>
    <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Input Setoran Hafalan</h1>
    <p class="text-gray-500 text-sm mt-2 font-medium">Catat progress hafalan harian santri.</p>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden animate-fade-in-up p-8 max-w-3xl mx-auto" style="animation-delay: 0.1s;">
    
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm mb-6 border border-red-100 flex items-start">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('mutabaah/store') ?>" method="POST" class="space-y-6">
        <?= csrf_field() ?>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Santri *</label>
            <select name="santri_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none text-gray-600">
                <option value="">-- Pilih Santri --</option>
                <?php foreach($santris as $s): ?>
                    <option value="<?= $s['id'] ?>" <?= old('santri_id') == $s['id'] ? 'selected' : '' ?>><?= esc($s['nis']) ?> - <?= esc($s['nama_lengkap']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Setoran *</label>
                <input type="date" name="tanggal" value="<?= old('tanggal', date('Y-m-d')) ?>" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none text-gray-600">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Surat / Juz *</label>
                <input type="text" name="surat" value="<?= old('surat') ?>" placeholder="Contoh: Al-Baqarah / Juz 30" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ayat Mulai *</label>
                <input type="number" name="ayat_mulai" value="<?= old('ayat_mulai') ?>" min="1" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ayat Selesai *</label>
                <input type="number" name="ayat_selesai" value="<?= old('ayat_selesai') ?>" min="1" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Predikat Penilaian *</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-2">
                <label class="cursor-pointer">
                    <input type="radio" name="predikat" value="Mumtaz" class="peer sr-only" <?= old('predikat') == 'Mumtaz' ? 'checked' : '' ?> required>
                    <div class="text-center px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-600 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 peer-checked:border-emerald-500 hover:bg-gray-50 transition-all">Mumtaz</div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="predikat" value="Lancar" class="peer sr-only" <?= old('predikat') == 'Lancar' ? 'checked' : '' ?>>
                    <div class="text-center px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-600 peer-checked:bg-blue-50 peer-checked:text-blue-700 peer-checked:border-blue-500 hover:bg-gray-50 transition-all">Lancar</div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="predikat" value="Kurang Lancar" class="peer sr-only" <?= old('predikat') == 'Kurang Lancar' ? 'checked' : '' ?>>
                    <div class="text-center px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-600 peer-checked:bg-amber-50 peer-checked:text-amber-700 peer-checked:border-amber-500 hover:bg-gray-50 transition-all">Kurang</div>
                </label>
                <label class="cursor-pointer">
                    <input type="radio" name="predikat" value="Mengulang" class="peer sr-only" <?= old('predikat') == 'Mengulang' ? 'checked' : '' ?>>
                    <div class="text-center px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-600 peer-checked:bg-red-50 peer-checked:text-red-700 peer-checked:border-red-500 hover:bg-gray-50 transition-all">Mengulang</div>
                </label>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
            <textarea name="keterangan" rows="2" placeholder="Cth: Perbaiki tajwid di ayat 5" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none"><?= old('keterangan') ?></textarea>
        </div>

        <div class="flex justify-end mt-8 pt-4 border-t border-gray-100">
            <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-8 py-3 rounded-xl font-semibold shadow-lg shadow-emerald-500/30 transition-all transform hover:-translate-y-0.5">
                Simpan Setoran
            </button>
        </div>
    </form>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; transform: translateY(10px); }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
</style>
<?= $this->endSection() ?>
