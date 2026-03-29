<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembuangan Sampah</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding: 10px; margin-bottom: 15px; }
        .title { text-align: center; margin-bottom: 20px; font-weight: bold; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 4px; text-align: center; }
        .bg-gray { background: #f2f2f2; }
        .footer { width: 100%; margin-top: 50px; }
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

    <div style="margin-bottom:10px;">
        BULAN: <?= strtoupper($header['bulan']) ?> <?= $header['tahun'] ?>
    </div>

    <table class="table">
        <thead>
            <tr class="bg-gray">
                <th rowspan="2" width="60">WAKTU</th>
                <th colspan="31">TANGGAL</th>
            </tr>
            <tr class="bg-gray">
                <?php for($i=1;$i<=31;$i++) echo "<th width='20'>$i</th>"; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach(['07.00', '14.00', '22.00'] as $time): ?>
            <tr>
                <td class="bg-gray"><strong><?= $time ?></strong></td>
                <?php for($i=1;$i<=31;$i++): ?>
                <td><?= (isset($rekap[$time][$i]) && $rekap[$time][$i] == '1') ? 'V' : '' ?></td>
                <?php endfor; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="footer" style="border:none;">
        <tr style="border:none;">
            <td class="footer-cell" style="border:none;">
                <p>Petugas Kebersihan,</p>
                <div style="height:60px;"></div>
                <p>..............................</p>
            </td>
            <td class="footer-cell" style="border:none;">
                <p>Mengetahui,</p>
                <p><strong>Ka. SPPG</strong></p>
                <div style="height:45px;"></div>
                <p><strong>( <?= esc($header['nama_kappg']) ?> )</strong></p>
            </td>
        </tr>
    </table>
</body>
</html>
