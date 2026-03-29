<?php
/**
 * Standardized Print Header for SPPG Management System
 * Displays official logos (BGN & Yayasan) and SPPG details.
 */
$sppg_nama   = session()->get('sppg_nama') ?? 'BUNAR SUKAMULYA';
$sppg_alamat = session()->get('sppg_alamat') ?? 'Alamat Dapur SPPG';

// Ensure we don't have "SPPG" prefix twice
$display_nama = str_ireplace('SPPG ', '', $sppg_nama);
?>
<div class="header-block" style="margin-bottom: 20px;">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <!-- Left Logo: BGN -->
            <td width="110" style="text-align: left; vertical-align: middle;">
                <img src="<?= base_url('bgn.png') ?>" alt="Logo BGN" style="width: 90px; height: auto;">
            </td>
            
            <!-- Center Text: SPPG Details -->
            <td style="text-align: center; vertical-align: middle;">
                <h2 style="font-size: 18px; font-weight: 800; margin: 0; color: #000; letter-spacing: 0.5px; text-transform: uppercase;">
                    SPPG <?= esc($display_nama) ?>
                </h2>
                <h3 style="font-size: 14px; font-weight: 700; margin: 3px 0; color: #000; letter-spacing: 0.2px;">
                    YAYASAN BUMI PANGAN INDONESIA
                </h3>
                <p style="font-size: 10px; margin: 2px 0; color: #444; line-height: 1.2; font-style: italic;">
                    <?= esc($sppg_alamat) ?>
                </p>
            </td>
            
            <!-- Right Logo: Yayasan -->
            <td width="110" style="text-align: right; vertical-align: middle;">
                <img src="<?= base_url('yayasan.png') ?>" alt="Logo Yayasan" style="width: 85px; height: auto;">
            </td>
        </tr>
    </table>
    <div style="border-top: 3px solid #000; margin-top: 15px; margin-bottom: 2px;"></div>
    <div style="border-top: 1px solid #000; margin-bottom: 20px;"></div>
</div>
