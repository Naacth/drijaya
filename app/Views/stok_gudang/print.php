<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            color: #fff; 
            background: #1a1a2e;
            margin: 0; padding: 20px;
        }
        .page-container { width: 750px; margin: 0 auto; background: #1a1a2e; padding: 20px; }

        @media print {
            body { padding: 0; background: #1a1a2e; }
            .page-container { width: 100%; }
            .no-print { display: none !important; }
            * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }

        .text-center { text-align: center; }

        .header-section { text-align: center; margin-bottom: 15px; }
        .header-section h3 { font-size: 14px; margin: 0; font-weight: bold; }
        .header-section p { margin: 3px 0; font-size: 12px; }

        .title-line { 
            text-align: center; 
            font-size: 14px; 
            font-weight: bold; 
            margin: 15px 0 5px; 
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .data-table th, .data-table td {
            border: 1px solid #555;
            padding: 5px 8px;
            text-align: center;
            font-size: 12px;
        }
        .data-table th {
            background-color: #2a2a4a;
            color: #fff;
            font-weight: bold;
        }
        .data-table td {
            background-color: #1a1a2e;
            color: #ddd;
        }
        .data-table td.name { text-align: left; }

        .sig-section { margin-top: 25px; text-align: center; }
        .sig-table { width: 100%; border-collapse: collapse; }
        .sig-table td {
            border: 1px solid #555;
            padding: 8px;
            text-align: center;
            vertical-align: top;
            color: #ddd;
            font-size: 11px;
        }
        .sig-space { height: 60px; }
        .sig-role { font-weight: bold; font-size: 11px; }
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
        $days = ['Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'];
        $hari = $days[date('l', strtotime($header['tanggal']))];
        $tgl = date('d', strtotime($header['tanggal']));
        $bln = (int)date('m', strtotime($header['tanggal']));
        $thn = date('Y', strtotime($header['tanggal']));
        ?>

        <!-- HEADER -->
        <table style="width: 100%; margin-bottom: 15px;">
            <tr>
                <td width="120" style="text-align: left; vertical-align: middle;">
                    <img src="<?= base_url('bgn.png') ?>" alt="Logo BGN" style="height: 100px; width: auto;">
                </td>
                <td style="text-align: center; color: #fff;">
                    <h3 style="font-size: 16px; margin: 0; font-weight: bold;">SPPG</h3>
                    <p style="margin: 3px 0; font-size: 14px;">( <?= esc($header['nama_sppg']) ?> )</p>
                </td>
                <td width="120" style="text-align: right; vertical-align: middle;">
                    <img src="<?= base_url('yayasan.png') ?>" alt="Logo Yayasan" style="height: 95px; width: auto;">
                </td>
            </tr>
        </table>

        <div class="title-line">STOCK BARANG DI GUDANG</div>
        <p class="text-center" style="margin-bottom: 15px;">HARI <?= $hari ?>,  TANGGAL <?= $tgl ?>  BULAN <?= $bln ?> TAHUN  <?= $thn ?></p>

        <!-- DATA TABLE -->
        <table class="data-table">
            <thead>
                <tr>
                    <th width="35">No</th>
                    <th>Nama produk</th>
                    <th width="100">Nama penerima</th>
                    <th width="80">Stock Awal</th>
                    <th width="80">Barang masuk</th>
                    <th width="80">Barang keluar</th>
                    <th width="80">Stok Akhir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td class="name"><?= esc($item['nama_produk']) ?></td>
                    <td><?= esc($item['nama_penerima'] ?? '') ?></td>
                    <td><?= esc($item['stok_awal'] ?? '') ?></td>
                    <td><?= esc($item['barang_masuk'] ?? '') ?></td>
                    <td><?= esc($item['barang_keluar'] ?? '') ?></td>
                    <td><?= esc($item['stok_akhir'] ?? '') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- SIGNATURE SECTION -->
        <div class="sig-section">
            <p style="font-weight: bold; margin-bottom: 10px;">Mengetahui,</p>
            <table class="sig-table">
                <tr>
                    <td>
                        <p class="sig-role">Pengawas produksi &amp; kualitas</p>
                        <div class="sig-space" style="display: flex; align-items: end; justify-content: center;">
                            <?php if (!empty($signature['ttd_ahli_gizi'])): ?>
                                <img src="<?= base_url('uploads/signatures/' . $signature['ttd_ahli_gizi']) ?>" style="max-height: 55px; max-width: 100%; object-fit: contain;">
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <p class="sig-role">Pengawas pengadaan bahan pangan</p>
                        <div class="sig-space" style="display: flex; align-items: end; justify-content: center;">
                            <?php if (!empty($signature['ttd_akuntan'])): ?>
                                <img src="<?= base_url('uploads/signatures/' . $signature['ttd_akuntan']) ?>" style="max-height: 55px; max-width: 100%; object-fit: contain;">
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <p class="sig-role">Kepala satuan pelayanan</p>
                        <div class="sig-space" style="display: flex; align-items: end; justify-content: center;">
                            <?php if (!empty($signature['ttd_kepala_sppg'])): ?>
                                <img src="<?= base_url('uploads/signatures/' . $signature['ttd_kepala_sppg']) ?>" style="max-height: 55px; max-width: 100%; object-fit: contain;">
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><p class="sig-role">AHLI GIZI</p></td>
                    <td><p class="sig-role">Akuntan</p></td>
                    <td><p class="sig-role">Kepala sppg</p></td>
                </tr>
            </table>
        </div>

    </div>

</body>
</html>
