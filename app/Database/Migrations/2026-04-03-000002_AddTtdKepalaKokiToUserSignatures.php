<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTtdKepalaKokiToUserSignatures extends Migration
{
    public function up()
    {
        $this->forge->addColumn('user_signatures', [
            'ttd_kepala_koki' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'ttd_ahli_gizi',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('user_signatures', 'ttd_kepala_koki');
    }
}
