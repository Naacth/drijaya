<?php
$db = new mysqli('localhost', 'root', '', 'sm');
if ($db->connect_error) { die("Connection failed: " . $db->connect_error); }
$db->query("SET FOREIGN_KEY_CHECKS = 0");

$tables = [
    'uji_cita_rasa', 'uji_cita_rasa_items',
    'pemeriksaan_sampel',
    'makanan_lebih', 'makanan_lebih_items',
    'serah_terima_bahan', 'serah_terima_bahan_items',
    'monitoring_suhu_masak', 'monitoring_suhu_masak_items',
    'checklist_thawing_air', 'checklist_thawing_air_items',
    'monitoring_thawing_chiller', 'monitoring_thawing_chiller_items',
    'catatan_suhu_ruangan',
    'suhu_chiller_freezer',
    'pencucian_bahan', 'pencucian_bahan_items'
];
foreach ($tables as $t) { $db->query("DROP TABLE IF EXISTS `$t` CASCADE"); }

echo "Tables dropped. Creating tables with accurate schema...\n";

// 1. Uji Cita Rasa
$db->query("CREATE TABLE `uji_cita_rasa` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, tanggal DATE, nama_checker VARCHAR(255), nama_chef VARCHAR(255), nama_ahli_gizi VARCHAR(255), created_by INT UNSIGNED, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)");
$db->query("CREATE TABLE `uji_cita_rasa_items` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, uji_cita_rasa_id INT UNSIGNED, nama_masakan VARCHAR(255), gramasi_standar VARCHAR(100), gramasi_real VARCHAR(100), masalah TEXT, penyelesaian TEXT, CONSTRAINT fk_uji_cita_rasa FOREIGN KEY (uji_cita_rasa_id) REFERENCES uji_cita_rasa(id) ON DELETE CASCADE)");

// 2. Pemeriksaan Sampel
$db->query("CREATE TABLE `pemeriksaan_sampel` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, tanggal DATE, jam_matang VARCHAR(20), jenis_produk VARCHAR(255), bahaya_fisik TEXT, bahaya_biologi TEXT, jam_penarikan VARCHAR(20), tindak_lanjut TEXT, sampel_diambil ENUM('ya', 'tidak') DEFAULT 'ya', jumlah_sampel VARCHAR(100), tempat_penyimpanan VARCHAR(255), tanggal_pemusnahan DATE, nama_pemeriksa VARCHAR(255), created_by INT UNSIGNED, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)");

// 3. Makanan Lebih
$db->query("CREATE TABLE `makanan_lebih` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, tanggal DATE, nama_cook VARCHAR(255), nama_chef VARCHAR(255), nama_ahli_gizi VARCHAR(255), created_by INT UNSIGNED, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)");
$db->query("CREATE TABLE `makanan_lebih_items` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, makanan_lebih_id INT UNSIGNED, nama_item VARCHAR(255), jumlah VARCHAR(100), kondisi VARCHAR(255), tindakan TEXT, CONSTRAINT fk_makanan_lebih FOREIGN KEY (makanan_lebih_id) REFERENCES makanan_lebih(id) ON DELETE CASCADE)");

// 4. Serah Terima Bahan
$db->query("CREATE TABLE `serah_terima_bahan` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, tanggal DATE, nama_pengirim VARCHAR(255), nama_penerima VARCHAR(255), created_by INT UNSIGNED, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)");
$db->query("CREATE TABLE `serah_terima_bahan_items` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, serah_terima_bahan_id INT UNSIGNED, jam VARCHAR(20), nama_bahan VARCHAR(255), tujuan_penggunaan VARCHAR(255), gramasi_per_porsi VARCHAR(100), jumlah_awal VARCHAR(100), jumlah_tidak_layak VARCHAR(100), tindak_lanjut TEXT, jumlah_akhir VARCHAR(100), CONSTRAINT fk_serah_terima FOREIGN KEY (serah_terima_bahan_id) REFERENCES serah_terima_bahan(id) ON DELETE CASCADE)");

// 5. Monitoring Suhu Masak
$db->query("CREATE TABLE `monitoring_suhu_masak` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, tanggal DATE, nama_pelaksana VARCHAR(255), nama_pemeriksa VARCHAR(255), created_by INT UNSIGNED, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)");
$db->query("CREATE TABLE `monitoring_suhu_masak_items` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, monitoring_suhu_masak_id INT UNSIGNED, nama_makanan VARCHAR(255), suhu_pemasakan VARCHAR(50), jam_matang VARCHAR(20), jadwal_penyajian VARCHAR(100), CONSTRAINT fk_suhu_masak FOREIGN KEY (monitoring_suhu_masak_id) REFERENCES monitoring_suhu_masak(id) ON DELETE CASCADE)");

// 6. Thawing Air
$db->query("CREATE TABLE `checklist_thawing_air` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, tanggal DATE, nama_petugas VARCHAR(255), created_by INT UNSIGNED, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)");
$db->query("CREATE TABLE `checklist_thawing_air_items` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, checklist_thawing_air_id INT UNSIGNED, nama_bahan VARCHAR(255), jumlah VARCHAR(100), suhu_air VARCHAR(50), waktu_thawing VARCHAR(100), paraf VARCHAR(255), CONSTRAINT fk_thawing_air FOREIGN KEY (checklist_thawing_air_id) REFERENCES checklist_thawing_air(id) ON DELETE CASCADE)");

// 7. Thawing Chiller
$db->query("CREATE TABLE `monitoring_thawing_chiller` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, tanggal DATE, nama_petugas VARCHAR(255), created_by INT UNSIGNED, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)");
$db->query("CREATE TABLE `monitoring_thawing_chiller_items` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, monitoring_thawing_chiller_id INT UNSIGNED, nama_bahan VARCHAR(255), jumlah VARCHAR(100), tgl_jam_keluar_freezer VARCHAR(100), tgl_jam_selesai_thawing VARCHAR(100), tgl_jam_pemasakan VARCHAR(100), paraf VARCHAR(255), CONSTRAINT fk_thawing_chiller FOREIGN KEY (monitoring_thawing_chiller_id) REFERENCES monitoring_thawing_chiller(id) ON DELETE CASCADE)");

// 8. Suhu Ruangan
$db->query("CREATE TABLE `catatan_suhu_ruangan` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, tanggal DATE, pagi_jam VARCHAR(20), pagi_kelembapan VARCHAR(50), pagi_suhu VARCHAR(50), pagi_keterangan TEXT, siang_jam VARCHAR(20), siang_kelembapan VARCHAR(50), siang_suhu VARCHAR(50), siang_keterangan TEXT, sore_jam VARCHAR(20), sore_kelembapan VARCHAR(50), sore_suhu VARCHAR(50), sore_keterangan TEXT, nama_petugas VARCHAR(255), created_by INT UNSIGNED, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)");

// 9. Suhu Chiller/Freezer
$db->query("CREATE TABLE `suhu_chiller_freezer` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, tanggal DATE, chiller_pagi VARCHAR(50), chiller_siang VARCHAR(50), chiller_malam VARCHAR(50), freezer_pagi VARCHAR(50), freezer_siang VARCHAR(50), freezer_malam VARCHAR(50), kebersihan_rak VARCHAR(255), verifikasi VARCHAR(255), nama_petugas VARCHAR(255), created_by INT UNSIGNED, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)");

// 10. Pencucian Bahan
$db->query("CREATE TABLE `pencucian_bahan` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, tanggal DATE, nama_petugas VARCHAR(255), created_by INT UNSIGNED, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)");
$db->query("CREATE TABLE `pencucian_bahan_items` (id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, pencucian_bahan_id INT UNSIGNED, nama_bahan VARCHAR(255), bahan_kimia VARCHAR(255), benda_asing VARCHAR(255), tindak_lanjut TEXT, jam_produksi VARCHAR(20), CONSTRAINT fk_pencucian_bahan FOREIGN KEY (pencucian_bahan_id) REFERENCES pencucian_bahan(id) ON DELETE CASCADE)");

$db->query("SET FOREIGN_KEY_CHECKS = 1");
$db->close();
echo "Tables restored with corrected schema.\n";
