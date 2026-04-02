<style id="print-signatures-standard">
/*
 * Standar blok TTD untuk cetak / Simpan sebagai PDF:
 * gambar tidak membesar memenuhi halaman; kolom sejajar vertikal bawah.
 */
@media print {
    .no-print,
    .no-print * {
        display: none !important;
        visibility: hidden !important;
    }
    #debug-bar,
    #debug-icon,
    #debug-icon-link,
    .debug-bar-ndisplay {
        display: none !important;
        visibility: hidden !important;
    }
}
.sig-section { page-break-inside: avoid; }
.sig-table { table-layout: fixed; }
.sig-table > tbody > tr > td,
.signature-table td { vertical-align: bottom; }
.sig-box { box-sizing: border-box; }
.sig-space {
    min-height: 56px;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    margin: 0 auto 6px;
    max-width: 220px;
    box-sizing: border-box;
}
.sig-table .sig-space,
.signature-table .sig-space {
    margin-left: auto;
    margin-right: auto;
}
.sig-space img,
.sig-table img,
.signature-table img,
td.signature-box img {
    max-height: 52px !important;
    max-width: 165px !important;
    width: auto !important;
    height: auto !important;
    object-fit: contain;
    display: block;
}
</style>
