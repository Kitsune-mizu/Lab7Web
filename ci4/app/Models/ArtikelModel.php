<?php
namespace App\Models;
use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table            = 'artikel';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // Tambahkan 'id_kategori' agar bisa disimpan ke database
    protected $allowedFields = ['judul', 'isi', 'status', 'slug', 'gambar', 'created_at', 'id_kategori'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
}