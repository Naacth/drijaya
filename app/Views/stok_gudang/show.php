<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('stok-gudang') ?>" class="text-decoration-none text-muted mb-2 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Stok Gudang</h4>
        <p class="text-muted small mb-0"><?= esc($header['nama_sppg']) ?> — <?= date('d F Y', strtotime($header['tanggal'])) ?></p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('stok-gudang/export-pdf/'.$header['id']) ?>" target="_blank" class="btn btn-outline-danger">
            <i class="bi bi-file-pdf me-1"></i> Cetak PDF
        </a>
        <a href="<?= site_url('stok-gudang/export-excel/'.$header['id']) ?>" class="btn btn-outline-success">
            <i class="bi bi-file-excel me-1"></i> Export Excel
        </a>
    </div>
</div>

<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-header"><h6><i class="bi bi-list-ul me-2"></i>Daftar Produk</h6></div>
    <div class="table-responsive">
        <table class="table table-premium mb-0">
            <thead>
                <tr>
                    <th width="40">No</th>
                    <th>Nama Produk</th>
                    <th>Nama Penerima</th>
                    <th class="text-center">Stok Awal</th>
                    <th class="text-center">Barang Masuk</th>
                    <th class="text-center">Barang Keluar</th>
                    <th class="text-end">Stok Akhir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td class="fw-medium text-dark"><?= esc($item['nama_produk']) ?></td>
                    <td><?= esc($item['nama_penerima'] ?: '-') ?></td>
                    <td class="text-center"><?= esc($item['stok_awal'] ?: '-') ?></td>
                    <td class="text-center"><?= esc($item['barang_masuk'] ?: '-') ?></td>
                    <td class="text-center"><?= esc($item['barang_keluar'] ?: '-') ?></td>
                    <td class="text-end fw-bold"><?= esc($item['stok_akhir'] ?: '-') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card-body bg-light p-3">
        <small class="text-muted">Diinput oleh <strong><?= esc($header['user_nama']) ?></strong> pada <?= date('d/m/Y H:i', strtotime($header['created_at'])) ?></small>
    </div>
</div>

<?= $this->endSection() ?>
