<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        // Data yang akan diinput (mirip dengan query SQL Anda)
        $data = [
            [
                'nama_kategori' => 'Teknologi',
                'slug_kategori' => 'teknologi'
            ],
            [
                'nama_kategori' => 'Pendidikan',
                'slug_kategori' => 'pendidikan'
            ],
            [
                'nama_kategori' => 'Gaya Hidup',
                'slug_kategori' => 'gaya-hidup'
            ],
            [
                'nama_kategori' => 'Kesehatan',
                'slug_kategori' => 'kesehatan'
            ],
            [
                'nama_kategori' => 'Hiburan',
                'slug_kategori' => 'hiburan'
            ]
        ];

        // Memasukkan semua data sekaligus ke tabel 'kategori'
        $this->db->table('kategori')->insertBatch($data);
    }
}