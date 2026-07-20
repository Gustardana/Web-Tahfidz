<?php
namespace App\Models;

use CodeIgniter\Model;

class PondokanModel extends Model
{
    protected $table            = 'pondokan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_kamar', 'kapasitas'];
    protected $useTimestamps    = true;
}
