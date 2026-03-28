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
        .title-main { text-align: center; font-size: 15px; font-weight: bold; margin: 20px 0; text-decoration: underline; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 10px; text-align: center; }
        .data-table th { background-color: #f2f2f2; }
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
        <div class="title-main">LAPORAN PEMANTAUAN SUHU UNIT PENDINGIN & PEMBEKU</div>
        <div style="margin-bottom: 15px;">
            Tanggal: <strong><?= date('d/m/Y', strtotime($header['tanggal'])) ?></strong><br>
            Petugas: <strong><?= esc($header['nama_petugas']) ?></strong>
        </div>
        <table class="data-table">
            <thead>
                <tr><th rowspan="2">Unit Peralatan</th><th colspan="3">Monitoring Suhu (°C)</th></tr>
                <tr><th>Pagi</th><th>Siang</th><th>Malam</th></tr>
            </thead>
            <tbody>
                <tr><td>Unit Chiller (0 s/d 4°C)</td><td><?= esc($header['chiller_pagi']) ?></td><td><?= esc($header['chiller_siang']) ?></td><td><?= esc($header['chiller_malam']) ?></td></tr>
                <tr><td>Unit Freezer (< -18°C)</td><td><?= esc($header['freezer_pagi']) ?></td><td><?= esc($header['freezer_siang']) ?></td><td><?= esc($header['freezer_malam']) ?></td></tr>
            </tbody>
        </table>
        <div style="margin-top: 20px;">
            <p>Kebersihan Rak: <strong><?= esc($header['kebersihan_rak'] ?: '-') ?></strong></p>
            <p>Verifikasi Ahli Gizi: <strong><?= esc($header['verifikasi'] ?: '-') ?></strong></p>
        </div>
        <table class="sig-block">
            <tr>
                <td><p>Petugas Pelaksana</p><div class="sig-space"></div><p>( <?= esc($header['nama_petugas']) ?> )</p></td>
                <td><p>Ahli Gizi (Verifikator)</p><div class="sig-space"></div><p>( <?= esc($header['verifikasi'] ?: '....................') ?> )</p></td>
            </tr>
        </table>
    </div>
</body>
</html>
