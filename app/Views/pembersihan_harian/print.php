<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding: 10px; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 6px; }
        .sig-table { width: 100%; border:none; margin-top: 30px; }
        .sig-cell { text-align: center; border:none; }
        .badge { font-weight: bold; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="text-align: center; margin-bottom: 20px; padding: 10px; background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
        <button onclick="window.print()" style="padding: 6px 16px; cursor: pointer; border-radius: 6px; border: 1px solid #6366f1; background: #6366f1; color: white; font-weight: 600;">Cetak PDF</button>
        <button onclick="window.close()" style="padding: 6px 16px; cursor: pointer; border-radius: 6px; border: 1px solid #cbd5e1; background: white; color: #64748b; font-weight: 600; margin-left: 8px;">Tutup</button>
    </div>
    <div class="header-block" style="position: relative; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px;">
        <img src="<?= base_url('bgn.png') ?>" style="position: absolute; left: 0; top: 0; height: 80px;">
        <div style="text-align: center;">
            <h2 style="margin: 0; font-size: 18px;">BADAN GIZI NASIONAL</h2>
            <h3 style="margin: 5px 0; font-size: 16px;">SPPG MANAGEMENT SYSTEM</h3>
            <p style="margin: 0; font-size: 13px;"><?= esc(session()->get('sppg_alamat') ?? 'Alamat belum diatur oleh PIC') ?></p>
        </div>
    </div>

    <table class="table" style="border:none;">
        <tr style="border:none;">
            <td style="border:none; width: 50%;">Tanggal: <?= date('d/m/Y', strtotime($header['tanggal'])) ?></td>
            <td style="border:none; text-align: right;">Unit: <strong><?= strtoupper($header['unit_type']) ?></strong></td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr style="background:#f0f0f0;">
                <th width="10%">No</th>
                <th>Area / Komponen</th>
                <th width="20%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($area as $k => $v): 
            ?>
            <tr>
                <td style="text-align:center;"><?= $no++ ?></td>
                <td style="text-transform: capitalize;"><?= str_replace('_', ' ', $k) ?></td>
                <td style="text-align:center;"><?= $v == '1' ? 'BERSIH' : 'KOTOR' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="sig-table">
        <tr>
            <td class="sig-cell" width="50%">
                <p>Petugas Pelaksana,</p>
                <div style="height:60px;"></div>
                <p><strong>( <?= esc($header['nama_petugas']) ?> )</strong></p>
            </td>
            <td class="sig-cell">
                <p>Ahli Gizi / Verifikator,</p>
                <?php if ($signature && $signature['image_data']): ?>
                    <img src="<?= $signature['image_data'] ?>" height="60">
                <?php else: ?>
                    <div style="height:60px;"></div>
                <?php endif; ?>
                <p><strong>( <?= esc($header['nama_verifikator']) ?> )</strong></p>
            </td>
        </tr>
    </table>
</body>
</html>
