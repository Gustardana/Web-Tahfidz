<?php
namespace App\Models;

use CodeIgniter\Model;

class HalaqohModel extends Model
{
    protected $table            = 'halaqoh';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_halaqoh', 'ustadz_id'];
    protected $useTimestamps    = true;
}
