<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStokOpnameTables extends Migration
{
    public function up()
    {
        // Header
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_sppg' => ['type' => 'VARCHAR', 'constraint' => 200, 'default' => 'SPPG Bunar Sukamulya'],
            'kelurahan_desa' => ['type' => 'VARCHAR', 'constraint' => 150, 'default' => 'Bunar'],
            'kecamatan' => ['type' => 'VARCHAR', 'constraint' => 150, 'default' => 'Balaraja'],
            'kabupaten_kota' => ['type' => 'VARCHAR', 'constraint' => 150, 'default' => 'Tangerang'],
            'provinsi' => ['type' => 'VARCHAR', 'constraint' => 150, 'default' => 'Banten'],
            'periode_awal' => ['type' => 'DATE'],
            'periode_akhir' => ['type' => 'DATE'],
            'nama_kepala_sppg' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'nama_akuntan' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('stok_opname');

        // Items (with hari_ke for multi-day grouping)
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'stok_opname_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'hari_ke' => ['type' => 'INT', 'constraint' => 3, 'default' => 1],
            'nama_bahan' => ['type' => 'VARCHAR', 'constraint' => 200],
            'satuan' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'stok_fisik' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'stok_di_kartu' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'selisih' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'keterangan' => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('stok_opname_id', 'stok_opname', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('stok_opname_items');
    }

    public function down()
    {
        $this->forge->dropTable('stok_opname_items');
        $this->forge->dropTable('stok_opname');
    }
}
