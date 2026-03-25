<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRouteItemsTable extends Migration
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
            'route_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'nama_sekolah' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'porsi_besar' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'porsi_kecil' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'jumlah' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'jam_antar' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'sesi' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
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
        $this->forge->addForeignKey('route_id', 'routes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('route_items');
    }

    public function down()
    {
        $this->forge->dropTable('route_items');
    }
}
