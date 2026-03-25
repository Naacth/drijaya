<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="data-card animate-in">
    <div class="card-header">
        <h6><i class="bi bi-receipt-cutoff me-2"></i>Daftar Purchase Order</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-premium">
            <thead>
                <tr>
                    <th>No. PO</th>
                    <th>Dibuat Oleh</th>
                    <th>Vendor</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                        Belum ada Purchase Order
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($orders as $o): ?>
                <tr>
                    <td><strong><?= esc($o['nomor_po']) ?></strong></td>
                    <td><?= esc($o['user_nama']) ?></td>
                    <td><?= esc($o['vendor']) ?></td>
                    <td>Rp <?= number_format($o['total'], 0, ',', '.') ?></td>
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
