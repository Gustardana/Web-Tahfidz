<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
    <div class="mb-8 border-b border-gray-100 pb-5 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Form Kas & Donasi</h2>
            <p class="text-gray-500 text-sm mt-1">Gunakan Barcode Scanner pada Kartu Santri atau input secara manual.</p>
        </div>
        <!-- Indikator Scanner Aktif -->
        <div id="scanner-indicator" class="flex items-center text-xs font-semibold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-100 transition-all">
            <span class="relative flex h-3 w-3 mr-2">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
            </span>
            Scanner Ready
        </div>
    </div>

    <form action="<?= base_url('donasi/store') ?>" method="POST" id="form-donasi" class="space-y-6">
        <!-- Keamanan CSRF -->
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Area Data Santri -->
            <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Santri</h3>
                
                <input type="hidden" name="santri_id" id="santri_id" required>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1">NIS (Scan/Ketik)</label>
                    <input type="text" id="nis_input" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary transition-shadow" placeholder="Scan Barcode Disini..." autocomplete="off">
                </div>

                <!-- Skeleton/Placeholder Info Santri -->
                <div id="santri-info" class="space-y-2 opacity-50 transition-opacity">
                    <div class="flex justify-between border-b border-gray-200 pb-1">
                        <span class="text-sm text-gray-500">Nama:</span>
                        <span id="label_nama" class="font-medium text-gray-800">-</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-1">
                        <span class="text-sm text-gray-500">Kamar/Pondokan:</span>
                        <span id="label_pondokan" class="font-medium text-gray-800">-</span>
                    </div>
                    <div class="flex justify-between pb-1">
                        <span class="text-sm text-gray-500">Wali:</span>
                        <span id="label_wali" class="font-medium text-gray-800">-</span>
                    </div>
                </div>
            </div>

            <!-- Area Pembayaran -->
            <div class="p-5">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Rincian Pembayaran</h3>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Jenis Transaksi</label>
                    <select name="jenis_donasi" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary bg-white">
                        <option value="SPP">Pembayaran SPP Bulanan</option>
                        <option value="INFAQ">Infaq / Shodaqoh</option>
                        <option value="WAKAF">Wakaf Pembangunan</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nominal (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500 font-medium">Rp</span>
                        <input type="text" id="nominal_display" class="w-full pl-10 pr-4 py-2 font-bold text-gray-800 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary text-lg" placeholder="0">
                        <input type="hidden" name="nominal" id="nominal_actual">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Catatan Tambahan</label>
                    <textarea name="keterangan" rows="2" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-primary focus:border-primary text-sm" placeholder="Opsional..."></textarea>
                </div>

                <button type="submit" id="btn-submit" disabled class="w-full bg-primary hover:bg-primaryDark text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-emerald-200 transition-all transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
                    Proses Pembayaran (QRIS / Transfer)
                </button>
            </div>
        </div>
    </form>
</div>

<!-- ==========================================
     INTEGRASI JS: Barcode & UX Enhancement
=========================================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. Integrasi Barcode Scanner (Poin 4) ---
    // Scanner perangkat keras mensimulasikan ketikan keyboard super cepat diakhiri dengan 'Enter'.
    let barcodeBuffer = '';
    let barcodeTimeout = null;

    document.addEventListener('keypress', function(e) {
        // Jika elemen yang difokuskan bukan input/textarea manual, kita tangkap global
        if (e.target.tagName === 'INPUT' && e.target.id !== 'nis_input' || e.target.tagName === 'TEXTAREA') {
            return; 
        }

        if (e.key === 'Enter') {
            e.preventDefault();
            if (barcodeBuffer.length >= 3) {
                // Trigger Ajax Call untuk mencari santri
                document.getElementById('nis_input').value = barcodeBuffer;
                fetchSantriData(barcodeBuffer);
            }
            barcodeBuffer = ''; // Reset
            return;
        }

        // Tangkap karakter
        barcodeBuffer += e.key;

        // Jika jeda ketikan lebih dari 100ms, kemungkinan diketik manual oleh manusia, bukan alat scanner.
        clearTimeout(barcodeTimeout);
        barcodeTimeout = setTimeout(() => {
            barcodeBuffer = '';
        }, 100); 
    });

    // Pemicu Manual (jika diketik manusia lalu tekan Enter/Blur)
    const nisInput = document.getElementById('nis_input');
    nisInput.addEventListener('change', function() {
        if(this.value) fetchSantriData(this.value);
    });

    function fetchSantriData(nis) {
        // Efek Loading
        document.getElementById('santri-info').classList.add('opacity-50');
        document.getElementById('label_nama').innerText = 'Mencari...';

        fetch(`<?= base_url('donasi/getSantriByNis') ?>?nis=${nis}`)
            .then(res => res.json())
            .then(response => {
                if(response.status === 'success') {
                    const santri = response.data;
                    document.getElementById('santri_id').value = santri.id;
                    document.getElementById('label_nama').innerText = santri.nama_lengkap;
                    document.getElementById('label_wali').innerText = santri.nama_ortu || '-';
                    document.getElementById('label_pondokan').innerText = santri.pondokan_id || 'Kamar Utama';
                    
                    document.getElementById('santri-info').classList.remove('opacity-50');
                    validateForm(); // Cek jika form siap disubmit
                } else {
                    alert('Santri dengan NIS ' + nis + ' tidak ditemukan!');
                    document.getElementById('santri_id').value = '';
                    document.getElementById('label_nama').innerText = 'Tidak Ditemukan';
                }
            }).catch(err => console.error(err));
    }


    // --- 2. Format Mata Uang Real-Time tanpa Reload (Poin Tambahan UX) ---
    const inputDisplay = document.getElementById('nominal_display');
    const inputActual = document.getElementById('nominal_actual');

    inputDisplay.addEventListener('input', function(e) {
        // Hapus karakter non-digit
        let val = this.value.replace(/[^0-9]/g, '');
        
        // Simpan nilai asli ke hidden input untuk backend (Decimal)
        inputActual.value = val;

        // Format untuk tampilan (Titik ribuan)
        if (val) {
            this.value = parseInt(val, 10).toLocaleString('id-ID');
        } else {
            this.value = '';
        }
        
        validateForm();
    });

    // --- 3. Validasi Dinamis Submit Button ---
    function validateForm() {
        const santriId = document.getElementById('santri_id').value;
        const nominal = document.getElementById('nominal_actual').value;
        const btnSubmit = document.getElementById('btn-submit');

        // Jika Santri sudah dipilih dan nominal > 0, aktifkan tombol
        if (santriId && nominal && parseInt(nominal) > 0) {
            btnSubmit.removeAttribute('disabled');
        } else {
            btnSubmit.setAttribute('disabled', 'true');
        }
    }
});
</script>

<!-- Midtrans Snap.js Modal (Poin 5) -->
<?php if (session()->get('snapToken')): ?>
    <script src="<?= env('payment.midtrans.isProduction') === 'true' ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' ?>" data-client-key="<?= env('payment.midtrans.clientKey') ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            snap.pay('<?= session()->get('snapToken') ?>', {
                onSuccess: function(result){
                    alert("Pembayaran Berhasil! Sistem Webhook otomatis mencatat pelunasan.");
                    window.location.reload();
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda.");
                },
                onError: function(result){
                    alert("Pembayaran Gagal.");
                },
                onClose: function(){
                    alert('Anda menutup popup sebelum menyelesaikan pembayaran');
                }
            });
        });
    </script>
<?php endif; ?>

<?= $this->endSection() ?>
