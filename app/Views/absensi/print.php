<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Absensi <?= date('d/m/Y', strtotime($absensi['tanggal'])) ?></title>
    <style>
        @page { size: A4 portrait; margin: 1.5cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10pt; color: #333; }
        .header { width: 100%; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header td { vertical-align: middle; }
        .title { text-align: center; font-size: 14pt; font-weight: bold; text-transform: uppercase; margin: 20px 0; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 10px 15px; text-align: left; }
        table.data-table th { background-color: #f0f0f0; text-align: center; }
        .text-center { text-align: center !important; }
        
        .footer { margin-top: 50px; width: 100%; }
        .footer td { text-align: center; width: 50%; }
        .signature-box { height: 100px; }
    </style>
<?= view('layout/print_signatures_style') ?>
</head>
<body>
    <!-- HEADER -->
    <?= view('layout/print_header') ?>

    <div class="title">LAPORAN ABSENSI RELAWAN HARIAN</div>
    <p><strong>Hari / Tanggal :</strong> <?= date('l, d F Y', strtotime($absensi['tanggal'])) ?></p>

    <table class="data-table">
        <thead>
            <tr>
                <th width="40">No</th>
                <th>Nama Relawan</th>
                <th width="150">Divisi</th>
                <th width="100">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $idx => $item): ?>
                <tr>
                    <td class="text-center"><?= $idx + 1 ?></td>
                    <td><strong><?= esc($item['nama']) ?></strong></td>
                    <td style="text-transform: uppercase; font-size: 9pt;"><?= esc($item['divisi']) ?></td>
                    <td class="text-center" style="font-weight: bold; <?= $item['status'] == 'Hadir' ? 'color: green;' : 'color: red;' ?>">
                        <?= strtoupper($item['status']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="footer">
        <tr>
            <td>
                Mengetahui,<br>Kepala SPPG
                <div class="signature-box"></div>
                ____________________
            </td>
            <td>
                Tangerang, <?= date('d/m/Y', strtotime($absensi['tanggal'])) ?><br>Asisten Lapangan
                <div class="signature-box"></div>
                <strong><?= esc(session()->get('name')) ?></strong>
            </td>
        </tr>
    </table>

    <script>window.onload = function() { window.print(); }</script>
</body>
</html>
