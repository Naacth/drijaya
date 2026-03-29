<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        /* PDF Print Optimizations */
        @page {
            size: A4;
            margin: 1.5cm;
        }
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 11px; 
            line-height: 1.4;
            color: #000; 
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .page-container { width: 100%; margin: 0 auto; }
        
        /* Header Styling */
        .header-block { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 15px; }
        .header-table { width: 100%; border-collapse: collapse; }
        .header-logo { width: 70px; }
        .header-text { text-align: center; }
        .header-text h2 { margin: 0; font-size: 16px; font-weight: bold; }
        .header-text h3 { margin: 1px 0; font-size: 12px; font-weight: normal; }
        .header-text p { margin: 0; font-size: 9px; color: #333; }
        
        .title-main { 
            text-align: center; 
            font-size: 14px; 
            font-weight: bold; 
            margin: 20px 0; 
            text-transform: uppercase;
            text-decoration: underline;
        }
        
        /* Info Area */
        .info-table { width: 100%; margin-bottom: 15px; border-collapse: collapse; }
        .info-table td { padding: 3px 5px; vertical-align: top; }
        .label { font-weight: bold; width: 120px; }
        .value { border-bottom: 1px dotted #ccc; }
        
        /* Table Data Styling */
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; table-layout: fixed; }
        .data-table th, .data-table td { 
            border: 1px solid #000; 
            padding: 8px 4px; 
            word-wrap: break-word;
            overflow-wrap: break-word;
            font-size: 10px;
        }
        .data-table th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .data-table td { text-align: center; }
        .text-left { text-align: left !important; padding-left: 5px !important; }
        
        /* Signatures */
        .sig-section { width: 100%; margin-top: 30px; page-break-inside: avoid; }
        .sig-table { width: 100%; border-collapse: collapse; }
        .sig-box { text-align: center; width: 33.33%; padding: 0 5px; vertical-align: top; }
        .sig-space { height: 60px; }
        .sig-name { font-weight: bold; text-decoration: underline; }
        
        /* Print Utilities */
        @media print { 
            .no-print { display: none !important; } 
            body { -webkit-print-color-adjust: exact; }
            .data-table tr { page-break-inside: avoid; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()">Cetak</button>
        <button onclick="window.close()">Tutup</button>
    </div>
    <div class="page-container">
        <?= view('layout/print_header') ?>
        <div class="title-main">LAPORAN PENANGANAN MAKANAN LEBIH</div>
        <table class="info-table">
            <tr>
                <td class="label">Tanggal</td><td class="value">: <?= date('d/m/Y', strtotime($header['tanggal'])) ?></td>
                <td class="label">Nama Cook</td><td class="value">: <?= esc($header['nama_cook']) ?></td>
            </tr>
            <tr>
                <td class="label">Nama Chef</td><td class="value">: <?= esc($header['nama_chef'] ?: '-') ?></td>
                <td class="label">Ahli Gizi</td><td class="value">: <?= esc($header['nama_ahli_gizi'] ?: '-') ?></td>
            </tr>
        </table>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th>Nama Item Lebih</th>
                    <th style="width: 70px;">Jumlah</th>
                    <th style="width: 120px;">Kondisi</th>
                    <th>Tindakan / Penanganan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td style="text-align: left;"><?= esc($item['nama_item']) ?></td>
                    <td><?= esc($item['jumlah']) ?></td>
                    <td><?= esc($item['kondisi']) ?></td>
                    <td><?= esc($item['tindakan']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="sig-section">
            <table class="sig-table">
                <tr>
                    <td class="sig-box">
                        <p>Cook (Pelaksana),</p>
                        <div class="sig-space"></div>
                        <p class="sig-name">( <?= esc($header['nama_cook']) ?> )</p>
                    </td>
                    <td class="sig-box">
                        <p>Chef Dapur,</p>
                        <div class="sig-space"></div>
                        <p class="sig-name">( <?= esc($header['nama_chef'] ?: '....................') ?> )</p>
                    </td>
                    <td class="sig-box">
                        <p>Validator (Gizi),</p>
                        <div class="sig-space"></div>
                        <p class="sig-name">( <?= esc($header['nama_ahli_gizi'] ?: '....................') ?> )</p>
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 30px; font-size: 9px; color: #666; text-align: center; border-top: 1px dotted #000; padding-top: 8px;">
            Halaman 1 dari 1 | SIM-GIZI Waste Management | Dicetak pada: <?= date('d/m/Y H:i') ?>
        </div>
    </div>
</body>
</html>
