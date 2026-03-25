<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserSignaturesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'ttd_aslap' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'ttd_kepala_sppg' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'ttd_ahli_gizi' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'ttd_akuntan' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('user_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_signatures');
    }

    public function down()
    {
        $this->forge->dropTable('user_signatures');
    }
}
