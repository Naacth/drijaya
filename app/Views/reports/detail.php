<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <div class="col-lg-8 animate-in">
        <div class="data-card">
            <div class="card-header">
                <h6><i class="bi bi-file-earmark-text me-2"></i>Detail Laporan</h6>
                <a href="<?= site_url('admin/reports') ?>" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label text-muted small">Pengirim</label>
                        <p class="fw-semibold"><?= esc($report['user_nama']) ?></p>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label text-muted small">Role</label>
                        <p><span class="badge bg-light text-dark"><?= ucfirst(str_replace('_',' ',$report['user_role'])) ?></span></p>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label text-muted small">Judul</label>
                        <p class="fw-semibold"><?= esc($report['judul']) ?></p>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label text-muted small">Kategori</label>
                        <p><?= ucwords(str_replace('_',' ',$report['kategori'])) ?></p>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label text-muted small">Tanggal Upload</label>
                        <p><?= date('d F Y, H:i', strtotime($report['created_at'])) ?></p>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label text-muted small">Status</label>
                        <p><span class="badge-status badge-<?= $report['status'] ?>"><?= ucfirst($report['status']) ?></span></p>
                    </div>
                    <div class="col-12">
                        <label class="form-label text-muted small">File</label>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-light text-dark p-2">
                                <i class="bi bi-file-earmark me-1"></i>
                                <?= esc($report['file_name']) ?>
                                <small class="text-muted ms-1">(<?= number_format($report['file_size'] / 1024, 1) ?> KB)</small>
                            </span>
                            <a href="<?= site_url("admin/reports/{$report['id']}/download") ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-download me-1"></i> Download
                            </a>
                        </div>
                    </div>
                    <?php if ($report['catatan']): ?>
                    <div class="col-12">
                        <label class="form-label text-muted small">Catatan</label>
                        <p><?= nl2br(esc($report['catatan'])) ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Panel -->
    <div class="col-lg-4 animate-in">
        <div class="data-card">
            <div class="card-header">
                <h6><i class="bi bi-check2-square me-2"></i>Update Status</h6>
            </div>
            <div class="card-body p-4">
                <form action="<?= site_url("admin/reports/{$report['id']}/status") ?>" method="post">
                    <div class="d-grid gap-2">
                        <button type="submit" name="status" value="diterima" class="btn btn-success btn-lg">
                            <i class="bi bi-check-circle-fill me-1"></i> Terima Laporan
                        </button>
                        <button type="submit" name="status" value="ditolak" class="btn btn-outline-danger btn-lg">
                            <i class="bi bi-x-circle-fill me-1"></i> Tolak Laporan
                        </button>
                    </div>
                </form>

                <hr class="my-3">

                <div class="text-center small text-muted">
                    Status saat ini: <span class="badge-status badge-<?= $report['status'] ?>"><?= ucfirst($report['status']) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
