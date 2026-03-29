<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 14px; 
            color: #000; 
            background: #fff;
            margin: 0; padding: 20px;
        }
        
        .page-container {
            width: 700px;
            margin: 0 auto;
        }

        @media print {
            body { padding: 0; }
            .page-container { width: 100%; }
            .no-print { display: none !important; }
        }

        .text-center { text-align: center; }
        .text-justify { text-align: justify; }
        .fw-bold { font-weight: bold; }
        
        .header-block {
            margin-bottom: 10px;
        }
        .header-block table { width: 100%; }
        .header-block h2 { font-size: 16px; font-weight: bold; margin: 0; }
        .header-block h3 { font-size: 15px; font-weight: bold; margin: 0; }
        .header-block p { font-size: 11px; margin: 2px 0; }
        .header-block hr { border: none; border-top: 3px double #000; margin: 8px 0; }

        .title-section {
            text-align: center;
            margin: 20px 0;
        }
        .title-section h3 { font-size: 16px; font-weight: bold; text-decoration: underline; margin: 0 0 5px; }
        .title-section p { font-size: 13px; margin: 0; }

        .body-text {
            text-align: justify;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-table td { padding: 3px 0; }
        .info-table .label { width: 250px; padding-left: 30px; }
        .info-table .colon { width: 15px; }

        .sig-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 40px;
        }
        .sig-table td {
            border: 1px solid #000;
            padding: 10px;
            vertical-align: top;
            width: 50%;
            text-align: center;
        }
        .sig-space { height: 100px; }
        .sig-name { 
            border-top: 1px solid #000; 
            display: inline-block; 
            min-width: 200px; 
            padding-top: 3px;
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; background: #333; color: #fff; border: none; border-radius: 5px;">Cetak Berita Acara</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; margin-left: 10px; border-radius: 5px;">Tutup</button>
    </div>

    <div class="page-container">

        <!-- HEADER -->
        <?= view('layout/print_header') ?>

        <!-- TITLE -->
        <div class="title-section">
            <h3>BERITA ACARA</h3>
            <p>No : <?= esc($header['no_surat']) ?></p>
        </div>

        <!-- BODY TEXT -->
        <div class="body-text">
            <p>Berita acara ini dibuat sebagai surat pernyataan kami sebagai penerima manfaat dari SPPG BUNAR SUKAMULYA yang bertanda tangan dibawah ini :</p>
        </div>

        <!-- INFO FIELDS -->
        <table class="info-table">
            <tr>
                <td class="label">Nama sekolah</td>
                <td class="colon">:</td>
                <td><?= esc($header['nama_sekolah']) ?></td>
            </tr>
            <tr>
                <td class="label">Nama penanggung jawab sekolah</td>
                <td class="colon">:</td>
                <td><?= esc($header['nama_pj_sekolah']) ?></td>
            </tr>
            <tr>
                <td class="label">Jam Kehilangan Ompreng</td>
                <td class="colon">:</td>
                <td><?= esc($header['jam_kehilangan']) ?></td>
            </tr>
            <tr>
                <td class="label">Jam Distribusi</td>
                <td class="colon">:</td>
                <td><?= esc($header['jam_distribusi']) ?></td>
            </tr>
        </table>

        <!-- PARAGRAPH -->
        <?php
        $months = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $tgl = date('d', strtotime($header['tanggal_kejadian']));
        $bln = $months[(int)date('m', strtotime($header['tanggal_kejadian']))];
        $thn = date('Y', strtotime($header['tanggal_kejadian']));
        ?>
        <div class="body-text" style="margin-top: 15px;">
            <p style="text-indent: 30px;">Bahwa pada tanggal <strong><?= $tgl ?></strong> bulan <strong><?= $bln ?></strong> tahun <strong><?= $thn ?></strong> memutuskan dan menetapkan bahwa telah kekurangan jumlah ompreng berjumlah <strong><?= $header['jumlah_ompreng_hilang'] ?></strong> <strong>Pcs</strong> dari jumlah awal <strong><?= $header['jumlah_awal'] ?></strong> <strong>menjadi</strong> <strong><?= $header['jumlah_akhir'] ?></strong>. Oleh karena itu kami selaku penerima manfaat dengan berita Acata ini menyampaikan <strong>Kehilangan Ompreng</strong> yang kedepannya akan menjadi laporan ke <strong>DAPUR SPPG BUNAR SUKAMULYA.</strong></p>
        </div>

        <!-- SIGNATURE TABLE -->
        <table class="sig-table">
            <tr>
                <td>Mengetahui</td>
                <td>Penanggung Jawab</td>
            </tr>
            <tr>
                <td>
                    <div class="sig-space">
                        <?php if (!empty($header['ttd_supir'])): ?>
                            <img src="<?= base_url($header['ttd_supir']) ?>" style="max-height: 80px;" alt="TTD Supir">
                        <?php endif; ?>
                    </div>
                </td>
                <td>
                    <div class="sig-space">
                        <?php if (!empty($header['ttd_pj_sekolah'])): ?>
                            <img src="<?= base_url($header['ttd_pj_sekolah']) ?>" style="max-height: 80px;" alt="TTD PJ Sekolah">
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    ( <?= esc($header['nama_supir'] ?? '') ?> )<br>
                    <small>Supir SPPG BUNAR SUKAMULYA</small>
                </td>
                <td>
                    ( <?= esc($header['nama_pj_sekolah']) ?> )<br>
                    <small>Penanggung Jawab Sekolah</small>
                </td>
            </tr>
        </table>

    </div>

</body>
</html>
