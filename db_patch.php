<?php
$conn = new mysqli('localhost', 'root', 'Elaina870.', 'sm');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$queries = [
    "ALTER TABLE user_signatures ADD COLUMN nama_aslap VARCHAR(255) NULL;",
    "ALTER TABLE user_signatures ADD COLUMN nama_kepala_sppg VARCHAR(255) NULL;",
    "ALTER TABLE user_signatures ADD COLUMN nama_ahli_gizi VARCHAR(255) NULL;",
    "ALTER TABLE user_signatures ADD COLUMN nama_kepala_koki VARCHAR(255) NULL;",
    "ALTER TABLE user_signatures ADD COLUMN nama_akuntan VARCHAR(255) NULL;"
];

foreach ($queries as $sql) {
    if ($conn->query($sql) === TRUE) {
        echo "Column added successfully\n";
    } else {
        echo "Error: " . $conn->error . "\n";
    }
}
$conn->close();
?>
