<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    // Menggunakan ORM bawaan CodeIgniter 4 (Model) untuk mempermudah operasi database.
    // Hal ini secara signifikan lebih aman terhadap SQL Injection dibandingkan 
    // jika menggunakan raw SQL yang umum ditemukan pada kode-kode lama (legacy code).
    protected $allowedFields    = [
        'nama_produk', 
        'deskripsi', 
        'harga', 
        'stok', 
        'foto_produk'
    ];

    // Mengaktifkan fitur auto timestamps (created_at & updated_at).
    // Memindahkan tanggung jawab penulisan waktu ke Model, sehingga 
    // controller lebih bersih dan fokus pada logika HTTP saja (Thin Controller).
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
