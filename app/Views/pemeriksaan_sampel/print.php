<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 13px; margin: 0; padding: 20px; }
        .page-container { width: 750px; margin: 0 auto; }
        .header-block { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header-block h2 { margin: 0; font-size: 16px; }
        .header-block h3 { margin: 0; font-size: 14px; }
        .title-main { text-align: center; font-size: 15px; font-weight: bold; margin: 20px 0; text-decoration: underline; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 5px; border: 1px solid #000; }
        .info-table td.label { width: 180px; background-color: #f2f2f2; font-weight: bold; }
        .sig-block { width: 100%; margin-top: 50px; }
        .sig-block td { text-align: center; width: 50%; }
        .sig-space { height: 70px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()">Cetak</button>
        <button onclick="window.close()">Tutup</button>
    </div>
    <div class="page-container">
        <div class="header-block" style="position: relative; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px;">
            <img src="<?= base_url('bgn.png') ?>" style="position: absolute; left: 0; top: 0; height: 80px;">
            <div style="text-align: center;">
                <h2 style="margin: 0; font-size: 18px;">BADAN GIZI NASIONAL</h2>
                <h3 style="margin: 5px 0; font-size: 16px;">SPPG MANAGEMENT SYSTEM</h3>
                <p style="margin: 0; font-size: 13px;"><?= esc(session()->get('sppg_alamat') ?? 'Alamat belum diatur oleh PIC') ?></p>
            </div>
        </div>
        <div class="title-main">LAPORAN PEMERIKSAAN & SAMPEL MAKANAN</div>
        <table class="info-table">
            <tr><td class="label">Tanggal Pemeriksaan</td><td><?= date('d/m/Y', strtotime($header['tanggal'])) ?></td></tr>
            <tr><td class="label">Jam Matang</td><td><?= esc($header['jam_matang'] ?: '-') ?></td></tr>
            <tr><td class="label">Jenis Produk</td><td><?= esc($header['jenis_produk']) ?></td></tr>
            <tr><td class="label">Bahaya Fisik</td><td><?= esc($header['bahaya_fisik'] ?: 'TIDAK ADA') ?></td></tr>
            <tr><td class="label">Bahaya Biologi</td><td><?= esc($header['bahaya_biologi'] ?: 'TIDAK ADA') ?></td></tr>
            <tr><td class="label">Jam Penarikan</td><td><?= esc($header['jam_penarikan'] ?: '-') ?></td></tr>
            <tr><td class="label">Tindak Lanjut</td><td><?= esc($header['tindak_lanjut'] ?: '-') ?></td></tr>
            <tr><td class="label">Sampel Diambil</td><td><?= strtoupper($header['sampel_diambil']) ?></td></tr>
            <tr><td class="label">Jumlah Sampel</td><td><?= esc($header['jumlah_sampel'] ?: '-') ?></td></tr>
            <tr><td class="label">Tempat Penyimpanan</td><td><?= esc($header['tempat_penyimpanan'] ?: '-') ?></td></tr>
            <tr><td class="label">Tanggal Pemusnahan</td><td><?= $header['tanggal_pemusnahan'] ? date('d/m/Y', strtotime($header['tanggal_pemusnahan'])) : '-' ?></td></tr>
        </table>
        <table class="sig-block">
            <tr>
                <td><p>Pemeriksa / Ahli Gizi</p><div class="sig-space"></div><p>( <?= esc($header['nama_pemeriksa']) ?> )</p></td>
                <td><p>Kepala SPPG</p><div class="sig-space"></div><p>( .................................. )</p></td>
            </tr>
        </table>
    </div>
</body>
</html>
