<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateThawingAirTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tanggal'         => ['type' => 'DATE'],
            'nama_petugas'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by'      => ['type' => 'INT', 'unsigned' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('checklist_thawing_air');

        $this->forge->addField([
            'id'                      => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'checklist_thawing_air_id' => ['type' => 'INT', 'unsigned' => true],
            'nama_bahan'              => ['type' => 'VARCHAR', 'constraint' => 255],
            'jumlah'                  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'suhu_air'                => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'waktu_thawing'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'paraf'                   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('checklist_thawing_air_id', 'checklist_thawing_air', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('checklist_thawing_air_items');
    }

    public function down()
    {
        $this->forge->dropTable('checklist_thawing_air_items', true);
        $this->forge->dropTable('checklist_thawing_air', true);
    }
}
