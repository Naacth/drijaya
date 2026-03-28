<?php
$mysqli = new mysqli('localhost', 'root', '', 'sm');
$tables = [
    'uji_cita_rasa',
    'pemeriksaan_sampel',
    'makanan_lebih',
    'serah_terima_bahan',
    'monitoring_suhu_masak',
    'checklist_thawing_air',
    'monitoring_thawing_chiller',
    'catatan_suhu_ruangan',
    'suhu_chiller_freezer',
    'pencucian_bahan'
];

foreach ($tables as $table) {
    $res = $mysqli->query("SHOW TABLES LIKE '$table'");
    echo "$table: " . ($res->num_rows > 0 ? "OK" : "MISSING") . "\n";
}

echo "\nMigration records:\n";
$res = $mysqli->query("SELECT version FROM migrations WHERE version LIKE '2026-03-28%'");
while($row = $res->fetch_assoc()) {
    echo $row['version'] . "\n";
}
