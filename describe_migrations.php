<?php
$mysqli = new mysqli('localhost', 'root', '', 'sm');
$res = $mysqli->query("DESCRIBE migrations");
while($row = $res->fetch_assoc()) {
    print_r($row);
}
