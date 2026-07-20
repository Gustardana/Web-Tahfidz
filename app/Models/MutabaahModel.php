<?php
namespace App\Models;

use CodeIgniter\Model;

class MutabaahModel extends Model
{
    protected $table            = 'mutabaah_tahfidz';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'santri_id', 'ustadz_id', 'tanggal', 'surat', 
        'ayat_mulai', 'ayat_selesai', 'predikat', 'keterangan'
    ];
    protected $useTimestamps    = true;
}
