<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuratTugas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nomor_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'tujuan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'tujuan_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'tanggal_tugas' => [
                'type' => 'DATE',
            ],
            'perihal' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'file_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('surat_tugas');
    }

    public function down()
    {
        $this->forge->dropTable('surat_tugas');
    }
}
