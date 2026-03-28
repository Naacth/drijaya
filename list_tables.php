<?php
require 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';
$db = \Config\Database::connect();
$tables = $db->listTables();
echo "Tables in " . $db->getDatabase() . ":\n";
foreach ($tables as $table) {
    echo "- $table\n";
}
