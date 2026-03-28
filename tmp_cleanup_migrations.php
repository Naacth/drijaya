<?php
$mysqli = new mysqli("localhost", "root", "", "sm");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$tablesToDrop = [
    'monitoring_thawing_chiller_items',
    'monitoring_thawing_chiller',
    'thawing_air_items',
    'thawing_air',
    'monitoring_suhu_masak_items',
    'monitoring_suhu_masak',
    'serah_terima_bahan_items',
    'serah_terima_bahan',
    'makanan_lebih_items',
    'makanan_lebih',
    'pemeriksaan_sampel',
    'uji_cita_rasa_items',
    'uji_cita_rasa',
    'catatan_suhu_ruangan',
    'suhu_chiller_freezer',
    'pencucian_bahan_items',
    'pencucian_bahan'
];

echo "Cleaning up tables...\n";

// Disable foreign key checks to allow dropping tables in any order
$mysqli->query("SET FOREIGN_KEY_CHECKS = 0");

foreach ($tablesToDrop as $table) {
    $result = $mysqli->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        echo "Dropping table: $table\n";
        $mysqli->query("DROP TABLE `$table` CASCADE");
    }
}

$mysqli->query("SET FOREIGN_KEY_CHECKS = 1");
$mysqli->close();

echo "Cleanup finished. Now run 'php spark migrate'.\n";
