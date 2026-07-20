<?php
namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        
        // Mengumpulkan Metrik Utama (Data Real)
        $data = [
            'title'          => 'Dashboard Utama',
            'total_santri'   => $db->table('santri')->countAllResults(),
            'total_pondokan' => $db->table('pondokan')->countAllResults(),
            'total_halaqoh'  => $db->table('halaqoh')->countAllResults(),
            
            // Pemasukan SPP & Donasi Bulan Ini (Yang Statusnya Sukses/Lunas)
            'pemasukan_bulan_ini' => $db->table('donasi')
                                        ->selectSum('nominal')
                                        ->where('status_pembayaran', 'success')
                                        ->where('MONTH(created_at)', date('m'))
                                        ->where('YEAR(created_at)', date('Y'))
                                        ->get()->getRow()->nominal ?? 0
        ];

        return view('pages/dashboard', $data);
    }
}
