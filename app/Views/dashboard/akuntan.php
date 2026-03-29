<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    .welcome-banner {
        background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%);
        color: #fff;
        border-radius: 12px;
        padding: 30px;
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.4);
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        top: -50%; right: -10%;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }
</style>

<div class="welcome-banner animate-in">
    <h3 class="fw-bold mb-2">Selamat Datang, <?= esc(session()->get('nama')) ?>!</h3>
    <p class="mb-0 opacity-75" style="font-size: 1.1rem;">Panel Manajemen Keuangan & Procurement untuk <strong><?= esc($sppg_name) ?></strong></p>
</div>

<div class="row g-4 mb-5">
    <!-- Stat Cards -->
    <div class="col-12 col-md-4 animate-in" style="animation-delay: 0.1s;">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #0ea5e9, #0284c7);">
                <i class="bi bi-file-earmark-bar-graph"></i>
            </div>
            <div class="stat-info">
                <h3><?= number_format($totalReports) ?></h3>
                <p>Laporan Diupload</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 animate-in" style="animation-delay: 0.2s;">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stat-info">
                <h3><?= number_format($pendingReports) ?></h3>
                <p>Status Pending</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4 animate-in" style="animation-delay: 0.3s;">
        <a href="<?= site_url('po') ?>" class="text-decoration-none w-100">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>
                <div class="stat-info">
                    <h3><?= number_format($totalPO) ?></h3>
                    <p>Purchase Order</p>
                </div>
            </div>
        </a>
    </div>
</div>

<h5 class="fw-bold mb-3" style="color: #334155;">Akses Cepat Keuangan</h5>
<div class="row g-3 mb-5 animate-in" style="animation-delay: 0.4s;">
    <div class="col-sm-6 col-lg-3">
        <a href="<?= site_url('buku-kas') ?>" class="category-card">
            <div class="card-body">
                <div class="category-icon" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                    <i class="bi bi-journal-check"></i>
                </div>
                <h6>Buku Kas Ops</h6>
                <small>Input Kas Harian</small>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="<?= site_url('petty-cash') ?>" class="category-card">
            <div class="card-body">
                <div class="category-icon" style="background:linear-gradient(135deg,#06b6d4,#0891b2);">
                    <i class="bi bi-wallet2"></i>
                </div>
                <h6>Petty Cash</h6>
                <small>Laporan Dana Kecil</small>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="<?= site_url('akuntan/upload/laporan_keuangan') ?>" class="category-card">
            <div class="card-body">
                <div class="category-icon" style="background:linear-gradient(135deg,#ec4899,#db2777);">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h6>Lap. Keuangan</h6>
                <small>Upload Bulanan</small>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="<?= site_url('akuntan/upload/pemasukan_pengeluaran') ?>" class="category-card">
            <div class="card-body">
                <div class="category-icon" style="background:linear-gradient(135deg,#10b981,#059669);">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <h6>Arus Kas</h6>
                <small>Income & Expense</small>
            </div>
        </a>
    </div>
</div>

<!-- History -->
<div class="row g-4 animate-in" style="animation-delay: 0.5s;">
    <div class="col-12">
        <div class="data-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6><i class="bi bi-clock-history me-2"></i>Riwayat Upload Laporan</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-premium">
                    <thead>
                        <tr>
                            <th>Judul Laporan</th>
                            <th>Kategori</th>
                            <th>Dokumen</th>
                            <th>Tanggal Upload</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($reports)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                Belum ada laporan yang diupload
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($reports as $r): ?>
                        <tr>
                            <td class="fw-bold"><?= esc($r['judul']) ?></td>
                            <td><span class="badge bg-light text-dark border"><?= esc(ucwords(str_replace('_',' ',$r['kategori']))) ?></span></td>
                            <td>
                                <a href="<?= base_url($r['file_path']) ?>" target="_blank" class="text-decoration-none">
                                    <span class="badge bg-light text-primary border"><i class="bi bi-file-earmark me-1"></i><?= esc($r['file_name']) ?></span>
                                </a>
                            </td>
                            <td><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                            <td><span class="badge-status badge-<?= $r['status'] ?>"><?= ucfirst($r['status']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
