<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-8 animate-fade-in-up">
    <a href="<?= base_url('santri') ?>" class="inline-flex items-center text-sm font-medium text-emerald-600 hover:text-emerald-700 transition-colors mb-4">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Data Santri
    </a>
    <h1 class="text-3xl font-bold text-gray-800 tracking-tight"><?= $title ?></h1>
    <p class="text-gray-500 text-sm mt-2 font-medium">Lengkapi formulir di bawah ini untuk menyimpan data santri.</p>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden animate-fade-in-up p-8" style="animation-delay: 0.1s;">
    
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm mb-6 border border-red-100 flex items-start">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('santri/'.($santri ? 'update/'.$santri['id'] : 'store')) ?>" method="POST" class="space-y-6">
        <?= csrf_field() ?>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kolom 1 -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Induk Santri (NIS) *</label>
                    <input type="text" name="nis" value="<?= old('nis', $santri['nis'] ?? '') ?>" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" value="<?= old('nama_lengkap', $santri['nama_lengkap'] ?? '') ?>" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="<?= old('tempat_lahir', $santri['tempat_lahir'] ?? '') ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="<?= old('tanggal_lahir', $santri['tanggal_lahir'] ?? '') ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none text-gray-600">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Santri *</label>
                    <select name="status" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none text-gray-600">
                        <option value="aktif" <?= old('status', $santri['status'] ?? '') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="lulus" <?= old('status', $santri['status'] ?? '') == 'lulus' ? 'selected' : '' ?>>Lulus / Alumni</option>
                        <option value="keluar" <?= old('status', $santri['status'] ?? '') == 'keluar' ? 'selected' : '' ?>>Keluar / Pindah</option>
                    </select>
                </div>
            </div>

            <!-- Kolom 2 -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Penempatan Asrama (Pondokan)</label>
                    <select name="pondokan_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none text-gray-600">
                        <option value="">-- Pilih Asrama --</option>
                        <?php foreach($pondokan as $p): ?>
                            <option value="<?= $p['id'] ?>" <?= old('pondokan_id', $santri['pondokan_id'] ?? '') == $p['id'] ? 'selected' : '' ?>><?= esc($p['nama_kamar']) ?> (Kapasitas: <?= $p['kapasitas'] ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelompok Halaqoh</label>
                    <select name="halaqoh_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none text-gray-600">
                        <option value="">-- Pilih Halaqoh --</option>
                        <?php foreach($halaqoh as $h): ?>
                            <option value="<?= $h['id'] ?>" <?= old('halaqoh_id', $santri['halaqoh_id'] ?? '') == $h['id'] ? 'selected' : '' ?>><?= esc($h['nama_halaqoh']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Orang Tua / Wali</label>
                    <input type="text" name="nama_ortu" value="<?= old('nama_ortu', $santri['nama_ortu'] ?? '') ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telp / WhatsApp Wali</label>
                    <input type="text" name="no_telp_ortu" value="<?= old('no_telp_ortu', $santri['no_telp_ortu'] ?? '') ?>" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Riwayat Penyakit (Bila Ada)</label>
                <textarea name="riwayat_penyakit" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none"><?= old('riwayat_penyakit', $santri['riwayat_penyakit'] ?? '') ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Prestasi</label>
                <textarea name="prestasi" rows="3" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none"><?= old('prestasi', $santri['prestasi'] ?? '') ?></textarea>
            </div>
        </div>

        <div class="flex justify-end mt-8">
            <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-8 py-3 rounded-xl font-semibold shadow-lg shadow-emerald-500/30 transition-all transform hover:-translate-y-0.5">
                <?= $santri ? 'Simpan Perubahan' : 'Tambahkan Santri' ?>
            </button>
        </div>
    </form>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; transform: translateY(10px); }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
</style>
<?= $this->endSection() ?>
