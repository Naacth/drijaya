<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        /* PDF Print Optimizations */
        @page {
            size: A4;
            margin: 1cm;
        }
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 11px; 
            line-height: 1.3;
            color: #000; 
            margin: 0;
            padding: 0;
            background: #fff;
            box-sizing: border-box;
        }
        html, body { width: 100%; }
        .page-container { width: 100%; margin: 0 auto; padding: 0; }
        
        /* Header Styling */
        .header-block { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 15px; }
        .header-table { width: 100%; border-collapse: collapse; }
        .header-logo-box { 
            width: 65px; 
            height: 65px; 
            border: 1.5px solid #000; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            text-align: center;
            font-size: 8px;
            font-weight: bold;
            line-height: 1;
        }
        .header-text { text-align: center; }
        .header-text h2 { margin: 0; font-size: 14px; font-weight: bold; }
        .header-text h3 { margin: 2px 0; font-size: 12px; font-weight: bold; }
        
        .title-main { 
            text-align: center; 
            font-size: 13px; 
            font-weight: bold; 
            margin: 10px 0; 
            text-transform: uppercase;
        }
        
        /* Info Area */
        .info-section { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .kepada-box { width: 45%; }
        .detail-table { width: 50%; border-collapse: collapse; }
        .detail-table td { border: 1px solid #000; padding: 3px 6px; font-size: 10px; }
        .detail-table td:first-child { background: #f2f2f2; width: 100px; }

        /* Table Data Styling */
        .main-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; table-layout: fixed; }
        .main-table th, .main-table td { 
            border: 1px solid #000; 
            padding: 4px 2px; 
            word-wrap: break-word;
            overflow-wrap: break-word;
            font-size: 9px;
            text-align: center;
        }
        .main-table th { background-color: #f2f2f2; font-weight: normal; }
        .text-start { text-align: left !important; padding-left: 5px !important; }

        /* Prevent accidental horizontal overflow */
        .main-table, .detail-table, .sj-sig-table { max-width: 100%; }
        
        /* Signatures — pakai .sj-sig-table agar tidak bentrok dengan layout/print_signatures_style.php */
        .sig-section { width: 100%; margin-top: 10px; page-break-inside: avoid; }
        .sj-sig-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .sj-sig-table th, .sj-sig-table td { border: 1px solid #000; width: 25%; text-align: center; padding: 4px; }
        .sj-sig-table th { background: #f2f2f2; font-weight: normal; border-bottom: none; }
        .sj-sig-table td.sj-sig-space {
            height: 68px;
            min-height: 68px;
            padding: 8px 4px !important;
            vertical-align: middle !important;
            text-align: center !important;
            /* override global .sig-space (flex + max-width) */
            display: table-cell !important;
            max-width: none !important;
            margin: 0 !important;
        }
        .sj-sig-table td.sj-sig-space img {
            display: block;
            margin: 0 auto;
            max-height: 52px;
            max-width: 100%;
            object-fit: contain;
        }
        .sj-sig-table td.sj-sig-name {
            border-top: 1px solid #000;
            padding: 8px 4px !important;
            vertical-align: top;
            font-size: 10px;
            line-height: 1.35;
        }
        .sj-sig-table td.sj-sig-name .sj-sig-line {
            display: block;
            border-bottom: 1px solid #000;
            min-height: 1.1em;
            margin-bottom: 4px;
        }
        .sj-sig-table td.sj-sig-name small { color: #000; font-size: 9px; }
        
        /* Print Utilities */
        @media print { 
            .no-print { display: none !important; } 
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .page-break { page-break-after: always; }
            /* Avoid cut-off due to flex in print */
            .info-section { display: block; }
            .kepada-box, .detail-table { width: 100%; }
            .kepada-box { margin-bottom: 6px; }
            /* Avoid splitting table rows across pages */
            table { page-break-inside: auto; }
            tr { page-break-inside: avoid; page-break-after: auto; }
            thead { display: table-header-group; }
            tfoot { display: table-footer-group; }
            /* Ensure content fits printable width */
            .page-container { padding: 0; }
        }
    </style>
<?= view('layout/print_signatures_style') ?>
</head>
<body onload="window.print()">

    <div class="no-print" style="position: fixed; top: 20px; right: 20px; z-index: 9999; background: rgba(255,255,255,0.9); padding: 15px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border: 1px solid #e2e8f0;">
        <button onclick="window.print()" style="padding: 8px 20px; cursor: pointer; border-radius: 6px; border: 1px solid #6366f1; background: #6366f1; color: white; font-weight: 600;">Cetak PDF</button>
        <button onclick="window.close()" style="padding: 8px 20px; cursor: pointer; border-radius: 6px; border: 1px solid #cbd5e1; background: white; color: #64748b; font-weight: 600; margin-left: 8px;">Tutup</button>
    </div>

    <?php 
    $hari = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
    $namaHari = $hari[date('l', strtotime($header['tanggal']))];
    $tanggalIndo = date('d/m/Y', strtotime($header['tanggal']));
    ?>

    <?php foreach ($items as $index => $item): ?>
    <div class="page-container <?= $index !== count($items) - 1 ? 'page-break' : '' ?>">
        
        <!-- HEADER -->
        <?= view('layout/print_header') ?>

        <div class="title-main">
            SURAT JALAN / DELIVERY ORDER<br>
            <span style="font-size: 11px; font-weight: normal;">PROGRAM MAKAN BERGIZI GRATIS (MBG)</span>
        </div>

        <!-- INFO -->
        <div class="info-section">
            <div class="kepada-box">
                <p><u>Kepada :</u> <?= esc($item['nama_sekolah']) ?></p>
            </div>
            <table class="detail-table">
                <tr>
                    <td>No. Surat</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Hari/Tanggal</td>
                    <td><?= $namaHari ?>, <?= $tanggalIndo ?></td>
                </tr>
                <tr>
                    <td>Waktu Pengiriman</td>
                    <td><?= date('H:i', strtotime($item['jam_antar'])) ?></td>
                </tr>
                <tr>
                    <td>Driver</td>
                    <td><?= esc($header['driver']) ?></td>
                </tr>
                <tr>
                    <td>Nopol Kendaraan</td>
                    <td><?= esc($header['mobil']) ?></td>
                </tr>
            </table>
        </div>

        <!-- MAIN TABLE -->
        <table class="main-table">
            <thead>
                <tr>
                    <th rowspan="2" width="30">No</th>
                    <th rowspan="2" width="90">Kategori</th>
                    <th rowspan="2" width="80">Jumlah Porsi</th>
                    <th colspan="3">Jumlah Alat Makan</th>
                    <th rowspan="2">Keterangan</th>
                </tr>
                <tr>
                    <th width="65">Sebelum</th>
                    <th width="65">Sesudah</th>
                    <th width="55">Sisa</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1.</td>
                    <td>Kecil</td>
                    <td><?= number_format($item['porsi_kecil']) ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Besar</td>
                    <td><?= number_format($item['porsi_besar']) ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Alergi</td>
                    <td>0</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-start">Total</td>
                    <td><?= number_format($item['jumlah']) ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- SIGNATURES -->
        <div class="sig-section">
            <table class="sj-sig-table">
                <thead>
                    <tr>
                        <th>Dibuat Oleh</th>
                        <th>Diperiksa Oleh</th>
                        <th>Diketahui Oleh</th>
                        <th>Diterima Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="sj-sig-space">
                            <?php if (($__sig = signature_data_uri_with_aslap_fallback($signature ?? [], $user_signature ?? [], 'ttd_akuntan')) !== ''): ?>
                                <img src="<?= $__sig ?>" alt="">
                            <?php endif; ?>
                        </td>
                        <td class="sj-sig-space">
                            <?php if (($__sig = signature_data_uri_with_aslap_fallback($signature ?? [], $user_signature ?? [], 'ttd_ahli_gizi')) !== ''): ?>
                                <img src="<?= $__sig ?>" alt="">
                            <?php endif; ?>
                        </td>
                        <td class="sj-sig-space">
                            <?php if (($__sig = signature_data_uri_with_aslap_fallback($signature ?? [], $user_signature ?? [], 'ttd_kepala_dapur')) !== ''): ?>
                                <img src="<?= $__sig ?>" alt="">
                            <?php endif; ?>
                        </td>
                        <td class="sj-sig-space"></td>
                    </tr>
                    <tr>
                        <td class="sj-sig-name">
                            <span class="sj-sig-line"><?= esc($signature['nama_akuntan'] ?? '') ?></span>
                            <small>(Akuntan)</small>
                        </td>
                        <td class="sj-sig-name">
                            <span class="sj-sig-line"><?= esc($signature['nama_ahli_gizi'] ?? '') ?></span>
                            <small>(Ahli Gizi)</small>
                        </td>
                        <td class="sj-sig-name">
                            <span class="sj-sig-line"><?= esc($signature['nama_kepala_dapur'] ?? '') ?></span>
                            <small>(Kepala Dapur)</small>
                        </td>
                        <td class="sj-sig-name">
                            <span class="sj-sig-line">&nbsp;</span>
                            <small>(Pihak Sekolah)</small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 15px; font-size: 8px; color: #666; text-align: right;">
            Cetak: <?= date('d/m/Y H:i') ?> | SPPG-MBG Delivery System
        </div>

    </div>
    <?php endforeach; ?>

</body>
</html>
