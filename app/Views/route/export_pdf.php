<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #333; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; color: #2c3e50; font-size: 18px; }
        .header h3 { margin: 5px 0 0; color: #e74c3c; font-size: 14px; letter-spacing: 2px; }
        
        .info { margin-bottom: 15px; }
        .info table { width: 100%; border: none; }
        .info td { border: none; padding: 2px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; color: #2c3e50; text-transform: uppercase; font-size: 9px; }
        
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        
        .summary-box { border: 1px solid #ddd; padding: 10px; margin-top: 20px; background: #fafafa; }
        .footer { margin-top: 30px; }
        .signature { float: right; width: 180px; text-align: center; }
        
        @media print { .no-print { display: none; } body { padding: 10px; } }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="background: #fff3cd; padding: 10px; border: 1px solid #ffeeba; margin-bottom: 20px;">
        <strong>NEW RUTE - ALUR PENGIRIMAN</strong>
        <button onclick="window.history.back()" style="float: right;">Kembali</button>
    </div>

    <div class="header">
        <h3>NEW RUTE</h3>
        <h2>ALUR PENGIRIMAN MAKANAN</h2>
        <p>Logistik Distribusi SPPG Management</p>
    </div>

    <div class="info">
        <table border="0">
            <tr>
                <td width="80">TANGGAL</td><td>: <strong><?= date('d/m/Y', strtotime($header['tanggal'])) ?></strong></td>
                <td width="80" class="text-end">UNIT SPPG</td><td width="150">: <?= strtoupper($header['sppg']) ?></td>
            </tr>
            <tr>
                <td>MOBIL</td><td>: <span style="color: #e74c3c; font-weight: bold;"><?= strtoupper($header['mobil']) ?></span></td>
                <td class="text-end">KECAMATAN</td><td>: <?= strtoupper($header['kecamatan']) ?></td>
            </tr>
            <tr>
                <td>DRIVER</td><td>: <strong><?= strtoupper($header['driver']) ?></strong></td>
                <td class="text-end">STATUS</td><td>: <?= strtoupper($header['status']) ?></td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30" class="text-center">NO</th>
                <th>NAMA SEKOLAH</th>
                <th width="70" class="text-center">PORSI BESAR</th>
                <th width="70" class="text-center">PORSI KECIL</th>
                <th width="70" class="text-center">JUMLAH</th>
                <th width="70" class="text-center">JAM ANTAR</th>
                <th width="60" class="text-center">SESI</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td class="text-center"><?= $i + 1 ?></td>
                    <td><strong><?= strtoupper($item['nama_sekolah']) ?></strong></td>
                    <td class="text-center"><?= $item['porsi_besar'] ?></td>
                    <td class="text-center"><?= $item['porsi_kecil'] ?></td>
                    <td class="text-center"><strong><?= $item['jumlah'] ?></strong></td>
                    <td class="text-center"><?= date('H:i', strtotime($item['jam_antar'])) ?></td>
                    <td class="text-center"><?= strtoupper($item['sesi']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tr style="background-color: #f8f9fa; font-weight: bold;">
            <td colspan="2" class="text-end">TOTAL SELURUH</td>
            <td class="text-center"><?= array_sum(array_column($items, 'porsi_besar')) ?></td>
            <td class="text-center"><?= array_sum(array_column($items, 'porsi_kecil')) ?></td>
            <td class="text-center" style="background-color: #ffff00;"><?= $header['total_porsi'] ?></td>
            <td colspan="2"></td>
        </tr>
    </table>

    <div class="footer">
        <div style="float: left; width: 300px;">
            <p><strong>Catatan Logistik:</strong></p>
            <p style="font-size: 9px; color: #666;">
                1. Driver wajib hadir 30 menit sebelum pengiriman.<br>
                2. Periksa kembali segel box makanan.<br>
                3. Dokumentasikan serah terima di sekolah.
            </p>
        </div>
        <div class="signature">
            <p>Penginput Rute,</p>
            <br><br><br>
            <strong>( <?= strtoupper($header['pembuat']) ?> )</strong>
            <p>Asisten Lapangan</p>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>
