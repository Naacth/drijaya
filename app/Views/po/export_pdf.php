<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; color: #2c3e50; text-transform: uppercase; font-size: 10px; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .footer { margin-top: 50px; text-align: right; font-style: italic; font-size: 10px; color: #777; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 20px; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="background: #fff3cd; padding: 15px; margin-bottom: 20px; border: 1px solid #ffeeba; border-radius: 4px;">
        <strong>Tip:</strong> Gunakan fitur "Save as PDF" pada jendela cetak browser untuk menyimpan dokumen ini sebagai file PDF.
        <button onclick="window.location.href='<?= base_url('po') ?>'" style="float: right;">Kembali</button>
    </div>

    <div class="header">
        <h2>Laporan Data Purchase Order</h2>
        <p>Dicetak pada: <?= date('d/m/Y H:i') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No PO</th>
                <th>Tanggal</th>
                <th>Pembuat</th>
                <th>Supplier</th>
                <th>Menu</th>
                <th class="text-end">Total Biaya</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pos as $po): ?>
                <tr>
                    <td><strong><?= $po['nomor_po'] ?></strong></td>
                    <td><?= date('d/m/Y', strtotime($po['tanggal'])) ?></td>
                    <td><?= $po['pembuat'] ?></td>
                    <td><?= $po['vendor'] ?></td>
                    <td><?= $po['menu'] ?></td>
                    <td class="text-end">Rp <?= number_format($po['total'], 0, ',', '.') ?></td>
                    <td class="text-center"><?= ucwords(str_replace('_', ' ', $po['status'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <?php 
                $grandTotal = array_sum(array_column($pos, 'total'));
                ?>
                <th colspan="5" class="text-end">GRAND TOTAL</th>
                <th class="text-end">Rp <?= number_format($grandTotal, 0, ',', '.') ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>SPPG Management System - Laporan Procurement</p>
    </div>
</body>
</html>
