<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuratKeluar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nomor_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'tujuan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'tanggal_kirim' => [
                'type' => 'DATE',
            ],
            'perihal' => [
                'type' => 'TEXT',
            ],
            'file_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true); // primary key
        $this->forge->createTable('surat_keluar');
    }

    public function down()
    {
        $this->forge->dropTable('surat_keluar');
    }
}