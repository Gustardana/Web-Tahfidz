<?php
namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table            = 'activity_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    
    protected $allowedFields    = [
        'user_id', 
        'ip_address', 
        'action', 
        'description', 
        'created_at'
    ];

    // Kita menggunakan created_at yang dikirim manual dari Logger
    protected $useTimestamps = false; 
}
