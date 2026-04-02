<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 14px; 
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
            .bg-blue { background-color: #0088cc !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .text-white { color: #fff !important; }
        }

        .text-center { text-align: center; }
        
        h3 {
            margin: 0 0 5px 0;
            font-size: 18px;
            font-weight: bold;
        }
        
        h4 {
            margin: 0 0 30px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header-info {
            width: 100%;
            margin-bottom: 10px;
        }
        .header-info td {
            padding: 2px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 8px 10px;
        }
        .data-table th {
            text-align: center;
            font-size: 13px;
        }
        .bg-blue {
            background-color: #0088cc;
            color: #fff;
        }

        .note {
            font-size: 13px;
            margin-bottom: 40px;
        }

        .footer-sig {
            width: 100%;
            margin-top: 50px;
        }
        .footer-sig td {
            width: 33.33%;
            vertical-align: top;
        }
        .sig-box {
            display: inline-block;
            text-align: left;
        }
        .sig-line {
            display: block;
            width: 250px;
            border-bottom: 1px solid #000;
            margin-top: 70px;
        }
    </style>
<?= view('layout/print_signatures_style') ?>
</head>
<body onload="window.print()">

    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; background: #0088cc; color: #fff; border: none; border-radius: 5px;">Cetak formulir</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; margin-left: 10px; border-radius: 5px;">Tutup</button>
    </div>

    <div class="page-container">
        
        <!-- HEADER -->
        <?= view('layout/print_header') ?>

        <table class="header-info">
            <tr>
                <td width="160">Tanggal</td>
                <td width="10">:</td>
                <td><?= date('d/m/Y', strtotime($header['tanggal'])) ?></td>
            </tr>
            <tr>
                <td>Penanggung Jawab</td>
                <td>:</td>
                <td><?= esc($header['penanggung_jawab']) ?></td>
            </tr>
        </table>

        <table class="data-table">
            <thead>
                <tr class="bg-blue text-white">
                    <th width="40">No.</th>
                    <th>Nama Barang</th>
                    <th width="80">Satuan</th>
                    <th width="120">Banyak Barang</th>
                    <th width="120">TTD QC /<br>Penerima</th>
                    <th width="120">TTD<br>Pemasok</th>
                    <th width="120">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $count = count($items);
                $rows = max(10, $count); // Minimum 10 rows according to image
                for ($i = 0; $i < $rows; $i++): 
                    $hasItem = isset($items[$i]);
                ?>
                <tr>
                    <td class="text-center"><?= $i + 1 ?></td>
                    <td><?= $hasItem ? esc($items[$i]['nama_barang']) : '&nbsp;' ?></td>
                    <td class="text-center"><?= $hasItem ? esc($items[$i]['satuan']) : '' ?></td>
                    <td class="text-center"><?= $hasItem ? number_format($items[$i]['banyak_barang'], 2) : '' ?></td>
                    <td class="text-center" style="font-size:12px; height: 35px;"><?= $hasItem && !empty($items[$i]['nama_qc']) ? esc($items[$i]['nama_qc']) : '' ?></td>
                    <td class="text-center" style="font-size:12px; height: 35px;"><?= $hasItem && !empty($items[$i]['nama_pemasok']) ? esc($items[$i]['nama_pemasok']) : '' ?></td>
                    <td class="text-center"><?= $hasItem ? esc(ucwords($items[$i]['keterangan'])) : '' ?></td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>

        <div class="note">
            *Note : Untuk keterangan diisi dengan <em>tidak ada nota / ada nota</em>
        </div>

        <table class="footer-sig">
            <tr>
                <td>
                    <div class="sig-box">
                        TTD Penanggung Jawab / QC
                        <br>
                        <span class="sig-line">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</span>
                    </div>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>
