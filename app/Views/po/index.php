<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid animate-in">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Management Purchase Order</h4>
            <p class="text-muted small">Kelola dan pantau proses pengadaan bahan makanan.</p>
        </div>
        <div class="d-flex gap-2">
            <?php if (in_array(session()->get('role'), ['admin', 'pic'])): ?>
                <a href="<?= base_url('po/export-excel') ?>" class="btn btn-outline-success btn-sm shadow-sm">
                    <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                </a>
                <a href="<?= base_url('po/export-pdf') ?>" class="btn btn-outline-danger btn-sm shadow-sm">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                </a>
            <?php endif; ?>
            <?php if (session()->get('role') == 'ahli_gizi'): ?>
                <a href="<?= base_url('po/create') ?>" class="btn btn-primary btn-sm shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Buat PO Baru
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-3 mb-4 animate-in">
        <div class="col-md-10">
            <form action="" method="GET" class="row g-2">
                <div class="col-md-3">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="draft" <?= ($filter['status'] ?? '') == 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="menunggu_harga" <?= ($filter['status'] ?? '') == 'menunggu_harga' ? 'selected' : '' ?>>Menunggu Harga</option>
                        <option value="menunggu_review" <?= ($filter['status'] ?? '') == 'menunggu_review' ? 'selected' : '' ?>>Menunggu Review</option>
                        <option value="menunggu_approval" <?= ($filter['status'] ?? '') == 'menunggu_approval' ? 'selected' : '' ?>>Menunggu Approval</option>
                        <option value="approved" <?= ($filter['status'] ?? '') == 'approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="rejected" <?= ($filter['status'] ?? '') == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Cari No PO, Vendor, atau Menu..." value="<?= esc($filter['search'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-light btn-sm w-100 border">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                </div>
                <?php if (!empty($filter['status']) || !empty($filter['search'])): ?>
                    <div class="col-md-2">
                        <a href="<?= base_url('po') ?>" class="btn btn-link btn-sm text-decoration-none">Reset</a>
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
                            <th width="150">No PO / Tanggal</th>
                            <th>Pembuat</th>
                            <th>Supplier & Menu</th>
                            <th class="text-end">Total Biaya</th>
                            <th class="text-center">Status</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pos)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                    Belum ada data Purchase Order.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pos as $po): ?>
                                <tr>
                                    <td>
                                        <span class="fw-bold d-block"><?= $po['nomor_po'] ?></span>
                                        <small class="text-muted"><?= date('d/m/Y', strtotime($po['tanggal'])) ?></small>
                                    </td>
                                    <td>
                                        <span class="small"><?= $po['pembuat'] ?></span>
                                    </td>
                                    <td>
                                        <span class="fw-medium d-block text-dark"><?= $po['vendor'] ?></span>
                                        <small class="text-muted">Menu: <?= $po['menu'] ?></small>
                                    </td>
                                    <td class="text-end fw-bold">
                                        Rp <?= number_format($po['total'], 0, ',', '.') ?>
                                    </td>
                                    <td class="text-center">
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
                                        <span class="badge badge-status badge-<?= $badge ?>">
                                            <?= ucwords(str_replace('_', ' ', $po['status'])) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('po/show/' . $po['id']) ?>" class="btn btn-light border" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            
                                            <?php if (session()->get('role') == 'akuntan' && $po['status'] == 'menunggu_harga'): ?>
                                                <a href="<?= base_url('po/edit-price/' . $po['id']) ?>" class="btn btn-primary" title="Input Harga">
                                                    <i class="bi bi-currency-dollar"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (session()->get('role') == 'pic' && $po['status'] == 'menunggu_review'): ?>
                                                <a href="<?= base_url('po/review/' . $po['id']) ?>" class="btn btn-info text-white" title="Review">
                                                    <i class="bi bi-check2-square"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (in_array(session()->get('role'), ['admin', 'pic']) && $po['status'] == 'menunggu_approval'): ?>
                                                <a href="<?= base_url('po/approve/' . $po['id']) ?>" class="btn btn-success" title="Approve">
                                                    <i class="bi bi-check-circle"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($po['status'] == 'approved'): ?>
                                                <a href="<?= base_url('po/print/' . $po['id']) ?>" target="_blank" class="btn btn-secondary" title="Cetak">
                                                    <i class="bi bi-printer"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (session()->get('role') == 'admin'): ?>
                                                <a href="<?= base_url('po/delete/' . $po['id']) ?>" class="btn btn-danger" title="Hapus" onclick="return confirm('Hapus Purchase Order ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if (!empty($pos)): ?>
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Menampilkan <?= count($pos) ?> PO di halaman ini
                    </div>
                    <div>
                        <?= $pager->links('pos', 'bootstrap_full') ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
