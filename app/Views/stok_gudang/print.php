<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        @page { size: A4; margin: 12mm; }
        body { 
            font-family: Arial, sans-serif; 
            font-size: 11px; 
            color: #000; 
            background: #fff;
            margin: 0; padding: 20px;
            box-sizing: border-box;
        }
        .page-container { width: 100%; max-width: 780px; margin: 0 auto; background: #fff; padding: 12px; }

        @media print {
            body { padding: 0; background: #fff; }
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
            table-layout: fixed;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            text-align: center;
            font-size: 10px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .data-table th {
            background-color: #f2f2f2;
            color: #000;
            font-weight: bold;
        }
        .data-table td {
            background-color: #fff;
            color: #000;
        }
        .data-table td.name { text-align: left; }

        .sig-section { margin-top: 25px; text-align: center; }
        .sig-table { width: 100%; border-collapse: collapse; }
        .sig-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            vertical-align: top;
            color: #000;
            font-size: 11px;
        }
        .sig-space { height: 60px; }
        .sig-role { font-weight: bold; font-size: 11px; }
    </style>
<?= view('layout/print_signatures_style') ?>
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
        if (! empty($blank) || empty($header['tanggal'] ?? null)) {
            $hari = '...............';
            $tgl = '....';
            $bln = '....';
            $thn = '....';
        } else {
            $hari = $days[date('l', strtotime($header['tanggal']))];
            $tgl = date('d', strtotime($header['tanggal']));
            $bln = (int)date('m', strtotime($header['tanggal']));
            $thn = date('Y', strtotime($header['tanggal']));
        }
        ?>

        <div class="header-block" style="margin-bottom: 20px;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td width="110" style="text-align: left; vertical-align: middle; border: none;">
                        <?php $__logo = public_asset_data_uri('bgn.png'); ?>
                        <img src="<?= $__logo !== '' ? $__logo : base_url('bgn.png') ?>" alt="Logo BGN" style="width: 100px; height: auto;">
                    </td>
                    <td style="text-align: center; border: none;">
                        <h2 style="font-size: 16px; font-weight: bold; margin: 0; color: #000;">SPPG BUNAR SUKAMULYA</h2>
                        <p style="font-size: 11px; margin: 8px 2px 0; color: #000;"><?= esc(session()->get('sppg_alamat') ?? 'Alamat belum diatur') ?></p>
                        <p style="font-size: 11px; margin: 2px 0; color: #000;">15610</p>
                    </td>
                </tr>
            </table>
            <hr style="border: none; border-top: 3px double #000; margin: 8px 0;">
        </div>

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
                            <?php if (($__sig = signature_data_uri($signature ?? [], 'ttd_ahli_gizi')) !== ''): ?>
                                <img src="<?= $__sig ?>" alt="TTD" style="max-height: 55px; max-width: 100%; object-fit: contain;">
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <p class="sig-role">Pengawas pengadaan bahan pangan</p>
                        <div class="sig-space" style="display: flex; align-items: end; justify-content: center;">
                            <?php if (($__sig = signature_data_uri($signature ?? [], 'ttd_akuntan')) !== ''): ?>
                                <img src="<?= $__sig ?>" alt="TTD" style="max-height: 55px; max-width: 100%; object-fit: contain;">
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <p class="sig-role">Kepala satuan pelayanan</p>
                        <div class="sig-space" style="display: flex; align-items: end; justify-content: center;">
                            <?php if (($__sig = signature_data_uri($signature ?? [], 'ttd_kepala_sppg')) !== ''): ?>
                                <img src="<?= $__sig ?>" alt="TTD" style="max-height: 55px; max-width: 100%; object-fit: contain;">
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
