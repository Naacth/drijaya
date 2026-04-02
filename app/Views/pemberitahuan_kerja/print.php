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
        .page-container { width: 700px; margin: 0 auto; }

        @media print {
            body { padding: 0; }
            .page-container { width: 100%; }
            .no-print { display: none !important; }
        }

        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }

        .header-block { margin-bottom: 10px; }
        .header-block table { width: 100%; }
        .header-block h2 { font-size: 16px; font-weight: bold; margin: 0; }
        .header-block h3 { font-size: 15px; font-weight: bold; margin: 0; }
        .header-block p { font-size: 11px; margin: 2px 0; }
        .header-block hr { border: none; border-top: 3px double #000; margin: 8px 0; }

        .title-section { text-align: center; margin: 20px 0; }
        .title-section h3 { font-size: 16px; font-weight: bold; text-decoration: underline; margin: 0 0 3px; }
        .title-section p { font-size: 13px; margin: 2px 0; }

        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 3px 0; }
        .info-table .label { width: 260px; padding-left: 30px; }
        .info-table .colon { width: 15px; }

        .body-text { text-align: justify; line-height: 1.8; margin: 20px 0; }
        .note { font-style: italic; font-size: 13px; margin: 10px 0 25px; }

        .sig-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .sig-table td { border: 1px solid #000; padding: 10px; vertical-align: top; width: 50%; text-align: center; }
        .sig-space { height: 100px; }
        .sig-name { border-top: 1px solid #000; display: inline-block; min-width: 200px; padding-top: 3px; }

        .content-area {
            min-height: 200px;
            border: 1px solid #ccc;
            padding: 15px;
            margin: 15px 0;
            text-align: left;
        }
    </style>
<?= view('layout/print_signatures_style') ?>
</head>
<body onload="window.print()">

    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; background: #333; color: #fff; border: none; border-radius: 5px;">Cetak Form</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; margin-left: 10px; border-radius: 5px;">Tutup</button>
    </div>

    <div class="page-container">

        <!-- HEADER -->
        <?= view('layout/print_header') ?>

        <!-- TITLE -->
        <?php
        $months = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $days = ['Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'];
        $hari = $days[date('l', strtotime($header['tanggal']))];
        $tgl = date('d', strtotime($header['tanggal']));
        $bln = $months[(int)date('m', strtotime($header['tanggal']))];
        $thn = date('Y', strtotime($header['tanggal']));

        // Determine divisi labels
        $divisi = $header['divisi'];
        if (str_contains($divisi, 'SIF 1')) {
            $formSubtitle = 'Forumulir pemberitahuan PIC persiapan SIF 1 :';
            $sigLeftLabel = 'ANGGOTA PERSIAPAN SIF 1 SPPG BUNAR SUKAMULYA';
            $sigRightLabel = 'PIC PERSIAPAN SIF 1 SPPG BUNAR SUKAMULYA';
        } elseif (str_contains($divisi, 'SIF 2')) {
            $formSubtitle = 'Forumulir pemberitahuan PIC persiapan SIF 2 :';
            $sigLeftLabel = 'ANGGOTA PERSIAPAN SIF 2 SPPG BUNAR SUKAMULYA';
            $sigRightLabel = 'PIC PERSIAPAN SIF 2 SPPG BUNAR SUKAMULYA';
        } else {
            $formSubtitle = 'Forumulir pemberitahuan PIC Cooking :';
            $sigLeftLabel = 'ANGGOTA COOKING SPPG BUNAR SUKAMULYA';
            $sigRightLabel = 'PIC COOKING SPPG BUNAR SUKAMULYA';
        }
        ?>

        <div class="title-section">
            <h3>FORM PEMBERITAHUAN</h3>
            <p>No : <?= esc($header['no_surat']) ?></p>
            <p>Hari <?= $hari ?>..........Tanggal <?= $tgl ?>......Tahun <?= $thn ?>......</p>
        </div>

        <p style="margin: 15px 0 10px 20px;"><?= $formSubtitle ?></p>

        <!-- INFO FIELDS -->
        <table class="info-table">
            <tr>
                <td class="label">Nama PIC</td>
                <td class="colon">:</td>
                <td><?= esc($header['nama_pic']) ?></td>
            </tr>
            <tr>
                <td class="label">Jam Mulai</td>
                <td class="colon">:</td>
                <td><?= esc($header['jam_mulai']) ?></td>
            </tr>
            <tr>
                <td class="label">Jam Selesai</td>
                <td class="colon">:</td>
                <td><?= esc($header['jam_selesai']) ?></td>
            </tr>
            <tr>
                <td class="label">Keterangan jumlah item</td>
                <td class="colon">:</td>
                <td><?= nl2br(esc($header['keterangan_jumlah_item'] ?? '')) ?></td>
            </tr>
            <tr>
                <td class="label">Keterangan yang sudah dikerjakan</td>
                <td class="colon">:</td>
                <td><?= nl2br(esc($header['keterangan_dikerjakan'] ?? '')) ?></td>
            </tr>
        </table>

        <!-- CONTENT AREA (blank space for hand-writing, as per image) -->
        <div class="content-area">&nbsp;</div>

        <!-- BODY TEXT -->
        <div class="body-text">
            <p>Dengan adanya surat pemberitahuan ini diharapkan PIC dari setiap divisi dapat memberikan keterangan atas apa yang sudah dikerjakan dan di komunikasikan kepasa SIF selanjutnya atau Divisi selanjutnya yang akan mengambil alih pekerjaan, <strong>UTAMAKAN KOMUNIKASI.</strong></p>
        </div>

        <div class="note">
            <p><strong>*Form ini wajib di isi, dan dikembalikan kepada asisten lapangan</strong></p>
            <p><strong>(simpan di office jika sudah selesai)</strong></p>
        </div>

        <!-- SIGNATURE TABLE -->
        <table class="sig-table">
            <tr>
                <td>
                    Mengetahui,<br>
                    <strong><?= $sigLeftLabel ?></strong>
                </td>
                <td>
                    Penanggung Jawab<br>
                    <strong><?= $sigRightLabel ?></strong>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="sig-space">
                        <?php if (($__sig = public_asset_data_uri($header['ttd_anggota'] ?? null)) !== ''): ?>
                            <img src="<?= $__sig ?>" style="max-height: 80px;" alt="TTD">
                        <?php endif; ?>
                    </div>
                </td>
                <td>
                    <div class="sig-space">
                        <?php if (($__sig = public_asset_data_uri($header['ttd_pj'] ?? null)) !== ''): ?>
                            <img src="<?= $__sig ?>" style="max-height: 80px;" alt="TTD">
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>( <?= esc($header['nama_anggota'] ?? '') ?> )</td>
                <td>( <?= esc($header['nama_pj'] ?? '') ?> )</td>
            </tr>
        </table>

    </div>

</body>
</html>
