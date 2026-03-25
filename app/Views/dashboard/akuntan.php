<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-4 animate-in">
        <a href="<?= site_url('akuntan/upload/laporan_keuangan') ?>" class="category-card">
            <div class="card-body">
                <div class="category-icon" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                    <i class="bi bi-journal-text"></i>
                </div>
                <h6>Laporan Keuangan</h6>
                <small>Upload laporan keuangan</small>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-4 animate-in">
        <a href="<?= site_url('akuntan/upload/pemasukan_pengeluaran') ?>" class="category-card">
            <div class="card-body">
                <div class="category-icon" style="background:linear-gradient(135deg,#10b981,#059669);">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <h6>Pemasukan & Pengeluaran</h6>
                <small>Upload laporan pemasukan/pengeluaran</small>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-4 animate-in">
        <a href="<?= site_url('akuntan/po') ?>" class="category-card">
            <div class="card-body">
                <div class="category-icon" style="background:linear-gradient(135deg,#f59e0b,#f97316);">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>
                <h6>Purchase Order</h6>
                <small><?= $totalPO ?> PO dibuat</small>
            </div>
        </a>
    </div>
</div>

<!-- Recent Reports -->
<?php if (!empty($reports)): ?>
<div class="data-card animate-in">
    <div class="card-header">
        <h6><i class="bi bi-clock-history me-2"></i>Riwayat Laporan Saya</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-premium">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>File</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports as $r): ?>
                <tr>
                    <td><?= esc($r['judul']) ?></td>
                    <td><?= esc(ucwords(str_replace('_',' ',$r['kategori']))) ?></td>
                    <td><span class="badge bg-light text-dark"><i class="bi bi-file-earmark me-1"></i><?= esc($r['file_name']) ?></span></td>
                    <td><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                    <td><span class="badge-status badge-<?= $r['status'] ?>"><?= ucfirst($r['status']) ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
