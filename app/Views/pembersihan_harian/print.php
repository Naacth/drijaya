<!DOCTYPE html>
<html>
<head>
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
        
        /* Table Data Styling */
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; table-layout: fixed; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 8px 5px; text-align: center; font-size: 11px; }
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
<?= view('layout/print_signatures_style') ?>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px; padding: 10px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
        <button onclick="window.print()" style="padding: 6px 16px; cursor: pointer; border-radius: 6px; border: 1px solid #6366f1; background: #6366f1; color: white; font-weight: 600;">Cetak PDF</button>
        <button onclick="window.close()" style="padding: 6px 16px; cursor: pointer; border-radius: 6px; border: 1px solid #cbd5e1; background: white; color: #64748b; font-weight: 600; margin-left: 8px;">Tutup</button>
    </div>
    <div class="page-container">
        <?= view('layout/print_header') ?>
        <div class="title-main">CHECKLIST PEMBERSIHAN HARIAN (UNIT <?= strtoupper($header['unit_type'] ?? '') ?>)</div>

        <div style="margin-bottom: 15px;">
            Tanggal Periksa: <strong><?= format_date_id($header['tanggal'] ?? null) ?></strong>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th width="40">No</th>
                    <th>Area / Komponen Kebersihan</th>
                    <th width="150">Status Kebersihan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($area as $k => $v): 
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td style="text-align: left; text-transform: capitalize; padding-left: 10px;"><?= str_replace('_', ' ', $k) ?></td>
                    <td style="font-weight: bold; <?= empty($blank) ? ($v == '1' ? 'color: #065f46;' : 'color: #991b1b;') : '' ?>">
                        <?php if (! empty($blank)): ?>&nbsp;<?php else: ?><?= $v == '1' ? 'BERSIH' : 'KOTOR / PERLU TINDAKAN' ?><?php endif; ?>
                    </td>
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
                        <p>Ahli Gizi / Verifikator,</p>
                        <div class="sig-space">
                            <?php if (($__sig = signature_data_uri($signature ?? [], 'ttd_ahli_gizi')) !== ''): ?>
                                <img src="<?= $__sig ?>" alt="TTD" style="max-height: 55px;">
                            <?php endif; ?>
                        </div>
                        <p class="sig-name">( <?= esc($header['nama_verifikator']) ?> )</p>
                    </td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 30px; font-size: 9px; color: #666; text-align: center; border-top: 1px dotted #000; padding-top: 8px;">
            Halaman 1 dari 1 | SIM-GIZI Sanitation Audit | Dicetak pada: <?= date('d/m/Y H:i') ?>
        </div>
    </div>
</body>
</html>
