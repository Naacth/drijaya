<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateMakananLebihTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tanggal'         => ['type' => 'DATE'],
            'nama_cook'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'nama_chef'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'nama_ahli_gizi'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by'      => ['type' => 'INT', 'unsigned' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('makanan_lebih');

        $this->forge->addField([
            'id'                => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'makanan_lebih_id'  => ['type' => 'INT', 'unsigned' => true],
            'nama_item'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'jumlah'            => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'kondisi'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tindakan'          => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('makanan_lebih_id', 'makanan_lebih', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('makanan_lebih_items');
    }

    public function down()
    {
        $this->forge->dropTable('makanan_lebih_items', true);
        $this->forge->dropTable('makanan_lebih', true);
    }
}
