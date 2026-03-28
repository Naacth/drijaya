<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('pembersihan-lantai') ?>" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Pembersihan Lantai</h4>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('pembersihan-lantai/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger"><i class="bi bi-file-pdf me-1"></i> Cetak PDF</a>
        <a href="<?= site_url('pembersihan-lantai/export-excel/' . $header['id']) ?>" class="btn btn-outline-success"><i class="bi bi-file-excel me-1"></i> Export Excel</a>
    </div>
</div>

<div class="container-fluid px-0">
    <div class="card shadow-sm border-0 col-lg-12">
        <div class="card-body">
            <div class="mb-3 text-center p-4">
                <div class="display-6"><i class="bi bi-layers text-primary"></i></div>
                <h4 class="mt-2"><?= $header['kondisi'] ?></h4>
                <small class="text-muted">Kondisi lantai pada saat pengecekan</small>
            </div>
            <div class="row border-top pt-3">
                <div class="col-6"><small class="text-muted">Tanggal</small><div class="fw-bold"><?= date('d M Y', strtotime($header['tanggal'])) ?></div></div>
                <div class="col-6"><small class="text-muted">Jam</small><div class="fw-bold"><?= $header['jam'] ?></div></div>
            </div>
            <div class="mt-3"><small class="text-muted">Personil Pelaksana</small><div class="fw-bold"><?= esc($header['nama_personil']) ?></div></div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
