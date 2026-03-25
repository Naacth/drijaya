<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: Calibri, sans-serif; font-size: 11px; color: #000; background: #fff; margin: 0; padding: 20px; }
        .page-container { width: 1000px; margin: 0 auto; }

        @media print {
            body { padding: 0; }
            .page-container { width: 100%; }
            .no-print { display: none !important; }
            * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }

        .header-title { font-size: 16px; font-weight: bold; margin-bottom: 20px; }
        .header-title span { font-weight: normal; margin-left: 10px; }

        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 11px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 4px 6px; text-align: center; vertical-align: middle; }
        .data-table th { background-color: #d9d9d9; font-weight: bold; }
        .data-table td.sekolah { text-align: left; }
        
        /* Pastel Colors for Tingkatan based on reference image */
        .bg-paud { background-color: #c4e5c4 !important; } /* Light green */
        .bg-tk { background-color: #f7dac4 !important; } /* Light orange/peach */
        .bg-sd13 { background-color: #d1dcf0 !important; } /* Light blue */
        .bg-sd46 { background-color: #fcebd2 !important; } /* Light yellowish orange */
        .bg-mi13 { background-color: #dcedc1 !important; } /* Pale green */
        .bg-mi46 { background-color: #c3d9ff !important; } /* Pale blue */
        .bg-smp { background-color: #d9d9d9 !important; } /* Gray */
        .bg-mts { background-color: #f5ccb0 !important; } /* Darker peach */
        .bg-sma { background-color: #fff2cc !important; } /* Light yellow */

    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; background: #333; color: #fff; border: none; border-radius: 5px;">Cetak</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; margin-left: 10px; border-radius: 5px;">Tutup</button>
    </div>

    <div class="page-container">

        <?php
        $days = ['Sunday'=>'MINGGU','Monday'=>'SENIN','Tuesday'=>'SELASA','Wednesday'=>'RABU','Thursday'=>'KAMIS','Friday'=>'JUMAT','Saturday'=>'SABTU'];
        $months = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $hari = $days[date('l', strtotime($header['tanggal']))];
        $tgl = date('d', strtotime($header['tanggal'])) . ' ' . $months[(int)date('m', strtotime($header['tanggal']))] . ' ' . date('Y', strtotime($header['tanggal']));
        ?>

        <!-- HEADER LOGOS -->
        <table style="width: 100%; margin-bottom: 15px;">
            <tr>
                <td width="120" style="text-align: left; vertical-align: middle;">
                    <img src="<?= base_url('bgn.png') ?>" alt="Logo BGN" style="height: 100px; width: auto;">
                </td>
                <td style="text-align: center;"></td>
                <td width="120" style="text-align: right; vertical-align: middle;">
                    <img src="<?= base_url('yayasan.png') ?>" alt="Logo Yayasan" style="height: 95px; width: auto;">
                </td>
            </tr>
        </table>

        <div class="header-title">Hari dan TGL <span><?= $hari ?> &nbsp;&nbsp;&nbsp; <?= $tgl ?></span></div>

        <table class="data-table">
            <thead>
                <tr>
                    <th width="30"></th>
                    <th width="80">TINGKATAN</th>
                    <th width="200">SEKOLAH</th>
                    <th width="70">JUMLAH PM</th>
                    <th width="80">JUMLAH PM<br>Ter<br>DISTRIBUSI</th>
                    <th width="90">Jumlah PM<br>tidak<br>terdistribusi</th>
                    <th width="120">Keterangan</th>
                    <th width="120">Pengalihan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($items as $i => $item): 
                    $bgClass = '';
                    switch ($item['tingkatan']) {
                        case 'PAUD': $bgClass = 'bg-paud'; break;
                        case 'TK': $bgClass = 'bg-tk'; break;
                        case 'SD 1-3': $bgClass = 'bg-sd13'; break;
                        case 'SD 4-6': $bgClass = 'bg-sd46'; break;
                        case 'MI 1-3': $bgClass = 'bg-mi13'; break;
                        case 'MI 4-6': $bgClass = 'bg-mi46'; break;
                        case 'SMP': $bgClass = 'bg-smp'; break;
                        case 'MTS': $bgClass = 'bg-mts'; break;
                        case 'SMA': $bgClass = 'bg-sma'; break;
                    }
                ?>
                <tr>
                    <td class="text-right"><?= $i + 1 ?></td>
                    <td class="<?= $bgClass ?> text-left" style="text-align: left; padding-left: 5px;"><?= esc($item['tingkatan']) ?></td>
                    <td class="<?= $bgClass ?> sekolah"><?= esc($item['sekolah']) ?></td>
                    <td class="<?= $bgClass ?> text-center font-weight-bold" style="font-weight: bold;"><?= $item['jumlah_pm'] ?></td>
                    <td class="text-center font-weight-bold" style="font-weight: bold;"><?= $item['jumlah_terdistribusi'] ?></td>
                    <td class="text-center font-weight-bold" style="font-weight: bold;"><?= $item['jumlah_tidak_terdistribusi'] ?: '' ?></td>
                    <td class="text-center"><?= esc($item['keterangan'] ?: '') ?></td>
                    <td class="text-center"><?= esc($item['pengalihan'] ?: '') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</body>
</html>
