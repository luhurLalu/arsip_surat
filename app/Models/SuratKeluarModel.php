<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratKeluarModel extends Model
{
    protected $table            = 'surat_keluar';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nomor_surat',
        'tujuan',
        'tujuan_surat',
        'tanggal_kirim',
        'perihal',
        'file_surat'
    ];

    // Aktifkan otomatis timestamp
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Urutan default
    protected $orderBy = 'tanggal_kirim DESC';
}