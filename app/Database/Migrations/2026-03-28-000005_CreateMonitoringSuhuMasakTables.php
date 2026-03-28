<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateMonitoringSuhuMasakTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tanggal'         => ['type' => 'DATE'],
            'nama_pelaksana'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'nama_pemeriksa'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by'      => ['type' => 'INT', 'unsigned' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('monitoring_suhu_masak');

        $this->forge->addField([
            'id'                       => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'monitoring_suhu_masak_id'  => ['type' => 'INT', 'unsigned' => true],
            'nama_makanan'             => ['type' => 'VARCHAR', 'constraint' => 255],
            'suhu_pemasakan'           => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'jam_matang'               => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'jadwal_penyajian'         => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('monitoring_suhu_masak_id', 'monitoring_suhu_masak', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('monitoring_suhu_masak_items');
    }

    public function down()
    {
        $this->forge->dropTable('monitoring_suhu_masak_items', true);
        $this->forge->dropTable('monitoring_suhu_masak', true);
    }
}
