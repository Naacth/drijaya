<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        /* PDF Print Optimizations */
        @page {
            size: A4;
            margin: 0.7cm 0.9cm;
        }
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 10px; 
            line-height: 1.25;
            color: #000; 
            margin: 0;
            padding: 0;
            background: #fff;
        }
        @media print {
            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .no-print,
            .no-print * {
                display: none !important;
            }
        }

        .text-center { text-align: center; }
        
        .title-main {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            margin: 8px 0 10px;
            text-decoration: underline;
        }

        /* Info fields */
        .info-table {
            width: 100%;
            margin-bottom: 8px;
        }
        .info-table td {
            padding: 1px 0;
            font-size: 10px;
        }
        .info-table .label { width: 180px; }
        .info-table .colon { width: 15px; }

        /* Data table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            font-size: 9px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 2px 3px;
            text-align: center;
            vertical-align: middle;
        }
        .dark-header th {
            background-color: #1a1a2e;
            color: #fff;
            font-weight: bold;
        }

        /* Notes section */
        .notes {
            font-size: 8px;
            margin-bottom: 6px;
        }
        .notes p { margin: 2px 0; }
        .notes ol { margin: 2px 0 4px 16px; padding: 0; }
        .notes li { margin-bottom: 2px; }

        /* Score legend */
        .skor-legend {
            font-size: 8px;
            margin-bottom: 6px;
        }
        .skor-legend table td {
            padding: 0 4px;
        }

        /* Tanda tangan — 3 kolom (ringkas agar muat 1 halaman) */
        .uji-org-print .sig-section { width: 100%; margin-top: 6px; page-break-inside: avoid; }
        .uji-org-print .sig-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .uji-org-print .sig-table td.sig-box {
            vertical-align: bottom;
            text-align: center;
            width: 33.33%;
            padding: 2px 4px;
        }
        .uji-org-print .sig-label { margin: 0; font-size: 9px; }
        .uji-org-print .sig-sub { margin: 0 0 4px; font-size: 8px; font-weight: bold; line-height: 1.2; }
        .uji-org-print .sig-name {
            font-size: 9px;
            margin: 4px auto 0;
            padding-top: 4px;
            border-top: 1px solid #000;
            display: inline-block;
            min-width: 85%;
            max-width: 260px;
            line-height: 1.25;
        }
        .uji-org-print .sig-space { min-height: 40px !important; margin-bottom: 2px !important; }
        .uji-org-print .sig-space img { max-height: 40px !important; max-width: 120px !important; }
    </style>
    <?= view('layout/print_signatures_style') ?>
</head>
<body onload="window.print()">

    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; background: #1a1a2e; color: #fff; border: none; border-radius: 5px;">Cetak formulir</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; margin-left: 10px; border-radius: 5px;">Tutup</button>
    </div>

    <div class="page-container uji-org-print">

        <!-- HEADER (mode ringkas untuk PDF) -->
        <?= view('layout/print_header', ['compact_print_header' => true]) ?>

        <div class="title-main">CHECKLIST UJI ORGANOLEPTIK</div>

        <!-- INFO FIELDS -->
        <table class="info-table">
            <tr>
                <td class="label">Nama Pemeriksa</td>
                <td class="colon">:</td>
                <td><?= esc($header['nama_pemeriksa']) ?></td>
            </tr>
            <tr>
                <td class="label">Tempat Pemeriksaan</td>
                <td class="colon">:</td>
                <td><?= esc($header['tempat_pemeriksaan']) ?></td>
            </tr>
            <tr>
                <td class="label">Nama Tempat Pemeriksa</td>
                <td class="colon">:</td>
                <td><?= esc($header['nama_tempat']) ?></td>
            </tr>
            <tr>
                <td class="label">Tanggal Pemeriksaan</td>
                <td class="colon">:</td>
                <td><?= format_date_id($header['tanggal_pemeriksaan'] ?? null) ?></td>
            </tr>
            <tr>
                <td class="label">Waktu Pemeriksaan</td>
                <td class="colon">:</td>
                <td><?= esc($header['waktu_pemeriksaan']) ?></td>
            </tr>
        </table>

        <!-- DATA TABLE -->
        <table class="data-table dark-header">
            <thead>
                <tr>
                    <th rowspan="2" width="30">No</th>
                    <th rowspan="2">Nama Makan</th>
                    <th colspan="4">Hasil Pemeriksaan<br><small>(diberi skor 1-5)</small></th>
                    <th rowspan="2" width="100">Waktu Uji</th>
                    <th rowspan="2" width="100">keterangan</th>
                </tr>
                <tr>
                    <th width="50">Rasa</th>
                    <th width="50">Warna</th>
                    <th width="55">Aroma</th>
                    <th width="55">Tekstur</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $count = count($items);
                $rows = max(3, $count);
                for ($i = 0; $i < $rows; $i++): 
                    $hasItem = isset($items[$i]);
                ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td style="text-align: left;"><?= $hasItem ? esc($items[$i]['nama_makan']) : '&nbsp;' ?></td>
                    <td><?= $hasItem ? $items[$i]['skor_rasa'] : '' ?></td>
                    <td><?= $hasItem ? $items[$i]['skor_warna'] : '' ?></td>
                    <td><?= $hasItem ? $items[$i]['skor_aroma'] : '' ?></td>
                    <td><?= $hasItem ? $items[$i]['skor_tekstur'] : '' ?></td>
                    <td><?= esc($hasItem ? ($items[$i]['waktu_uji'] ?? '') : '') ?></td>
                    <td style="text-align: left;"><?= $hasItem ? esc($items[$i]['keterangan'] ?? '') : '' ?></td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>

        <!-- NOTES -->
        <div class="notes">
            <p><strong>Catatan:</strong></p>
            <ol>
                <li>Silakan dipilih salah satu untuk pengisian hasil pelaksanaan uji organoleptik (Sebelum Pengantaran/Saat Tiba di Lokasi/Sebelum dikonsumsi)</li>
                <li>Form dibawa oleh sopir untuk diberikan ke penanggung jawab program MBG dan diambil kembali bersamaan dengan pengambilan ompreng MBG, dan dibawa Kembali ke SPPG.</li>
            </ol>
        </div>

        <!-- SCORE LEGEND -->
        <div class="skor-legend">
            <p><strong>Skor :</strong></p>
            <table>
                <tr>
                    <td width="100">Sangat baik</td><td width="30">: 5</td>
                    <td width="80">Kurang</td><td>: 2</td>
                </tr>
                <tr>
                    <td>Baik</td><td>: 4</td>
                    <td>Tidak baik</td><td>: 1</td>
                </tr>
                <tr>
                    <td>Cukup</td><td>: 3</td>
                    <td></td><td></td>
                </tr>
            </table>
        </div>

        <!-- SIGNATURE BLOCK -->
        <div class="sig-section">
            <table class="sig-table">
                <tbody>
                <tr>
                    <td class="sig-box">
                        <p class="sig-label">Mengetahui,</p>
                        <p class="sig-sub">Asisten Lapangan</p>
                        <div class="sig-space">
                            <?php if (($__sig = signature_data_uri_first($signature ?? [], 'ttd_aslap', 'ttd_kepala_sppg', 'ttd_ahli_gizi', 'ttd_akuntan')) !== ''): ?>
                                <img src="<?= $__sig ?>" alt="TTD">
                            <?php endif; ?>
                        </div>
                        <p class="sig-name">( <?= esc($header['nama_aslap']) ?> )</p>
                    </td>
                    <td class="sig-box">
                        <p class="sig-label">Pemeriksa,</p>
                        <p class="sig-sub">PLOK / PIC Sekolah</p>
                        <div class="sig-space">
                            <?php if (($__sig = signature_data_uri_first($signature ?? [], 'ttd_ahli_gizi', 'ttd_aslap', 'ttd_kepala_sppg', 'ttd_akuntan')) !== ''): ?>
                                <img src="<?= $__sig ?>" alt="TTD">
                            <?php endif; ?>
                        </div>
                        <p class="sig-name">( <?= esc($header['nama_pemeriksa_plok'] ?: '........................') ?> )</p>
                    </td>
                    <td class="sig-box">
                        <p class="sig-label">Menyetujui,</p>
                        <p class="sig-sub">Kepala SPPG</p>
                        <div class="sig-space">
                            <?php if (($__sig = signature_data_uri_first($signature ?? [], 'ttd_kepala_sppg', 'ttd_aslap', 'ttd_ahli_gizi', 'ttd_akuntan')) !== ''): ?>
                                <img src="<?= $__sig ?>" alt="TTD">
                            <?php endif; ?>
                        </div>
                        <p class="sig-name">( <?= esc($header['nama_kepala_sppg']) ?> )</p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 6px; font-size: 7px; color: #666; text-align: center; padding-top: 4px;">
            Dicetak: <?= date('d/m/Y H:i') ?>
        </div>

    </div>

</body>
</html>
