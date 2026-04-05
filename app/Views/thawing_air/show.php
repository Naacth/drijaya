<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('thawing-air') ?>" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Thawing Air</h4>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'thawing-air/export-pdf-blank', 'printBlankRoles' => ['ahli_gizi', 'admin', 'pic'], 'printBlankWrapperClass' => 'mb-0']) ?>
        <?php if (session()->get('role') === 'ahli_gizi'): ?>
        <a href="<?= site_url('thawing-air/edit/' . $header['id']) ?>" class="btn btn-warning"><i class="bi bi-pencil me-1"></i> Edit</a>
        <?php endif; ?>
        <a href="<?= site_url('thawing-air/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger"><i class="bi bi-file-pdf"></i></a>
        <a href="<?= site_url('thawing-air/export-excel/' . $header['id']) ?>" class="btn btn-outline-success"><i class="bi bi-file-excel"></i></a>
    </div>
</div>
<div class="row g-4 animate-in" style="animation-delay: 0.1s;">
    <div class="col-md-4">
        <div class="data-card h-100"><div class="card-header"><h6><i class="bi bi-info-circle me-2"></i>Info</h6></div>
            <div class="card-body p-4">
                <table class="table table-borderless table-sm mb-0">
                    <tr><td class="text-muted" width="130">Tanggal</td><td>: <?= date('d/m/Y', strtotime($header['tanggal'])) ?></td></tr>
                    <tr><td class="text-muted">Petugas</td><td class="fw-bold">: <?= esc($header['nama_petugas']) ?></td></tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr><td class="text-muted">Diinput Oleh</td><td>: <?= esc($header['user_nama']) ?></td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="data-card h-100"><div class="card-header"><h6><i class="bi bi-list-ul me-2"></i>Daftar Bahan Thawing</h6></div>
            <div class="table-responsive">
                <table class="table table-premium mb-0">
                    <thead><tr><th width="40">No</th><th>Nama Bahan</th><th>Jumlah</th><th>Suhu Air (°C)</th><th>Waktu Thawing</th></tr></thead>
                    <tbody>
                        <?php foreach ($items as $i => $item): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td class="fw-medium"><?= esc($item['nama_bahan']) ?></td>
                            <td><?= esc($item['jumlah'] ?: '-') ?></td>
                            <td class="fw-bold"><?= esc($item['suhu_air'] ?: '-') ?> °C</td>
                            <td><?= esc($item['waktu_thawing'] ?: '-') ?> Jam</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
