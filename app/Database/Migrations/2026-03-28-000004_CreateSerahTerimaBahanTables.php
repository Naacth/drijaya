<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateSerahTerimaBahanTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tanggal'         => ['type' => 'DATE'],
            'nama_pengirim'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'nama_penerima'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by'      => ['type' => 'INT', 'unsigned' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('serah_terima_bahan');

        $this->forge->addField([
            'id'                    => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'serah_terima_bahan_id' => ['type' => 'INT', 'unsigned' => true],
            'jam'                   => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'nama_bahan'            => ['type' => 'VARCHAR', 'constraint' => 255],
            'tujuan_penggunaan'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'gramasi_per_porsi'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'jumlah_awal'           => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'jumlah_tidak_layak'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'tindak_lanjut'         => ['type' => 'TEXT', 'null' => true],
            'jumlah_akhir'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('serah_terima_bahan_id', 'serah_terima_bahan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('serah_terima_bahan_items');
    }

    public function down()
    {
        $this->forge->dropTable('serah_terima_bahan_items', true);
        $this->forge->dropTable('serah_terima_bahan', true);
    }
}
