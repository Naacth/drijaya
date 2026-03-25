<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBaKehilanganTable extends Migration
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
            'nama_sekolah' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'nama_pj_sekolah' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'jam_kehilangan' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'jam_distribusi' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'tanggal_kejadian' => [
                'type' => 'DATE',
            ],
            'jumlah_ompreng_hilang' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'jumlah_awal' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'jumlah_akhir' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'ttd_supir' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'Path file gambar TTD supir',
            ],
            'nama_supir' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'ttd_pj_sekolah' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'Path file gambar TTD PJ Sekolah',
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
        $this->forge->createTable('ba_kehilangan');
    }

    public function down()
    {
        $this->forge->dropTable('ba_kehilangan');
    }
}
