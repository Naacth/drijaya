<?php
$printBlankRoles = $printBlankRoles ?? ['aslap', 'admin', 'ahli_gizi', 'akuntan', 'pic', 'petugas'];
if (! isset($printBlankUrl) || $printBlankUrl === '') return;
if (! in_array((string) session()->get('role'), $printBlankRoles, true)) return;

$isInline = $isInline ?? false;
$wrapperClass = $printBlankWrapperClass ?? ($isInline ? 'd-inline-block' : 'mb-3');
?>
<div class="<?= esc($wrapperClass, 'attr') ?>">
    <a href="<?= site_url($printBlankUrl) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-danger rounded-pill shadow-sm px-3">
        <i class="bi bi-file-earmark-pdf me-1"></i> Cetak Form Kosong
    </a>
</div>
