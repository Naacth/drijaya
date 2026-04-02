<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <h4 class="mb-1" style="font-weight: 700;">Stok Opname</h4>
        <p class="text-muted small mb-0">Pencatatan stok opname mingguan (hanya hari Jumat).</p>
    </div>
    <?php if (session()->get('role') === 'aslap'): ?>
        <?php if (!empty($is_friday)): ?>
        <a href="<?= site_url('stok-opname/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Input Stok Opname
        </a>
        <?php else: ?>
        <button class="btn btn-secondary" disabled>
            <i class="bi bi-lock me-1"></i> Hanya bisa diinput hari Jumat
        </button>
        <?php endif; ?>
    <?php endif; ?>
</div>

<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-header">
        <h6><i class="bi bi-calculator me-2"></i>Riwayat Stok Opname</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-premium table-hover">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Periode</th>
                    <th>Nama SPPG</th>
                    <th>Dibuat Oleh</th>
                    <th>Waktu Input</th>
                    <th class="text-center" width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($forms)): ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data stok opname.</td></tr>
                <?php else: ?>
                    <?php foreach ($forms as $i => $form): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= date('d/m/Y', strtotime($form['periode_awal'])) ?> — <?= date('d/m/Y', strtotime($form['periode_akhir'])) ?></td>
                        <td class="fw-medium text-dark"><?= esc($form['nama_sppg']) ?></td>
                        <td><?= esc($form['user_nama']) ?></td>
                        <td><small class="text-muted"><?= date('d M Y, H:i', strtotime($form['created_at'])) ?></small></td>
                        <td class="text-center">
                            <a href="<?= site_url('stok-opname/show/' . $form['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            <?php if (session()->get('role') === 'admin' || session()->get('role') === 'aslap'): ?>
                            <a href="<?= site_url('stok-opname/edit/' . $form['id']) ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3" title="Ubah">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (session()->get('role') === 'admin'): ?>
                            <a href="<?= site_url('stok-opname/delete/' . $form['id']) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
