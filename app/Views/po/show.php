<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid animate-in">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Detail Purchase Order</h4>
            <p class="text-muted small">Informasi lengkap mengenai histori dan rincian item PO.</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'po/export-pdf-blank', 'printBlankRoles' => ['admin', 'pic', 'akuntan'], 'printBlankWrapperClass' => 'mb-0']) ?>
            <a href="<?= base_url('po') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <?php if ($po['status'] == 'approved'): ?>
                <a href="<?= base_url('po/print/' . $po['id']) ?>" target="_blank" class="btn btn-primary btn-sm">
                    <i class="bi bi-printer me-1"></i> Cetak PO
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="data-card mb-4">
                <div class="card-header py-3 bg-light border-bottom">
                    <h6 class="m-0 fw-bold text-dark">Rincian Barang</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-premium align-middle mb-0">
                            <thead>
                                <tr>
                                    <th width="50" class="text-center">No</th>
                                    <th width="100" class="text-center">Banyaknya</th>
                                    <th width="80" class="text-center">Satuan</th>
                                    <th>Nama Barang</th>
                                    <th width="130" class="text-end">Harga Satuan</th>
                                    <th width="100" class="text-end">Tambahan</th>
                                    <th width="120" class="text-center">Jml Faktual</th>
                                    <th width="140" class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $index => $item): ?>
                                    <tr>
                                        <td class="text-center"><?= $index + 1 ?></td>
                                        <td class="text-center"><?= $item['qty'] ?></td>
                                        <td class="text-center text-muted small"><?= $item['satuan'] ?></td>
                                        <td>
                                            <span class="fw-medium"><?= $item['nama_barang'] ?></span>
                                            <?php if ($item['catatan']): ?>
                                                <br><small class="text-muted"><?= $item['catatan'] ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">Rp <?= number_format($item['harga_satuan'] ?? 0, 0, ',', '.') ?></td>
                                        <td class="text-end">Rp <?= number_format($item['tambahan'] ?? 0, 0, ',', '.') ?></td>
                                        <td class="text-center fw-medium"><?= $item['jumlah_faktual'] ?? '' ?></td>
                                        <td class="text-end fw-bold">Rp <?= number_format($item['total'] ?? 0, 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <th colspan="7" class="text-end py-3 text-uppercase small">Total Keseluruhan</th>
                                    <th class="text-end py-3 text-primary h5 fw-bold mb-0">Rp <?= number_format($po['total'], 0, ',', '.') ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="data-card mb-4">
                <div class="card-header py-3 bg-light border-bottom">
                    <h6 class="m-0 fw-bold text-dark">Informasi Utama</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-center">
                        <small class="text-muted d-block mb-1">Status Saat Ini</small>
                        <?php
                        $badge = 'secondary';
                        switch ($po['status']) {
                            case 'draft': $badge = 'draft'; break;
                            case 'menunggu_harga': $badge = 'pending'; break;
                            case 'menunggu_review': $badge = 'diajukan'; break;
                            case 'menunggu_approval': $badge = 'pending'; break;
                            case 'approved': $badge = 'disetujui'; break;
                            case 'rejected': $badge = 'ditolak'; break;
                        }
                        ?>
                        <span class="badge badge-status badge-<?= $badge ?> px-4 py-2 fs-6">
                            <?= ucwords(str_replace('_', ' ', $po['status'])) ?>
                        </span>
                    </div>
                    
                    <div class="list-group list-group-flush small">
                        <div class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">No PO</span>
                            <span class="fw-bold"><?= $po['nomor_po'] ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Tanggal</span>
                            <span><?= date('d/m/Y', strtotime($po['tanggal'])) ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Supplier</span>
                            <span class="text-end text-truncate ms-2" style="max-width: 150px;"><?= $po['vendor'] ?></span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between px-0 border-0">
                            <span class="text-muted">Dibuat Oleh</span>
                            <span><?= $po['pembuat'] ?? 'Ahli Gizi' ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="data-card">
                <div class="card-header py-3 bg-light border-bottom">
                    <h6 class="m-0 fw-bold text-dark">Histori Approval</h6>
                </div>
                <div class="card-body p-0">
                    <div class="timeline p-3">
                        <?php if (empty($approvals)): ?>
                            <p class="text-center text-muted small my-3">Belum ada riwayat approval.</p>
                        <?php else: ?>
                            <?php foreach ($approvals as $app): ?>
                                <div class="mb-3 border-start border-2 ps-3 position-relative pb-1">
                                    <div class="position-absolute bg-primary rounded-circle" style="width:10px; height:10px; left:-6px; top:5px;"></div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="fw-bold text-primary text-uppercase"><?= str_replace('_', ' ', $app['role']) ?></small>
                                        <small class="text-muted" style="font-size:0.65rem;"><?= date('d/m/y H:i', strtotime($app['created_at'])) ?></small>
                                    </div>
                                    <p class="mb-1 small fw-medium"><?= ucwords($app['status']) ?></p>
                                    <?php if ($app['catatan']): ?>
                                        <div class="bg-light p-2 rounded border-start border-3 border-warning small italic">
                                            "<?= $app['catatan'] ?>"
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
