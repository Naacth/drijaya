<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 13px; color: #000; background: #fff; margin: 0; padding: 20px; }
        .page-container { width: 750px; margin: 0 auto; }

        @media print {
            body { padding: 0; }
            .page-container { width: 100%; }
            .no-print { display: none !important; }
        }

        .text-center { text-align: center; }

        .title-section { text-align: center; margin-bottom: 15px; }
        .title-section h3 { font-size: 16px; font-weight: bold; margin: 0 0 3px; }
        .title-section p { font-size: 12px; margin: 2px 0; }

        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 2px 0; font-size: 13px; }
        .info-table .label { width: 160px; }
        .info-table .colon { width: 15px; }
        .info-table .dots { letter-spacing: 2px; }

        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 5px; font-size: 12px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 4px 6px; text-align: center; }
        .data-table th { background-color: #f5f5f5; font-weight: bold; }
        .data-table td.name { text-align: left; }

        .day-header { text-align: center; font-weight: bold; font-size: 12px; padding: 5px 0; border: 1px solid #000; border-bottom: none; background: #f9f9f9; }

        .sig-section { margin-top: 30px; }
        .sig-table { width: 100%; }
        .sig-table td { padding: 5px 10px; vertical-align: top; }
        .sig-name { border-bottom: 1px solid #000; display: inline-block; min-width: 180px; padding-bottom: 2px; margin-top: 60px; }
        .note { font-size: 11px; margin-top: 20px; }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; background: #333; color: #fff; border: none; border-radius: 5px;">Cetak</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; margin-left: 10px; border-radius: 5px;">Tutup</button>
    </div>

    <div class="page-container">

        <?php
        $months = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $tglAwal = date('d', strtotime($header['periode_awal']));
        $blnAwal = $months[(int)date('m', strtotime($header['periode_awal']))];
        $tglAkhir = date('d', strtotime($header['periode_akhir']));
        $blnAkhir = $months[(int)date('m', strtotime($header['periode_akhir']))];
        $thn = date('Y', strtotime($header['periode_akhir']));
        ?>

        <div class="header-block" style="margin-bottom: 20px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td width="120" style="text-align: center; vertical-align: middle; border: none;">
                        <img src="<?= base_url('bgn.png') ?>" alt="Logo BGN" style="width: 100px; height: auto;">
                    </td>
                    <td style="text-align: center; border: none;">
                        <h2 style="font-size: 16px; font-weight: bold; margin: 0;">SPPG BUNAR SUKAMULYA</h2>
                        <h3 style="font-size: 15px; font-weight: bold; margin: 0;">YAYASAN BUMI PANGAN INDONESIA</h3>
                        <p style="font-size: 11px; margin: 2px 0;"><?= esc(session()->get('sppg_alamat') ?? 'Alamat belum diatur') ?></p>
                        <p style="font-size: 11px; margin: 2px 0;">15610</p>
                    </td>
                    <td width="120" style="text-align: center; vertical-align: middle; border: none;">
                        <img src="<?= base_url('yayasan.png') ?>" alt="Logo Yayasan" style="width: 95px; height: auto;">
                    </td>
                </tr>
            </table>
            <hr style="border: none; border-top: 3px double #000; margin: 8px 0;">
        </div>

        <!-- INFO -->
        <table class="info-table">
            <tr><td class="label">Nama SPPG</td><td class="colon">:</td><td><?= esc($header['nama_sppg']) ?></td></tr>
            <tr><td class="label">Kelurahan/Desa</td><td class="colon">:</td><td><?= esc($header['kelurahan_desa']) ?></td></tr>
            <tr><td class="label">Kecamatan</td><td class="colon">:</td><td><?= esc($header['kecamatan']) ?></td></tr>
            <tr><td class="label">Kabupaten/Kota</td><td class="colon">:</td><td><?= esc($header['kabupaten_kota']) ?></td></tr>
            <tr><td class="label">Provinsi</td><td class="colon">:</td><td><?= esc($header['provinsi']) ?></td></tr>
        </table>

        <!-- TABLE HEADER -->
        <table class="data-table">
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Nama Bahan</th>
                    <th width="65">Satuan</th>
                    <th width="70">Stok Fisik</th>
                    <th width="75">Stok di Kartu</th>
                    <th width="60">Selisih</th>
                    <th width="100">Keterangan</th>
                </tr>
            </thead>
        </table>

        <?php foreach ($grouped_items as $dayNum => $items): ?>
        <!-- DAY SUB-HEADER -->
        <div class="day-header">HARI KE-<?= $dayNum ?></div>
        <table class="data-table" style="margin-top: 0;">
            <tbody>
                <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td width="30"><?= $i + 1 ?></td>
                    <td class="name"><?= esc($item['nama_bahan']) ?></td>
                    <td width="65"><?= esc($item['satuan'] ?? '') ?></td>
                    <td width="70"><?= esc($item['stok_fisik'] ?? '') ?></td>
                    <td width="75"><?= esc($item['stok_di_kartu'] ?? '') ?></td>
                    <td width="60"><?= esc($item['selisih'] ?? '') ?></td>
                    <td width="100" class="name"><?= esc($item['keterangan'] ?? '') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endforeach; ?>

        <!-- SIGNATURE -->
        <?php
        $tglSign = date('d', strtotime($header['periode_akhir']));
        $blnSign = $months[(int)date('m', strtotime($header['periode_akhir']))];
        $thnSign = date('Y', strtotime($header['periode_akhir']));
        ?>
        <div class="sig-section">
            <p style="text-align: right; margin-bottom: 10px;">............, .................... 20.....</p>

            <table class="sig-table">
                <tr>
                    <td width="50%">
                        <p>Mengetahui</p>
                        <p>Kepala SPPG,</p>
                        <div style="height: 60px; display: flex; align-items: end; padding-left: 20%;">
                            <?php if (!empty($signature['ttd_kepala_sppg'])): ?>
                                <img src="<?= base_url('uploads/signatures/' . $signature['ttd_kepala_sppg']) ?>" style="max-height: 55px; max-width: 150px; object-fit: contain;">
                            <?php endif; ?>
                        </div>
                        <p>(<?= esc($header['nama_kepala_sppg'] ?? '.....................') ?>)</p>
                    </td>
                    <td width="50%">
                        <p>&nbsp;</p>
                        <p>Akuntan SPPG,</p>
                        <div style="height: 60px; display: flex; align-items: end; padding-left: 20%;">
                            <?php if (!empty($signature['ttd_akuntan'])): ?>
                                <img src="<?= base_url('uploads/signatures/' . $signature['ttd_akuntan']) ?>" style="max-height: 55px; max-width: 150px; object-fit: contain;">
                            <?php endif; ?>
                        </div>
                        <p>(<?= esc($header['nama_akuntan'] ?? '.....................') ?>)</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="note">
            <p>Catatan penting:</p>
        </div>

    </div>

</body>
</html>
