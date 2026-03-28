<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 11px; margin: 0; padding: 20px; }
        .page-container { width: 100%; }
        .header-block { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header-block h2 { margin: 0; font-size: 16px; }
        .title-main { text-align: center; font-size: 14px; font-weight: bold; margin: 15px 0; text-decoration: underline; }
        .info-table { width: 100%; margin-bottom: 10px; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 4px; text-align: center; }
        .data-table th { background-color: #f2f2f2; }
        .sig-block { width: 100%; margin-top: 30px; }
        .sig-block td { text-align: center; width: 50%; }
        .sig-space { height: 60px; }
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
        <div class="title-main">MONITORING THAWING (MEDIA CHILLER)</div>
        <table class="info-table">
            <tr><td width="100">Tanggal</td><td>: <?= date('d/m/Y', strtotime($header['tanggal'])) ?></td></tr>
            <tr><td>Nama Petugas</td><td>: <?= esc($header['nama_petugas']) ?></td></tr>
        </table>
        <table class="data-table">
            <thead>
                <tr>
                    <th rowspan="2">No</th><th rowspan="2">Nama Bahan</th><th rowspan="2">Jml</th><th colspan="3">Waktu (Tgl/Jam)</th><th rowspan="2">Paraf</th>
                </tr>
                <tr>
                    <th>Keluar Freezer</th><th>Selesai Thawing</th><th>Pemasakan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td style="text-align: left;"><?= esc($item['nama_bahan']) ?></td>
                    <td><?= esc($item['jumlah']) ?></td>
                    <td><?= $item['tgl_jam_keluar_freezer'] ? date('d/m H:i', strtotime($item['tgl_jam_keluar_freezer'])) : '-' ?></td>
                    <td><?= $item['tgl_jam_selesai_thawing'] ? date('d/m H:i', strtotime($item['tgl_jam_selesai_thawing'])) : '-' ?></td>
                    <td><?= $item['tgl_jam_pemasakan'] ? date('d/m H:i', strtotime($item['tgl_jam_pemasakan'])) : '-' ?></td>
                    <td><?= esc($item['paraf']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <table class="sig-block">
            <tr>
                <td><p>Petugas Pelaksana</p><div class="sig-space"></div><p>( <?= esc($header['nama_petugas']) ?> )</p></td>
                <td><p>Diverifikasi (Ahli Gizi)</p><div class="sig-space"></div><p>( .................................. )</p></td>
            </tr>
        </table>
    </div>
</body>
</html>
