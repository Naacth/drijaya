<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Dashboard Admin</h4>
    <div class="dropdown">
        <button class="btn btn-white border shadow-sm dropdown-toggle px-4" type="button" data-bs-toggle="dropdown">
            <i class="bi bi-geo-alt-fill me-2 text-danger"></i>
            <?= session()->get('sppg_nama') ?: 'Pilih Dapur' ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 p-2" style="min-width: 250px;">
            <li><h6 class="dropdown-header">Pilih Lokasi Pantauan</h6></li>
            <?php foreach ($allSppg as $s): ?>
                <li>
                    <a class="dropdown-item rounded-2 py-2 <?= $s['id'] == $currentSppgId ? 'active' : '' ?>" href="<?= site_url('admin/switch-sppg/' . $s['id']) ?>">
                        <i class="bi bi-door-open me-2"></i><?= $s['nama_sppg'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item rounded-2 py-2" href="<?= site_url('admin/switch-sppg/0') ?>">
                    <i class="bi bi-globe me-2"></i>Semua Dapur (Pusat)
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3 animate-in">
        <div class="stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
                <div>
                    <p class="stat-value"><?= $totalReports ?></p>
                    <p class="stat-label mb-0">Total Laporan</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 animate-in">
        <div class="stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:linear-gradient(135deg,#f59e0b,#f97316);">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <p class="stat-value"><?= $pendingReports ?></p>
                    <p class="stat-label mb-0">Menunggu Review</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 animate-in">
        <div class="stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:linear-gradient(135deg,#10b981,#059669);">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div>
                    <p class="stat-value"><?= $acceptedReports ?></p>
                    <p class="stat-label mb-0">Diterima</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3 animate-in">
        <div class="stat-card">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:linear-gradient(135deg,#06b6d4,#0284c7);">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <p class="stat-value"><?= $totalUsers ?></p>
                    <p class="stat-label mb-0">Total Pengguna</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4 mt-2">
    <div class="col-12">
        <h5 class="fw-bold mb-3"><i class="bi bi-grid-fill me-2 text-primary"></i>Command Center SPPG</h5>
        <p class="text-muted small">Akses cepat ke seluruh modul berdasarkan peran (role)</p>
    </div>
    
    <!-- ASLAP MENU -->
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-header bg-white border-0 py-3 d-flex align-items-center gap-3">
                <div class="stat-icon flex-shrink-0" style="background:linear-gradient(135deg,#06b6d4,#0891b2);">
                    <i class="bi bi-person-workspace"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold">Asisten Lapangan</h6>
                    <small class="text-muted">Data Lapangan & Operasional</small>
                </div>
            </div>
            <div class="card-body pt-0">
                <button class="btn btn-light w-100 btn-sm text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#menuAslap" aria-expanded="false">
                    Buka Semua Menu <i class="bi bi-chevron-down small"></i>
                </button>
                <div class="collapse mt-2" id="menuAslap">
                    <div class="list-group list-group-flush small border-top">
                        <a href="<?= site_url('barang-datang') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2">
                            <i class="bi bi-box-seam me-2 text-info"></i> Barang Datang
                        </a>
                        <a href="<?= site_url('cek-bahan-baku') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2">
                            <i class="bi bi-clipboard-check me-2 text-success"></i> Cek Bahan Baku
                        </a>
                        <a href="<?= site_url('uji-organoleptik') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2">
                            <i class="bi bi-eyedropper me-2 text-warning"></i> Uji Organoleptik
                        </a>
                        <a href="<?= site_url('ba-kehilangan') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2">
                            <i class="bi bi-exclamation-triangle me-2 text-danger"></i> BA Kehilangan
                        </a>
                        <a href="<?= site_url('pemberitahuan-kerja') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2">
                            <i class="bi bi-megaphone me-2 text-primary"></i> Hasil Kerja
                        </a>
                        <a href="<?= site_url('stok-gudang') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2">
                            <i class="bi bi-building me-2 text-info"></i> Stok Gudang
                        </a>
                        <a href="<?= site_url('stok-opname') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2">
                            <i class="bi bi-calculator me-2 text-dark"></i> Stok Opname
                        </a>
                        <a href="<?= site_url('rekap-porsi') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2">
                            <i class="bi bi-pie-chart me-2 text-warning"></i> Rekap Porsi
                        </a>
                        <a href="<?= site_url('absensi') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2 fw-bold">
                            <i class="bi bi-calendar-check me-2 text-primary"></i> Laporan Absensi Relawan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AKUNTAN MENU -->
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-header bg-white border-0 py-3 d-flex align-items-center gap-3">
                <div class="stat-icon flex-shrink-0" style="background:linear-gradient(135deg,#10b981,#059669);">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold">Akuntan</h6>
                    <small class="text-muted">Keuangan & Petty Cash</small>
                </div>
            </div>
            <div class="card-body pt-0">
                <button class="btn btn-light w-100 btn-sm text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#menuAkuntan" aria-expanded="false">
                    Buka Semua Menu <i class="bi bi-chevron-down small"></i>
                </button>
                <div class="collapse mt-2" id="menuAkuntan">
                    <div class="list-group list-group-flush small border-top">
                        <a href="<?= site_url('buku-kas/report') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2 fw-bold">
                            <i class="bi bi-journal-text me-2 text-success"></i> Buku Kas Operasional
                        </a>
                        <a href="<?= site_url('petty-cash/report') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2 fw-bold">
                            <i class="bi bi-wallet2 me-2 text-primary"></i> Laporan Petty Cash
                        </a>
                        <a href="<?= site_url('akuntan/upload/laporan_keuangan') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2">
                            <i class="bi bi-file-earmark-spreadsheet me-2 text-info"></i> Laporan Keuangan
                        </a>
                        <a href="<?= site_url('akuntan/upload/pemasukan_pengeluaran') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2">
                            <i class="bi bi-arrow-down-up me-2 text-warning"></i> Pemasukan & Pengeluaran
                        </a>
                        <a href="<?= base_url('po') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2">
                            <i class="bi bi-receipt-cutoff me-2 text-danger"></i> Purchase Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AHLI GIZI MENU -->
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-header bg-white border-0 py-3 d-flex align-items-center gap-3">
                <div class="stat-icon flex-shrink-0" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                    <i class="bi bi-egg-fried"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold">Ahli Gizi</h6>
                    <small class="text-muted">Menu & Nutrisi</small>
                </div>
            </div>
            <div class="card-body pt-0">
                <button class="btn btn-light w-100 btn-sm text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#menuGizi" aria-expanded="false">
                    Buka Semua Menu <i class="bi bi-chevron-down small"></i>
                </button>
                <div class="collapse mt-2" id="menuGizi">
                    <div class="list-group list-group-flush small border-top">
                        <a href="<?= site_url('ahli-gizi/upload') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2">
                            <i class="bi bi-calendar3 me-2 text-warning"></i> Menu Makanan Mingguan
                        </a>
                        <a href="<?= base_url('po') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2">
                            <i class="bi bi-receipt-cutoff me-2 text-danger"></i> Purchase Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PIC MENU -->
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 overflow-hidden">
            <div class="card-header bg-white border-0 py-3 d-flex align-items-center gap-3">
                <div class="stat-icon flex-shrink-0" style="background:linear-gradient(135deg,#6366f1,#4f46e5);">
                    <i class="bi bi-person-badge"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold">PIC / Koor</h6>
                    <small class="text-muted">Approval & Monitoring</small>
                </div>
            </div>
            <div class="card-body pt-0">
                <button class="btn btn-light w-100 btn-sm text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#menuPic" aria-expanded="false">
                    Buka Semua Menu <i class="bi bi-chevron-down small"></i>
                </button>
                <div class="collapse mt-2" id="menuPic">
                    <div class="list-group list-group-flush small border-top">
                        <a href="<?= base_url('po') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2">
                            <i class="bi bi-clipboard-check me-2 text-primary"></i> Approval Purchase Order
                        </a>
                        <a href="<?= site_url('signatures') ?>" class="list-group-item list-group-item-action border-0 px-0 py-2">
                            <i class="bi bi-pen me-2 text-dark"></i> Pengaturan Tanda Tangan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Persetujuan Perlu Tindakan (PIC Submissions) -->
<?php if (!empty($pendingBarangRusak) || !empty($pendingPengadaan)): ?>
<div class="data-card animate-in mb-4" style="border-left: 4px solid #f59e0b;">
    <div class="card-header bg-light">
        <h6 class="text-warning fw-bold mb-0"><i class="bi bi-exclamation-triangle-fill me-2"></i>Persetujuan Perlu Tindakan</h6>
        <span class="badge bg-warning text-dark"><?= count($pendingBarangRusak) + count($pendingPengadaan) ?> Pengajuan Baru</span>
    </div>
    <div class="table-responsive">
        <table class="table table-premium table-hover">
            <thead>
                <tr>
                    <th>PIC</th>
                    <th>Tipe Pengajuan</th>
                    <th>Nama Barang / Deskripsi</th>
                    <th>Tanggal</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pendingBarangRusak as $p): ?>
                <tr>
                    <td><strong><?= esc($p['user_nama']) ?></strong></td>
                    <td><span class="badge bg-danger-subtle text-danger">Barang Rusak</span></td>
                    <td><?= esc($p['nama_barang']) ?></td>
                    <td><?= date('d M Y', strtotime($p['tanggal'])) ?></td>
                    <td class="text-center">
                        <form action="<?= site_url('pengajuan-barang-rusak/approve/' . $p['id']) ?>" method="post" class="d-inline">
                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3" onclick="return confirm('Setujui pengajuan ini?')"><i class="bi bi-check-lg"></i> Setujui</button>
                        </form>
                        <form action="<?= site_url('pengajuan-barang-rusak/reject/' . $p['id']) ?>" method="post" class="d-inline">
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Tolak pengajuan ini?')"><i class="bi bi-x-lg"></i> Tolak</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <?php foreach ($pendingPengadaan as $p): ?>
                <tr>
                    <td><strong><?= esc($p['user_nama']) ?></strong></td>
                    <td><span class="badge bg-success-subtle text-success">Pengadaan Barang</span></td>
                    <td><?= esc($p['nama_barang']) ?> (<?= $p['jumlah'] ?> <?= $p['satuan'] ?>)</td>
                    <td><?= date('d M Y', strtotime($p['tanggal'])) ?></td>
                    <td class="text-center">
                        <form action="<?= site_url('pengadaan-barang/approve/' . $p['id']) ?>" method="post" class="d-inline">
                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3" onclick="return confirm('Setujui pengadaan ini?')"><i class="bi bi-check-lg"></i> Setujui</button>
                        </form>
                        <form action="<?= site_url('pengadaan-barang/reject/' . $p['id']) ?>" method="post" class="d-inline">
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Tolak pengajuan ini?')"><i class="bi bi-x-lg"></i> Tolak</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Recent Reports -->
<div class="data-card animate-in mt-4">
    <div class="card-header">
        <h6><i class="bi bi-clock-history me-2"></i>Laporan Terbaru</h6>
        <a href="<?= site_url('admin/reports') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-premium">
            <thead>
                <tr>
                    <th>Pengirim</th>
                    <th>Role</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recentReports)): ?>
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        Belum ada laporan masuk
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($recentReports as $r): ?>
                <tr>
                    <td><strong><?= esc($r['user_nama']) ?></strong></td>
                    <td><span class="badge bg-light text-dark"><?= esc(ucfirst(str_replace('_',' ',$r['user_role']))) ?></span></td>
                    <td><?= esc($r['judul']) ?></td>
                    <td><?= esc(ucwords(str_replace('_',' ',$r['kategori']))) ?></td>
                    <td><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                    <td><span class="badge-status badge-<?= $r['status'] ?>"><?= ucfirst($r['status']) ?></span></td>
                    <td>
                        <a href="<?= site_url("admin/reports/{$r['id']}") ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
