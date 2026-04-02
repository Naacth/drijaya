<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <h4 class="mb-1" style="font-weight: 700;">Form Pemberitahuan Hasil Kerja</h4>
        <p class="text-muted small mb-0">Riwayat form pemberitahuan PIC per divisi.</p>
    </div>
    <?php if (session()->get('role') === 'aslap'): ?>
    <a href="<?= site_url('pemberitahuan-kerja/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Buat Form Baru
    </a>
    <?php endif; ?>
</div>

<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-header">
        <h6><i class="bi bi-megaphone me-2"></i>Riwayat Pemberitahuan</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-premium table-hover">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>No. Surat</th>
                    <th>Tanggal</th>
                    <th>Divisi</th>
                    <th>Nama PIC</th>
                    <th>Dibuat Oleh</th>
                    <th class="text-center" width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($forms)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data pemberitahuan.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($forms as $i => $form): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><span class="fw-medium text-dark"><?= esc($form['no_surat']) ?></span></td>
                        <td><?= date('d M Y', strtotime($form['tanggal'])) ?></td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1"><?= esc($form['divisi']) ?></span></td>
                        <td><?= esc($form['nama_pic']) ?></td>
                        <td><?= esc($form['user_nama']) ?></td>
                        <td class="text-center">
                            <a href="<?= site_url('pemberitahuan-kerja/show/' . $form['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            <?php if (session()->get('role') === 'admin' || session()->get('role') === 'aslap'): ?>
                            <a href="<?= site_url('pemberitahuan-kerja/edit/' . $form['id']) ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3" title="Ubah">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (session()->get('role') === 'admin'): ?>
                            <a href="<?= site_url('pemberitahuan-kerja/delete/' . $form['id']) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Yakin hapus data ini?')">
                                <i class="bi bi-trash"></i>
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
