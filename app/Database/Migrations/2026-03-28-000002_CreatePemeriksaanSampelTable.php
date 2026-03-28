<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreatePemeriksaanSampelTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                  => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tanggal'             => ['type' => 'DATE'],
            'jam_matang'          => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'jenis_produk'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'bahaya_fisik'        => ['type' => 'TEXT', 'null' => true],
            'bahaya_biologi'      => ['type' => 'TEXT', 'null' => true],
            'jam_penarikan'       => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'tindak_lanjut'       => ['type' => 'TEXT', 'null' => true],
            'sampel_diambil'      => ['type' => 'ENUM', 'constraint' => ['ya', 'tidak'], 'default' => 'ya'],
            'jumlah_sampel'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tempat_penyimpanan'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tanggal_pemusnahan'  => ['type' => 'DATE', 'null' => true],
            'nama_pemeriksa'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by'          => ['type' => 'INT', 'unsigned' => true],
            'created_at'          => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'          => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pemeriksaan_sampel');
    }

    public function down()
    {
        $this->forge->dropTable('pemeriksaan_sampel', true);
    }
}
