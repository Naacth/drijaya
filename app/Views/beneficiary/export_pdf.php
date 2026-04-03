<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; color: #2c3e50; font-size: 18px; }
        .info { margin-bottom: 20px; }
        .info table { width: 100%; border: none; }
        .info td { border: none; padding: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; color: #2c3e50; text-transform: uppercase; font-size: 9px; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 40px; }
        .signature { float: right; width: 200px; text-align: center; margin-top: 20px; }
        @media print { .no-print { display: none; } body { padding: 20px; } }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="background: #fff3cd; padding: 10px; margin-bottom: 20px; border: 1px solid #ffeeba;">
        Gunakan menu cetak browser dan pilih "Save as PDF" untuk menyimpan.
        <button onclick="window.history.back()" style="float: right;">Kembali</button>
    </div>

    <div class="header">
        <h2>DATA PENERIMA MANFAAT SPPG</h2>
        <p>Laporan Distribusi Makanan Harian</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="100">UNIT SPPG</td><td>: <strong><?= strtoupper($header['sppg']) ?></strong></td>
                <td width="100" class="text-end">TANGGAL</td><td width="120">: <?= format_date_id($header['tanggal'] ?? null) ?></td>
            </tr>
            <tr>
                <td>KECAMATAN</td><td>: <?= strtoupper($header['kecamatan']) ?></td>
                <td class="text-end">PENGINPUT</td><td>: <?= $header['pembuat'] ?></td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30" class="text-center">NO</th>
                <th>NAMA SEKOLAH</th>
                <th class="text-center">JML SISWA</th>
                <th class="text-center">PORSI KECIL</th>
                <th class="text-center">PORSI BESAR</th>
                <th class="text-center">GURU</th>
                <th class="text-center">STAF</th>
                <th class="text-end">JUMLAH PORSI</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $totalSiswa = 0; $totalKecil = 0; $totalBesar = 0; $totalGuru = 0; $totalStaf = 0; $totalPorsi = 0;
            foreach ($items as $i => $item): 
                $totalSiswa += $item['jumlah_siswa'];
                $totalKecil += $item['porsi_kecil'];
                $totalBesar += $item['porsi_besar'];
                $totalGuru += $item['pendidik'];
                $totalStaf += $item['non_pendidik'];
                $totalPorsi += $item['total_porsi'];
            ?>
                <tr>
                    <td class="text-center"><?= $i + 1 ?></td>
                    <td><?= strtoupper($item['nama_sekolah']) ?></td>
                    <td class="text-center"><?= $item['jumlah_siswa'] ?></td>
                    <td class="text-center"><?= $item['porsi_kecil'] ?></td>
                    <td class="text-center"><?= $item['porsi_besar'] ?></td>
                    <td class="text-center"><?= $item['pendidik'] ?></td>
                    <td class="text-center"><?= $item['non_pendidik'] ?></td>
                    <td class="text-end"><strong><?= number_format($item['total_porsi']) ?></strong></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tr style="background-color: #f8f9fa; font-weight: bold;">
            <td colspan="2" class="text-end">TOTAL SELURUH</td>
            <td class="text-center"><?= $totalSiswa ?></td>
            <td class="text-center"><?= $totalKecil ?></td>
            <td class="text-center"><?= $totalBesar ?></td>
            <td class="text-center"><?= $totalGuru ?></td>
            <td class="text-center"><?= $totalStaf ?></td>
            <td class="text-end"><?= number_format($totalPorsi) ?></td>
        </tr>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Dicetak pada: <?= date('d/m/Y H:i') ?></p>
            <br><br><br>
            <strong>( ____________________ )</strong>
            <p>Petugas SPPG</p>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>
