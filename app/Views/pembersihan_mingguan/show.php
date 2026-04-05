<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('pembersihan-mingguan') ?>" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Pembersihan Mingguan</h4>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'pembersihan-mingguan/export-pdf-blank', 'printBlankRoles' => ['ahli_gizi', 'admin', 'pic'], 'printBlankWrapperClass' => 'mb-0']) ?>
        <?php if (session()->get('role') === 'ahli_gizi'): ?>
        <a href="<?= site_url('pembersihan-mingguan/edit/' . $header['id']) ?>" class="btn btn-warning"><i class="bi bi-pencil me-1"></i> Edit</a>
        <?php endif; ?>
        <a href="<?= site_url('pembersihan-mingguan/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger"><i class="bi bi-file-pdf me-1"></i> Cetak PDF</a>
        <a href="<?= site_url('pembersihan-mingguan/export-excel/' . $header['id']) ?>" class="btn btn-outline-success"><i class="bi bi-file-excel me-1"></i> Export Excel</a>
    </div>
</div>

<div class="container-fluid px-0">
    <div class="card shadow-sm border-0 col-lg-12">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4"><small class="text-muted">Unit</small><h5><?= esc($header['area_pencucian']) ?></h5></div>
                <div class="col-md-4"><small class="text-muted">Periode</small><h5>Minggu <?= $header['minggu_ke'] ?></h5></div>
                <div class="col-md-4"><small class="text-muted">Bulan</small><h5><?= $header['bulan'] ?></h5></div>
            </div>
            <div class="row g-2">
                <?php foreach($checklist as $k => $v): ?>
                <div class="col-md-6">
                    <div class="p-2 border rounded d-flex justify-content-between align-items-center bg-light">
                        <span class="text-capitalize small"><?= str_replace('_', ' ', $k) ?></span>
                        <span class="badge <?= $v == 'OK' ? 'bg-success' : 'bg-danger' ?>"><?= $v ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="mt-4 border-top pt-3 text-end">
                <small class="text-muted">Verifikator:</small><br><strong><?= esc($header['nama_verifikator']) ?></strong>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
