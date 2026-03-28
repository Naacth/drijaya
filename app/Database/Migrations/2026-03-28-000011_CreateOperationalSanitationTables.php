<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOperationalSanitationTables extends Migration
{
    public function up()
    {
        // 11. Sanitasi Ruangan & Peralatan
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tanggal'        => ['type' => 'DATE'],
            'fasilitas_data' => ['type' => 'TEXT', 'null' => true], // JSON or Serialized: Lantai, Dinding, etc.
            'nama_pelaksana' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'nama_pemeriksa' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by'     => ['type' => 'INT', 'unsigned' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('sanitasi_ruangan', true);

        // 12. Pembersihan Freezer & Chiller (Harian)
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tanggal'        => ['type' => 'DATE'],
            'unit_type'      => ['type' => 'ENUM', 'constraint' => ['freezer', 'chiller'], 'default' => 'chiller'],
            'area_data'      => ['type' => 'TEXT', 'null' => true], // JSON: Lantai, Dinding, Rak, etc.
            'nama_petugas'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'nama_verifikator' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by'     => ['type' => 'INT', 'unsigned' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pembersihan_harian', true);

        // 13. Pembersihan Freezer & Chiller (Mingguan)
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'area_pencucian' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'minggu_ke'      => ['type' => 'INT', 'null' => true],
            'bulan'          => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'checklist_data' => ['type' => 'TEXT', 'null' => true],
            'nama_verifikator' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by'     => ['type' => 'INT', 'unsigned' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pembersihan_mingguan', true);

        // 14. Pembuangan Sampah Harian
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'bulan'          => ['type' => 'VARCHAR', 'constraint' => 20],
            'tahun'          => ['type' => 'INT'],
            'rekap_data'     => ['type' => 'LONGTEXT', 'null' => true], // Daily data status
            'nama_kappg'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by'     => ['type' => 'INT', 'unsigned' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pembuangan_sampah', true);

        // 15. Pembersihan Bak Sampah
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tanggal'        => ['type' => 'DATE'],
            'nama_personil'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'jam'            => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'keterangan'     => ['type' => 'TEXT', 'null' => true],
            'created_by'     => ['type' => 'INT', 'unsigned' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pembersihan_bak_sampah', true);

        // 16. Pembersihan Lantai
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tanggal'        => ['type' => 'DATE'],
            'nama_personil'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'jam'            => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'kondisi'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by'     => ['type' => 'INT', 'unsigned' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pembersihan_lantai', true);

        // 17. Pengeluaran Bahan Kimia (Chemical)
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tanggal'        => ['type' => 'DATE'],
            'nama_chemical'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'jumlah'         => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'unit'           => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'nama_personil'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'nama_gizi'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by'     => ['type' => 'INT', 'unsigned' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengeluaran_chemical', true);
    }

    public function down()
    {
        $this->forge->dropTable('sanitasi_ruangan', true);
        $this->forge->dropTable('pembersihan_harian', true);
        $this->forge->dropTable('pembersihan_mingguan', true);
        $this->forge->dropTable('pembuangan_sampah', true);
        $this->forge->dropTable('pembersihan_bak_sampah', true);
        $this->forge->dropTable('pembersihan_lantai', true);
        $this->forge->dropTable('pengeluaran_chemical', true);
    }
}
