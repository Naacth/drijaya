<?php
$mysqli = new mysqli('localhost', 'root', '', 'sm');
if ($mysqli->connect_error) die("Connect Error: " . $mysqli->connect_error);

$tables = [
    'sanitasi_ruangan', 'pembersihan_harian', 'pembersihan_mingguan', 
    'pembuangan_sampah', 'pembersihan_bak_sampah', 'pembersihan_lantai', 
    'pengeluaran_chemical'
];

foreach ($tables as $t) {
    $mysqli->query("DROP TABLE IF EXISTS `$t` CASCADE");
}

echo "Dropped old operational tables. Creating new ones...\n";

$sql = [
    "CREATE TABLE `sanitasi_ruangan` (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        tanggal DATE,
        fasilitas_data TEXT,
        nama_pelaksana VARCHAR(255),
        nama_pemeriksa VARCHAR(255),
        created_by INT UNSIGNED,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )",
    "CREATE TABLE `pembersihan_harian` (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        tanggal DATE,
        unit_type ENUM('freezer', 'chiller') DEFAULT 'chiller',
        area_data TEXT,
        nama_petugas VARCHAR(255),
        nama_verifikator VARCHAR(255),
        created_by INT UNSIGNED,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )",
    "CREATE TABLE `pembersihan_mingguan` (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        area_pencucian VARCHAR(255),
        minggu_ke INT,
        bulan VARCHAR(20),
        checklist_data TEXT,
        nama_verifikator VARCHAR(255),
        created_by INT UNSIGNED,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )",
    "CREATE TABLE `pembuangan_sampah` (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        bulan VARCHAR(20),
        tahun INT,
        rekap_data LONGTEXT,
        nama_kappg VARCHAR(255),
        created_by INT UNSIGNED,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )",
    "CREATE TABLE `pembersihan_bak_sampah` (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        tanggal DATE,
        nama_personil VARCHAR(255),
        jam VARCHAR(10),
        keterangan TEXT,
        created_by INT UNSIGNED,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )",
    "CREATE TABLE `pembersihan_lantai` (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        tanggal DATE,
        nama_personil VARCHAR(255),
        jam VARCHAR(10),
        kondisi VARCHAR(255),
        created_by INT UNSIGNED,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )",
    "CREATE TABLE `pengeluaran_chemical` (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        tanggal DATE,
        nama_chemical VARCHAR(255),
        jumlah DECIMAL(10,2),
        unit VARCHAR(50),
        nama_personil VARCHAR(255),
        nama_gizi VARCHAR(255),
        created_by INT UNSIGNED,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )"
];

foreach ($sql as $q) {
    if (!$mysqli->query($q)) {
        echo "Error creating table: " . $mysqli->error . "\n";
    }
}

echo "Operational & Sanitation tables restored.\n";
