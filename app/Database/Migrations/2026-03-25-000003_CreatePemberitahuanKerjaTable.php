<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePemberitahuanKerjaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'no_surat' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'divisi' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'comment'    => 'PIC Persiapan SIF 1 / PIC Persiapan SIF 2 / PIC Cooking',
            ],
            'nama_pic' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'jam_mulai' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'jam_selesai' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'keterangan_jumlah_item' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'keterangan_dikerjakan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nama_anggota' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'ttd_anggota' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'nama_pj' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'ttd_pj' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
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
        $this->forge->createTable('pemberitahuan_kerja');
    }

    public function down()
    {
        $this->forge->dropTable('pemberitahuan_kerja');
    }
}
