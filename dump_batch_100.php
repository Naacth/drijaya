<?php
$mysqli = new mysqli('localhost', 'root', '', 'sm');
$res = $mysqli->query("SELECT * FROM migrations WHERE batch = 100");
while($row = $res->fetch_assoc()) {
    echo json_encode($row) . "\n";
}
