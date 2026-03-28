<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreatePencucianBahanTables extends Migration
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
        $this->forge->createTable('pencucian_bahan');

        $this->forge->addField([
            'id'                  => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'pencucian_bahan_id'  => ['type' => 'INT', 'unsigned' => true],
            'nama_bahan'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'bahan_kimia'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'benda_asing'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tindak_lanjut'       => ['type' => 'TEXT', 'null' => true],
            'jam_produksi'        => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pencucian_bahan_id', 'pencucian_bahan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pencucian_bahan_items');
    }

    public function down()
    {
        $this->forge->dropTable('pencucian_bahan_items', true);
        $this->forge->dropTable('pencucian_bahan', true);
    }
}
