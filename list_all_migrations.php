<?php
$mysqli = new mysqli('localhost', 'root', '', 'sm');
$res = $mysqli->query("SELECT version FROM migrations ORDER BY version ASC");
echo "Migrations in database:\n";
while($row = $res->fetch_assoc()) {
    echo $row['version'] . "\n";
}
