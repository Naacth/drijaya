<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBeneficiaryItemsTable extends Migration
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
            'beneficiary_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'nama_sekolah' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'jumlah_siswa' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'porsi_kecil' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'porsi_besar' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'pendidik' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'non_pendidik' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'total_porsi' => [
                'type' => 'INT',
                'default' => 0,
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
        $this->forge->addForeignKey('beneficiary_id', 'beneficiaries', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('beneficiary_items');
    }

    public function down()
    {
        $this->forge->dropTable('beneficiary_items');
    }
}
