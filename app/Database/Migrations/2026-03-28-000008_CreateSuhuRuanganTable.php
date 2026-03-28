<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateSuhuRuanganTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                 => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tanggal'            => ['type' => 'DATE'],
            'pagi_jam'           => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'pagi_kelembapan'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'pagi_suhu'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'pagi_keterangan'    => ['type' => 'TEXT', 'null' => true],
            'siang_jam'          => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'siang_kelembapan'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'siang_suhu'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'siang_keterangan'   => ['type' => 'TEXT', 'null' => true],
            'sore_jam'           => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'sore_kelembapan'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'sore_suhu'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'sore_keterangan'    => ['type' => 'TEXT', 'null' => true],
            'nama_petugas'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by'         => ['type' => 'INT', 'unsigned' => true],
            'created_at'         => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('catatan_suhu_ruangan');
    }

    public function down()
    {
        $this->forge->dropTable('catatan_suhu_ruangan', true);
    }
}
