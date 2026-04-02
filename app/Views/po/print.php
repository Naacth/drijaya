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
            <h2 style="margin: 0; color: #000; font-size: 20pt; letter-spacing: 1px;">FORM PURCHASE ORDER</h2>
            <p style="margin: 5px 0 0; font-weight: bold;"><?= session()->get('sppg_nama') ?? 'Dapur SPPG Bunar' ?></p>
        </div>
        <div style="width: 120px; text-align: right;">
            <img src="<?= base_url('yayasan.png') ?>" alt="Logo Yayasan" style="width: 95px; height: auto;">
        </div>
    </div>

    <div class="info-section" style="margin-bottom: 15px;">
        <table class="info-table">
            <tr>
                <td width="120">Dari</td>
                <td>: <?= session()->get('sppg_nama') ?? 'Dapur SPPG Bunar, Kec. Balaraja' ?></td>
            </tr>
            <tr>
                <td>Nama Supplier</td>
                <td>: <?= $po['vendor'] ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: <?= date('d F Y', strtotime($po['tanggal'])) ?></td>
            </tr>
        </table>
    </div>

    <table class="items-table" style="font-size: 10pt; width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: center; background-color: #f0f0f0;">
                <th style="border: 1px solid #000; padding: 5px;" width="30">No.</th>
                <th style="border: 1px solid #000; padding: 5px;" width="80">Banyaknya</th>
                <th style="border: 1px solid #000; padding: 5px;" width="80">Satuan</th>
                <th style="border: 1px solid #000; padding: 5px;">Nama Barang</th>
                <th style="border: 1px solid #000; padding: 5px;" width="110">Harga Satuan</th>
                <th style="border: 1px solid #000; padding: 5px;" width="80">Tambahan</th>
                <th style="border: 1px solid #000; padding: 5px;" width="110">Jumlah Faktual</th>
                <th style="border: 1px solid #000; padding: 5px;" width="120">Total</th>
                <th style="border: 1px solid #000; padding: 5px;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $index => $item): ?>
                <tr>
                    <td style="border: 1px solid #000; padding: 5px; text-align: center;"><?= $index + 1 ?></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: center;"><?= number_format($item['qty'] ?? 0, 2, ',', '.') ?></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: center;"><?= $item['satuan'] ?? '' ?></td>
                    <td style="border: 1px solid #000; padding: 5px;"><?= $item['nama_barang'] ?? '' ?></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: right;">Rp <?= number_format($item['harga_satuan'] ?? 0, 0, ',', '.') ?></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: right;">Rp <?= number_format($item['tambahan'] ?? 0, 0, ',', '.') ?></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: center;"><?= number_format($item['jumlah_faktual'] ?? 0, 2, ',', '.') ?></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: right;">Rp <?= number_format($item['total'] ?? 0, 0, ',', '.') ?></td>
                    <td style="border: 1px solid #000; padding: 5px;"><?= $item['catatan'] ?? '' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="font-weight: bold; background-color: #f9f9f9;">
                <td colspan="7" style="border: 1px solid #000; padding: 5px; text-align: center;">Total</td>
                <td style="border: 1px solid #000; padding: 5px; text-align: right;">Rp <?= number_format($po['total'], 0, ',', '.') ?></td>
                <td style="border: 1px solid #000; padding: 5px;"></td>
            </tr>
        </tfoot>
    </table>

    <p style="font-size: 10pt; margin-bottom: 30px;">
        Demikian surat permintaan penawaran harga bahan baku ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terimakasih.
    </p>

    <div class="signature-section" style="display: flex; justify-content: space-between; font-size: 9pt; text-align: center;">
        <div style="width: 24%;">
            <div style="font-weight: bold; margin-bottom: 60px;">Akuntan Satuan Pelayanan</div>
            <div style="text-decoration: underline; font-weight: bold;">( Yusta Anjaya, S.AK )</div>
            <div>Dibuat Oleh</div>
        </div>
        <div style="width: 24%;">
            <div style="font-weight: bold; margin-bottom: 60px;">Ahli Gizi Satuan Pelayanan</div>
            <div style="text-decoration: underline; font-weight: bold;">( Desy Junesty, AMD.GZ )</div>
            <div>Diketahui</div>
        </div>
        <div style="width: 24%;">
            <div style="font-weight: bold; margin-bottom: 60px;">Kepala Koki Satuan Pelayanan</div>
            <div style="text-decoration: underline; font-weight: bold;">( Dera )</div>
            <div>Diketahui</div>
        </div>
        <div style="width: 24%;">
            <div style="font-weight: bold; margin-bottom: 43px;">Kepala satuan Pelayanan Pemenuhan Gizi</div>
            <div style="text-decoration: underline; font-weight: bold;">( M.Rizki Waluya, S.P.W.K. )</div>
            <div>Disetujui Oleh</div>
        </div>
    </div>

    <div class="no-print" style="position: fixed; bottom: 20px; left: 0; right: 0; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 4px;">Print Document</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer; background: #6c757d; color: white; border: none; border-radius: 4px; margin-left: 10px;">Close</button>
    </div>
</body>
</html>
