<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model Donasi (Transaksi Keuangan)
 * 
 * Sesuai poin 3 (Atomic Transactions) & poin 5 (Midtrans Webhook).
 * Digunakan Fungsionalitas "Fat Model" secara esensial.
 */
class DonasiModel extends Model
{
    protected $table            = 'donasi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    
    // Menambahkan kolom order_id dan status_pembayaran secara virtual
    // untuk mengakomodasi Payment Gateway Midtrans (Poin 5)
    protected $allowedFields    = [
        'santri_id', 
        'jenis_donasi', 
        'nominal', 
        'tanggal', 
        'keterangan', 
        'user_id',
        'order_id',          // Contoh: TQ-DON-168923456
        'status_pembayaran'  // pending, success (Lunas), expired
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Memperbarui status pembayaran dari Webhook Midtrans.
     * Pastikan race condition tidak terjadi dengan locking atau atomic query.
     */
    public function updateStatus($orderId, $status)
    {
        return $this->where('order_id', $orderId)
                    ->set(['status_pembayaran' => $status])
                    ->update();
    }
}
