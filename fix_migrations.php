<?php
$mysqli = new mysqli('localhost', 'root', '', 'sm');

$migrations = [
    ['2026-03-28-000001', 'CreateUjiCitaRasaTables'],
    ['2026-03-28-000002', 'CreatePemeriksaanSampelTable'],
    ['2026-03-28-000003', 'CreateMakananLebihTables'],
    ['2026-03-28-000004', 'CreateSerahTerimaBahanTables'],
    ['2026-03-28-000005', 'CreateMonitoringSuhuMasakTables'],
    ['2026-03-28-000006', 'CreateThawingAirTables'],
    ['2026-03-28-000007', 'CreateThawingChillerTables'],
    ['2026-03-28-000008', 'CreateSuhuRuanganTable'],
    ['2026-03-28-000009', 'CreateSuhuChillerFreezerTable'],
    ['2026-03-28-000010', 'CreatePencucianBahanTables'],
    ['2026-03-28-000011', 'CreateOperationalSanitationTables'],
];

$batch = 100; // Large batch number to distinguish from previous ones

foreach ($migrations as $m) {
    $version = $m[0];
    $class = 'App\\Database\\Migrations\\' . $m[1];
    
    // Check if record exists
    $check = $mysqli->query("SELECT id FROM migrations WHERE version = '$version'");
    if ($check->num_rows == 0) {
        $time = time();
        $sql = "INSERT INTO migrations (version, class, `group`, namespace, time, batch) VALUES ('$version', '$class', 'default', 'App', $time, $batch)";
        if ($mysqli->query($sql)) {
            echo "Inserted $version\n";
        } else {
            echo "Error inserting $version: " . $mysqli->error . "\n";
        }
    } else {
        echo "Skipping $version (already exists)\n";
    }
}
