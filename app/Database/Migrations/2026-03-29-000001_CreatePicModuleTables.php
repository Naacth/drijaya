<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePicModuleTables extends Migration
{
    public function up()
    {
        // Pengajuan Barang Rusak
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'tanggal'     => ['type' => 'DATE'],
            'nama_barang' => ['type' => 'VARCHAR', 'constraint' => 255],
            'jumlah'      => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
            'satuan'      => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'pcs'],
            'kondisi'     => ['type' => 'TEXT', 'null' => true],
            'keterangan'  => ['type' => 'TEXT', 'null' => true],
            'foto'        => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'status'      => ['type' => 'ENUM', 'constraint' => ['draft', 'diajukan', 'disetujui', 'ditolak'], 'default' => 'draft'],
            'created_by'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengajuan_barang_rusak', true);

        // Pengadaan Barang
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'tanggal'         => ['type' => 'DATE'],
            'nama_barang'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'jumlah'          => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
            'satuan'          => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'pcs'],
            'estimasi_harga'  => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'alasan'          => ['type' => 'TEXT', 'null' => true],
            'status'          => ['type' => 'ENUM', 'constraint' => ['draft', 'diajukan', 'disetujui', 'ditolak'], 'default' => 'draft'],
            'created_by'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengadaan_barang', true);
    }

    public function down()
    {
        $this->forge->dropTable('pengajuan_barang_rusak', true);
        $this->forge->dropTable('pengadaan_barang', true);
    }
}
