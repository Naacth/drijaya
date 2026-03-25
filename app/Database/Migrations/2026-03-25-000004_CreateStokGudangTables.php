<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStokGudangTables extends Migration
{
    public function up()
    {
        // Header table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_sppg' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'default'    => 'SPPG Bunar Sukamulya',
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('stok_gudang');

        // Items table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'stok_gudang_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nama_produk' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'nama_penerima' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'stok_awal' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'barang_masuk' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'barang_keluar' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'stok_akhir' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('stok_gudang_id', 'stok_gudang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('stok_gudang_items');
    }

    public function down()
    {
        $this->forge->dropTable('stok_gudang_items');
        $this->forge->dropTable('stok_gudang');
    }
}
