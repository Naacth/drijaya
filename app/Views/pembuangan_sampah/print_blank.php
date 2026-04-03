<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; margin: 16px; color: #000; }
        h2 { text-align: center; font-size: 14px; margin-bottom: 8px; }
        .meta { margin-bottom: 12px; }
        .meta span { display: inline-block; min-width: 120px; border-bottom: 1px solid #000; margin-left: 6px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
        th { background: #f0f0f0; font-size: 9px; }
        .waktu { font-weight: bold; text-align: left; padding-left: 8px; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align:center;margin-bottom:12px;">
        <button type="button" onclick="window.print()" style="padding:8px 16px;">Cetak</button>
        <button type="button" onclick="window.close()" style="padding:8px 16px;margin-left:8px;">Tutup</button>
    </div>
    <h2><?= esc($title) ?></h2>
    <div class="meta">Bulan: <span></span> &nbsp; Tahun: <span></span> &nbsp; Mengetahui Ka.SPPG: <span></span></div>
    <table>
        <thead>
            <tr>
                <th width="90">Waktu</th>
                <?php for ($d = 1; $d <= 31; $d++): ?>
                    <th style="min-width:22px;"><?= $d ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach (['07.00', '14.00', '22.00'] as $t): ?>
            <tr>
                <td class="waktu"><?= $t ?></td>
                <?php for ($d = 1; $d <= 31; $d++): ?>
                    <td>&nbsp;</td>
                <?php endfor; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
