<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('suhu-chiller-freezer') ?>" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Suhu Chiller & Freezer</h4>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'suhu-chiller-freezer/export-pdf-blank', 'printBlankRoles' => ['ahli_gizi', 'admin', 'pic'], 'printBlankWrapperClass' => 'mb-0']) ?>
        <?php if (session()->get('role') === 'ahli_gizi'): ?>
        <a href="<?= site_url('suhu-chiller-freezer/edit/' . $header['id']) ?>" class="btn btn-warning"><i class="bi bi-pencil me-1"></i> Edit</a>
        <?php endif; ?>
        <a href="<?= site_url('suhu-chiller-freezer/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger"><i class="bi bi-file-pdf"></i></a>
        <a href="<?= site_url('suhu-chiller-freezer/export-excel/' . $header['id']) ?>" class="btn btn-outline-success"><i class="bi bi-file-excel"></i></a>
    </div>
</div>
<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-body p-4">
        <div class="row mb-5">
            <div class="col-md-6">
                <h5>Tanggal: <?= date('d F Y', strtotime($header['tanggal'])) ?></h5>
                <p class="text-muted">Petugas: <span class="fw-bold text-dark"><?= esc($header['nama_petugas']) ?></span></p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-1">Kebersihan Rak: <span class="badge bg-primary"><?= esc($header['kebersihan_rak'] ?: '-') ?></span></p>
                <p>Verifikasi: <span class="badge bg-info"><?= esc($header['verifikasi'] ?: '-') ?></span></p>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-5">
                <div class="p-4 border border-primary rounded bg-white shadow-sm">
                    <h5 class="text-primary text-center border-bottom pb-2 mb-4"><i class="bi bi-thermometer-half"></i> UNIT CHILLER</h5>
                    <div class="d-flex justify-content-around text-center">
                        <div><small class="text-muted d-block uppercase">Pagi</small><h2 class="mb-0"><?= $header['chiller_pagi'] ?: '-' ?>°</h2></div>
                        <div class="border-start"></div>
                        <div><small class="text-muted d-block uppercase">Siang</small><h2 class="mb-0"><?= $header['chiller_siang'] ?: '-' ?>°</h2></div>
                        <div class="border-start"></div>
                        <div><small class="text-muted d-block uppercase">Malam</small><h2 class="mb-0"><?= $header['chiller_malam'] ?: '-' ?>°</h2></div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="p-4 border border-info rounded bg-white shadow-sm">
                    <h5 class="text-info text-center border-bottom pb-2 mb-4"><i class="bi bi-thermometer-snow"></i> UNIT FREEZER</h5>
                    <div class="d-flex justify-content-around text-center">
                        <div><small class="text-muted d-block uppercase">Pagi</small><h2 class="mb-0"><?= $header['freezer_pagi'] ?: '-' ?>°</h2></div>
                        <div class="border-start"></div>
                        <div><small class="text-muted d-block uppercase">Siang</small><h2 class="mb-0"><?= $header['freezer_siang'] ?: '-' ?>°</h2></div>
                        <div class="border-start"></div>
                        <div><small class="text-muted d-block uppercase">Malam</small><h2 class="mb-0"><?= $header['freezer_malam'] ?: '-' ?>°</h2></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
