<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIndexesToSantri extends Migration
{
    public function up()
    {
        // Menambahkan Index untuk optimasi pencarian 10rb+ data
        $this->db->query('ALTER TABLE santri ADD INDEX idx_nama_lengkap (nama_lengkap)');
        $this->db->query('ALTER TABLE santri ADD INDEX idx_nis (nis)');
    }

    public function down()
    {
        // Menghapus index jika di-rollback
        $this->db->query('ALTER TABLE santri DROP INDEX idx_nama_lengkap');
        $this->db->query('ALTER TABLE santri DROP INDEX idx_nis');
    }
}
