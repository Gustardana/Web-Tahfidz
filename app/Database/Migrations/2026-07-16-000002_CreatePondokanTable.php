<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePondokanTable extends Migration
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
            'nama_kamar' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'kapasitas' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'default'    => 0,
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
        $this->forge->createTable('pondokan');
    }

    public function down()
    {
        $this->forge->dropTable('pondokan');
    }
}
