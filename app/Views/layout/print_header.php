<?php
/**
 * Header cetak: logo BGN + teks SPPG.
 *
 * @var bool $compact_print_header Mode ringkas untuk PDF (font/ margin lebih kecil, garis pemisah satu).
 */
$sppg_nama   = $override_nama   ?? session()->get('sppg_nama')   ?? 'BUNAR SUKAMULYA';
$sppg_alamat = $override_alamat ?? session()->get('sppg_alamat') ?? 'Alamat Dapur SPPG';

$display_nama = str_ireplace('SPPG ', '', $sppg_nama);
$__bgn        = public_asset_data_uri('bgn.png');
$compact      = isset($compact_print_header) && $compact_print_header;

if ($compact) {
    $logoW       = 62;
    $titleFs     = '15px';
    $addrFs      = '9px';
    $addrMargin  = '4px 0 0';
    $wrapMb      = '10px';
    $ruleMarginT = '8px';
    $ruleMb      = '10px';
    $ruleThick   = '2px';
} else {
    $logoW       = 90;
    $titleFs     = '18px';
    $addrFs      = '10px';
    $addrMargin  = '6px 0 2px';
    $wrapMb      = '20px';
    $ruleMarginT = '15px';
    $ruleMb      = '2px';
    $ruleThick   = '3px';
}
?>
<div class="print-header-wrap" style="margin-bottom: <?= $wrapMb ?>;">
    <table style="width: 100%; border-collapse: collapse; table-layout: fixed;">
        <tr>
            <td style="width: <?= $logoW + 18 ?>px; vertical-align: middle; text-align: left; padding: 0;">
                <img src="<?= $__bgn !== '' ? $__bgn : base_url('bgn.png') ?>" alt="Logo BGN" style="width: <?= $logoW ?>px; height: auto; display: block;">
            </td>
            <td style="vertical-align: middle; text-align: center; padding: 0 8px 0 12px;">
                <div style="font-size: <?= $titleFs ?>; font-weight: 800; margin: 0; color: #000; letter-spacing: 0.4px; text-transform: uppercase; line-height: 1.2;">
                    SPPG <?= esc($display_nama) ?>
                </div>
                <p style="font-size: <?= $addrFs ?>; margin: <?= $addrMargin ?>; color: #333; line-height: 1.35; font-style: italic;">
                    <?= esc($sppg_alamat) ?>
                </p>
            </td>
        </tr>
    </table>
    <?php if ($compact): ?>
    <div style="border-top: <?= $ruleThick ?> solid #000; margin-top: <?= $ruleMarginT ?>; margin-bottom: 0;"></div>
    <?php else: ?>
    <div style="border-top: <?= $ruleThick ?> solid #000; margin-top: <?= $ruleMarginT ?>; margin-bottom: <?= $ruleMb ?>;"></div>
    <div style="border-top: 1px solid #000; margin-bottom: 20px;"></div>
    <?php endif; ?>
</div>
