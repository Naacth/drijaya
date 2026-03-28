<?php
$mysqli = new mysqli('localhost', 'root', '', 'sm');
$mysqli->query("UPDATE migrations SET batch = 1 WHERE batch = 100");
echo $mysqli->affected_rows . " rows updated to batch 1\n";

$res = $mysqli->query("SELECT * FROM migrations WHERE version = '2026-03-28-000001'");
print_r($res->fetch_assoc());
