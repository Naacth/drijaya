<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCekBahanBakuTables extends Migration
{
    public function up()
    {
        // 1. Header Table: cek_bahan_baku
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tanggal_laporan' => [
                'type' => 'DATE',
            ],
            'nama_sppg' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'alamat_sppg' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_kepala_sppg' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'submitted',
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
        $this->forge->createTable('cek_bahan_baku');

        // 2. Detail Table: cek_bahan_baku_items
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'cek_bahan_baku_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tgl_bahan' => [
                'type' => 'DATE',
            ],
            'jenis_bahan' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'satuan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'banyaknya' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'jumlah_sesuai' => [
                'type'       => 'ENUM',
                'constraint' => ['Sesuai', 'Tidak'],
            ],
            'kondisi_bahan' => [
                'type'       => 'ENUM',
                'constraint' => ['Baik', 'Rusak'],
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('cek_bahan_baku_id', 'cek_bahan_baku', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('cek_bahan_baku_items');
    }

    public function down()
    {
        $this->forge->dropTable('cek_bahan_baku_items');
        $this->forge->dropTable('cek_bahan_baku');
    }
}
