<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('pembersihan-bak-sampah') ?>" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Pembersihan Bak Sampah</h4>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('pembersihan-bak-sampah/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger"><i class="bi bi-file-pdf me-1"></i> Cetak PDF</a>
        <a href="<?= site_url('pembersihan-bak-sampah/export-excel/' . $header['id']) ?>" class="btn btn-outline-success"><i class="bi bi-file-excel me-1"></i> Export Excel</a>
    </div>
</div>

<div class="container-fluid px-0">
    <div class="card shadow-sm border-0 col-lg-12">
        <div class="card-body">
            <div class="mb-3"><small class="text-muted d-block">Tanggal & Jam</small><strong><?= date('d/m/Y', strtotime($header['tanggal'])) ?> <?= $header['jam'] ?></strong></div>
            <div class="mb-3"><small class="text-muted d-block">Personil</small><strong><?= esc($header['nama_personil']) ?></strong></div>
            <div class="p-3 bg-light rounded"><small class="text-muted d-block">Keterangan</small><p class="mb-0"><?= nl2br(esc($header['keterangan'])) ?></p></div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
