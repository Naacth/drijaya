<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        /* PDF Print Optimizations */
        @page {
            size: A4;
            margin: 2cm;
        }
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 12px; 
            line-height: 1.5;
            color: #000; 
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .page-container { width: 100%; margin: 0 auto; }
        
        /* Header Styling */
        .header-block { border-bottom: 2px solid #000; padding-bottom: 15px; margin-bottom: 20px; }
        .header-table { width: 100%; border-collapse: collapse; }
        .header-logo { width: 80px; }
        .header-text { text-align: center; }
        .header-text h2 { margin: 0; font-size: 18px; font-weight: bold; }
        .header-text h3 { margin: 2px 0; font-size: 14px; font-weight: normal; }
        .header-text p { margin: 0; font-size: 10px; color: #333; }
        
        .title-main { 
            text-align: center; 
            font-size: 16px; 
            font-weight: bold; 
            margin: 25px 0; 
            text-transform: uppercase;
            text-decoration: underline;
        }
        
        /* Info Area */
        .info-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-table td { padding: 4px 6px; vertical-align: top; }
        .label { font-weight: bold; width: 130px; }
        .value { border-bottom: 1px dotted #ccc; }
        
        /* Table Data Styling */
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; table-layout: fixed; }
        .data-table th, .data-table td { 
            border: 1px solid #000; 
            padding: 10px 8px; 
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .data-table th { background-color: #f2f2f2; font-weight: bold; text-align: center; }
        .data-table td { text-align: center; }
        .text-left { text-align: left !important; }
        .text-right { text-align: right !important; }
        
        .summary-row { background-color: #f9f9f9; font-weight: bold; }
        
        /* Signatures */
        .sig-section { width: 100%; margin-top: 50px; page-break-inside: avoid; }
        .sig-table { width: 100%; border-collapse: collapse; }
        .sig-box { text-align: center; width: 50%; vertical-align: top; }
        .sig-space { height: 80px; }
        .sig-name { font-weight: bold; }
        
        /* Print Utilities */
        @media print { 
            .no-print { display: none !important; } 
            body { -webkit-print-color-adjust: exact; }
            .data-table tr { page-break-inside: avoid; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: right; padding: 10px; background: #f4f4f4; margin-bottom: 20px; border-radius: 8px;">
        <span style="float: left; padding: 8px; color: #666;">Pratinjau Cetak Laporan</span>
        <button onclick="window.print()" style="padding: 8px 20px; cursor: pointer; background: #0d6efd; color: white; border: none; border-radius: 4px;">Cetak Sekarang</button>
        <button onclick="window.close()" style="padding: 8px 20px; cursor: pointer; background: #6c757d; color: white; border: none; border-radius: 4px; margin-left: 5px;">Tutup</button>
    </div>

    <div class="page-container">
        <!-- HEADER -->
        <?= view('layout/print_header') ?>

        <div class="title-main">ESTIMASI ANGGARAN (MENU KERING)</div>

        <!-- INFO HEADER -->
        <table class="info-table">
            <tr>
                <td class="label">Periode Tanggal</td>
                <td class="value">: <?= date('d/m/Y', strtotime($header['tanggal_mulai'])) ?> s/d <?= date('d/m/Y', strtotime($header['tanggal_selesai'])) ?></td>
                <td class="label">Status Laporan</td>
                <td class="value">: RESMI / VALID</td>
            </tr>
            <tr>
                <td class="label">Kategori Porsi</td>
                <td class="value">: <?= strtoupper(esc($header['kategori_porsi'])) ?></td>
                <td class="label">Reporter</td>
                <td class="value">: <?= esc($header['user_nama']) ?></td>
            </tr>
        </table>

        <!-- DATA TABLE -->
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th>Nama Bahan / Menu Masakan</th>
                    <th style="width: 180px;">Estimasi Harga Satuan (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td class="text-left"><?= esc($item['nama_item']) ?></td>
                    <td class="text-right"><?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="summary-row">
                    <td colspan="2" class="text-right" style="padding: 12px; font-size: 14px;">TOTAL KALKULASI ESTIMASI ANGGARAN</td>
                    <td class="text-right" style="padding: 12px; font-size: 14px; border-double: 3px double #000;">Rp <?= number_format($header['total_kalkulasi'], 0, ',', '.') ?></td>
                </tr>
            </tfoot>
        </table>

        <!-- SIGNATURES -->
        <div class="sig-section">
            <table class="sig-table">
                <tr>
                    <td class="sig-box">
                        <p>Dibuat Oleh,</p>
                        <p style="font-size: 11px; margin-top: -10px;">Nutrisionis (Ahli Gizi)</p>
                        <div class="sig-space"></div>
                        <p class="sig-name"><?= esc($header['user_nama']) ?></p>
                        <p style="font-size: 10px; margin-top: -12px; font-family: monospace;">ID: USER-<?= str_pad($header['user_id'] ?? 0, 4, '0', STR_PAD_LEFT) ?></p>
                    </td>
                    <td class="sig-box">
                        <p>Mengetahui,</p>
                        <p style="font-size: 11px; margin-top: -10px;">Manager Unit SPPG</p>
                        <div class="sig-space"></div>
                        <p class="sig-name">................................................</p>
                        <p style="font-size: 11px; margin-top: -12px;">(Tanda Tangan & Nama Terang)</p>
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 50px; font-size: 10px; color: #777; text-align: center; border-top: 1px dotted #000; padding-top: 10px;">
            Dokumen ini dicetak secara sistematis melalui <b>SPPG Management System</b> pada <?= date('d/m/Y H:i:s') ?>
            <br><i>Halaman 1 dari 1 - Salinan Sah</i>
        </div>
    </div>
</body>
</html>
