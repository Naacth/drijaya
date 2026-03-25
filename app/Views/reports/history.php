<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="data-card animate-in">
    <div class="card-header">
        <h6><i class="bi bi-clock-history me-2"></i>Riwayat Laporan Saya</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-premium">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>File</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reports)): ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        Belum ada laporan dikirim
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($reports as $i => $r): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= esc($r['judul']) ?></td>
                    <td><?= ucwords(str_replace('_',' ',$r['kategori'])) ?></td>
                    <td>
                        <span class="badge bg-light text-dark">
                            <i class="bi bi-file-earmark me-1"></i><?= esc($r['file_name']) ?>
                        </span>
                    </td>
                    <td><?= date('d M Y H:i', strtotime($r['created_at'])) ?></td>
                    <td><span class="badge-status badge-<?= $r['status'] ?>"><?= ucfirst($r['status']) ?></span></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
