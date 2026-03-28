<?php
$mysqli = new mysqli('localhost', 'root', '', 'sm');

$migrationsToDelete = [
    '2026-03-28-000001',
    '2026-03-28-000002',
    '2026-03-28-000003',
    '2026-03-28-000004',
    '2026-03-28-000005',
    '2026-03-28-000006',
    '2026-03-28-000007',
    '2026-03-28-000008',
    '2026-03-28-000009',
    '2026-03-28-000010'
];

echo "Deleting migration records...\n";

foreach ($migrationsToDelete as $migration) {
    $mysqli->query("DELETE FROM migrations WHERE version = '$migration'");
    if ($mysqli->affected_rows > 0) {
        echo "Deleted record for: $migration\n";
    }
}

$mysqli->close();
echo "Migration records cleared.\n";
