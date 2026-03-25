<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 13px; 
            color: #000; 
            background: #fff;
            margin: 0; padding: 20px;
        }
        
        .page-container {
            width: 750px;
            margin: 0 auto;
        }

        @media print {
            body { padding: 0; }
            .page-container { width: 100%; }
            .no-print { display: none !important; }
            .dark-header th { 
                background-color: #1a1a2e !important; 
                color: #fff !important; 
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
            }
        }

        .text-center { text-align: center; }
        
        /* Header with logo */
        .header-block {
            text-align: center;
            margin-bottom: 25px;
        }
        .header-block table {
            width: 100%;
        }
        .header-block h2 {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }
        .header-block h3 {
            font-size: 15px;
            font-weight: bold;
            margin: 0;
        }
        .header-block p {
            font-size: 11px;
            margin: 2px 0;
        }
        .header-block hr {
            border: none;
            border-top: 2px solid #000;
            margin: 8px 0;
        }

        .title-main {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            margin: 20px 0 25px;
            text-decoration: underline;
        }

        /* Info fields */
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 3px 0;
            font-size: 13px;
        }
        .info-table .label { width: 180px; }
        .info-table .colon { width: 15px; }

        /* Data table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 5px 6px;
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
            font-size: 12px;
            margin-bottom: 15px;
        }
        .notes p { margin: 3px 0; }
        .notes ol { margin: 5px 0 10px 20px; padding: 0; }
        .notes li { margin-bottom: 5px; }

        /* Score legend */
        .skor-legend {
            font-size: 12px;
            margin-bottom: 30px;
        }
        .skor-legend table td {
            padding: 2px 5px;
        }

        /* Signature block */
        .sig-block {
            width: 100%;
            margin-top: 30px;
        }
        .sig-block td {
            vertical-align: top;
            text-align: center;
            width: 33.33%;
            padding: 5px;
        }
        .sig-name {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 180px;
            padding-bottom: 2px;
            margin-top: 70px;
        }
        .sig-role {
            font-weight: bold;
            margin-bottom: 0;
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; background: #1a1a2e; color: #fff; border: none; border-radius: 5px;">Cetak formulir</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; margin-left: 10px; border-radius: 5px;">Tutup</button>
    </div>

    <div class="page-container">

        <!-- HEADER -->
        <div class="header-block">
            <table>
                <tr>
                    <td width="120" style="text-align: center; vertical-align: middle;">
                        <img src="<?= base_url('bgn.png') ?>" alt="Logo BGN" style="width: 100px; height: auto;">
                    </td>
                    <td style="text-align: center;">
                        <h2>SPPG BUNAR SUKAMULYA</h2>
                        <h3>YAYASAN BUMI PANGAN INDONESIA</h3>
                        <p>KP. BEJI No.001, RT.004, Bunar, Kec. Sukamulya, Kabupaten Tangerang, Banten</p>
                        <p>15610</p>
                    </td>
                    <td width="120" style="text-align: center; vertical-align: middle;">
                        <img src="<?= base_url('yayasan.png') ?>" alt="Logo Yayasan" style="width: 95px; height: auto;">
                    </td>
                </tr>
            </table>
            <hr>
        </div>

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
                <td><?= date('d/m/Y', strtotime($header['tanggal_pemeriksaan'])) ?></td>
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
                    <th rowspan="2" width="130"><?= esc($header['waktu_uji']) ?></th>
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
                $rows = max(5, $count);
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
                    <td></td>
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
        <?php 
        $months = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $tgl = date('d', strtotime($header['tanggal_pemeriksaan']));
        $bln = $months[(int)date('m', strtotime($header['tanggal_pemeriksaan']))];
        $thn = date('Y', strtotime($header['tanggal_pemeriksaan']));
        ?>

        <div style="text-align: right; margin-bottom: 5px;">
            Tangerang, &nbsp;&nbsp; <?= $bln ?> <?= $thn ?>
        </div>

        <table class="sig-block">
            <tr>
                <td>
                    <p>Mengetahui</p>
                    <p class="sig-role">Asisten Lapangan</p>
                    <div style="height: 70px; display: flex; align-items: end; justify-content: center;">
                        <?php if (!empty($signature['ttd_aslap'])): ?>
                            <img src="<?= base_url('uploads/signatures/' . $signature['ttd_aslap']) ?>" style="max-height: 60px; max-width: 150px; object-fit: contain;">
                        <?php endif; ?>
                    </div>
                    <span class="sig-name">( <?= esc($header['nama_aslap']) ?> )</span>
                </td>
                <td>
                    <p>Pemeriksa</p>
                    <p class="sig-role">PLOK / PIC Sekolah</p>
                    <div style="height: 70px;"></div>
                    <span class="sig-name">( <?= esc($header['nama_pemeriksa_plok'] ?: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;') ?> )</span>
                </td>
            </tr>
        </table>

        <div style="text-align: center; margin-top: 30px;">
            <p class="sig-role">Kepala SPPG</p>
            <div style="height: 70px; display: flex; align-items: end; justify-content: center;">
                <?php if (!empty($signature['ttd_kepala_sppg'])): ?>
                    <img src="<?= base_url('uploads/signatures/' . $signature['ttd_kepala_sppg']) ?>" style="max-height: 60px; max-width: 150px; object-fit: contain;">
                <?php endif; ?>
            </div>
            <span class="sig-name">(<?= esc($header['nama_kepala_sppg']) ?>)</span>
        </div>

    </div>

</body>
</html>
