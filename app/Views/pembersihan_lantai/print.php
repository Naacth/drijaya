<!DOCTYPE html>
<html>
<head>
    <title>Pembersihan Lantai</title>
    <style>body { font-family: sans-serif; font-size: 12px; } .header { text-align: center; border-bottom: 2px solid #000; padding:10px; } .table { width:100%; border-collapse:collapse; margin:20px 0; } .table td { border:1px solid #000; padding:8px; }
        .sig-cell { text-align: center; border:none; }
        .badge { font-weight: bold; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px; padding: 10px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
        <button onclick="window.print()" style="padding: 6px 16px; cursor: pointer; border-radius: 6px; border: 1px solid #6366f1; background: #6366f1; color: white; font-weight: 600;">Cetak PDF</button>
        <button onclick="window.close()" style="padding: 6px 16px; cursor: pointer; border-radius: 6px; border: 1px solid #cbd5e1; background: white; color: #64748b; font-weight: 600; margin-left: 8px;">Tutup</button>
    </div>
    <div class="header-block">
        <table>
            <tr>
                <td width="120" style="text-align: center; vertical-align: middle; border: none;">
                    <img src="<?= base_url('bgn.png') ?>" alt="Logo BGN" style="width: 100px; height: auto;">
                </td>
                <td style="text-align: center; border: none;">
                    <h2 style="font-size: 16px; font-weight: bold; margin: 0;">SPPG BUNAR SUKAMULYA</h2>
                    <h3 style="font-size: 15px; font-weight: bold; margin: 0;">YAYASAN BUMI PANGAN INDONESIA</h3>
                    <p style="font-size: 11px; margin: 2px 0;"><?= esc(session()->get('sppg_alamat') ?? 'Alamat belum diatur') ?></p>
                    <p style="font-size: 11px; margin: 2px 0;">15610</p>
                </td>
                <td width="120" style="text-align: center; vertical-align: middle; border: none;">
                    <img src="<?= base_url('yayasan.png') ?>" alt="Logo Yayasan" style="width: 95px; height: auto;">
                </td>
            </tr>
        </table>
        <hr style="border: none; border-top: 3px double #000; margin: 8px 0;">
    </div>
    <div style="text-align:center; font-weight:bold; font-size:15px; text-decoration:underline; margin-bottom:15px;">LOG PEMBERSIHAN LANTAI AREA PRODUKSI</div>
    <table class="table">
        <tr><td width="30%">Tanggal</td><td><?= date('d/m/Y', strtotime($header['tanggal'])) ?></td></tr>
        <tr><td>Jam</td><td><?= $header['jam'] ?></td></tr>
        <tr><td>Personil</td><td><?= esc($header['nama_personil']) ?></td></tr>
        <tr><td>Kondisi Lantai</td><td><strong><?= strtoupper($header['kondisi']) ?></strong></td></tr>
    </table>
    <div style="margin-top:50px; text-align:right;">Dicetak oleh: <?= session()->get('nama') ?></div>
    <script>window.print();</script>
</body>
</html>
