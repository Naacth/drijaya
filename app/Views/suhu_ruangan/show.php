<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('suhu-ruangan') ?>" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Suhu Ruangan</h4>
    </div>
    <div class="d-flex gap-2">
        <?php if (session()->get('role') === 'ahli_gizi'): ?>
        <a href="<?= site_url('suhu-ruangan/edit/' . $header['id']) ?>" class="btn btn-warning"><i class="bi bi-pencil me-1"></i> Edit</a>
        <?php endif; ?>
        <a href="<?= site_url('suhu-ruangan/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger"><i class="bi bi-file-pdf"></i></a>
        <a href="<?= site_url('suhu-ruangan/export-excel/' . $header['id']) ?>" class="btn btn-outline-success"><i class="bi bi-file-excel"></i></a>
    </div>
</div>
<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-body p-4">
        <div class="row align-items-center mb-4">
            <div class="col-md-6 text-center text-md-start">
                <h5 class="mb-1">Tanggal: <?= date('d F Y', strtotime($header['tanggal'])) ?></h5>
                <p class="text-muted mb-0">Petugas: <span class="text-dark fw-bold"><?= esc($header['nama_petugas']) ?></span></p>
            </div>
            <div class="col-md-6 text-md-end text-center mt-3 mt-md-0">
                <small class="text-muted d-block">Terakhir diupdate:</small>
                <strong><?= date('d/m/Y H:i', strtotime($header['created_at'])) ?></strong>
            </div>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="p-4 border rounded bg-white shadow-sm h-100">
                    <h6 class="text-primary fw-bold text-uppercase border-bottom pb-2 mb-3">Pagi</h6>
                    <div class="row">
                        <div class="col-6 border-end"><small class="text-muted d-block">Suhu</small><h2 class="mb-0"><?= $header['pagi_suhu'] ?: '-' ?>°</h2></div>
                        <div class="col-6"><small class="text-muted d-block">Lembap</small><h2 class="mb-0"><?= $header['pagi_kelembapan'] ?: '-' ?>%</h2></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded bg-white shadow-sm h-100">
                    <h6 class="text-warning fw-bold text-uppercase border-bottom pb-2 mb-3">Siang</h6>
                    <div class="row">
                        <div class="col-6 border-end"><small class="text-muted d-block">Suhu</small><h2 class="mb-0"><?= $header['siang_suhu'] ?: '-' ?>°</h2></div>
                        <div class="col-6"><small class="text-muted d-block">Lembap</small><h2 class="mb-0"><?= $header['siang_kelembapan'] ?: '-' ?>%</h2></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded bg-white shadow-sm h-100">
                    <h6 class="text-info fw-bold text-uppercase border-bottom pb-2 mb-3">Sore</h6>
                    <div class="row">
                        <div class="col-6 border-end"><small class="text-muted d-block">Suhu</small><h2 class="mb-0"><?= $header['sore_suhu'] ?: '-' ?>°</h2></div>
                        <div class="col-6"><small class="text-muted d-block">Lembap</small><h2 class="mb-0"><?= $header['sore_kelembapan'] ?: '-' ?>%</h2></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
