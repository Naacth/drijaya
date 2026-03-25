<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid animate-in">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Manajemen Rute Pengiriman</h4>
            <p class="text-muted small">Kelola alur distribusi makanan (mobil, driver, dan rute sekolah).</p>
        </div>
        <?php if (session()->get('role') == 'aslap'): ?>
            <a href="<?= base_url('routes/create') ?>" class="btn btn-primary btn-sm shadow-sm">
                <i class="bi bi-truck me-1"></i> Buat Rute Baru
            </a>
        <?php endif; ?>
    </div>

    <div class="row g-3 mb-4 animate-in">
        <div class="col-md-10">
            <form action="" method="GET" class="row g-2">
                <div class="col-md-3">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="draft" <?= ($filter['status'] ?? '') == 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="submitted" <?= ($filter['status'] ?? '') == 'submitted' ? 'selected' : '' ?>>Submitted</option>
                        <option value="approved" <?= ($filter['status'] ?? '') == 'approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="rejected" <?= ($filter['status'] ?? '') == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Cari Mobil, Driver, atau SPPG..." value="<?= esc($filter['search'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-light btn-sm w-100 border">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                </div>
                <?php if (!empty($filter['status']) || !empty($filter['search'])): ?>
                    <div class="col-md-2">
                        <a href="<?= base_url('routes') ?>" class="btn btn-link btn-sm text-decoration-none">Reset</a>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="data-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-premium align-middle mb-0">
                    <thead>
                        <tr>
                            <th width="120">Tanggal</th>
                            <th>Mobil / Driver</th>
                            <th>SPPG / Unit</th>
                            <th class="text-end">Total Porsi</th>
                            <th class="text-center">Status</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($items)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-map fs-1 d-block mb-3 opacity-25"></i>
                                    Belum ada data rute pengiriman.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td class="fw-bold"><?= date('d/m/Y', strtotime($item['tanggal'])) ?></td>
                                    <td>
                                        <span class="fw-medium d-block text-dark"><?= $item['mobil'] ?></span>
                                        <small class="text-muted"><?= $item['driver'] ?></small>
                                    </td>
                                    <td>
                                        <span class="small text-muted d-block"><?= $item['sppg'] ?></span>
                                        <small class="text-muted"><?= $item['kecamatan'] ?></small>
                                    </td>
                                    <td class="text-end fw-bold">
                                        <?= number_format($item['total_porsi']) ?> 
                                        <small class="text-muted fw-normal">Porsi</small>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $badge = 'secondary';
                                        switch ($item['status']) {
                                            case 'draft': $badge = 'draft'; break;
                                            case 'submitted': $badge = 'pending'; break;
                                            case 'approved': $badge = 'disetujui'; break;
                                            case 'rejected': $badge = 'ditolak'; break;
                                        }
                                        ?>
                                        <span class="badge badge-status badge-<?= $badge ?>">
                                            <?= ucwords($item['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('routes/show/' . $item['id']) ?>" class="btn btn-light border" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <?php if ($item['status'] != 'approved' || session()->get('role') == 'admin'): ?>
                                                <a href="<?= base_url('routes/edit/' . $item['id']) ?>" class="btn btn-light border" title="Edit">
                                                    <i class="bi bi-pencil-square text-primary"></i>
                                                </a>
                                                <form action="<?= base_url('routes/delete/' . $item['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rute ini?')">
                                                    <button type="submit" class="btn btn-light border" title="Hapus">
                                                        <i class="bi bi-trash3 text-danger"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <a href="<?= base_url('routes/export-pdf/' . $item['id']) ?>" target="_blank" class="btn btn-light border" title="Export PDF">
                                                <i class="bi bi-file-pdf text-danger"></i>
                                            </a>
                                            <a href="<?= base_url('routes/export-excel/' . $item['id']) ?>" class="btn btn-light border" title="Export Excel">
                                                <i class="bi bi-file-earmark-excel text-success"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if (!empty($items)): ?>
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Menampilkan <?= count($items) ?> rute di halaman ini
                    </div>
                    <div>
                        <?= $pager->links('routes', 'bootstrap_full') ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
