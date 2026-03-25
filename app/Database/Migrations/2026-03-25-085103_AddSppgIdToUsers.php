<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSppgIdToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'sppg_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'role',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'sppg_id');
    }
}
