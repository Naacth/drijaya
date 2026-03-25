<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        @page { size: A4 landscape; margin: 1.5cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10pt; color: #333; }
        .header { width: 100%; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header td { vertical-align: middle; }
        .title { text-align: center; font-size: 14pt; font-weight: bold; text-transform: uppercase; margin: 20px 0; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 6px 4px; text-align: center; }
        table.data-table th { background-color: #f0f0f0; }
        .text-left { text-align: left !important; }
        .divisi-group { background-color: #eee; font-weight: bold; text-align: left; }
        
        .footer { margin-top: 50px; width: 100%; }
        .footer td { text-align: center; width: 33%; }
        .signature-box { height: 80px; }

        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="background:#fff; padding:10px; border-bottom:1px solid #ddd; position:fixed; top:0; left:0; right:0; text-align:center;">
        <button onclick="window.print()" style="padding:8px 20px; cursor:pointer;">CETAK LAPORAN</button>
    </div>

    <table class="header">
        <tr>
            <td width="80"><img src="<?= base_url('bgn.png') ?>" width="80"></td>
            <td style="text-align: center; padding: 0 20px;">
                <h2 style="margin: 0; font-size: 16pt;"><?= esc($header['nama_sppg']) ?></h2>
                <p style="margin: 5px 0 0; font-size: 9pt; color: #666;"><?= esc($header['alamat_sppg']) ?></p>
            </td>
            <td width="80" style="text-align: right;"><img src="<?= base_url('yayasan.png') ?>" width="80"></td>
        </tr>
    </table>

    <div class="title">LAPORAN REKAP ABSENSI RELAWAN<br><span style="font-size: 10pt; font-weight: normal;">Periode: <?= date('d/m/Y', strtotime($start)) ?> s/d <?= date('d/m/Y', strtotime($end)) ?></span></div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="30">No</th>
                <th class="text-left">Nama Relawan (Divisi)</th>
                <?php foreach ($sessions as $s): ?>
                    <th width="35"><?= date('d/m', strtotime($s['tanggal'])) ?></th>
                <?php endforeach; ?>
                <th width="40">Hadir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($relawan as $idx => $r): ?>
                <tr>
                    <td><?= $idx + 1 ?></td>
                    <td class="text-left">
                        <strong><?= esc($r['nama']) ?></strong><br>
                        <small style="color: #666; text-transform: uppercase;"><?= esc($r['divisi']) ?></small>
                    </td>
                    <?php 
                        $present = 0;
                        foreach ($sessions as $s): 
                            $st = $matrix[$r['id']][$s['tanggal']] ?? '';
                            if ($st == 'Hadir') $present++;
                    ?>
                        <td style="<?= $st == 'Hadir' ? 'color: green;' : ($st == 'Tidak Hadir' ? 'color: red;' : '') ?>">
                            <?= $st == 'Hadir' ? 'H' : ($st == 'Tidak Hadir' ? 'A' : '-') ?>
                        </td>
                    <?php endforeach; ?>
                    <td style="font-weight: bold;"><?= $present ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="margin-top: 15px; font-size: 8pt; color: #666;">
        Keterangan: H = Hadir, A = Alpha (Tidak Hadir), - = Data Kosong
    </div>

    <table class="footer">
        <tr>
            <td>
                Mengetahui,<br>Kepala SPPG
                <div class="signature-box"></div>
                ____________________
            </td>
            <td></td>
            <td>
                Tangerang, <?= date('d F Y') ?><br>Asisten Lapangan
                <div class="signature-box"></div>
                <strong><?= esc(session()->get('name')) ?></strong>
            </td>
        </tr>
    </table>

    <script>window.onload = function() { // window.print(); }</script>
</body>
</html>
