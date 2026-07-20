<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-end mb-8 animate-fade-in-up">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Data Santri</h1>
        <p class="text-gray-500 text-sm mt-2 font-medium">Kelola seluruh data induk santri dan penempatan asrama.</p>
    </div>
    <a href="<?= base_url('santri/create') ?>" class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white px-6 py-2.5 rounded-xl font-medium shadow-lg shadow-emerald-500/30 transition-all transform hover:-translate-y-0.5 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Tambah Santri
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden animate-fade-in-up" style="animation-delay: 0.1s;">
    <!-- Toolbar Tabel -->
    <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center bg-white space-y-4 md:space-y-0">
        <div class="relative w-full md:w-80">
            <input type="text" id="searchInput" name="search" value="<?= esc($search ?? '') ?>" placeholder="Cari NIS atau Nama Santri..." class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-transparent rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
            <div class="absolute left-4 top-3.5">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
        
        <div class="flex space-x-3 w-full md:w-auto">
            <button class="px-4 py-2.5 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-700 rounded-xl text-sm font-medium transition-colors flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
        </div>
    </div>
    
    <!-- Table Data -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">NIS</th>
                    <th class="px-6 py-4 font-semibold">Nama Lengkap</th>
                    <th class="px-6 py-4 font-semibold">Asrama</th>
                    <th class="px-6 py-4 font-semibold">Halaqoh</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody id="santriTableBody" class="divide-y divide-gray-100 text-sm relative">
                <?php if(empty($santris)): ?>
                    <tr><td colspan="6" class="px-8 py-16 text-center text-gray-500">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <p class="text-base font-medium text-gray-800">Belum ada data santri</p>
                        <p class="mt-1 text-sm text-gray-400">Data santri yang diinput akan muncul di sini.</p>
                    </td></tr>
                <?php else: ?>
                    <?php foreach($santris as $s): ?>
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md border border-emerald-100">
                                <?= esc($s['nis']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800"><?= esc($s['nama_lengkap']) ?></td>
                        <td class="px-6 py-4 text-gray-600">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                <?= esc($s['nama_kamar'] ?? '-') ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                                <?= esc($s['nama_halaqoh'] ?? '-') ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <?php if($s['status'] == 'aktif'): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span> Aktif
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span> Tidak Aktif
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="<?= base_url('santri/edit/'.$s['id']) ?>" class="text-blue-600 hover:text-blue-900 bg-white hover:bg-blue-50 border border-gray-200 hover:border-blue-200 px-3 py-1.5 rounded-lg text-sm font-medium transition-all">Edit</a>
                                <a href="<?= base_url('santri/delete/'.$s['id']) ?>" onclick="return confirm('Yakin ingin menghapus santri ini?');" class="text-red-600 hover:text-red-900 bg-white hover:bg-red-50 border border-gray-200 hover:border-red-200 px-3 py-1.5 rounded-lg text-sm font-medium transition-all">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Container untuk Paginasi -->
    <div id="pagination-container" class="px-6 py-4 border-t border-gray-100 flex justify-between items-center">
        <?= $pager->links('santri', 'tailwind') ?>
    </div>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; transform: translateY(10px); }
    @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('santriTableBody');
    const paginationContainer = document.getElementById('pagination-container');
    let searchTimeout;

    searchInput.addEventListener('input', function(e) {
        const query = e.target.value;
        
        // Menampilkan loading indikator tipis (opsional)
        tableBody.style.opacity = '0.5';

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            fetch(`<?= base_url('santri') ?>?search=${encodeURIComponent(query)}`, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => response.json())
            .then(res => {
                tableBody.innerHTML = '';
                tableBody.style.opacity = '1';

                if (res.data.length === 0) {
                    tableBody.innerHTML = `
                    <tr><td colspan="6" class="px-8 py-16 text-center text-gray-500">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <p class="text-base font-medium text-gray-800">Tidak ada santri ditemukan</p>
                        <p class="mt-1 text-sm text-gray-400">Pencarian tidak membuahkan hasil.</p>
                    </td></tr>`;
                } else {
                    res.data.forEach(s => {
                        const statusBadge = s.status === 'aktif' 
                            ? `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span> Aktif</span>`
                            : `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800"><span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span> Tidak Aktif</span>`;
                        
                        const kamar = s.nama_kamar ? s.nama_kamar : '-';
                        const halaqoh = s.nama_halaqoh ? s.nama_halaqoh : '-';

                        tableBody.innerHTML += `
                        <tr class="hover:bg-gray-50/80 transition-colors group animate-fade-in-up" style="animation-duration: 0.3s;">
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md border border-emerald-100">
                                    ${s.nis}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800">${s.nama_lengkap}</td>
                            <td class="px-6 py-4 text-gray-600">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                    ${kamar}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                                    ${halaqoh}
                                </span>
                            </td>
                            <td class="px-6 py-4">${statusBadge}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="${res.edit_url}${s.id}" class="text-blue-600 hover:text-blue-900 bg-white hover:bg-blue-50 border border-gray-200 hover:border-blue-200 px-3 py-1.5 rounded-lg text-sm font-medium transition-all">Edit</a>
                                    <a href="${res.delete_url}${s.id}" onclick="return confirm('Yakin ingin menghapus santri ini?');" class="text-red-600 hover:text-red-900 bg-white hover:bg-red-50 border border-gray-200 hover:border-red-200 px-3 py-1.5 rounded-lg text-sm font-medium transition-all">Hapus</a>
                                </div>
                            </td>
                        </tr>
                        `;
                    });
                }
                
                // Update pagination links
                if (res.pager) {
                    paginationContainer.innerHTML = res.pager;
                }
            })
            .catch(err => {
                tableBody.style.opacity = '1';
                console.error("Search error:", err);
            });
        }, 500); // 500ms debounce
    });
});
</script>

<?= $this->endSection() ?>
