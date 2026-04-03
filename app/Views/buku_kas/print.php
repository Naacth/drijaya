<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        @page { size: A4 portrait; margin: 1cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 9pt; color: #333; line-height: 1.4; }
        
        table { width: 100%; border-collapse: collapse; }
        
        .header-info { margin-bottom: 20px; font-weight: bold; }
        .header-info td { padding: 2px 0; border: none; }

        .data-table th, .data-table td { border: 1px solid #000; padding: 6px 8px; }
        .data-table th { background-color: #ffff00; text-transform: uppercase; text-align: center; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bg-light { background-color: #f2f2f2; }
        
        .footer { margin-top: 30px; }
        .footer td { text-align: center; border: none; }
        .signature-space { height: 60px; }
    </style>
<?= view('layout/print_signatures_style') ?>
</head>
<body>
    <table class="header-info">
        <tr>
            <td width="120">Nama Lembaga</td>
            <td width="10">:</td>
            <td><?= esc($header['nama_sppg']) ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?= esc($header['alamat_sppg']) ?></td>
        </tr>
        <tr>
            <td>Nama Kepala SPPG</td>
            <td>:</td>
            <td><?= esc($header['kepala_sppg']) ?></td>
        </tr>
        <tr>
            <td>Tanggal, Periode</td>
            <td>:</td>
            <td><?php
                if (! empty($blank)) {
                    echo '____/____/________  s/d  ____/____/________';
                } else {
                    echo format_date_id($start) . ($start != $end ? ' s/d ' . format_date_id($end) : '');
                }
            ?></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="80">TANGGAL</th>
                <th>OPERASIONAL</th>
                <th width="100">DEBET</th>
                <th width="100">KREDIT</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($entries) && empty($blank)): ?>
                <tr>
                    <td colspan="4" class="text-center py-4">Tidak ada data transaksi.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($entries as $e): ?>
                    <tr>
                        <td class="text-center"><?= format_date_id($e['tanggal'] ?? null) ?></td>
                        <td><?= esc($e['keterangan'] ?? '') ?></td>
                        <td class="text-right"><?= ($e['debet'] ?? 0) > 0 ? number_format((float) $e['debet'], 0, ',', '.') : '-' ?></td>
                        <td class="text-right"><?= ($e['kredit'] ?? 0) > 0 ? number_format((float) $e['kredit'], 0, ',', '.') : '-' ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr style="background-color: #ccc; font-weight: bold;">
                    <td colspan="2" class="text-center">TOTAL</td>
                    <td class="text-right">Rp <?= number_format($summary['debet'] ?? 0, 0, ',', '.') ?></td>
                    <td class="text-right">Rp <?= number_format($summary['kredit'] ?? 0, 0, ',', '.') ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <table class="footer" style="width: 100%; margin-top: 40px;">
        <tr>
            <td width="30%">
                Mengetahui,<br>Kepala SPPG
                <div class="signature-space"></div>
                <strong><?= esc($header['kepala_sppg']) ?></strong>
            </td>
            <td width="40%"></td>
            <td width="30%">
                Tangerang, <?= date('d F Y') ?><br>Asisten Lapangan / Akuntan
                <div class="signature-space"></div>
                <strong><?= esc(session()->get('nama')) ?></strong>
            </td>
        </tr>
    </table>

    <script>window.onload = function() { // window.print(); }</script>
</body>
</html>
