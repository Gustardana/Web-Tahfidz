<?php
namespace App\Controllers;

use App\Models\MutabaahModel;
use App\Models\SantriModel;

class MutabaahController extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        
        $model = new MutabaahModel();
        
        $mutabaah = $model->select('mutabaah_tahfidz.*, santri.nama_lengkap as nama_santri, users.nama_lengkap as nama_ustadz')
                          ->join('santri', 'santri.id = mutabaah_tahfidz.santri_id')
                          ->join('users', 'users.id = mutabaah_tahfidz.ustadz_id', 'left')
                          ->orderBy('mutabaah_tahfidz.tanggal', 'DESC')
                          ->orderBy('mutabaah_tahfidz.created_at', 'DESC')
                          ->findAll();

        $data = [
            'title'    => 'Mutabaah Hafalan',
            'mutabaah' => $mutabaah
        ];
        
        return view('pages/mutabaah/index', $data);
    }

    public function create()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        
        $santriModel = new SantriModel();
        $data = [
            'title'   => 'Input Setoran Hafalan',
            'santris' => $santriModel->where('status', 'aktif')->findAll()
        ];
        
        return view('pages/mutabaah/form', $data);
    }

    public function store()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        
        $rules = [
            'santri_id'    => 'required',
            'tanggal'      => 'required|valid_date',
            'surat'        => 'required',
            'ayat_mulai'   => 'required|is_natural_no_zero',
            'ayat_selesai' => 'required|is_natural_no_zero',
            'predikat'     => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: Lengkapi seluruh form wajib dengan benar.');
        }

        $model = new MutabaahModel();
        $model->save([
            'santri_id'    => $this->request->getPost('santri_id'),
            'ustadz_id'    => session()->get('id') ?? null, // dari session login
            'tanggal'      => $this->request->getPost('tanggal'),
            'surat'        => $this->request->getPost('surat'),
            'ayat_mulai'   => $this->request->getPost('ayat_mulai'),
            'ayat_selesai' => $this->request->getPost('ayat_selesai'),
            'predikat'     => $this->request->getPost('predikat'),
            'keterangan'   => $this->request->getPost('keterangan')
        ]);

        \App\Libraries\ActivityLogger::log('CREATE_MUTABAAH', 'Input setoran surat: ' . $this->request->getPost('surat'));
        return redirect()->to('/mutabaah')->with('success', 'Setoran hafalan berhasil dicatat!');
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (session()->get('role') !== 'admin' && session()->get('role') !== 'ustadz') {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }
        
        $model = new MutabaahModel();
        $model->delete($id);
        
        \App\Libraries\ActivityLogger::log('DELETE_MUTABAAH', 'Menghapus mutabaah ID: ' . $id);
        return redirect()->to('/mutabaah')->with('success', 'Data mutabaah berhasil dihapus!');
    }
}
