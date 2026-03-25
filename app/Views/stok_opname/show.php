<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('stok-opname') ?>" class="text-decoration-none text-muted mb-2 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Stok Opname</h4>
        <p class="text-muted small mb-0"><?= esc($header['nama_sppg']) ?> — <?= date('d/m/Y', strtotime($header['periode_awal'])) ?> s.d <?= date('d/m/Y', strtotime($header['periode_akhir'])) ?></p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('stok-opname/export-pdf/'.$header['id']) ?>" target="_blank" class="btn btn-outline-danger">
            <i class="bi bi-file-pdf me-1"></i> Cetak PDF
        </a>
        <a href="<?= site_url('stok-opname/export-excel/'.$header['id']) ?>" class="btn btn-outline-success">
            <i class="bi bi-file-excel me-1"></i> Export Excel
        </a>
    </div>
</div>

<?php foreach ($grouped_items as $dayNum => $items): ?>
<div class="data-card mb-4 animate-in" style="animation-delay: <?= 0.1 * $dayNum ?>s;">
    <div class="card-header"><h6><i class="bi bi-calendar-day me-2"></i>HARI KE-<?= $dayNum ?></h6></div>
    <div class="table-responsive">
        <table class="table table-premium mb-0">
            <thead>
                <tr>
                    <th width="40">No</th>
                    <th>Nama Bahan</th>
                    <th class="text-center" width="70">Satuan</th>
                    <th class="text-center" width="90">Stok Fisik</th>
                    <th class="text-center" width="90">Stok Kartu</th>
                    <th class="text-center" width="80">Selisih</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td class="fw-medium text-dark"><?= esc($item['nama_bahan']) ?></td>
                    <td class="text-center"><?= esc($item['satuan'] ?: '-') ?></td>
                    <td class="text-center"><?= esc($item['stok_fisik'] ?: '-') ?></td>
                    <td class="text-center"><?= esc($item['stok_di_kartu'] ?: '-') ?></td>
                    <td class="text-center fw-bold <?= (float)($item['selisih'] ?? 0) < 0 ? 'text-danger' : '' ?>"><?= esc($item['selisih'] ?: '-') ?></td>
                    <td><?= esc($item['keterangan'] ?: '-') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endforeach; ?>

<div class="bg-light rounded p-3 text-muted small animate-in">
    Diinput oleh <strong><?= esc($header['user_nama']) ?></strong> pada <?= date('d/m/Y H:i', strtotime($header['created_at'])) ?>
</div>

<?= $this->endSection() ?>
