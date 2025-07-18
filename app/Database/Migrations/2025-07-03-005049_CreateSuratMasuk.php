<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuratMasuk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nomor_surat'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'pengirim'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'tujuan_surat'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'tanggal_terima'  => ['type' => 'DATE'],
            'perihal'         => ['type' => 'TEXT'],
            'file_surat'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('surat_masuk');
    }

    public function down()
    {
        //
    }
}
