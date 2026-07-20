<?php

namespace App\Validation;

/**
 * Class ProductValidation
 * 
 * Sesuai rekomendasi poin 10 (Thin Controller, Fat Model/Layer), 
 * logika validasi kompleks dipisahkan dari Controller ke file mandiri.
 * Pendekatan ini membuat Controller menjadi sangat bersih dan modular 
 * dibandingkan dengan pendekatan "Fat Controller" di Yii 1.x sebelumnya.
 */
class ProductValidation
{
    /**
     * Mendapatkan rule validasi untuk produk
     * @param bool $isUpdate True jika operasi update (foto tidak wajib)
     * @return array
     */
    public static function getRules($isUpdate = false)
    {
        // Validasi ekstensi dan ukuran file diterapkan secara ketat.
        // Hal ini sangat vital untuk menghindari eksekusi malware/shell 
        // yang sering menyusup lewat ekstensi file berbahaya (seperti .php)
        $fotoRules = $isUpdate 
            ? 'is_image[foto_produk]|mime_in[foto_produk,image/jpg,image/jpeg,image/png,image/webp]|max_size[foto_produk,2048]'
            : 'uploaded[foto_produk]|is_image[foto_produk]|mime_in[foto_produk,image/jpg,image/jpeg,image/png,image/webp]|max_size[foto_produk,2048]';

        return [
            'nama_produk' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Nama produk wajib diisi.',
                    'min_length' => 'Nama produk minimal 3 karakter.'
                ]
            ],
            'harga' => [
                'rules' => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required' => 'Harga wajib diisi.',
                    'numeric' => 'Harga harus berupa angka.',
                    'greater_than' => 'Harga harus lebih dari 0.'
                ]
            ],
            'stok' => [
                'rules' => 'required|integer|greater_than_equal_to[0]',
                'errors' => [
                    'required' => 'Stok wajib diisi.',
                    'integer' => 'Stok harus berupa bilangan bulat.',
                    'greater_than_equal_to' => 'Stok tidak boleh bernilai negatif.'
                ]
            ],
            'foto_produk' => [
                'rules' => $fotoRules,
                'errors' => [
                    'uploaded' => 'Foto produk wajib diunggah.',
                    'is_image' => 'File harus berupa gambar valid.',
                    'mime_in' => 'Format file tidak diizinkan (hanya jpg, jpeg, png, webp).',
                    'max_size' => 'Ukuran foto maksimal 2MB.'
                ]
            ]
        ];
    }
}
