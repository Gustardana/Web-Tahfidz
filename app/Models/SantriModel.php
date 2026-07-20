<?php

namespace App\Models;

use CodeIgniter\Model;

class SantriModel extends Model
{
    protected $table            = 'santri';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    
    protected $allowedFields    = [
        'nis', 
        'nama_lengkap', 
        'tempat_lahir', 
        'tanggal_lahir', 
        'nama_ortu', 
        'no_telp_ortu', 
        'riwayat_penyakit', 
        'prestasi', 
        'pondokan_id', 
        'halaqoh_id', 
        'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Pencarian Santri Cepat via Barcode Scanner (Berdasarkan NIS)
     */
    public function findByNis($nis)
    {
        return $this->where('nis', $nis)->first();
    }
}
