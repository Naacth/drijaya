<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdatePurchaseOrdersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('purchase_orders', [
            'tanggal' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'nomor_po',
            ],
            'menu' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'vendor',
            ],
        ]);

        $this->forge->modifyColumn('purchase_orders', [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['draft', 'menunggu_harga', 'menunggu_review', 'menunggu_approval', 'approved', 'rejected'],
                'default'    => 'draft',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('purchase_orders', ['tanggal', 'menu']);
        $this->forge->modifyColumn('purchase_orders', [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['draft', 'diajukan', 'disetujui', 'ditolak'],
                'default'    => 'draft',
            ],
        ]);
    }
}
