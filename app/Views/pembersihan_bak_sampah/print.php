<!DOCTYPE html>
<html>
<head>
    <title>Pembersihan Bak Sampah</title>
    <style>body { font-family: sans-serif; font-size: 12px; } .header { text-align: center; border-bottom: 2px solid #000; padding:10px; } .table { width:100%; border-collapse:collapse; margin:20px 0; } .table td { border:1px solid #000; padding:8px; }
        .sig-cell { text-align: center; border:none; }
        .badge { font-weight: bold; }
        @media print { .no-print { display: none; } }
    </style>
<?= view('layout/print_signatures_style') ?>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px; padding: 10px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
        <button onclick="window.print()" style="padding: 6px 16px; cursor: pointer; border-radius: 6px; border: 1px solid #6366f1; background: #6366f1; color: white; font-weight: 600;">Cetak PDF</button>
        <button onclick="window.close()" style="padding: 6px 16px; cursor: pointer; border-radius: 6px; border: 1px solid #cbd5e1; background: white; color: #64748b; font-weight: 600; margin-left: 8px;">Tutup</button>
    </div>
    <!-- HEADER -->
    <?= view('layout/print_header') ?>
    <div style="text-align:center; font-weight:bold; font-size:15px; text-decoration:underline; margin-bottom:15px;">LOG PEMBERSIHAN BAK SAMPAH</div>
    <table class="table">
        <tr><td width="30%">Tanggal</td><td><?= date('d/m/Y', strtotime($header['tanggal'])) ?></td></tr>
        <tr><td>Jam</td><td><?= $header['jam'] ?></td></tr>
        <tr><td>Personil</td><td><?= esc($header['nama_personil']) ?></td></tr>
        <tr><td>Keterangan</td><td><?= nl2br(esc($header['keterangan'])) ?></td></tr>
    </table>
    <div style="margin-top:50px; text-align:right;">Dicetak oleh: <?= session()->get('nama') ?></div>
    <script>window.print();</script>
</body>
</html>
