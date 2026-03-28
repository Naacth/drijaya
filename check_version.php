<?php
$mysqli = new mysqli('localhost', 'root', '', 'sm');
$res = $mysqli->query("SELECT version FROM migrations WHERE version LIKE '2026-03-08%' LIMIT 1");
$row = $res->fetch_assoc();
echo "Version: '" . $row['version'] . "' (Length: " . strlen($row['version']) . ")\n";

$res = $mysqli->query("SELECT version FROM migrations WHERE batch = 100 LIMIT 1");
$row = $res->fetch_assoc();
echo "Batch 100 Version: '" . $row['version'] . "' (Length: " . strlen($row['version']) . ")\n";
