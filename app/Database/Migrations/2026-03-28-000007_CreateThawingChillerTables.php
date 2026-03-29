<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateThawingChillerTables extends Migration
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
        $this->forge->createTable('monitoring_thawing_chiller');

        $this->forge->addField([
            'id'                            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'monitoring_thawing_chiller_id'  => ['type' => 'INT', 'unsigned' => true],
            'nama_bahan'                    => ['type' => 'VARCHAR', 'constraint' => 255],
            'jumlah'                        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tgl_jam_keluar_freezer'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tgl_jam_selesai_thawing'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tgl_jam_pemasakan'             => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'paraf'                         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('monitoring_thawing_chiller_id', 'monitoring_thawing_chiller', 'id', 'CASCADE', 'CASCADE', 'fk_mtc_items_id');
        $this->forge->createTable('monitoring_thawing_chiller_items', true);
    }

    public function down()
    {
        $this->forge->dropTable('monitoring_thawing_chiller_items', true);
        $this->forge->dropTable('monitoring_thawing_chiller', true);
    }
}
