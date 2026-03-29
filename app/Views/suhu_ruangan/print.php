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
        
        .info-area { margin-bottom: 15px; font-size: 11px; }
        
        /* Table Data Styling */
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; table-layout: fixed; }
        .data-table th, .data-table td { 
            border: 1px solid #000; 
            padding: 10px 5px; 
            word-wrap: break-word;
            overflow-wrap: break-word;
            font-size: 11px;
            text-align: center;
        }
        .data-table th { background-color: #f2f2f2; font-weight: bold; }
        
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
        <div class="title-main">LAPORAN CATATAN SUHU & KELEMBAPAN RUANGAN</div>
        <div style="margin-bottom: 15px;">
            Tanggal: <strong><?= date('d/m/Y', strtotime($header['tanggal'])) ?></strong><br>
            Petugas: <strong><?= esc($header['nama_petugas']) ?></strong>
        </div>
        <table class="data-table">
            <thead>
                <tr><th>Waktu</th><th>Jam</th><th>Suhu (°C)</th><th>Kelembapan (%)</th><th>Keterangan</th></tr>
            </thead>
            <tbody>
                <tr><td>Pagi</td><td><?= esc($header['pagi_jam']) ?></td><td><?= esc($header['pagi_suhu']) ?></td><td><?= esc($header['pagi_kelembapan']) ?></td><td><?= esc($header['pagi_keterangan']) ?></td></tr>
                <tr><td>Siang</td><td><?= esc($header['siang_jam']) ?></td><td><?= esc($header['siang_suhu']) ?></td><td><?= esc($header['siang_kelembapan']) ?></td><td><?= esc($header['siang_keterangan']) ?></td></tr>
                <tr><td>Sore</td><td><?= esc($header['sore_jam']) ?></td><td><?= esc($header['sore_suhu']) ?></td><td><?= esc($header['sore_kelembapan']) ?></td><td><?= esc($header['sore_keterangan']) ?></td></tr>
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
                        <p>Kepala SPPG / Ahli Gizi,</p>
                        <div class="sig-space"></div>
                        <p class="sig-name">( .................................. )</p>
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 30px; font-size: 9px; color: #666; text-align: center; border-top: 1px dotted #000; padding-top: 8px;">
            Halaman 1 dari 1 | SIM-GIZI Room Environment Log | Dicetak pada: <?= date('d/m/Y H:i') ?>
        </div>
    </div>
</body>
</html>
