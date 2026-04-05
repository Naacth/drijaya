<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('uji-cita-rasa') ?>" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Uji Cita Rasa</h4>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'uji-cita-rasa/export-pdf-blank', 'printBlankRoles' => ['ahli_gizi', 'admin', 'pic'], 'printBlankWrapperClass' => 'mb-0']) ?>
        <?php if (session()->get('role') === 'ahli_gizi'): ?>
        <a href="<?= site_url('uji-cita-rasa/edit/' . $header['id']) ?>" class="btn btn-warning"><i class="bi bi-pencil me-1"></i> Edit</a>
        <?php endif; ?>
        <a href="<?= site_url('uji-cita-rasa/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger"><i class="bi bi-file-pdf me-1"></i> Cetak PDF</a>
        <a href="<?= site_url('uji-cita-rasa/export-excel/' . $header['id']) ?>" class="btn btn-outline-success"><i class="bi bi-file-excel me-1"></i> Export Excel</a>
    </div>
</div>
<div class="row g-4 animate-in" style="animation-delay: 0.1s;">
    <div class="col-md-4">
        <div class="data-card h-100"><div class="card-header"><h6><i class="bi bi-info-circle me-2"></i>Info</h6></div>
            <div class="card-body p-4">
                <table class="table table-borderless table-sm mb-0">
                    <tr><td class="text-muted" width="130">Tanggal</td><td><?= date('d F Y', strtotime($header['tanggal'])) ?></td></tr>
                    <tr><td class="text-muted">Checker</td><td class="fw-bold"><?= esc($header['nama_checker']) ?></td></tr>
                    <tr><td class="text-muted">Chef</td><td><?= esc($header['nama_chef'] ?: '-') ?></td></tr>
                    <tr><td class="text-muted">Ahli Gizi</td><td><?= esc($header['nama_ahli_gizi'] ?: '-') ?></td></tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr><td class="text-muted">Diinput Oleh</td><td><?= esc($header['user_nama']) ?></td></tr>
                    <tr><td class="text-muted">Waktu Input</td><td><?= date('d/m/Y H:i', strtotime($header['created_at'])) ?></td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="data-card h-100"><div class="card-header"><h6><i class="bi bi-list-ul me-2"></i>Daftar Masakan</h6></div>
            <div class="table-responsive">
                <table class="table table-premium mb-0">
                    <thead><tr><th width="40">No</th><th>Nama Masakan</th><th>Gramasi Standar</th><th>Gramasi Real</th><th>Masalah</th><th>Penyelesaian</th></tr></thead>
                    <tbody>
                        <?php foreach ($items as $i => $item): ?>
                        <tr><td><?= $i + 1 ?></td><td class="fw-medium"><?= esc($item['nama_masakan']) ?></td><td><?= esc($item['gramasi_standar'] ?: '-') ?></td><td><?= esc($item['gramasi_real'] ?: '-') ?></td><td><?= esc($item['masalah'] ?: '-') ?></td><td><?= esc($item['penyelesaian'] ?: '-') ?></td></tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
