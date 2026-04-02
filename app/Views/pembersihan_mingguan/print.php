<!DOCTYPE html>
<html>
<head>
    <title>Pembersihan Mingguan</title>
    <style>body { font-family: sans-serif; font-size: 11px; } .header { text-align: center; border-bottom: 2px solid #000; padding:10px; } .table { width:100%; border-collapse:collapse; margin:20px 0; } .table th, .table td { border:1px solid #000; padding:6px; }
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
    <div style="text-align:center; font-weight:bold; font-size:15px; text-decoration:underline; margin-bottom:20px;">LOG PEMBERSIHAN MINGGUAN (DEEP CLEANING)</div>
    <div style="margin-bottom:10px;">
        UNIT: <strong><?= strtoupper($header['area_pencucian']) ?></strong><br>
        MINGGU KE: <?= $header['minggu_ke'] ?> (<?= $header['bulan'] ?>)
    </div>
    <table class="table">
        <thead><tr style="background:#f0f0f0;"><th>Komponen</th><th>Status</th></tr></thead>
        <tbody>
            <?php foreach($checklist as $k => $v): ?>
            <tr><td style="text-transform: capitalize;"><?= str_replace('_', ' ', $k) ?></td><td align="center"><strong><?= $v ?></strong></td></tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="margin-top:50px; text-align:right;">Verifikator: <strong>( <?= esc($header['nama_verifikator']) ?> )</strong></div>
</body>
</html>
