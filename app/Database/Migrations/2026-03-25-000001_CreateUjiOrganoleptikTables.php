<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUjiOrganoleptikTables extends Migration
{
    public function up()
    {
        // 1. Header Table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_pemeriksa' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'tempat_pemeriksaan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'Satuan Pendidikan',
            ],
            'nama_tempat' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'tanggal_pemeriksaan' => [
                'type' => 'DATE',
            ],
            'waktu_pemeriksaan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'waktu_uji' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'Sebelum Pengantaran',
                'comment'    => 'Sebelum Pengantaran / Saat Tiba di Lokasi / Sebelum Dikonsumsi',
            ],
            'nama_aslap' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'nama_pemeriksa_plok' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'nama_kepala_sppg' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
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
        $this->forge->createTable('uji_organoleptik');

        // 2. Detail Items Table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'uji_organoleptik_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nama_makan' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'skor_rasa' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'comment'    => '1-5',
            ],
            'skor_warna' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
            ],
            'skor_aroma' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
            ],
            'skor_tekstur' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
            ],
            'keterangan' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('uji_organoleptik_id', 'uji_organoleptik', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('uji_organoleptik_items');
    }

    public function down()
    {
        $this->forge->dropTable('uji_organoleptik_items');
        $this->forge->dropTable('uji_organoleptik');
    }
}
