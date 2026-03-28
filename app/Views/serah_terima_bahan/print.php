<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 11px; margin: 0; padding: 20px; }
        .page-container { width: 100%; }
        .header-block { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header-block h2 { margin: 0; font-size: 16px; }
        .title-main { text-align: center; font-size: 14px; font-weight: bold; margin: 15px 0; text-decoration: underline; }
        .info-table { width: 100%; margin-bottom: 10px; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 4px; text-align: center; }
        .data-table th { background-color: #f2f2f2; }
        .sig-block { width: 100%; margin-top: 30px; }
        .sig-block td { text-align: center; width: 50%; }
        .sig-space { height: 60px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()">Cetak</button>
        <button onclick="window.close()">Tutup</button>
    </div>
    <div class="page-container">
        <div class="header-block" style="position: relative; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px;">
            <img src="<?= base_url('bgn.png') ?>" style="position: absolute; left: 0; top: 0; height: 80px;">
            <div style="text-align: center;">
                <h2 style="margin: 0; font-size: 18px;">BADAN GIZI NASIONAL</h2>
                <h3 style="margin: 5px 0; font-size: 16px;">SPPG MANAGEMENT SYSTEM</h3>
                <p style="margin: 0; font-size: 13px;"><?= esc(session()->get('sppg_alamat') ?? 'Alamat belum diatur oleh PIC') ?></p>
            </div>
        </div>
        <div class="title-main">FORMULIR SERAH TERIMA BAHAN BAKU</div>
        <table class="info-table">
            <tr><td width="100">Tanggal</td><td>: <?= date('d/m/Y', strtotime($header['tanggal'])) ?></td></tr>
            <tr><td>Pengirim</td><td>: <?= esc($header['nama_pengirim']) ?></td></tr>
            <tr><td>Penerima</td><td>: <?= esc($header['nama_penerima']) ?></td></tr>
        </table>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th><th>Jam</th><th>Nama Bahan</th><th>Tujuan</th><th>Gram/Ps</th><th>Awal</th><th>Tdk Layak</th><th>Tindak Lanjut</th><th>Akhir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= esc($item['jam']) ?></td>
                    <td style="text-align: left;"><?= esc($item['nama_bahan']) ?></td>
                    <td><?= esc($item['tujuan_penggunaan']) ?></td>
                    <td><?= esc($item['gramasi_per_porsi']) ?></td>
                    <td><?= esc($item['jumlah_awal']) ?></td>
                    <td><?= esc($item['jumlah_tidak_layak']) ?></td>
                    <td><?= esc($item['tindak_lanjut']) ?></td>
                    <td><?= esc($item['jumlah_akhir']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <table class="sig-block">
            <tr>
                <td><p>Yang Menyerahkan (Gudang/Logistik)</p><div class="sig-space"></div><p>( <?= esc($header['nama_pengirim']) ?> )</p></td>
                <td><p>Yang Menerima (Dapur/Chef)</p><div class="sig-space"></div><p>( <?= esc($header['nama_penerima']) ?> )</p></td>
            </tr>
        </table>
    </div>
</body>
</html>
