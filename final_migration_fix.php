<?php
$mysqli = new mysqli("localhost", "root", "", "sm");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$tablesToDrop = [
    'uji_cita_rasa_items', 'uji_cita_rasa',
    'pemeriksaan_sampel',
    'makanan_lebih_items', 'makanan_lebih',
    'serah_terima_bahan_items', 'serah_terima_bahan',
    'monitoring_suhu_masak_items', 'monitoring_suhu_masak',
    'checklist_thawing_air_items', 'checklist_thawing_air',
    'monitoring_thawing_chiller_items', 'monitoring_thawing_chiller',
    'catatan_suhu_ruangan',
    'suhu_chiller_freezer',
    'pencucian_bahan_items', 'pencucian_bahan'
];

$migrationsToClear = [
    '2026-03-28-000001', '2026-03-28-000002', '2026-03-28-000003', '2026-03-28-000004', '2026-03-28-000005',
    '2026-03-28-000006', '2026-03-28-000007', '2026-03-28-000008', '2026-03-28-000009', '2026-03-28-000010'
];

echo "1. Disabling foreign keys...\n";
$mysqli->query("SET FOREIGN_KEY_CHECKS = 0");

echo "2. Dropping tables...\n";
foreach ($tablesToDrop as $table) {
    $mysqli->query("DROP TABLE IF EXISTS `$table` CASCADE");
    echo "Dropped (if existed): $table\n";
}

echo "3. Clearing migration records...\n";
foreach ($migrationsToClear as $m) {
    $mysqli->query("DELETE FROM migrations WHERE version = '$m'");
    if ($mysqli->affected_rows > 0) echo "Cleared migration: $m\n";
}

$mysqli->query("SET FOREIGN_KEY_CHECKS = 1");
$mysqli->close();

echo "4. Running php spark migrate...\n";
passthru("php spark migrate");

echo "Cleanup and Migration finished.\n";
