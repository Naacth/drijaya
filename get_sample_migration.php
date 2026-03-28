<?php
$mysqli = new mysqli('localhost', 'root', '', 'sm');
$res = $mysqli->query("SELECT version, class FROM migrations WHERE version = '2026-03-08-000001'");
print_r($res->fetch_assoc());
