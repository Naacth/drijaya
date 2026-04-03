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
        .data-table th { background-color: #f2f2f2; font-weight: bold; text-align: center; text-transform: uppercase; }
        .data-table td { text-align: center; }
        .text-left { text-align: left !important; padding-left: 5px !important; }
        
        /* Signatures */
        .sig-section { width: 100%; margin-top: 30px; page-break-inside: avoid; }
        .sig-table { width: 100%; border-collapse: collapse; }
        .sig-box { text-align: center; width: 33.33%; padding: 0 5px; vertical-align: top; }
        .sig-space { height: 60px; border-bottom: 1px dotted #000; margin: 5px 15px; }
        .sig-name { font-weight: bold; text-decoration: underline; }
        
        /* Print Utilities */
        @media print { 
            .no-print { display: none !important; } 
            body { -webkit-print-color-adjust: exact; }
            .data-table tr { page-break-inside: avoid; }
        }
    </style>
<?= view('layout/print_signatures_style') ?>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px; border: 1px solid #ddd; padding: 10px; background: #fafafa;">
        <button onclick="window.print()" style="padding: 10px 30px; cursor: pointer; background: #198754; color: white; border: none; border-radius: 4px; font-weight: bold;">PRINT DOCUMENT</button>
        <button onclick="window.close()" style="padding: 10px 20px; cursor: pointer; background: #6c757d; color: white; border: none; border-radius: 4px; margin-left:10px;">CLOSE WINDOW</button>
    </div>

    <div class="page-container">
        <!-- HEADER -->
        <?= view('layout/print_header') ?>

        <div class="title-main">CHECKLIST PEMERIKSAAN HASIL MASAKAN</div>

        <!-- INFO -->
        <table class="info-table">
            <tr>
                <td class="label">Hari / Tanggal</td>
                <td class="value">: <?= format_weekday_date_long_id($header['tanggal'] ?? null) ?></td>
                <td class="label">Waktu Sajian</td>
                <td class="value">: <?php $__wt = format_time_id($header['waktu_penyajian'] ?? null); ?><?= $__wt !== '' ? $__wt . ' WIB' : '' ?></td>
            </tr>
            <tr>
                <td class="label">Petugas QC</td>
                <td class="value">: <?= esc($header['user_nama']) ?></td>
                <td class="label">ID Laporan</td>
                <td class="value">: #QC-<?= str_pad($header['id'], 5, '0', STR_PAD_LEFT) ?></td>
            </tr>
        </table>

        <!-- DATA TABLE -->
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th>Nama Masakan</th>
                    <th style="width: 65px;">Standar<br>(Gram)</th>
                    <th style="width: 65px;">Aktual<br>(Gram)</th>
                    <th style="width: 70px;">Rasa</th>
                    <th style="width: 70px;">Tekstur</th>
                    <th style="width: 150px;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td class="text-left" style="font-weight: bold;"><?= esc($item['nama_masakan']) ?></td>
                    <td><?= number_format($item['gramasi_standar'], 1) ?>g</td>
                    <td style="<?= $item['gramasi_real'] < $item['gramasi_standar'] ? 'color: red; font-weight: bold;' : 'font-weight: bold;' ?>">
                        <?= number_format($item['gramasi_real'], 1) ?>g
                    </td>
                    <td style="font-weight: bold;"><?= esc($item['rasa']) ?></td>
                    <td style="font-weight: bold;"><?= esc($item['tekstur']) ?></td>
                    <td class="text-left" style="font-style: italic; font-size: 11px;"><?= esc($item['keterangan'] ?: '-') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- SIGNATURES -->
        <div class="sig-section">
            <table class="sig-table">
                <tr>
                    <td class="sig-box">
                        <p>Petugas QC,</p>
                        <div class="sig-space"></div>
                        <p class="sig-name"><?= esc($header['user_nama']) ?></p>
                        <p style="font-size: 9px; margin-top: -12px; font-family: monospace;">ID: USER-<?= str_pad($header['user_id'] ?? 0, 4, '0', STR_PAD_LEFT) ?></p>
                    </td>
                    <td class="sig-box">
                        <p>Checker Dapur,</p>
                        <div class="sig-space"></div>
                        <p class="sig-name">..................................</p>
                        <p style="font-size: 9px; margin-top: -12px;">Saksi Dapur (Daily)</p>
                    </td>
                    <td class="sig-box">
                        <p>Ahli Gizi,</p>
                        <div class="sig-space"></div>
                        <p class="sig-name">..................................</p>
                        <p style="font-size: 9px; margin-top: -12px;">Validator Gizi</p>
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 40px; font-size: 9px; color: #666; text-align: center; border-top: 1px dotted #000; padding-top: 8px;">
            Sistem Informasi Manajemen Gizi & Mutu (SIM-GIZI) | Dicetak pada: <?= date('d/m/Y H:i') ?>
            <br><i>Terimakasih telah menjaga standar kualitas makanan untuk penerima manfaat.</i>
        </div>
    </div>
</body>
</html>
