<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateSuhuChillerFreezerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tanggal'               => ['type' => 'DATE'],
            'chiller_pagi'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'chiller_siang'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'chiller_malam'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'freezer_pagi'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'freezer_siang'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'freezer_malam'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'kebersihan_rak'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'verifikasi'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'nama_petugas'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by'            => ['type' => 'INT', 'unsigned' => true],
            'created_at'            => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'            => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('suhu_chiller_freezer');
    }

    public function down()
    {
        $this->forge->dropTable('suhu_chiller_freezer', true);
    }
}
