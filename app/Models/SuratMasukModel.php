<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratMasukModel extends Model
{
    protected $table            = 'surat_masuk';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nomor_surat',
        'pengirim',
        'tujuan_surat',
        'tanggal_terima',
        'perihal',
        'file_surat'
    ];

    // Aktifkan otomatis timestamp
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Urutan default (opsional)
    protected $orderBy = 'tanggal_terima DESC';
}