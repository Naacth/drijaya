<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- Filters -->
<div class="data-card mb-4 animate-in">
    <div class="card-body p-3">
        <form method="get" class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="pending"  <?= ($status ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="diterima" <?= ($status ?? '') === 'diterima' ? 'selected' : '' ?>>Diterima</option>
                    <option value="ditolak"  <?= ($status ?? '') === 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-sm btn-primary">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Reports Table -->
<div class="data-card animate-in">
    <div class="card-header">
        <h6><i class="bi bi-file-earmark-text-fill me-2"></i>Semua Laporan</h6>
        <span class="badge bg-primary rounded-pill"><?= count($reports) ?></span>
    </div>
    <div class="table-responsive">
        <table class="table table-premium">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pengirim</th>
                    <th>Role</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>File</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reports)): ?>
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        Tidak ada laporan ditemukan
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($reports as $i => $r): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><strong><?= esc($r['user_nama']) ?></strong></td>
                    <td><span class="badge bg-light text-dark"><?= ucfirst(str_replace('_',' ',$r['user_role'])) ?></span></td>
                    <td><?= esc($r['judul']) ?></td>
                    <td><?= ucwords(str_replace('_',' ',$r['kategori'])) ?></td>
                    <td>
                        <span class="badge bg-light text-dark">
                            <i class="bi bi-file-earmark me-1"></i><?= strtoupper($r['file_type']) ?>
                        </span>
                    </td>
                    <td><?= date('d M Y H:i', strtotime($r['created_at'])) ?></td>
                    <td><span class="badge-status badge-<?= $r['status'] ?>"><?= ucfirst($r['status']) ?></span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="<?= site_url("admin/reports/{$r['id']}") ?>" class="btn btn-sm btn-outline-primary" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="<?= site_url("admin/reports/{$r['id']}/download") ?>" class="btn btn-sm btn-outline-primary" title="Download">
                                <i class="bi bi-download"></i>
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

<?= $this->endSection() ?>
