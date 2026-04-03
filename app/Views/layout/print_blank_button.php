<?php
/**
 * Tombol cetak form kosong (PDF). Set: $printBlankUrl (path, e.g. 'barang-datang/export-pdf-blank')
 * Opsional: $printBlankRoles — array role yang boleh melihat tombol (default umum modul internal).
 */
$printBlankRoles = $printBlankRoles ?? ['aslap', 'admin', 'ahli_gizi', 'akuntan', 'pic'];
if (! isset($printBlankUrl) || $printBlankUrl === '') {
    return;
}
if (! in_array((string) session()->get('role'), $printBlankRoles, true)) {
    return;
}
$wrapperClass = $printBlankWrapperClass ?? 'mb-0 mt-2';
?>
<div class="<?= esc($wrapperClass, 'attr') ?>">
    <a href="<?= site_url($printBlankUrl) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-file-earmark-pdf"></i> Cetak form kosong (PDF)
    </a>
</div>
