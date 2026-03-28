<?php
$mysqli = new mysqli('localhost', 'root', '', 'sm');
$res = $mysqli->query("SELECT version, batch FROM migrations ORDER BY version DESC");
while ($row = $res->fetch_assoc()) {
    echo $row['version'] . " | " . $row['batch'] . "\n";
}
