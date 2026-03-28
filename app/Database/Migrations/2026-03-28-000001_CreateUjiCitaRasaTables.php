<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateUjiCitaRasaTables extends Migration
{
    public function up()
    {
        // Header table
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tanggal'         => ['type' => 'DATE'],
            'nama_checker'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'nama_chef'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'nama_ahli_gizi'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_by'      => ['type' => 'INT', 'unsigned' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('uji_cita_rasa');

        // Items table
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'uji_cita_rasa_id'  => ['type' => 'INT', 'unsigned' => true],
            'nama_masakan'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'gramasi_standar'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'gramasi_real'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'masalah'           => ['type' => 'TEXT', 'null' => true],
            'penyelesaian'      => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('uji_cita_rasa_id', 'uji_cita_rasa', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('uji_cita_rasa_items');
    }

    public function down()
    {
        $this->forge->dropTable('uji_cita_rasa_items', true);
        $this->forge->dropTable('uji_cita_rasa', true);
    }
}
