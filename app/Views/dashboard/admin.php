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

<!-- Module Specific Stats Cards -->
<div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-5 mb-4">
    <?php foreach ($moduleStats as $name => $meta): ?>
    <div class="col animate-in">
        <div class="stat-card h-100 py-2 border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-body p-3">
                <div class="d-flex flex-column align-items-center text-center gap-2">
                    <div class="stat-icon-sm mb-1" style="background: <?= $meta['color'] ?>15; color: <?= $meta['color'] ?>; width: 45px; height: 45px; font-size: 1.25rem; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="<?= $meta['icon'] ?>"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0" style="font-size: 1.25rem; color: #1e293b;"><?= number_format($meta['count']) ?></h4>
                        <p class="mb-0 text-muted fw-semibold" style="font-size: 0.75rem; white-space: nowrap;"><?= $name ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <!-- Additional Quick Stats -->
    <div class="col animate-in">
        <div class="stat-card h-100 py-2 border-0 shadow-sm" style="border-radius: 16px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
            <div class="card-body p-3">
                <div class="d-flex flex-column align-items-center text-center gap-2">
                    <div class="stat-icon-sm mb-1 bg-white shadow-sm" style="color: #64748b; width: 45px; height: 45px; font-size: 1.25rem; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0" style="font-size: 1.25rem; color: #1e293b;"><?= number_format($totalUsers) ?></h4>
                        <p class="mb-0 text-muted fw-semibold" style="font-size: 0.75rem;">Total Pengguna</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4 mt-2">
    <!-- LEFT COLUMN: Operations & Approvals -->
    <div class="col-lg-8">
        <!-- Pending Approvals (PIC Submissions) -->
        <?php if (!empty($pendingBarangRusak) || !empty($pendingPengadaan)): ?>
        <div class="data-card animate-in mb-4" style="border-left: 4px solid #f59e0b; border-radius: 20px;">
            <div class="card-header bg-white py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-warning fw-bold mb-0"><i class="bi bi-shield-lock-fill me-2"></i>Butuh Persetujuan</h6>
                        <small class="text-muted">Tinjau pengajuan inventaris dan pengadaan</small>
                    </div>
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><?= count($pendingBarangRusak) + count($pendingPengadaan) ?> Baru</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-premium table-hover align-middle">
                    <thead>
                        <tr>
                            <th>PIC / Koor</th>
                            <th>Tipe</th>
                            <th>Deskripsi / Barang</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendingBarangRusak as $p): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-sm bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                        <?= strtoupper(substr($p['user_nama'],0,1)) ?>
                                    </div>
                                    <span class="fw-semibold"><?= esc($p['user_nama']) ?></span>
                                </div>
                            </td>
                            <td><span class="badge bg-danger-subtle text-danger">Barang Rusak</span></td>
                            <td><div class="text-truncate" style="max-width: 200px;"><?= esc($p['nama_barang']) ?></div></td>
                            <td class="text-center">
                                <div class="btn-group gap-1">
                                    <form action="<?= site_url('pengajuan-barang-rusak/approve/' . $p['id']) ?>" method="post">
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3"><i class="bi bi-check-lg"></i></button>
                                    </form>
                                    <form action="<?= site_url('pengajuan-barang-rusak/reject/' . $p['id']) ?>" method="post">
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3"><i class="bi bi-x-lg"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php foreach ($pendingPengadaan as $p): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-sm bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                        <?= strtoupper(substr($p['user_nama'],0,1)) ?>
                                    </div>
                                    <span class="fw-semibold"><?= esc($p['user_nama']) ?></span>
                                </div>
                            </td>
                            <td><span class="badge bg-success-subtle text-success">Pengadaan</span></td>
                            <td><div class="text-truncate" style="max-width: 200px;"><?= esc($p['nama_barang']) ?></div></td>
                            <td class="text-center">
                                <div class="btn-group gap-1">
                                    <form action="<?= site_url('pengadaan-barang/approve/' . $p['id']) ?>" method="post">
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3"><i class="bi bi-check-lg"></i></button>
                                    </form>
                                    <form action="<?= site_url('pengadaan-barang/reject/' . $p['id']) ?>" method="post">
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3"><i class="bi bi-x-lg"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <!-- Recent Reports -->
        <div class="data-card animate-in">
            <div class="card-header bg-white py-3 border-0">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-clock-history me-2"></i>Laporan Terbaru</h6>
                        <small class="text-muted">Aktivitas terkini dari seluruh role lapangan</small>
                    </div>
                    <a href="<?= site_url('admin/reports') ?>" class="btn btn-sm btn-light border px-3 rounded-pill text-primary fw-bold">Lihat Semua</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-premium table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Pengirim</th>
                            <th>Judul & Kategori</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th class="text-center">Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentReports as $r): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="stat-icon bg-light text-primary border" style="width: 36px; height: 36px; font-size: 0.85rem;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold mb-0" style="font-size: 0.85rem;"><?= esc($r['user_nama']) ?></div>
                                        <small class="text-muted" style="font-size: 0.7rem;"><?= esc(ucfirst(str_replace('_',' ',$r['user_role']))) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold mb-0" style="font-size: 0.85rem;"><?= esc($r['judul']) ?></div>
                                <small class="text-primary-emphasis" style="font-size: 0.7rem;"><?= esc(ucwords(str_replace('_',' ',$r['kategori']))) ?></small>
                            </td>
                            <td>
                                <div class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-calendar3 me-1"></i> <?= date('d M Y', strtotime($r['created_at'])) ?></div>
                            </td>
                            <td><span class="badge-status badge-<?= $r['status'] ?> fw-bold" style="font-size: 0.65rem; padding: 4px 10px;"><?= strtoupper($r['status']) ?></span></td>
                            <td class="text-center">
                                <a href="<?= site_url("admin/reports/{$r['id']}") ?>" class="btn btn-sm btn-light border-0 text-primary"><i class="bi bi-arrow-right-short fs-5"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: Insights & Stats -->
    <div class="col-lg-4">
        <!-- Distribution by Role -->
        <div class="data-card animate-in mb-4" style="background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);">
            <div class="card-header bg-transparent border-0 py-3">
                <h6 class="fw-bold mb-0">Distribusi Pengguna</h6>
            </div>
            <div class="card-body pt-0">
                <div class="d-flex flex-column gap-3">
                    <?php 
                    $roleColors = ['admin' => 'primary', 'aslap' => 'info', 'akuntan' => 'success', 'ahli_gizi' => 'warning', 'pic' => 'indigo'];
                    foreach ($userRoleStats as $roleStat): 
                        $color = $roleColors[$roleStat['role']] ?? 'secondary';
                        $percentage = ($totalUsers > 0) ? round(($roleStat['count'] / $totalUsers) * 100) : 0;
                    ?>
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="small fw-semibold text-capitalize"><?= str_replace('_', ' ', $roleStat['role']) ?></span>
                            <span class="small text-muted"><?= $roleStat['count'] ?> (<?= $percentage ?>%)</span>
                        </div>
                        <div class="progress" style="height: 6px; border-radius: 10px;">
                            <div class="progress-bar bg-<?= $color ?>" role="progressbar" style="width: <?= $percentage ?>%"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Kitchen Status Summary -->
        <div class="data-card animate-in">
            <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Status Dapur (SPPG)</h6>
                <span class="badge bg-primary-subtle text-primary rounded-pill"><?= count($kitchenStatus) ?> Total</span>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <?php foreach ($kitchenStatus as $kitchen): ?>
                    <a href="<?= site_url('admin/switch-sppg/' . $kitchen['id']) ?>" class="list-group-item list-group-item-action border-0 px-3 py-3 d-flex align-items-center gap-3">
                        <div class="stat-icon bg-blue-subtle text-primary" style="width: 40px; height: 40px; border-radius: 12px; font-size: 1rem;">
                            <i class="bi bi-house-door-fill"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold" style="font-size: 0.85rem;"><?= esc($kitchen['nama_sppg']) ?></div>
                            <small class="text-muted"><?= esc($kitchen['report_count']) ?> Laporan Masuk</small>
                        </div>
                        <i class="bi bi-chevron-right text-muted small"></i>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="card-footer bg-light border-0 text-center py-3">
                <a href="<?= site_url('admin/switch-sppg/0') ?>" class="small text-decoration-none fw-bold"><i class="bi bi-globe me-1"></i> Lihat Data Pusat</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
