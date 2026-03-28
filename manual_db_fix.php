<?php
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->systemDirectory . '/Boot.php';
$app = CodeIgniter\Boot::bootWeb($paths);

$db = \Config\Database::connect();
$forge = \Config\Database::forge();

echo "Manually creating table: catatan_suhu_ruangan...\n";

$forge->addField([
    'id'                 => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
    'tanggal'            => ['type' => 'DATE'],
    'pagi_jam'           => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
    'pagi_kelembapan'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
    'pagi_suhu'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
    'pagi_keterangan'    => ['type' => 'TEXT', 'null' => true],
    'siang_jam'          => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
    'siang_kelembapan'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
    'siang_suhu'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
    'siang_keterangan'   => ['type' => 'TEXT', 'null' => true],
    'sore_jam'           => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
    'sore_kelembapan'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
    'sore_suhu'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
    'sore_keterangan'    => ['type' => 'TEXT', 'null' => true],
    'nama_petugas'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
    'created_by'         => ['type' => 'INT', 'unsigned' => true],
    'created_at'         => ['type' => 'DATETIME', 'null' => true, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
    'updated_at'         => ['type' => 'DATETIME', 'null' => true, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
]);
$forge->addKey('id', true);
$forge->createTable('catatan_suhu_ruangan', true);

echo "Table catatan_suhu_ruangan created.\n";

echo "Manually creating table: suhu_chiller_freezer...\n";
$forge->addField([
    'id'                    => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
    'tanggal'               => ['type' => 'DATE'],
    'chiller_pagi'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
    'chiller_siang'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
    'chiller_malam'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
    'freezer_pagi'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
    'freezer_siang'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
    'freezer_malam'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
    'kebersihan_rak'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
    'verifikasi'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
    'nama_petugas'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
    'created_by'            => ['type' => 'INT', 'unsigned' => true],
    'created_at'            => ['type' => 'DATETIME', 'null' => true, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
    'updated_at'            => ['type' => 'DATETIME', 'null' => true, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
]);
$forge->addKey('id', true);
$forge->createTable('suhu_chiller_freezer', true);
echo "Table suhu_chiller_freezer created.\n";

echo "Manually creating table: pencucian_bahan and items...\n";
$forge->addField([
    'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
    'tanggal'         => ['type' => 'DATE'],
    'nama_petugas'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
    'created_by'      => ['type' => 'INT', 'unsigned' => true],
    'created_at'      => ['type' => 'DATETIME', 'null' => true, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
    'updated_at'      => ['type' => 'DATETIME', 'null' => true, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
]);
$forge->addKey('id', true);
$forge->createTable('pencucian_bahan', true);

$forge->addField([
    'id'                  => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
    'pencucian_bahan_id'  => ['type' => 'INT', 'unsigned' => true],
    'nama_bahan'          => ['type' => 'VARCHAR', 'constraint' => 255],
    'bahan_kimia'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
    'benda_asing'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
    'tindak_lanjut'       => ['type' => 'TEXT', 'null' => true],
    'jam_produksi'        => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
]);
$forge->addKey('id', true);
$mysqli = $db->getConnectionId();
$mysqli->query("SET FOREIGN_KEY_CHECKS = 0");
$forge->addForeignKey('pencucian_bahan_id', 'pencucian_bahan', 'id', 'CASCADE', 'CASCADE');
$forge->createTable('pencucian_bahan_items', true);
$mysqli->query("SET FOREIGN_KEY_CHECKS = 1");
echo "Table pencucian_bahan and items created.\n";

// Manual migration record insert
$db->table('migrations')->insertBatch([
    ['version' => '2026-03-28-000008', 'class' => 'App\Database\Migrations\CreateSuhuRuanganTable', 'group' => 'default', 'namespace' => 'App', 'time' => time(), 'batch' => 3],
    ['version' => '2026-03-28-000009', 'class' => 'App\Database\Migrations\CreateSuhuChillerFreezerTable', 'group' => 'default', 'namespace' => 'App', 'time' => time(), 'batch' => 3],
    ['version' => '2026-03-28-000010', 'class' => 'App\Database\Migrations\CreatePencucianBahanTables', 'group' => 'default', 'namespace' => 'App', 'time' => time(), 'batch' => 3],
]);

echo "Manual setup finished.\n";
