<?php
$mysqli = new mysqli('localhost', 'root', '', 'sm');
$tables = [
    'pembersihan_transportasi',
    'pembersihan_trolly',
    'higiene_personil',
    'pembersihan_harian',
    'sanitasi_ruangan',
    'pembersihan_mingguan',
    'pembuangan_sampah'
];

foreach ($tables as $table) {
    if ($mysqli->query("SHOW TABLES LIKE '$table'")->num_rows > 0) {
        echo "$table: OK\n";
    } else {
        echo "$table: MISSING\n";
    }
}
