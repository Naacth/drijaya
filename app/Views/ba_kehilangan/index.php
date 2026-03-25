<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <h4 class="mb-1" style="font-weight: 700;">BA Kehilangan Ompreng</h4>
        <p class="text-muted small mb-0">Riwayat berita acara kehilangan ompreng.</p>
    </div>
    <?php if (session()->get('role') === 'aslap'): ?>
    <a href="<?= site_url('ba-kehilangan/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Buat Berita Acara Baru
    </a>
    <?php endif; ?>
</div>

<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-header">
        <h6><i class="bi bi-exclamation-triangle me-2"></i>Riwayat BA Kehilangan</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-premium table-hover">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>No. Surat</th>
                    <th>Tanggal</th>
                    <th>Nama Sekolah</th>
                    <th>Jumlah Hilang</th>
                    <th>Dibuat Oleh</th>
                    <th class="text-center" width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($forms)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada berita acara kehilangan.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($forms as $i => $form): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><span class="fw-medium text-dark"><?= esc($form['no_surat']) ?></span></td>
                        <td><?= date('d M Y', strtotime($form['tanggal_kejadian'])) ?></td>
                        <td><?= esc($form['nama_sekolah']) ?></td>
                        <td><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1"><?= $form['jumlah_ompreng_hilang'] ?> Pcs</span></td>
                        <td><?= esc($form['user_nama']) ?></td>
                        <td class="text-center">
                            <a href="<?= site_url('ba-kehilangan/show/' . $form['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
