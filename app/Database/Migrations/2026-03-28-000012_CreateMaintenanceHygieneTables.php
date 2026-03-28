<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMaintenanceHygieneTables extends Migration
{
    public function up()
    {
        // Checklist Pembersihan Alat Transportasi
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'bulan' => ['type' => 'VARCHAR', 'constraint' => 20],
            'tahun' => ['type' => 'INT', 'constraint' => 4],
            'nama_kendaraan' => ['type' => 'VARCHAR', 'constraint' => 100],
            'rekap_data' => ['type' => 'TEXT', 'null' => true],
            'nama_gizi' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'nama_kappg' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pembersihan_transportasi');

        // Checklist Pembersihan Trolly Makanan
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'bulan' => ['type' => 'VARCHAR', 'constraint' => 20],
            'tahun' => ['type' => 'INT', 'constraint' => 4],
            'rekap_data' => ['type' => 'TEXT', 'null' => true],
            'nama_gizi' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'nama_kappg' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pembersihan_trolly');

        // Checklist Pemeriksaan Higiene Personil
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'bulan' => ['type' => 'VARCHAR', 'constraint' => 20],
            'tahun' => ['type' => 'INT', 'constraint' => 4],
            'rekap_data' => ['type' => 'TEXT', 'null' => true],
            'nama_gizi' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'nama_kappg' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('higiene_personil');
    }

    public function down()
    {
        $this->forge->dropTable('pembersihan_transportasi');
        $this->forge->dropTable('pembersihan_trolly');
        $this->forge->dropTable('higiene_personil');
    }
}
