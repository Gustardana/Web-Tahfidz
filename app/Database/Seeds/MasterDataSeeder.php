<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder Master Data (TahfidzQu)
 * 
 * Mengisi data hierarki esensial secara otomatis: User (Hak Akses), 
 * Pondokan (Asrama), Halaqoh (Kelompok), dan Santri.
 * Seeder ini memastikan database tidak kosong saat pengujian End-to-End berjalan.
 */
class MasterDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Data User / Pengguna Aplikasi (Role Base)
        $users = [
            [
                'username'     => 'admin_pusat',
                'password'     => password_hash('rahasia123', PASSWORD_BCRYPT),
                'role'         => 'admin',
                'nama_lengkap' => 'Administrator TahfidzQu',
                'created_at'   => date('Y-m-d H:i:s')
            ],
            [
                'username'     => 'keuangan_utama',
                'password'     => password_hash('rahasia123', PASSWORD_BCRYPT),
                'role'         => 'keuangan',
                'nama_lengkap' => 'Staf Keuangan',
                'created_at'   => date('Y-m-d H:i:s')
            ],
            [
                'username'     => 'ustadz_budi',
                'password'     => password_hash('rahasia123', PASSWORD_BCRYPT),
                'role'         => 'ustadz',
                'nama_lengkap' => 'Ustadz Budi',
                'created_at'   => date('Y-m-d H:i:s')
            ]
        ];
        
        $this->db->table('users')->insertBatch($users);
        $ustadzId = $this->db->insertID(); // ID auto-increment ustadz_budi (data terakhir)

        // 2. Data Pondokan / Kamar
        $pondokan = [
            [
                'nama_kamar' => 'Kamar Abu Bakar',
                'kapasitas'  => 10,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nama_kamar' => 'Kamar Umar',
                'kapasitas'  => 12,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('pondokan')->insertBatch($pondokan);
        $pondokanId = $this->db->insertID(); // Mengambil ID kamar pertama yang diinsert

        // 3. Data Halaqoh (Kelompok Hafalan)
        $halaqoh = [
            [
                'nama_halaqoh' => 'Halaqoh Tahsin A',
                'ustadz_id'    => $ustadzId, // Relasi ke ustadz_budi
                'created_at'   => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('halaqoh')->insertBatch($halaqoh);
        $halaqohId = $this->db->insertID();

        // 4. Data Santri (Data Terkait Semua Entitas)
        $santri = [
            [
                'nis'              => '100100100', // NIS ini digunakan untuk simulasi scan Barcode
                'nama_lengkap'     => 'Ahmad Fulan',
                'tempat_lahir'     => 'Jakarta',
                'tanggal_lahir'    => '2010-05-20',
                'nama_ortu'        => 'Bapak Fulan',
                'no_telp_ortu'     => '081234567890',
                'pondokan_id'      => $pondokanId,
                'halaqoh_id'       => $halaqohId,
                'status'           => 'aktif',
                'created_at'       => date('Y-m-d H:i:s')
            ]
        ];
        $this->db->table('santri')->insertBatch($santri);
    }
}
