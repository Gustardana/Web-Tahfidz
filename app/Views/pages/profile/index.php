<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="mb-8 animate-fade-in-up">
    <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Profil Saya</h1>
    <p class="text-gray-500 text-sm mt-2 font-medium">Kelola informasi pribadi dan pengaturan akun Anda.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 animate-fade-in-up" style="animation-delay: 0.1s;">
    
    <!-- Kolom Kiri: Foto Profil -->
    <div class="md:col-span-1">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 flex flex-col items-center justify-center text-center">
            <div class="relative group cursor-pointer w-40 h-40 mb-6">
                <?php if(!empty($user['foto_profil']) && file_exists(FCPATH . 'uploads/profile/' . $user['foto_profil'])): ?>
                    <img src="<?= base_url('uploads/profile/' . $user['foto_profil']) ?>" alt="Foto Profil" class="w-40 h-40 rounded-full object-cover shadow-lg border-4 border-white" id="preview-image">
                <?php else: ?>
                    <div class="w-40 h-40 rounded-full bg-gradient-to-br from-emerald-100 to-teal-200 text-emerald-600 flex items-center justify-center shadow-lg border-4 border-white" id="preview-image-container">
                        <span class="text-5xl font-bold uppercase" id="preview-text"><?= substr($user['nama_lengkap'], 0, 1) ?></span>
                    </div>
                    <img src="" alt="Foto Profil" class="w-40 h-40 rounded-full object-cover shadow-lg border-4 border-white hidden" id="preview-image">
                <?php endif; ?>
                
                <label for="foto_profil" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </label>
            </div>
            
            <h3 class="text-xl font-bold text-gray-800"><?= esc($user['nama_lengkap']) ?></h3>
            <p class="text-sm font-medium text-emerald-600 uppercase tracking-wide mt-1"><?= esc($user['role']) ?></p>
        </div>
    </div>

    <!-- Kolom Kanan: Form Data -->
    <div class="md:col-span-2">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl text-sm mb-6 border border-emerald-100 flex items-start">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm mb-6 border border-red-100 flex items-start">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <?php if(is_array(session()->getFlashdata('error'))): ?>
                            <ul class="list-disc pl-4">
                                <?php foreach(session()->getFlashdata('error') as $e): ?>
                                    <li><?= $e ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <?= session()->getFlashdata('error') ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('profile/update') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <?= csrf_field() ?>
                
                <!-- Input file disembunyikan, di-trigger dari label di area foto -->
                <input type="file" name="foto_profil" id="foto_profil" class="hidden" accept="image/jpeg,image/png,image/jpg" onchange="previewFile()">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username (ID Login)</label>
                    <input type="text" value="<?= esc($user['username']) ?>" disabled class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-sm outline-none text-gray-500 cursor-not-allowed">
                    <p class="text-xs text-gray-400 mt-1">Username tidak dapat diubah karena merupakan identitas *login* utama.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" value="<?= old('nama_lengkap', $user['nama_lengkap']) ?>" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none">
                </div>

                <div class="pt-4 border-t border-gray-100 mt-6">
                    <h4 class="text-sm font-bold text-gray-800 mb-4">Ganti Password (Opsional)</h4>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input type="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-sm outline-none">
                    </div>
                </div>

                <div class="flex justify-end mt-8">
                    <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-8 py-3 rounded-xl font-semibold shadow-lg shadow-emerald-500/30 transition-all transform hover:-translate-y-0.5">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewFile() {
        const file = document.getElementById('foto_profil').files[0];
        const previewImg = document.getElementById('preview-image');
        const container = document.getElementById('preview-image-container');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
                if(container) container.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    }
</script>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; transform: translateY(10px); }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
</style>
<?= $this->endSection() ?>
