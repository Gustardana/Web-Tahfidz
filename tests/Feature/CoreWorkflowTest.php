<?php

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * Pengujian End-to-End untuk Modul Inti (Transaksi Keuangan).
 * Skenario mengacu pada Alur Bisnis Poin 7 dan Poin 3 (Transaksi Aman).
 */
class CoreWorkflowTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    // Refresh database & jalankan Seeder sebelum tiap test case
    protected $refresh = true; 
    protected $seed    = 'App\Database\Seeds\MasterDataSeeder';

    /**
     * Skenario Uji 1: Penolakan input yang tidak valid pada Modul Kritis
     */
    public function test_transaksi_ditolak_jika_input_tidak_valid()
    {
        $result = $this->post('donasi/store', [
            'santri_id'    => null, // Sengaja dikosongkan (Invalid)
            'jenis_donasi' => 'SPP',
            'nominal'      => 'minus_satu' // Format invalid
        ]);

        // Verifikasi bahwa aplikasi merespon dengan redirect (ke halaman form kembali)
        $result->assertRedirect();
        
        // Verifikasi bahwa aplikasi menangkap kesalahan validasi
        $result->assertSessionHas('error'); 
    }

    /**
     * Skenario Uji 2 & 3: Alur Normal Transaksi & Webhook Eksternal (Mocking/Isolasi)
     */
    public function test_alur_normal_donasi_dan_isolasi_webhook_midtrans()
    {
        // =========================================================================
        // TAHAP 1: Mocking/Faking Konfigurasi Eksternal
        // Mencegah hit/ping langsung ke Server Midtrans.
        // Jika kode di Controller membaca 'isProduction' false dan key dummy, 
        // Snap API tidak akan me-request token betulan atau kita bypass logikanya.
        // =========================================================================
        putenv('payment.midtrans.serverKey=dummy-server-key');

        // Mendapatkan ID santri dari data seeder ('Ahmad Fulan' ber-NIS 100100100)
        $db = \Config\Database::connect();
        $santri = $db->table('santri')->where('nis', '100100100')->get()->getRow();
        
        $payloadKas = [
            'santri_id'    => $santri->id,
            'jenis_donasi' => 'SPP',
            'nominal'      => 500000,
            'keterangan'   => 'Pembayaran Bulan Juli'
        ];

        // Jalankan instruksi ke endpoint
        $result = $this->post('donasi/store', $payloadKas);
        
        // Verifikasi output respon (Sukses di-redirect dengan pesan sukses)
        $result->assertRedirectTo('donasi');
        $result->assertSessionHas('success');

        // =========================================================================
        // TAHAP 2: Verifikasi Integritas Data Pasca-Transaksi
        // =========================================================================
        // Validasi menggunakan Assert bawaan CI4: Pastikan data masuk & statusnya 'pending'
        $this->seeInDatabase('donasi', [
            'santri_id'         => $santri->id,
            'nominal'           => '500000.00',
            'status_pembayaran' => 'pending'
        ]);

        // =========================================================================
        // TAHAP 3: Simulasi (Mocking) Jalur Webhook Callback Midtrans
        // Saat pembayaran via QRIS sukses di sisi user, Midtrans me-request webhook kita.
        // =========================================================================
        // Ambil order_id yang digenerate oleh sistem di tabel donasi
        $donasi = $db->table('donasi')->orderBy('id', 'DESC')->get()->getRow();
        $orderId = $donasi->order_id;

        // Faking Payload Webhook JSON dari Midtrans
        $webhookPayload = json_encode([
            'order_id'           => $orderId,
            'transaction_status' => 'settlement' // Status = 'Lunas'
        ]);

        // Simulasikan request masuk (Hit Webhook)
        $webhookResult = $this->withBodyFormat('json')
                              ->withBody($webhookPayload)
                              ->post('donasi/midtransWebhook');
        
        // Verifikasi endpoint webhook mengembalikan Response HTTP 200 OK
        $webhookResult->assertStatus(200);

        // =========================================================================
        // TAHAP 4: Verifikasi Akhir Integritas Data (Data Mutasi)
        // =========================================================================
        // Status donasi WAJIB berubah dari 'pending' menjadi 'success'
        $this->seeInDatabase('donasi', [
            'order_id'          => $orderId,
            'status_pembayaran' => 'success'
        ]);
    }
}
