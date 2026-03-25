<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRekapPorsiTables extends Migration
{
    public function up()
    {
        // Header
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'tanggal' => ['type' => 'DATE'],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rekap_porsi');

        // Items
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'rekap_porsi_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tingkatan' => ['type' => 'VARCHAR', 'constraint' => 100],
            'sekolah' => ['type' => 'VARCHAR', 'constraint' => 200],
            'jumlah_pm' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'jumlah_terdistribusi' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'jumlah_tidak_terdistribusi' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'keterangan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'pengalihan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('rekap_porsi_id', 'rekap_porsi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rekap_porsi_items');
    }

    public function down()
    {
        $this->forge->dropTable('rekap_porsi_items');
        $this->forge->dropTable('rekap_porsi');
    }
}
