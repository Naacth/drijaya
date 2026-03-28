<?php
$mysqli = new mysqli('localhost', 'root', '', 'sm');
$tables = [
    'pembersihan_transportasi',
    'pembersihan_trolly',
    'higiene_personil'
];

foreach ($tables as $table) {
    if ($mysqli->query("SHOW TABLES LIKE '$table'")->num_rows > 0) {
        echo "$table: OK\n";
    } else {
        echo "$table: MISSING\n";
    }
}

echo "\nMigrations in sm:\n";
$res = $mysqli->query("SELECT version FROM migrations ORDER BY version DESC LIMIT 5");
if ($res) {
    while($row = $res->fetch_assoc()) {
        echo $row['version'] . "\n";
    }
}
