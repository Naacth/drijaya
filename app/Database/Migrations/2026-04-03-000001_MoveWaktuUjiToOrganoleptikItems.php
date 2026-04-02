<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MoveWaktuUjiToOrganoleptikItems extends Migration
{
    public function up()
    {
        $this->forge->addColumn('uji_organoleptik_items', [
            'waktu_uji' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'Sebelum Pengantaran',
            ],
        ]);

        $db = \Config\Database::connect();
        $items = $db->table('uji_organoleptik_items')->get()->getResultArray();
        foreach ($items as $it) {
            $h = $db->table('uji_organoleptik')->where('id', $it['uji_organoleptik_id'])->get()->getRowArray();
            if ($h !== null && isset($h['waktu_uji']) && $h['waktu_uji'] !== '') {
                $db->table('uji_organoleptik_items')->where('id', $it['id'])->update(['waktu_uji' => $h['waktu_uji']]);
            }
        }

        $this->forge->dropColumn('uji_organoleptik', 'waktu_uji');
    }

    public function down()
    {
        $this->forge->addColumn('uji_organoleptik', [
            'waktu_uji' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'Sebelum Pengantaran',
                'after'      => 'waktu_pemeriksaan',
            ],
        ]);

        $db = \Config\Database::connect();
        $headers = $db->table('uji_organoleptik')->select('id')->get()->getResultArray();
        foreach ($headers as $row) {
            $first = $db->table('uji_organoleptik_items')
                ->where('uji_organoleptik_id', $row['id'])
                ->orderBy('id', 'ASC')
                ->get(1)
                ->getRowArray();
            if ($first && ! empty($first['waktu_uji'])) {
                $db->table('uji_organoleptik')
                    ->where('id', $row['id'])
                    ->update(['waktu_uji' => $first['waktu_uji']]);
            }
        }

        $this->forge->dropColumn('uji_organoleptik_items', 'waktu_uji');
    }
}
