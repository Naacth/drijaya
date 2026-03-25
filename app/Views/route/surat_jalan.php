<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        @media print {
            body { padding: 0; margin: 0; font-family: 'Times New Roman', Times, serif; }
            .page-break { page-break-after: always; }
            .no-print { display: none !important; }
        }
        
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 13px; 
            color: #000; 
            line-height: 1.3; 
            background: #fdfdfd;
        }
        
        .page-container {
            width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        @media print {
            .page-container {
                width: 100%;
                margin: 0;
                padding: 10px 20px;
                box-shadow: none;
            }
        }

        /* HEADER */
        .header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header-logo {
            width: 80px;
            height: 80px;
            background: #eee;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            text-align: center;
            border: 1px solid #000;
        }
        .header-text {
            flex: 1;
            text-align: center;
        }
        .header-text h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .header-text h3 {
            margin: 0;
            font-size: 16px;
            font-weight: normal;
        }

        .title-box {
            text-align: center;
            margin-bottom: 20px;
        }
        .title-box h4 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* INFO SECTION */
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .kepada-box {
            width: 50%;
        }
        .kepada-box p {
            margin: 0;
            font-size: 14px;
        }
        .detail-table {
            border-collapse: collapse;
            width: 40%;
            font-size: 12px;
        }
        .detail-table td {
            border: 1px solid #000;
            padding: 4px 8px;
        }
        .detail-table td:first-child {
            width: 120px;
        }

        /* MAIN TABLE */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            text-align: center;
        }
        .main-table th, .main-table td {
            border: 1px solid #000;
            padding: 6px;
        }
        .main-table th {
            font-weight: normal;
            vertical-align: middle;
        }
        .border-bottom-0 { border-bottom: 0 !important; }
        .text-start { text-align: left; }

        /* SIGNATURES */
        .signatures {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            margin-top: 20px;
        }
        .signatures th, .signatures td {
            border: 1px solid #000;
            padding: 5px;
            width: 25%;
            vertical-align: bottom;
        }
        .signatures th {
            font-weight: normal;
            border-bottom: none;
        }
        .sig-space {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sig-space img {
            max-height: 60px;
            max-width: 120px;
            object-fit: contain;
        }
        .sig-name {
            border-top: none;
            padding-top: 0 !important;
        }
        .sig-name span {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 80%;
            padding-bottom: 2px;
        }

    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="text-align: center; margin: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Cetak Sekarang</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; margin-left: 10px;">Tutup</button>
    </div>

    <?php 
    $hari = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
    $namaHari = $hari[date('l', strtotime($header['tanggal']))];
    $tanggalIndo = date('d/m/Y', strtotime($header['tanggal']));
    ?>

    <?php foreach ($items as $index => $item): ?>
    <div class="page-container <?= $index !== count($items) - 1 ? 'page-break' : '' ?>">
        
        <!-- HEADER -->
        <div class="header">
            <div class="header-logo">
                <strong>BADAN GIZI<br>NASIONAL</strong>
            </div>
            <div class="header-text">
                <h2>BADAN GIZI NASIONAL - SATUAN PELAYANAN PEMENUHAN GIZI</h2>
                <h3>SPPG <?= strtoupper($header['sppg']) ?></h3>
            </div>
        </div>

        <div class="title-box">
            <h4>SURAT JALAN / DELIVERY ORDER</h4>
            <h4>PROGRAM MAKAN BERGIZI GRATIS (MBG)</h4>
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
                    <th rowspan="2" width="40">No</th>
                    <th rowspan="2" width="120">Kategori</th>
                    <th rowspan="2" width="100">Jumlah Porsi</th>
                    <th colspan="3">Jumlah Alat Makan</th>
                    <th rowspan="2">Keterangan</th>
                </tr>
                <tr>
                    <th width="80">Sebelum</th>
                    <th width="80">Sesudah</th>
                    <th width="80">Sisa</th>
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
        <table class="signatures">
            <tr>
                <th>Dibuat</th>
                <th>Diperiksa</th>
                <th>Diketahui</th>
                <th>Penerima</th>
            </tr>
            <tr>
                <td style="border-top: none; border-bottom: none;">
                    <div class="sig-space">
                        <?php if(!empty($signature['ttd_akuntan'])): ?>
                            <img src="<?= base_url('uploads/signatures/' . $signature['ttd_akuntan']) ?>" alt="ttd">
                        <?php endif; ?>
                    </div>
                </td>
                <td style="border-top: none; border-bottom: none;">
                    <div class="sig-space">
                        <?php if(!empty($signature['ttd_ahli_gizi'])): ?>
                            <img src="<?= base_url('uploads/signatures/' . $signature['ttd_ahli_gizi']) ?>" alt="ttd">
                        <?php endif; ?>
                    </div>
                </td>
                <td style="border-top: none; border-bottom: none;">
                    <div class="sig-space">
                        <?php if(!empty($signature['ttd_kepala_dapur'])): ?>
                            <img src="<?= base_url('uploads/signatures/' . $signature['ttd_kepala_dapur']) ?>" alt="ttd">
                        <?php endif; ?>
                    </div>
                </td>
                <td style="border-top: none; border-bottom: none;">
                    <div class="sig-space"></div>
                </td>
            </tr>
            <tr>
                <td class="sig-name">
                    <span><?= esc($signature['nama_akuntan']) ?></span>
                </td>
                <td class="sig-name">
                    <span><?= esc($signature['nama_ahli_gizi']) ?></span>
                </td>
                <td class="sig-name">
                    <span><?= esc($signature['nama_kepala_dapur']) ?></span>
                </td>
                <td class="sig-name">
                    <span></span>
                </td>
            </tr>
        </table>

    </div>
    <?php endforeach; ?>

</body>
</html>
