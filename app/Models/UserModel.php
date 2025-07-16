<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';           // Nama tabel di database
    protected $primaryKey = 'id';              // Primary key tabel

    protected $allowedFields = [
        'nama',
        'email',
        'username',
        'password',
        'role'
    ];

    protected $useTimestamps = true;           // Aktifkan otomatis timestamps
    protected $createdField  = 'created_at';   // Kolom timestamp saat create
    protected $updatedField  = 'updated_at';   // Kolom timestamp saat update

    protected $validationRules = [];           // Bisa ditambah jika pakai validate() di model
    protected $validationMessages = [];
    protected $skipValidation = false;         // Set false agar validasi dijalankan saat insert/update
}