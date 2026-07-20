<?php
namespace App\Libraries;

use App\Models\ActivityLogModel;

/**
 * Pustaka Pencatatan Aktivitas Keamanan & Transaksi Krusial (Activity Logging)
 */
class ActivityLogger
{
    /**
     * Mencatat aksi spesifik pengguna ke database tersendiri.
     * Menggunakan strategi Graceful Degradation jika DB Crash.
     */
    public static function log(string $action, string $description)
    {
        // 1. Sebagai backup & audit file tingkat server (Tercatat di logs/log-*.php)
        log_message('info', "[ACTIVITY] {$action} | {$description}");

        $logModel = new ActivityLogModel();
        $request  = \Config\Services::request();
        
        try {
            // 2. Mencoba menyimpan ke Tabel Database tersendiri
            $logModel->insert([
                'user_id'     => session()->get('id') ?? null,
                'ip_address'  => $request->getIPAddress(),
                'action'      => $action,
                'description' => $description,
                'created_at'  => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            // Graceful Degradation: 
            // Jika proses simpan log gagal (misal koneksi DB terputus singkat), 
            // biarkan eksekusi terus berlanjut. Tidak boleh merusak UX.
            log_message('error', 'ActivityLogger gagal menyimpan ke database: ' . $e->getMessage());
        }
    }
}
