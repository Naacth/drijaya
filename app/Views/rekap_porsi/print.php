<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        /* PDF Print Optimizations */
        @page {
            size: A4;
            margin: 1.5cm;
        }
        body { 
            font-family: Calibri, 'Times New Roman', serif; 
            font-size: 10px; 
            line-height: 1.3;
            color: #000; 
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .page-container { width: 100%; margin: 0 auto; }
        
        /* Header Styling */
        .header-block { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 15px; }
        .header-table { width: 100%; border-collapse: collapse; }
        .header-logo { width: 70px; }
        .header-text { text-align: center; }
        .header-text h2 { margin: 0; font-size: 16px; font-weight: bold; }
        .header-text h3 { margin: 1px 0; font-size: 12px; font-weight: normal; }
        .header-text p { margin: 0; font-size: 9px; color: #333; }
        
        .title-main { 
            text-align: center; 
            font-size: 14px; 
            font-weight: bold; 
            margin: 15px 0; 
            text-transform: uppercase;
            text-decoration: underline;
        }
        
        .header-info { font-size: 12px; font-weight: bold; margin-bottom: 10px; }
        .header-info span { font-weight: normal; border-bottom: 1px dotted #000; padding: 0 10px; }

        /* Table Data Styling */
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; table-layout: fixed; }
        .data-table th, .data-table td { 
            border: 1px solid #000; 
            padding: 6px 3px; 
            word-wrap: break-word;
            overflow-wrap: break-word;
            font-size: 9px;
            text-align: center;
        }
        .data-table th { background-color: #d9d9d9; font-weight: bold; }
        .text-left { text-align: left !important; padding-left: 5px !important; }
        
        /* Pastel Colors for Tingkatan */
        .bg-paud { background-color: #e2efda !important; } 
        .bg-tk { background-color: #fff2cc !important; } 
        .bg-sd13 { background-color: #ddebf7 !important; } 
        .bg-sd46 { background-color: #fce4d6 !important; } 
        .bg-mi13 { background-color: #e2f0d9 !important; } 
        .bg-mi46 { background-color: #d9e1f2 !important; } 
        .bg-smp { background-color: #f2f2f2 !important; } 
        .bg-mts { background-color: #fee6d2 !important; } 
        .bg-sma { background-color: #fff9e6 !important; } 

        /* Print Utilities */
        @media print { 
            .no-print { display: none !important; } 
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .data-table tr { page-break-inside: avoid; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="position: fixed; top: 20px; right: 20px; z-index: 9999; background: rgba(255,255,255,0.9); padding: 15px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border: 1px solid #e2e8f0;">
        <button onclick="window.print()" style="padding: 8px 20px; cursor: pointer; border-radius: 6px; border: 1px solid #6366f1; background: #6366f1; color: white; font-weight: 600;">Cetak PDF</button>
        <button onclick="window.close()" style="padding: 8px 20px; cursor: pointer; border-radius: 6px; border: 1px solid #cbd5e1; background: white; color: #64748b; font-weight: 600; margin-left: 8px;">Tutup</button>
    </div>

    <div class="page-container">

        <?php
        $days = ['Sunday'=>'MINGGU','Monday'=>'SENIN','Tuesday'=>'SELASA','Wednesday'=>'RABU','Thursday'=>'KAMIS','Friday'=>'JUMAT','Saturday'=>'SABTU'];
        $months = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $hari = $days[date('l', strtotime($header['tanggal']))];
        $tgl = date('d', strtotime($header['tanggal'])) . ' ' . $months[(int)date('m', strtotime($header['tanggal']))] . ' ' . date('Y', strtotime($header['tanggal']));
        ?>
        <?= view('layout/print_header') ?>

        <div class="title-main">REKAPITULASI DISTRIBUSI PORSI PM</div>
        <div class="header-info">Hari dan TGL: <span><?= $hari ?>, <?= $tgl ?></span></div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th style="width: 80px;">TINGKATAN</th>
                    <th>SEKOLAH / PENERIMA</th>
                    <th style="width: 60px;">JUMLAH PM</th>
                    <th style="width: 70px;">DISTRIBUSI</th>
                    <th style="width: 70px;">SISA PM</th>
                    <th>Keterangan</th>
                    <th>Pengalihan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($items as $i => $item): 
                    $bgClass = '';
                    switch ($item['tingkatan']) {
                        case 'PAUD': $bgClass = 'bg-paud'; break;
                        case 'TK': $bgClass = 'bg-tk'; break;
                        case 'SD 1-3': $bgClass = 'bg-sd13'; break;
                        case 'SD 4-6': $bgClass = 'bg-sd46'; break;
                        case 'MI 1-3': $bgClass = 'bg-mi13'; break;
                        case 'MI 4-6': $bgClass = 'bg-mi46'; break;
                        case 'SMP': $bgClass = 'bg-smp'; break;
                        case 'MTS': $bgClass = 'bg-mts'; break;
                        case 'SMA': $bgClass = 'bg-sma'; break;
                    }
                ?>
                <tr>
                    <td class="text-right"><?= $i + 1 ?></td>
                    <td class="<?= $bgClass ?> text-left" style="text-align: left; padding-left: 5px;"><?= esc($item['tingkatan']) ?></td>
                    <td class="<?= $bgClass ?> sekolah"><?= esc($item['sekolah']) ?></td>
                    <td class="<?= $bgClass ?> text-center font-weight-bold" style="font-weight: bold;"><?= $item['jumlah_pm'] ?></td>
                    <td class="text-center font-weight-bold" style="font-weight: bold;"><?= $item['jumlah_terdistribusi'] ?></td>
                    <td class="text-center font-weight-bold" style="font-weight: bold;"><?= $item['jumlah_tidak_terdistribusi'] ?: '' ?></td>
                    <td class="text-center"><?= esc($item['keterangan'] ?: '') ?></td>
                    <td class="text-center"><?= esc($item['pengalihan'] ?: '') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</body>
</html>
