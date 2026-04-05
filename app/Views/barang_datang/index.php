<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <h4 class="mb-1" style="font-weight: 700;">Formulir Barang Datang</h4>
        <p class="text-muted small mb-0">Kelola riwayat input penerimaan barang.</p>
    </div>
    <div class="text-end">
        <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'barang-datang/export-pdf-blank', 'printBlankRoles' => ['aslap', 'admin', 'pic']]) ?>
        <?php if (session()->get('role') === 'aslap' || session()->get('role') === 'admin'): ?>
        <a href="<?= site_url('barang-datang/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Buat Laporan Baru
        </a>
        <?php endif; ?>
    </div>
</div>

<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-header">
        <h6><i class="bi bi-box-seam me-2"></i>Riwayat Barang Datang</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-premium table-hover">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Tanggal</th>
                    <th>Penanggung Jawab</th>
                    <th>Dibuat Oleh</th>
                    <th>Waktu Input</th>
                    <th class="text-center" width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($forms)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data barang datang.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($forms as $i => $form): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= date('d M Y', strtotime($form['tanggal'])) ?></td>
                        <td><span class="fw-medium text-dark"><?= esc($form['penanggung_jawab']) ?></span></td>
                        <td><?= esc($form['user_nama']) ?></td>
                        <td><small class="text-muted"><?= date('d M Y, H:i', strtotime($form['created_at'])) ?></small></td>
                        <td class="text-center">
                            <a href="<?= site_url('barang-datang/show/' . $form['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            <?php if (session()->get('role') === 'admin' || session()->get('role') === 'aslap'): ?>
                            <a href="<?= site_url('barang-datang/edit/' . $form['id']) ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3" title="Ubah">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (session()->get('role') === 'admin'): ?>
                            <form action="<?= site_url('barang-datang/delete/' . $form['id']) ?>" method="post" class="d-inline">
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
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
