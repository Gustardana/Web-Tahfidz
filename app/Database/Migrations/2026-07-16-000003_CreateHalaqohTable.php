<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHalaqohTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_halaqoh' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'ustadz_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('ustadz_id', 'users', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('halaqoh');
    }

    public function down()
    {
        $this->forge->dropTable('halaqoh');
    }
}
