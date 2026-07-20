<?php
namespace App\Controllers;

use App\Models\SantriModel;

class SantriController extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) { 
            return redirect()->to('/login'); 
        }
        
        $model = new SantriModel();
        
        // Join tabel untuk mendapatkan nama kamar & halaqoh menggunakan Model instance
        $model->select('santri.*, pondokan.nama_kamar, halaqoh.nama_halaqoh')
              ->join('pondokan', 'pondokan.id = santri.pondokan_id', 'left')
              ->join('halaqoh', 'halaqoh.id = santri.halaqoh_id', 'left');
                         
        $search = $this->request->getGet('search');
        if (!empty($search)) {
            $model->groupStart()
                  ->like('santri.nama_lengkap', $search)
                  ->orLike('santri.nis', $search)
                  ->groupEnd();
        }
        
        // Menggunakan paginate() alih-alih findAll() agar server tidak overload (Pilar 2)
        $santris = $model->orderBy('santri.nama_lengkap', 'ASC')->paginate(10, 'santri');
        $pager = $model->pager;
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $santris,
                // Mengembalikan HTML paginasi ke Frontend
                'pager' => $pager->links('santri', 'tailwind'),
                'edit_url' => base_url('santri/edit/'),
                'delete_url' => base_url('santri/delete/')
            ]);
        }
                         
        $data = [
            'title'   => 'Manajemen Data Santri',
            'santris' => $santris,
            'search'  => $search,
            'pager'   => $pager // Pass pager ke view awal
        ];
        
        return view('pages/santri/index', $data);
    }
    
    public function create()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $pondokanModel = new \App\Models\PondokanModel();
        $halaqohModel  = new \App\Models\HalaqohModel();

        $data = [
            'title'    => 'Tambah Data Santri',
            'pondokan' => $pondokanModel->findAll(),
            'halaqoh'  => $halaqohModel->findAll(),
            'santri'   => null // form kosong
        ];
        return view('pages/santri/form', $data);
    }

    public function store()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $model = new SantriModel();

        // Validasi
        $rules = [
            'nis'          => 'required|is_unique[santri.nis]|min_length[5]',
            'nama_lengkap' => 'required|min_length[3]',
            'status'       => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: Cek kembali NIS atau Nama Anda.');
        }

        $model->save([
            'nis'              => $this->request->getPost('nis'),
            'nama_lengkap'     => $this->request->getPost('nama_lengkap'),
            'tempat_lahir'     => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir'    => $this->request->getPost('tanggal_lahir'),
            'nama_ortu'        => $this->request->getPost('nama_ortu'),
            'no_telp_ortu'     => $this->request->getPost('no_telp_ortu'),
            'riwayat_penyakit' => $this->request->getPost('riwayat_penyakit'),
            'prestasi'         => $this->request->getPost('prestasi'),
            'pondokan_id'      => $this->request->getPost('pondokan_id') ?: null,
            'halaqoh_id'       => $this->request->getPost('halaqoh_id') ?: null,
            'status'           => $this->request->getPost('status')
        ]);

        \App\Libraries\ActivityLogger::log('CREATE_SANTRI', 'Menambahkan santri baru: ' . $this->request->getPost('nama_lengkap'));
        return redirect()->to('/santri')->with('success', 'Data santri berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $model = new SantriModel();
        $santri = $model->find($id);

        if (!$santri) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data tidak ditemukan');

        $pondokanModel = new \App\Models\PondokanModel();
        $halaqohModel  = new \App\Models\HalaqohModel();

        $data = [
            'title'    => 'Edit Data Santri',
            'pondokan' => $pondokanModel->findAll(),
            'halaqoh'  => $halaqohModel->findAll(),
            'santri'   => $santri
        ];
        return view('pages/santri/form', $data);
    }

    public function update($id)
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $model = new SantriModel();

        $rules = [
            'nis'          => "required|is_unique[santri.nis,id,{$id}]|min_length[5]",
            'nama_lengkap' => 'required|min_length[3]',
            'status'       => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal: Cek kembali NIS atau Nama Anda.');
        }

        $model->update($id, [
            'nis'              => $this->request->getPost('nis'),
            'nama_lengkap'     => $this->request->getPost('nama_lengkap'),
            'tempat_lahir'     => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir'    => $this->request->getPost('tanggal_lahir'),
            'nama_ortu'        => $this->request->getPost('nama_ortu'),
            'no_telp_ortu'     => $this->request->getPost('no_telp_ortu'),
            'riwayat_penyakit' => $this->request->getPost('riwayat_penyakit'),
            'prestasi'         => $this->request->getPost('prestasi'),
            'pondokan_id'      => $this->request->getPost('pondokan_id') ?: null,
            'halaqoh_id'       => $this->request->getPost('halaqoh_id') ?: null,
            'status'           => $this->request->getPost('status')
        ]);

        \App\Libraries\ActivityLogger::log('UPDATE_SANTRI', 'Mengubah data santri ID: ' . $id);
        return redirect()->to('/santri')->with('success', 'Data santri berhasil diperbarui!');
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        if (session()->get('role') !== 'admin') return redirect()->back()->with('error', 'Akses ditolak.');

        $model = new SantriModel();
        $model->delete($id);

        \App\Libraries\ActivityLogger::log('DELETE_SANTRI', 'Menghapus data santri ID: ' . $id);
        return redirect()->to('/santri')->with('success', 'Data santri berhasil dihapus!');
    }
}
