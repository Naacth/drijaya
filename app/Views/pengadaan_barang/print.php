<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 14px; color: #000; background: #fff; margin: 0; padding: 20px; }
        .page-container { width: 700px; margin: 0 auto; }
        @media print { body { padding: 0; } .page-container { width: 100%; } .no-print { display: none !important; } }
        .header-block { margin-bottom: 10px; }
        .header-block table { width: 100%; }
        .header-block h2 { font-size: 16px; font-weight: bold; margin: 0; }
        .header-block h3 { font-size: 15px; font-weight: bold; margin: 0; }
        .header-block p { font-size: 11px; margin: 2px 0; }
        .header-block hr { border: none; border-top: 3px double #000; margin: 8px 0; }
        .title-section { text-align: center; margin: 20px 0; }
        .title-section h3 { font-size: 16px; font-weight: bold; text-decoration: underline; margin: 0 0 5px; }
        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 4px 0; }
        .info-table .label { width: 180px; font-weight: bold; }
        .info-table .colon { width: 15px; }
        .sig-table { width: 100%; border-collapse: collapse; margin-top: 40px; }
        .sig-table td { width: 50%; text-align: center; padding: 10px; }
        .sig-space { height: 80px; }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; background: #333; color: #fff; border: none; border-radius: 5px;">Cetak</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; margin-left: 10px; border-radius: 5px;">Tutup</button>
    </div>
    <div class="page-container">
        <!-- HEADER -->
        <?= view('layout/print_header') ?>

        <div class="title-section">
            <h3>PENGAJUAN PENGADAAN BARANG</h3>
            <p>No: #PB-<?= str_pad($header['id'], 5, '0', STR_PAD_LEFT) ?></p>
        </div>

        <table class="info-table">
            <tr><td class="label">Tanggal</td><td class="colon">:</td><td><?= date('d/m/Y', strtotime($header['tanggal'])) ?></td></tr>
            <tr><td class="label">Nama Barang</td><td class="colon">:</td><td><?= esc($header['nama_barang']) ?></td></tr>
            <tr><td class="label">Jumlah</td><td class="colon">:</td><td><?= $header['jumlah'] ?> <?= esc($header['satuan']) ?></td></tr>
            <tr><td class="label">Estimasi Harga</td><td class="colon">:</td><td>Rp <?= number_format($header['estimasi_harga'], 0, ',', '.') ?></td></tr>
            <tr><td class="label">Alasan Pengadaan</td><td class="colon">:</td><td><?= esc($header['alasan'] ?: '-') ?></td></tr>
            <tr><td class="label">Status</td><td class="colon">:</td><td><?= ucfirst($header['status']) ?></td></tr>
            <tr><td class="label">Diajukan Oleh</td><td class="colon">:</td><td><?= esc($user_nama) ?></td></tr>
        </table>

        <table class="sig-table">
            <tr>
                <td>Diajukan Oleh,</td>
                <td>Disetujui Oleh,</td>
            </tr>
            <tr>
                <td><div class="sig-space"></div><strong>( <?= esc($user_nama) ?> )</strong><br><small>PIC Dapur</small></td>
                <td><div class="sig-space"></div><strong>( .................. )</strong><br><small>Kepala SPPG</small></td>
            </tr>
        </table>
    </div>
</body>
</html>
