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
            margin: 15px 0; 
            text-transform: uppercase;
            text-decoration: underline;
        }
        
        .info-area { margin-bottom: 15px; font-size: 11px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .info-table td { padding: 3px 5px; vertical-align: top; }
        .label { font-weight: bold; width: 150px; }
        .value { border-bottom: 1px dotted #ccc; }
        
        /* Table Data Styling */
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; table-layout: fixed; }
        .data-table th, .data-table td { 
            border: 1px solid #000; 
            padding: 8px 5px; 
            word-wrap: break-word;
            overflow-wrap: break-word;
            font-size: 10px;
            text-align: center;
        }
        .data-table th { background-color: #f2f2f2; font-weight: bold; }
        .text-left { text-align: left !important; padding-left: 5px !important; }
        
        /* Signatures */
        .sig-section { width: 100%; margin-top: 30px; page-break-inside: avoid; }
        .sig-table { width: 100%; border-collapse: collapse; }
        .sig-box { text-align: center; width: 50%; padding: 0 5px; vertical-align: top; }
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
        <div class="header-block">
            <table class="header-table">
                <tr>
                    <td class="header-logo" style="text-align: left;">
                        <img src="<?= base_url('bgn.png') ?>" alt="Logo BGN" style="width: 70px; height: auto;">
                    </td>
                    <td class="header-text">
                        <h2>SPPG BUNAR SUKAMULYA</h2>
                        <h3>YAYASAN BUMI PANGAN INDONESIA</h3>
                        <p><?= esc(session()->get('sppg_alamat') ?? 'Kabupaten Tangerang, Banten') ?></p>
                    </td>
                    <td class="header-logo" style="text-align: right;">
                        <img src="<?= base_url('yayasan.png') ?>" alt="Logo Yayasan" style="width: 65px; height: auto;">
                    </td>
                </tr>
            </table>
        </div>
        <div class="title-main">LAPORAN PENCUCIAN BAHAN MAKANAN</div>
        <table class="info-table">
            <tr>
                <td class="label">Tanggal</td><td class="value">: <?= date('d/m/Y', strtotime($header['tanggal'])) ?></td>
            </tr>
            <tr>
                <td class="label">Nama Petugas</td><td class="value">: <?= esc($header['nama_petugas']) ?></td>
            </tr>
        </table>
        <table class="data-table">
            <thead>
                <tr><th width="30">No</th><th>Nama Bahan</th><th>Bahan Kimia</th><th>Benda Asing</th><th>Tindak Lanjut</th><th>Jam Prdks</th></tr>
            </thead>
            <tbody>
                <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td style="text-align: left;"><?= esc($item['nama_bahan']) ?></td>
                    <td><?= esc($item['bahan_kimia'] ?: '-') ?></td>
                    <td><?= esc($item['benda_asing'] ?: '-') ?></td>
                    <td><?= esc($item['tindak_lanjut'] ?: '-') ?></td>
                    <td><?= esc($item['jam_produksi'] ?: '-') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="sig-section">
            <table class="sig-table">
                <tr>
                    <td class="sig-box">
                        <p>Petugas Pelaksana,</p>
                        <div class="sig-space"></div>
                        <p class="sig-name">( <?= esc($header['nama_petugas']) ?> )</p>
                    </td>
                    <td class="sig-box">
                        <p>Verifikasi (Ahli Gizi),</p>
                        <div class="sig-space"></div>
                        <p class="sig-name">( .................................. )</p>
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 30px; font-size: 9px; color: #666; text-align: center; border-top: 1px dotted #000; padding-top: 8px;">
            Halaman 1 dari 1 | SIM-GIZI Washing Log | Dicetak pada: <?= date('d/m/Y H:i') ?>
        </div>
    </div>
</body>
</html>
