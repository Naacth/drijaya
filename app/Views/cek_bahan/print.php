<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 13px; 
            color: #000; 
            background: #fff;
            margin: 0; padding: 20px;
        }
        
        .page-container {
            width: 850px;
            margin: 0 auto;
        }

        @media print {
            body { padding: 0; }
            .page-container { width: 100%; }
            .no-print { display: none !important; }
            .print-dark-header th { 
                background-color: #333 !important; 
                color: #fff !important; 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
            }
        }

        .text-center { text-align: center; }
        
        .header-table {
            width: 100%;
            margin-bottom: 20px;
        }
        
        .header-table td {
            vertical-align: middle;
        }

        .logo-placeholder {
            width: 100px;
            height: 100px;
            border: 1px solid #000;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 11px;
            text-align: center;
        }

        h2, h3, h4, p { margin: 0; padding: 0; }
        
        .title-section {
            text-align: center;
            line-height: 1.5;
        }

        .title-section h2 { font-size: 16px; font-weight: bold; }
        .title-section h3 { font-size: 14px; font-weight: bold; margin-top: 15px; }
        .title-section h4 { font-size: 13px; font-weight: normal; margin-top: 5px; }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 12px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 6px;
        }
        
        .print-dark-header th {
            background-color: #333;
            color: #fff;
            text-align: center;
            vertical-align: middle;
        }

        .check-box {
            display: inline-block;
            width: 15px;
            height: 15px;
        }

        .footer-sig {
            width: 100%;
            margin-top: 30px;
        }
        .footer-sig td {
            vertical-align: top;
            text-align: right;
        }
        .sig-box {
            display: inline-block;
            text-align: center;
            width: 300px;
            border: 1px dotted #ccc;
            padding: 10px;
            margin-left: auto;
        }
        .sig-line {
            display: block;
            border-bottom: 1px solid #000;
            margin-top: 70px;
            width: 80%;
            margin-left: 10%;
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; background: #333; color: #fff; border: none; border-radius: 5px;">Cetak formulir</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; margin-left: 10px; border-radius: 5px;">Tutup</button>
    </div>

    <div class="page-container">
        
        <!-- HEADER -->
        <?= view('layout/print_header') ?>

        <table class="data-table print-dark-header">
            <thead>
                <tr>
                    <th rowspan="2" width="30">No</th>
                    <th rowspan="2" width="70">Tgl</th>
                    <th rowspan="2">Jenis Bahan<br>Makanan</th>
                    <th rowspan="2" width="80">Banyaknya<br>(Angka)</th>
                    <th rowspan="2" width="80">Satuan</th>
                    <th colspan="2" width="100">Jumlah</th>
                    <th colspan="2" width="120">Kondisi Bahan<br>Makanan</th>
                </tr>
                <tr>
                    <th width="50">Sesuai</th>
                    <th width="50">Tidak</th>
                    <th width="60">Baik</th>
                    <th width="60">Rusak</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $count = count($items);
                $rows = max(19, $count); // Minimum 19 rows according to image
                for ($i = 0; $i < $rows; $i++): 
                    $hasItem = isset($items[$i]);
                    if($hasItem) {
                        $isSesuai = $items[$i]['jumlah_sesuai'] == 'Sesuai' ? '✓' : '';
                        $isTidakSesuai = $items[$i]['jumlah_sesuai'] == 'Tidak' ? '✓' : '';
                        $isBaik = $items[$i]['kondisi_bahan'] == 'Baik' ? '✓' : '';
                        $isRusak = $items[$i]['kondisi_bahan'] == 'Rusak' ? '✓' : '';
                    } else {
                        $isSesuai = $isTidakSesuai = $isBaik = $isRusak = '';
                    }
                ?>
                <tr>
                    <td class="text-center"><?= $i + 1 ?></td>
                    <td class="text-center"><?= $hasItem ? date('d/m/Y', strtotime($items[$i]['tgl_bahan'])) : '' ?></td>
                    <td><?= $hasItem ? esc($items[$i]['jenis_bahan']) : '&nbsp;' ?></td>
                    <td class="text-center"><?= $hasItem ? rtrim(rtrim(number_format($items[$i]['banyaknya'], 2), '0'), '.') : '' ?></td>
                    <td class="text-center"><?= $hasItem ? esc($items[$i]['satuan']) : '' ?></td>
                    <td class="text-center"><span class="check-box"><?= $isSesuai ?></span></td>
                    <td class="text-center"><span class="check-box"><?= $isTidakSesuai ?></span></td>
                    <td class="text-center"><span class="check-box"><?= $isBaik ?></span></td>
                    <td class="text-center"><span class="check-box"><?= $isRusak ?></span></td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>

        <!-- Footer exactly matching the image -->
        <table class="footer-sig">
            <tr>
                <td>
                    <div class="sig-box" style="border: none;">
                        <?php 
                        $months = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        $tgl = date('d', strtotime($header['tanggal_laporan']));
                        $bln = $months[(int)date('m', strtotime($header['tanggal_laporan']))];
                        $thn = date('Y', strtotime($header['tanggal_laporan']));
                        ?>
                        <p style="margin-bottom: 5px;">Tangerang, <?= $tgl . ' ' . $bln . ' ' . $thn ?></p>
                        <p>Kepala SPPG</p>
                        <span class="sig-line"></span>
                        <p><?= esc($header['nama_kepala_sppg']) ?></p>
                    </div>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>
