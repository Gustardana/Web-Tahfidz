<?php

namespace App\Controllers;

use App\Models\DonasiModel;
use App\Models\SantriModel;
use CodeIgniter\RESTful\ResourceController;

/**
 * Modul Paling Kritis (The Heart): Transaksi Pembayaran & Donasi
 * 
 * Menerapkan Atomic Transaction (Poin 3) untuk menghindari race condition
 * serta implementasi Midtrans API (Poin 5) untuk Payment Gateway.
 */
class DonasiController extends BaseController
{
    protected $donasiModel;
    protected $santriModel;

    public function __construct()
    {
        $this->donasiModel = new DonasiModel();
        $this->santriModel = new SantriModel();

        // Konfigurasi Midtrans SDK (Poin 5)
        // Note: Pastikan package midtrans/midtrans-php sudah terinstall via Composer
        if (class_exists('\Midtrans\Config')) {
            \Midtrans\Config::$serverKey = getenv('payment.midtrans.serverKey');
            \Midtrans\Config::$isProduction = getenv('payment.midtrans.isProduction') === 'true';
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;
        }
    }

    public function create()
    {
        $data['title'] = 'Form Kas & Donasi';
        return view('pages/keuangan/donasi_create', $data);
    }

    /**
     * Fungsi untuk Ajax Endpoint Barcode Scanner
     */
    public function getSantriByNis()
    {
        $nis = $this->request->getVar('nis');
        $santri = $this->santriModel->findByNis($nis);

        if ($santri) {
            return $this->response->setJSON(['status' => 'success', 'data' => $santri]);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Santri tidak ditemukan']);
    }

    /**
     * Memproses form kas dan melakukan integrasi Midtrans
     */
    public function store()
    {
        // Validasi input
        $rules = [
            'santri_id'    => 'required|integer',
            'jenis_donasi' => 'required',
            'nominal'      => 'required|numeric|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, cek nominal atau data santri.');
        }

        $db = \Config\Database::connect();
        
        // =========================================================================
        // ATOMIC TRANSACTION MULAI (Poin 3)
        // Mencegah anomali jika API Midtrans gagal tapi DB terlanjur tersimpan.
        // =========================================================================
        $db->transStart();

        try {
            $santriId = $this->request->getPost('santri_id');
            $nominal = $this->request->getPost('nominal');
            
            // Format order ID unik
            $orderId = 'TQ-DON-' . time() . '-' . rand(1000, 9999);

            // 1. Simpan Data Donasi ke Database sebagai status 'pending'
            $donasiData = [
                'santri_id'         => $santriId,
                'jenis_donasi'      => $this->request->getPost('jenis_donasi'),
                'nominal'           => $nominal,
                'tanggal'           => date('Y-m-d'),
                'keterangan'        => $this->request->getPost('keterangan'),
                'order_id'          => $orderId,
                'status_pembayaran' => 'pending',
                // 'user_id' => session()->get('user_id') // Aktifkan jika ada fitur Auth
            ];
            $this->donasiModel->insert($donasiData);

            $santri = $this->santriModel->find($santriId);

            // 2. Request Token dari API Midtrans (Poin 5)
            $snapToken = null;
            if (class_exists('\Midtrans\Snap')) {
                $transactionParams = [
                    'transaction_details' => [
                        'order_id' => $orderId,
                        'gross_amount' => (int) $nominal, // Midtrans menerima Integer
                    ],
                    'customer_details' => [
                        'first_name' => $santri['nama_lengkap'],
                        'phone'      => $santri['no_telp_ortu'],
                    ],
                ];
                $snapToken = \Midtrans\Snap::getSnapToken($transactionParams);
            }

            // Selesaikan Transaksi Database
            $db->transComplete();

            if ($db->transStatus() === false) {
                // Rollback otomatis terjadi jika ada Exception/Kesalahan
                return redirect()->back()->with('error', 'Terjadi kegagalan sistem saat menyimpan transaksi.');
            }

            // Arahkan ke halaman konfirmasi / tampilkan popup QRIS Midtrans
            return redirect()->to('/donasi')->with('success', 'Transaksi direkam.')->with('snapToken', $snapToken);

        } catch (\Exception $e) {
            // Jika API Midtrans gagal (misal server down), transaksi DB ikut dibatalkan.
            $db->transRollback();
            return redirect()->back()->with('error', 'Gagal memproses Payment Gateway: ' . $e->getMessage());
        }
    }

    /**
     * Webhook Endpoint Callback dari Midtrans
     */
    public function midtransWebhook()
    {
        // 1. Validasi Signature Key (Keamanan)
        $json = $this->request->getBody();
        $notification = json_decode($json);

        if (!$notification) {
            return $this->response->setStatusCode(400);
        }

        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;

        // 2. Update Status Transaksi 
        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            $this->donasiModel->updateStatus($orderId, 'success'); // Otomatis Lunas
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $this->donasiModel->updateStatus($orderId, 'failed');
        }

        return $this->response->setStatusCode(200);
    }
}
