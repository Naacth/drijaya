<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-0">Purchase Order</h5>
        <small class="text-muted">Kelola Purchase Order Anda</small>
    </div>
    <a href="<?= site_url('akuntan/po/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Buat PO Baru
    </a>
</div>

<div class="data-card animate-in">
    <div class="table-responsive">
        <table class="table table-premium">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No. PO</th>
                    <th>Vendor</th>
                    <th>Total</th>
                    <th>Keterangan</th>
                    <th>File</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="8" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        Belum ada PO. Klik "Buat PO Baru" untuk membuat.
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($orders as $i => $o): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><strong><?= esc($o['nomor_po']) ?></strong></td>
                    <td><?= esc($o['vendor']) ?></td>
                    <td>Rp <?= number_format($o['total'], 0, ',', '.') ?></td>
                    <td><?= esc($o['keterangan'] ?? '-') ?></td>
                    <td>
                        <?php if ($o['file_name']): ?>
                        <span class="badge bg-light text-dark"><i class="bi bi-file-earmark me-1"></i><?= esc($o['file_name']) ?></span>
                        <?php else: ?>
                        <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td><span class="badge-status badge-<?= $o['status'] ?>"><?= ucfirst($o['status']) ?></span></td>
                    <td><?= date('d M Y', strtotime($o['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
