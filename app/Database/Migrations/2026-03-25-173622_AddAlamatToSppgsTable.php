<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAlamatToSppgsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('sppgs', [
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('sppgs', 'alamat');
    }
}
