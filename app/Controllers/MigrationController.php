<?php

namespace App\Controllers;

use App\Models\SppgModel;

class MigrationController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $forge = \Config\Database::forge();

        // 1. Estimasi Anggaran
        $forge->addField([
            'id'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'tanggal_mulai'    => ['type' => 'DATE'],
            'tanggal_selesai'  => ['type' => 'DATE'],
            'kategori_porsi'   => ['type' => 'ENUM', 'constraint' => ['Besar', 'Kecil']],
            'total_kalkulasi'  => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0.00],
            'sppg_id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_by'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $forge->addKey('id', true);
        $forge->createTable('estimasi_anggaran', true);

        $forge->addField([
            'id'                   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'estimasi_anggaran_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_item'            => ['type' => 'VARCHAR', 'constraint' => 255],
            'harga_satuan'         => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0.00],
        ]);
        $forge->addKey('id', true);
        $forge->createTable('estimasi_anggaran_items', true);

        // 2. Analisis Kandungan Gizi
        $forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_paket'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'tanggal_sajian' => ['type' => 'DATE'],
            'sppg_id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_by'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $forge->addKey('id', true);
        $forge->createTable('analisis_gizi', true);

        $forge->addField([
            'id'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'analisis_gizi_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_item'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'gramasi'          => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'kalori'           => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'protein'          => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'lemak'            => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'karbohidrat'      => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'serat'            => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
        ]);
        $forge->addKey('id', true);
        $forge->createTable('analisis_gizi_items', true);

        // 3. Checklist Pemeriksaan Hasil Masakan
        $forge->addField([
            'id'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'tanggal'          => ['type' => 'DATE'],
            'waktu_penyajian'  => ['type' => 'TIME'],
            'sppg_id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_by'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $forge->addKey('id', true);
        $forge->createTable('checklist_masakan', true);

        $forge->addField([
            'id'                   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'checklist_masakan_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_masakan'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'gramasi_standar'      => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'gramasi_real'         => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'rasa'                 => ['type' => 'ENUM', 'constraint' => ['Sesuai', 'Tidak Sesuai']],
            'tekstur'              => ['type' => 'ENUM', 'constraint' => ['Sesuai', 'Tidak Sesuai']],
            'keterangan'           => ['type' => 'TEXT', 'null' => true],
        ]);
        $forge->addKey('id', true);
        $forge->createTable('checklist_masakan_items', true);

        echo "Migration successful!";
    }
}
