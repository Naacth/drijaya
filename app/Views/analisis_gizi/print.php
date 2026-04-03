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
            padding: 6px 4px; 
            word-wrap: break-word;
            overflow-wrap: break-word;
            font-size: 10px;
        }
        .data-table th { background-color: #f2f2f2; font-weight: bold; text-align: center; text-transform: uppercase; }
        .data-table td { text-align: center; }
        .text-left { text-align: left !important; padding-left: 5px !important; }
        .text-right { text-align: right !important; padding-right: 5px !important; }
        
        .summary-row { background-color: #f9f9f9; font-weight: bold; }
        
        /* Signatures */
        .sig-section { width: 100%; margin-top: 30px; page-break-inside: avoid; }
        .sig-table { width: 100%; border-collapse: collapse; }
        .sig-box { text-align: center; width: 50%; vertical-align: top; }
        .sig-space { height: 60px; }
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
    <div class="no-print" style="text-align: right; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 25px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 5px; font-weight: bold;">CETAK LAPORAN</button>
        <button onclick="window.close()" style="padding: 10px 25px; cursor: pointer; background: #6c757d; color: white; border: none; border-radius: 5px; margin-left:10px;">TUTUP</button>
    </div>

    <div class="page-container">
        <!-- HEADER -->
        <?= view('layout/print_header') ?>

        <div class="title-main">ANALISIS KANDUNGAN GIZI (AKG)</div>

        <!-- INFO -->
        <table class="info-table">
            <tr>
                <td class="label">Nama Paket Menu</td>
                <td class="value">: <?= esc($header['nama_paket']) ?></td>
                <td class="label">ID Laporan</td>
                <td class="value">: #<?= str_pad($header['id'], 5, '0', STR_PAD_LEFT) ?></td>
            </tr>
            <tr>
                <td class="label">Tanggal Sajian</td>
                <td class="value">: <?= format_date_long_id($header['tanggal_sajian'] ?? null) ?></td>
                <td class="label">Ahli Gizi</td>
                <td class="value">: <?= esc($header['user_nama']) ?></td>
            </tr>
        </table>

        <!-- DATA TABLE -->
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th>Nama Item</th>
                    <th style="width: 60px;">Gram</th>
                    <th style="width: 60px;">Kalori</th>
                    <th style="width: 60px;">Prot(g)</th>
                    <th style="width: 60px;">Lemak(g)</th>
                    <th style="width: 60px;">KH(g)</th>
                    <th style="width: 60px;">Serat(g)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totals = ['gram'=>0,'kkal'=>0,'prot'=>0,'lemak'=>0,'kh'=>0,'serat'=>0];
                foreach ($items as $i => $item): 
                    $totals['gram']  += $item['gramasi'];
                    $totals['kkal']  += $item['kalori'];
                    $totals['prot']  += $item['protein'];
                    $totals['lemak'] += $item['lemak'];
                    $totals['kh']    += $item['karbohidrat'];
                    $totals['serat'] += $item['serat'];
                ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td class="text-left fw-bold"><?= esc($item['nama_item']) ?></td>
                    <td><?= number_format($item['gramasi'], 1) ?></td>
                    <td><?= number_format($item['kalori'], 1) ?></td>
                    <td><?= number_format($item['protein'], 1) ?>g</td>
                    <td><?= number_format($item['lemak'], 1) ?>g</td>
                    <td><?= number_format($item['karbohidrat'], 1) ?>g</td>
                    <td><?= number_format($item['serat'], 1) ?>g</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="summary-total">
                    <td colspan="2" style="text-align: right; padding: 10px;">REKAPITULASI TOTAL NUTRISI</td>
                    <td><?= number_format($totals['gram'], 1) ?></td>
                    <td><?= number_format($totals['kkal'], 1) ?></td>
                    <td><?= number_format($totals['prot'], 1) ?>g</td>
                    <td><?= number_format($totals['lemak'], 1) ?>g</td>
                    <td><?= number_format($totals['kh'], 1) ?>g</td>
                    <td><?= number_format($totals['serat'], 1) ?>g</td>
                </tr>
            </tfoot>
        </table>

        <!-- SIGNATURES -->
        <div class="sig-section">
            <table class="sig-table">
                <tr>
                    <td class="sig-box">
                        <p>Mengetahui,</p>
                        <p style="font-size: 10px; margin-top: -10px;">Manager / Admin SPPG</p>
                        <div class="sig-space"></div>
                        <p class="sig-name">................................................</p>
                        <p style="font-size: 10px; margin-top: -12px;">(Tanda Tangan & Nama Terang)</p>
                    </td>
                    <td class="sig-box">
                        <p>Dilaporkan Oleh,</p>
                        <p style="font-size: 10px; margin-top: -10px;">Ahli Gizi (Nutrisionis)</p>
                        <div class="sig-space"></div>
                        <p class="sig-name"><?= esc($header['user_nama']) ?></p>
                        <p style="font-size: 10px; margin-top: -12px; font-family: monospace;">ID: USER-<?= str_pad($header['user_id'] ?? 0, 4, '0', STR_PAD_LEFT) ?></p>
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 40px; font-size: 9px; color: #777; text-align: center; border-top: 1px dotted #000; padding-top: 8px;">
            Dokumen ini dicetak secara otomatis melalui <b>SPPG Management System</b> pada <?= date('d/m/Y H:i:s') ?>
            <br><i>Simpan dokumen ini sebagai arsip resmi pemenuhan gizi harian.</i>
        </div>
    </div>
</body>
</html>
