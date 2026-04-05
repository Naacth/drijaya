<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Purchase Order - <?= esc($po['nomor_po'] ?? '') ?: 'Form kosong' ?></title>
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
        
        .signature-section { display: flex; justify-content: space-between; gap: 8px; page-break-inside: avoid; flex-wrap: wrap; }
        .signature-box { width: 23%; min-width: 140px; text-align: center; flex: 1; }
        .signature-box .sig-title { font-weight: bold; font-size: 8.5pt; margin-bottom: 6px; line-height: 1.2; min-height: 2.4em; }
        .signature-box .sig-space { min-height: 52px; display: flex; align-items: flex-end; justify-content: center; margin-bottom: 8px; }
        .signature-box .sig-space img { max-height: 48px; max-width: 130px; object-fit: contain; }
        .signature-box .name { text-decoration: underline; font-weight: bold; font-size: 9pt; }
        .signature-box .role { font-size: 8pt; color: #666; margin-top: 4px; }

        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
<?= view('layout/print_signatures_style') ?>
</head>
<body onload="window.print()">
    <?php $__bgnPo = public_asset_data_uri('bgn.png'); ?>
    <div class="header" style="display: flex; justify-content: flex-start; align-items: center; gap: 20px; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px;">
        <div style="flex-shrink: 0;">
            <img src="<?= $__bgnPo !== '' ? $__bgnPo : base_url('bgn.png') ?>" alt="Logo BGN" style="width: 100px; height: auto;">
        </div>
        <div style="text-align: center; flex: 1;">
            <h2 style="margin: 0; color: #000; font-size: 20pt; letter-spacing: 1px;">FORM PURCHASE ORDER</h2>
            <p style="margin: 5px 0 0; font-weight: bold;"><?= session()->get('sppg_nama') ?? 'Dapur SPPG Bunar' ?></p>
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
                <td>: <?= format_date_long_id($po['tanggal'] ?? null) ?></td>
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

    <?php
    /*
     * Sesuai Pengaturan: tiap kolom pakai slot user_signatures yang cocok dulu,
     * baru fallback ke TTD aslap / peran lain (supaya sama dengan pratinjau di /signatures).
     */
    $__sigPo = $signature ?? [];
    $__poCols = [
        signature_data_uri_first($__sigPo, 'ttd_akuntan', 'ttd_aslap', 'ttd_ahli_gizi', 'ttd_kepala_sppg'),
        signature_data_uri_first($__sigPo, 'ttd_ahli_gizi', 'ttd_aslap', 'ttd_akuntan', 'ttd_kepala_sppg'),
        signature_data_uri_first($__sigPo, 'ttd_kepala_koki', 'ttd_aslap', 'ttd_ahli_gizi', 'ttd_kepala_sppg', 'ttd_akuntan'),
        signature_data_uri_first($__sigPo, 'ttd_kepala_sppg', 'ttd_aslap', 'ttd_ahli_gizi', 'ttd_akuntan'),
    ];
    ?>
    <div class="signature-section">
        <div class="signature-box">
            <div class="sig-title">Akuntan Satuan Pelayanan</div>
            <div class="sig-space">
                <?php if ($__poCols[0] !== ''): ?><img src="<?= $__poCols[0] ?>" alt="TTD"><?php endif; ?>
            </div>
            <div class="name">( <?= !empty($__sigPo['nama_akuntan']) ? esc($__sigPo['nama_akuntan']) : 'Yusta Anjaya, S.AK' ?> )</div>
            <div class="role">Dibuat Oleh</div>
        </div>
        <div class="signature-box">
            <div class="sig-title">Ahli Gizi Satuan Pelayanan</div>
            <div class="sig-space">
                <?php if ($__poCols[1] !== ''): ?><img src="<?= $__poCols[1] ?>" alt="TTD"><?php endif; ?>
            </div>
            <div class="name">( <?= !empty($__sigPo['nama_ahli_gizi']) ? esc($__sigPo['nama_ahli_gizi']) : 'Desy Junesty, AMD.GZ' ?> )</div>
            <div class="role">Diketahui</div>
        </div>
        <div class="signature-box">
            <div class="sig-title">Kepala Koki Satuan Pelayanan</div>
            <div class="sig-space">
                <?php if ($__poCols[2] !== ''): ?><img src="<?= $__poCols[2] ?>" alt="TTD"><?php endif; ?>
            </div>
            <div class="name">( <?= !empty($__sigPo['nama_kepala_koki']) ? esc($__sigPo['nama_kepala_koki']) : 'Dera' ?> )</div>
            <div class="role">Diketahui</div>
        </div>
        <div class="signature-box">
            <div class="sig-title">Kepala satuan Pelayanan Pemenuhan Gizi</div>
            <div class="sig-space">
                <?php if ($__poCols[3] !== ''): ?><img src="<?= $__poCols[3] ?>" alt="TTD"><?php endif; ?>
            </div>
            <div class="name">( <?= !empty($__sigPo['nama_kepala_sppg']) ? esc($__sigPo['nama_kepala_sppg']) : 'M.Rizki Waluya, S.P.W.K.' ?> )</div>
            <div class="role">Disetujui Oleh</div>
        </div>
    </div>

    <div class="no-print" style="position: fixed; bottom: 20px; left: 0; right: 0; text-align: center;">
        <button type="button" class="no-print" onclick="window.print()" style="padding: 10px 20px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 4px;">Print Document</button>
        <button type="button" class="no-print" onclick="window.close()" style="padding: 10px 20px; cursor: pointer; background: #6c757d; color: white; border: none; border-radius: 4px; margin-left: 10px;">Close</button>
    </div>
</body>
</html>
