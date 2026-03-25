<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Purchase Order - <?= $po['nomor_po'] ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 11pt; color: #333; line-height: 1.4; margin: 0; padding: 40px; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header-left h2 { margin: 0; color: #000; font-size: 24pt; letter-spacing: 1px; }
        .header-left p { margin: 5px 0 0; font-weight: bold; }
        .header-right { text-align: right; }
        .header-right h3 { margin: 0; font-weight: normal; color: #666; }
        
        .info-section { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .info-box { width: 48%; }
        .info-box h4 { margin: 0 0 10px; text-transform: uppercase; border-bottom: 1px solid #ddd; padding-bottom: 5px; font-size: 10pt; color: #777; }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 4px 0; vertical-align: top; }
        .info-table td:first-child { width: 100px; color: #666; }
        
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .items-table th { background-color: #f8f9fa; border-top: 2px solid #333; border-bottom: 1px solid #333; padding: 12px 8px; text-align: left; font-size: 10pt; }
        .items-table td { border-bottom: 1px solid #eee; padding: 10px 8px; vertical-align: top; }
        .items-table tr:last-child td { border-bottom: 2px solid #333; }
        
        .total-section { display: flex; justify-content: flex-end; margin-bottom: 50px; }
        .total-box { width: 300px; }
        .total-row { display: flex; justify-content: space-between; padding: 8px 0; }
        .total-row.grand-total { border-top: 2px double #333; margin-top: 5px; font-weight: bold; font-size: 14pt; }
        
        .signature-section { display: flex; justify-content: space-between; page-break-inside: avoid; }
        .signature-box { width: 30%; text-align: center; }
        .signature-box .title { margin-bottom: 80px; font-weight: bold; }
        .signature-box .name { text-decoration: underline; font-weight: bold; }
        .signature-box .role { font-size: 9pt; color: #666; }

        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px;">
        <div style="width: 120px; text-align: left;">
            <img src="<?= base_url('bgn.png') ?>" alt="Logo BGN" style="width: 100px; height: auto;">
        </div>
        <div style="text-align: center; flex: 1;">
            <h2 style="margin: 0; color: #000; font-size: 20pt; letter-spacing: 1px;">PURCHASE ORDER</h2>
            <p style="margin: 5px 0 0; font-weight: bold;"><?= session()->get('sppg_nama') ?? 'Dapur SPPG Bunar' ?></p>
            <h3 style="margin: 5px 0 0; font-weight: normal; color: #666; font-size: 14pt;">#<?= $po['nomor_po'] ?> | <?= date('d/m/Y', strtotime($po['tanggal'])) ?></h3>
        </div>
        <div style="width: 120px; text-align: right;">
            <img src="<?= base_url('yayasan.png') ?>" alt="Logo Yayasan" style="width: 95px; height: auto;">
        </div>
    </div>

    <div class="info-section">
        <div class="info-box">
            <h4>Pemasok / Vendor</h4>
            <div class="fw-bold fs-5"><?= $po['vendor'] ?></div>
        </div>
        <div class="info-box text-end">
            <h4>Detail Menu</h4>
            <div><?= $po['menu'] ?></div>
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th width="50">NO</th>
                <th>DESKRIPSI BARANG</th>
                <th width="100" style="text-align: center;">QTY</th>
                <th width="100" style="text-align: center;">SATUAN</th>
                <th width="150" style="text-align: right;">HARGA</th>
                <th width="150" style="text-align: right;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $index => $item): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td>
                        <strong><?= $item['nama_barang'] ?></strong>
                        <?php if($item['catatan']): ?><br><small><?= $item['catatan'] ?></small><?php endif; ?>
                    </td>
                    <td style="text-align: center;"><?= number_format($item['qty'], 2, ',', '.') ?></td>
                    <td style="text-align: center;"><?= $item['satuan'] ?></td>
                    <td style="text-align: right;">Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                    <td style="text-align: right;">Rp <?= number_format($item['total'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-box">
            <div class="total-row grand-total">
                <span>TOTAL</span>
                <span>Rp <?= number_format($po['total'], 0, ',', '.') ?></span>
            </div>
        </div>
    </div>

    <div class="signature-section">
        <?php
        $ahliGizi = $po['pembuat'];
        $akuntan = '( .................... )';
        $pic = '( .................... )';
        
        foreach ($approvals as $app) {
            if ($app['role'] == 'akuntan' || $app['role'] == 'pic') {
                 // logic to pick the latest approved/reviewed by each role
            }
        }
        // Simpler: find by role
        foreach ($approvals as $app) {
            if (strpos($app['role'], 'akuntan') !== false) $akuntan = $app['nama'];
            if (strpos($app['role'], 'pic') !== false || strpos($app['role'], 'kepala') !== false) $pic = $app['nama'];
        }
        ?>
        <div class="signature-box">
            <div class="title">Dipesan Oleh,</div>
            <div class="name"><?= $ahliGizi ?></div>
            <div class="role">Ahli Gizi</div>
        </div>
        <div class="signature-box">
            <div class="title">Diperiksa Oleh,</div>
            <div class="name"><?= $akuntan ?></div>
            <div class="role">Akuntan</div>
        </div>
        <div class="signature-box">
            <div class="title">Disetujui Oleh,</div>
            <div class="name"><?= $pic ?></div>
            <div class="role">PIC / Kepala SPPG</div>
        </div>
    </div>

    <div class="no-print" style="position: fixed; bottom: 20px; left: 0; right: 0; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 4px;">Print Document</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer; background: #6c757d; color: white; border: none; border-radius: 4px; margin-left: 10px;">Close</button>
    </div>
</body>
</html>
