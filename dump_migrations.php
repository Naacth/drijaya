<?php
$mysqli = new mysqli('localhost', 'root', '', 'sm');
$res = $mysqli->query("SELECT * FROM migrations WHERE version LIKE '2026-03-28%'");
while($row = $res->fetch_assoc()) {
    var_dump($row);
}
