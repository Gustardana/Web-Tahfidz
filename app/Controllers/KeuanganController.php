<?php
namespace App\Controllers;

use App\Models\DonasiModel;
use App\Models\PengeluaranModel;

class KeuanganController extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'bendahara') {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }
        
        $donasiModel      = new DonasiModel();
        $pengeluaranModel = new PengeluaranModel();
        
        // Pemasukan
        $donasi = $donasiModel->select('donasi.*, santri.nama_lengkap as nama_santri')
                              ->join('santri', 'santri.id = donasi.santri_id', 'left')
                              ->orderBy('donasi.created_at', 'DESC')
                              ->findAll();
                              
        // Pengeluaran
        $pengeluaran = $pengeluaranModel->select('pengeluaran.*, users.nama_lengkap as nama_user')
                                        ->join('users', 'users.id = pengeluaran.user_id', 'left')
                                        ->orderBy('pengeluaran.tanggal', 'DESC')
                                        ->orderBy('pengeluaran.created_at', 'DESC')
                                        ->findAll();
                                        
        // Hitung Saldo Total
        $totalPemasukan = array_sum(array_column($donasi, 'nominal'));
        $totalPengeluaran = array_sum(array_column($pengeluaran, 'nominal'));
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        $data = [
            'title'            => 'Kas & Keuangan',
            'donasi'           => $donasi,
            'pengeluaran'      => $pengeluaran,
            'totalPemasukan'   => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldoAkhir'       => $saldoAkhir
        ];
        
        return view('pages/keuangan/index', $data);
    }

    public function createPengeluaran()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        
        $data = [
            'title' => 'Input Pengeluaran Kas'
        ];
        return view('pages/keuangan/form_pengeluaran', $data);
    }

    public function storePengeluaran()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        
        $rules = [
            'tanggal'    => 'required|valid_date',
            'keterangan' => 'required',
            'nominal'    => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Semua field wajib diisi dengan format yang benar.');
        }

        $model = new PengeluaranModel();
        $model->save([
            'tanggal'    => $this->request->getPost('tanggal'),
            'keterangan' => $this->request->getPost('keterangan'),
            'nominal'    => $this->request->getPost('nominal'),
            'user_id'    => session()->get('id')
        ]);

        \App\Libraries\ActivityLogger::log('CREATE_PENGELUARAN', 'Input pengeluaran kas: Rp ' . number_format($this->request->getPost('nominal'), 0, ',', '.'));
        return redirect()->to('/keuangan')->with('success', 'Data pengeluaran berhasil dicatat!');
    }
}
