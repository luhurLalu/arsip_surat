<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratTugasModel extends Model
{
    protected $table            = 'surat_tugas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nomor_surat',
        'tujuan',
        'tujuan_surat',
        'tanggal_tugas',
        'perihal',
        'file_surat'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $orderBy = 'tanggal_tugas DESC';
}
