<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #444; margin-bottom: 20px; padding-bottom: 10px; }
        .logo { width: 80px; height: auto; margin-bottom: 5px; }
        h2 { margin: 0; color: #000; text-transform: uppercase; }
        .info-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-table td { padding: 5px; }
        .content-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .content-table th, .content-table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .content-table th { background: #f0f0f0; }
        .signature-table { width: 100%; margin-top: 50px; }
        .signature-box { text-align: center; width: 33%; }
        .sig-space { height: 80px; }
        .status-ok { color: green; font-weight: bold; }
        .status-fail { color: red; font-weight: bold; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px; padding: 10px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
        <button onclick="window.print()" style="padding: 6px 16px; cursor: pointer; border-radius: 6px; border: 1px solid #6366f1; background: #6366f1; color: white; font-weight: 600;">Cetak PDF</button>
        <button onclick="window.close()" style="padding: 6px 16px; cursor: pointer; border-radius: 6px; border: 1px solid #cbd5e1; background: white; color: #64748b; font-weight: 600; margin-left: 8px;">Tutup</button>
    </div>
    <?= view('layout/print_header') ?>
    <hr style="border: none; border-top: 3px double #000; margin: 8px 0;">

    <table class="info-table">
        <tr>
            <td width="15%">Tanggal</td><td>: <?= date('d F Y', strtotime($header['tanggal'])) ?></td>
            <td width="15%">ID Form</td><td>: #SR-<?= str_pad($header['id'], 5, '0', STR_PAD_LEFT) ?></td>
        </tr>
    </table>

    <table class="content-table">
        <thead>
            <tr>
                <th width="10%">No</th>
                <th>Fasilitas / Peralatan</th>
                <th width="20%" style="text-align:center;">Status Kebersihan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $items = ['Lantai', 'Dinding', 'Meja Persiapan', 'Steamer', 'Chopper', 'Blender', 'Talenan', 'Pisau', 'Kompor', 'Rak Alat', 'Sink'];
            foreach ($items as $item): 
                $key = strtolower(str_replace(' ', '_', $item));
                $isClean = isset($fasilitas[$key]) && $fasilitas[$key] == '1';
            ?>
            <tr>
                <td style="text-align:center;"><?= $no++ ?></td>
                <td><?= $item ?></td>
                <td style="text-align:center;">
                    <span class="<?= $isClean ? 'status-ok' : 'status-fail' ?>">
                        <?= $isClean ? 'BERSIH' : 'KOTOR' ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="signature-table">
        <tr>
            <td class="signature-box">
                <p>Pelaksana</p>
                <div class="sig-space"></div>
                <p><strong>( <?= esc($header['nama_pelaksana']) ?> )</strong></p>
            </td>
            <td class="signature-box">
                <p>Mengetahui,</p>
                <?php if ($signature && $signature['image_data']): ?>
                    <img src="<?= $signature['image_data'] ?>" style="height:80px; width:auto;">
                <?php else: ?>
                    <div class="sig-space"></div>
                <?php endif; ?>
                <p><strong>( <?= esc($header['nama_pemeriksa']) ?> )</strong></p>
                <p><small>Ahli Gizi</small></p>
            </td>
        </tr>
    </table>

    <div style="margin-top:20px; font-size:10px; text-align:right;">
        Dicetak pada: <?= date('d/m/Y H:i') ?>
    </div>
</body>
</html>
