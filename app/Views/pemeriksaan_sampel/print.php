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
            margin: 20px 0 10px; 
            text-transform: uppercase;
            text-decoration: underline;
        }
        
        /* Information Table */
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; table-layout: fixed; }
        .info-table td { padding: 10px; border: 1px solid #000; word-wrap: break-word; vertical-align: top; }
        .info-table td.label { width: 180px; background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        
        /* Signatures */
        .sig-section { width: 100%; margin-top: 30px; page-break-inside: avoid; }
        .sig-table { width: 100%; border-collapse: collapse; }
        .sig-box { text-align: center; width: 50%; vertical-align: top; }
        .sig-space { height: 70px; }
        .sig-name { font-weight: bold; text-decoration: underline; }
        
        /* Print Utilities */
        @media print { 
            .no-print { display: none !important; } 
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()">Cetak</button>
        <button onclick="window.close()">Tutup</button>
    </div>
    <div class="page-container">
        <!-- HEADER -->
        <?= view('layout/print_header') ?>
        <div class="title-main">LAPORAN PEMERIKSAAN & SAMPEL MAKANAN</div>
        <table class="info-table">
            <tr><td class="label">Tanggal Pemeriksaan</td><td><?= date('d/m/Y', strtotime($header['tanggal'])) ?></td></tr>
            <tr><td class="label">Jam Matang</td><td><?= esc($header['jam_matang'] ?: '-') ?></td></tr>
            <tr><td class="label">Jenis Produk</td><td><?= esc($header['jenis_produk']) ?></td></tr>
            <tr><td class="label">Bahaya Fisik</td><td><?= esc($header['bahaya_fisik'] ?: 'TIDAK ADA') ?></td></tr>
            <tr><td class="label">Bahaya Biologi</td><td><?= esc($header['bahaya_biologi'] ?: 'TIDAK ADA') ?></td></tr>
            <tr><td class="label">Jam Penarikan</td><td><?= esc($header['jam_penarikan'] ?: '-') ?></td></tr>
            <tr><td class="label">Tindak Lanjut</td><td><?= esc($header['tindak_lanjut'] ?: '-') ?></td></tr>
            <tr><td class="label">Sampel Diambil</td><td><?= strtoupper($header['sampel_diambil']) ?></td></tr>
            <tr><td class="label">Jumlah Sampel</td><td><?= esc($header['jumlah_sampel'] ?: '-') ?></td></tr>
            <tr><td class="label">Tempat Penyimpanan</td><td><?= esc($header['tempat_penyimpanan'] ?: '-') ?></td></tr>
            <tr><td class="label">Tanggal Pemusnahan</td><td><?= $header['tanggal_pemusnahan'] ? date('d/m/Y', strtotime($header['tanggal_pemusnahan'])) : '-' ?></td></tr>
        </table>
        <div class="sig-section">
            <table class="sig-table">
                <tr>
                    <td class="sig-box">
                        <p>Pemeriksa / Ahli Gizi,</p>
                        <div class="sig-space"></div>
                        <p class="sig-name">( <?= esc($header['nama_pemeriksa']) ?> )</p>
                        <p style="font-size: 9px; margin-top: -12px;">Reporter</p>
                    </td>
                    <td class="sig-box">
                        <p>Mengetahui,</p>
                        <div class="sig-space"></div>
                        <p class="sig-name">( .................................. )</p>
                        <p style="font-size: 9px; margin-top: -12px;">Kepala SPPG / Manager</p>
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 40px; font-size: 9px; color: #666; text-align: center; border-top: 1px dotted #000; padding-top: 8px;">
            Halaman 1 dari 1 | SIM-GIZI Safety Audit Report | Dicetak pada: <?= date('d/m/Y H:i') ?>
            <br><i>Arsip sampel makanan wajib disimpan selama 2x24 jam sebelum dimusnahkan.</i>
        </div>
    </div>
</body>
</html>
