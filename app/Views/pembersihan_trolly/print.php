<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; line-height: 1.4; }
        .header { margin-bottom: 20px; border-bottom: 2px solid #000; padding: 10px; position: relative; }
        .logo { height: 80px; position: absolute; left: 0; top: 10px; }
        .title-container { text-align: center; }
        .title { font-size: 18px; font-weight: bold; margin: 0; text-transform: uppercase; }
        .subtitle { font-size: 14px; margin: 5px 0 0 0; color: #444; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 5px 0; border: none; }
        .label { font-weight: bold; width: 150px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .table th { background-color: #f2f2f2; font-weight: bold; padding: 8px; border: 1px solid #000; text-transform: uppercase; font-size: 10px; }
        .table td { padding: 8px; border: 1px solid #000; font-size: 11px; }
        .text-center { text-align: center; }
        .sig-table { width: 100%; margin-top: 40px; border-collapse: collapse; }
        .sig-table td { width: 50%; text-align: center; border: none; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px; padding: 10px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
        <button onclick="window.print()" style="padding: 6px 16px; cursor: pointer; border-radius: 6px; border: 1px solid #dc3545; background: #dc3545; color: white; font-weight: 600;">Cetak PDF</button>
        <button onclick="window.close()" style="padding: 6px 16px; cursor: pointer; border-radius: 6px; border: 1px solid #6c757d; background: white; color: #6c757d; font-weight: 600; margin-left: 8px;">Tutup</button>
    </div>

    <div class="header">
        <img src="<?= base_url('bgn.png') ?>" class="logo">
        <div class="title-container">
            <h1 class="title">Checklist Pembersihan Trolly Makanan</h1>
            <p class="subtitle">PT. Drijaya - Manajemen Pemeliharaan & Higiene</p>
        </div>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Periode</td>
            <td>: <?= $header['bulan'] ?> <?= $header['tahun'] ?></td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="100">Tanggal</th>
                <th>Nama Personil</th>
                <th width="100">Jam</th>
                <th width="80">Paraf</th>
                <th>Keterangan (Kondisi)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rekap as $i => $row): ?>
            <tr>
                <td class="text-center fw-bold"><?= $i + 1 ?></td>
                <td class="text-center"><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                <td><?= $row['nama_personil'] ?></td>
                <td class="text-center"><?= $row['jam'] ?></td>
                <td class="text-center"><?= $row['paraf'] ?></td>
                <td><?= $row['keterangan'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="sig-table">
        <tr>
            <td>
                <p>Check By (Ahli Gizi),</p>
                <?php if (isset($signature) && $signature && $signature['image_data']): ?>
                    <img src="<?= $signature['image_data'] ?>" height="60">
                <?php else: ?>
                    <div style="height:60px;"></div>
                <?php endif; ?>
                <strong>( <?= $header['nama_gizi'] ?> )</strong>
            </td>
            <td>
                <p>Ka.SPPG,</p>
                <div style="height:60px;"></div>
                <strong>( <?= $header['nama_kappg'] ?> )</strong>
            </td>
        </tr>
    </table>
</body>
</html>
