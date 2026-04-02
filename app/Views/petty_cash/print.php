<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        @page { size: A4 landscape; margin: 1cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 8pt; color: #000; line-height: 1.2; }
        
        .header { text-align: center; margin-bottom: 20px; text-decoration: underline; font-size: 11pt; font-weight: bold; }
        .period { text-align: center; margin-bottom: 10px; font-size: 10pt; font-weight: bold; text-transform: uppercase; }

        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px 6px; }
        th { background-color: #dbe5f1; text-transform: uppercase; text-align: center; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .fw-bold { font-weight: bold; }

        .footer { margin-top: 30px; }
        .footer td { border: none; text-align: center; }
        .signature-space { height: 50px; }
    </style>
<?= view('layout/print_signatures_style') ?>
</head>
<body>
    <div class="header"><?= $title ?></div>
    <div class="period">PERIODE <?= date('d', strtotime($start)) ?> - <?= date('d F Y', strtotime($end)) ?></div>

    <table>
        <thead>
            <tr>
                <th width="80">TANGGAL</th>
                <th>KETERANGAN</th>
                <th width="100">PEMASUKKAN</th>
                <th width="100">PENGELUARAN</th>
                <th width="120">SALDO</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">-</td>
                <td>SALDO AWAL (PINDAHAN)</td>
                <td class="text-right">-</td>
                <td class="text-right">-</td>
                <td class="text-right fw-bold">Rp <?= number_format($saldoAwal, 0, ',', '.') ?></td>
            </tr>
            <?php 
            $runningSaldo = $saldoAwal;
            if (empty($entries)): 
                // Fill some empty rows for aesthetic if needed, but app logic follows data
            else:
                foreach ($entries as $e): 
                    $runningSaldo += $e['pemasukkan'] - $e['pengeluaran'];
            ?>
                <tr>
                    <td class="text-center"><?= date('d/m/Y', strtotime($e['tanggal'])) ?></td>
                    <td><?= esc($e['keterangan']) ?></td>
                    <td class="text-right"><?= $e['pemasukkan'] > 0 ? number_format($e['pemasukkan'], 0, ',', '.') : '-' ?></td>
                    <td class="text-right"><?= $e['pengeluaran'] > 0 ? number_format($e['pengeluaran'], 0, ',', '.') : '-' ?></td>
                    <td class="text-right">Rp <?= number_format($runningSaldo, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr style="background-color: #f2f2f2;">
                <td colspan="2" class="text-right fw-bold">TOTAL & SISA SALDO</td>
                <td class="text-right fw-bold"><?= number_format($summary['pemasukkan'] ?? 0, 0, ',', '.') ?></td>
                <td class="text-right fw-bold"><?= number_format($summary['pengeluaran'] ?? 0, 0, ',', '.') ?></td>
                <td class="text-right fw-bold">Rp <?= number_format($runningSaldo, 0, ',', '.') ?></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <table class="footer" style="width: 100%;">
        <tr>
            <td width="30%">
                Diketahui Oleh,<br>Kepala SPPG
                <div class="signature-space"></div>
                <strong>( .................................... )</strong>
            </td>
            <td width="40%"></td>
            <td width="30%">
                Tangerang, <?= date('d F Y') ?><br>Dibuat Oleh,<br>Akuntan
                <div class="signature-space"></div>
                <strong><?= session()->get('nama') ?></strong>
            </td>
        </tr>
    </table>
</body>
</html>
