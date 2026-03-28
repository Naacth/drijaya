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
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 3px 0; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 5px; text-align: center; }
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
        <div class="title-main">LAPORAN MONITORING SUHU PEMASAKAN</div>
        <table class="info-table">
            <tr><td width="150">Tanggal</td><td>: <?= date('d/m/Y', strtotime($header['tanggal'])) ?></td></tr>
            <tr><td>Pelaksana Cook</td><td>: <?= esc($header['nama_pelaksana']) ?></td></tr>
            <tr><td>Pemeriksa (Ahli Gizi)</td><td>: <?= esc($header['nama_pemeriksa']) ?></td></tr>
        </table>
        <table class="data-table">
            <thead>
                <tr><th width="30">No</th><th>Nama Makanan</th><th width="100">Suhu (°C)</th><th>Jam Matang</th><th>Jadwal Saji</th></tr>
            </thead>
            <tbody>
                <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td style="text-align: left;"><?= esc($item['nama_makanan']) ?></td>
                    <td><?= esc($item['suhu_pemasakan']) ?> °C</td>
                    <td><?= esc($item['jam_matang'] ?: '-') ?></td>
                    <td><?= esc($item['jadwal_penyajian'] ?: '-') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <table class="sig-block">
            <tr>
                <td><p>Pelaksana / Cook</p><div class="sig-space"></div><p>( <?= esc($header['nama_pelaksana']) ?> )</p></td>
                <td><p>Pemeriksa / Ahli Gizi</p><div class="sig-space"></div><p>( <?= esc($header['nama_pemeriksa']) ?> )</p></td>
            </tr>
        </table>
    </div>
</body>
</html>
