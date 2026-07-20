<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Validation\ProductValidation;

class ProductController extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $data['title'] = 'Manajemen Produk';
        $data['products'] = $this->productModel->findAll();
        
        return view('pages/products/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Produk Baru';
        return view('pages/products/create', $data);
    }

    public function store()
    {
        // Menerapkan prinsip "Early Return": 
        // Jika validasi gagal, eksekusi langsung berhenti dan direturn ke halaman sebelumnya.
        // Hal ini sangat menghindari blok 'if-else' bertingkat yang rentan menyebabkan spaghetti code/fat controller.
        $rules = ProductValidation::getRules(false);
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, silakan periksa input Anda.')->with('errors', $this->validator->getErrors());
        }

        // Penanganan file upload dengan aman. 
        // Ekstensi dan ukuran sudah dicek secara ketat di ProductValidation.
        $foto = $this->request->getFile('foto_produk');
        $namaFoto = $foto->getRandomName();
        $foto->move(FCPATH . 'uploads/products', $namaFoto);

        // Menggunakan ORM insert untuk mencegah serangan SQL Injection
        $this->productModel->insert([
            'nama_produk' => $this->request->getPost('nama_produk'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
            'foto_produk' => $namaFoto
        ]);

        return redirect()->to('/products')->with('success', 'Produk berhasil ditambahkan ke dalam database.');
    }

    public function edit($id)
    {
        $data['product'] = $this->productModel->find($id);
        
        if (!$data['product']) {
            return redirect()->to('/products')->with('error', 'Produk yang Anda cari tidak ditemukan.');
        }

        $data['title'] = 'Edit Produk';
        return view('pages/products/edit', $data);
    }

    public function update($id)
    {
        $product = $this->productModel->find($id);
        
        // Early Return: Validasi eksistensi data
        if (!$product) {
            return redirect()->to('/products')->with('error', 'Data produk tidak ditemukan.');
        }

        // Mengambil rules untuk update (foto_produk tidak wajib/required di sini)
        $rules = ProductValidation::getRules(true);
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal.')->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'nama_produk' => $this->request->getPost('nama_produk'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'harga'       => $this->request->getPost('harga'),
            'stok'        => $this->request->getPost('stok'),
        ];

        // Validasi dan penanganan jika pengguna mengunggah foto baru
        $foto = $this->request->getFile('foto_produk');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/products', $namaFoto);
            $updateData['foto_produk'] = $namaFoto;

            // Hapus file fisik gambar yang lama dari direktori public (optimasi storage/disk space)
            if (!empty($product['foto_produk']) && file_exists(FCPATH . 'uploads/products/' . $product['foto_produk'])) {
                unlink(FCPATH . 'uploads/products/' . $product['foto_produk']);
            }
        }

        $this->productModel->update($id, $updateData);

        return redirect()->to('/products')->with('success', 'Informasi produk berhasil diperbarui.');
    }

    public function delete($id)
    {
        $product = $this->productModel->find($id);
        
        if (!$product) {
            return redirect()->to('/products')->with('error', 'Produk gagal dihapus karena tidak ditemukan.');
        }

        // Membersihkan storage: Hapus file fisik gambar terkait sebelum menghapus data dari DB
        if (!empty($product['foto_produk']) && file_exists(FCPATH . 'uploads/products/' . $product['foto_produk'])) {
            unlink(FCPATH . 'uploads/products/' . $product['foto_produk']);
        }

        // Menghapus record menggunakan ORM 
        $this->productModel->delete($id);

        return redirect()->to('/products')->with('success', 'Produk dan gambar terkait berhasil dihapus permanen.');
    }
}
