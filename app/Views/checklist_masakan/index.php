<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <h4 class="mb-1" style="font-weight: 700;">Checklist Pemeriksaan Hasil Masakan</h4>
        <p class="text-muted small mb-0">Kontrol kualitas (QC) masakan sesuai standar gramasi dan organoleptik.</p>
    </div>
    <div class="text-end d-flex gap-2 align-items-center flex-wrap justify-content-end">
        <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'checklist-masakan/export-pdf-blank', 'printBlankRoles' => ['ahli_gizi', 'admin'], 'printBlankWrapperClass' => 'mb-0']) ?>
        <?php if (session()->get('role') === 'ahli_gizi'): ?>
    <a href="<?= site_url('checklist-masakan/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Buat Baru</a>
    <?php endif; ?>
    </div>
</div>

<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-header"><h6><i class="bi bi-clipboard-check me-2"></i>Riwayat Checklist QC Masakan</h6></div>
    <div class="table-responsive">
        <table class="table table-premium table-hover">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Tanggal</th>
                    <th>Waktu Penyajian</th>
                    <th>Dibuat Oleh</th>
                    <th class="text-center" width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($forms)): ?>
                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data.</td></tr>
                <?php else: foreach ($forms as $i => $form): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><span class="fw-medium text-dark"><?= date('d M Y', strtotime($form['tanggal'])) ?></span></td>
                    <td><span class="badge bg-light text-dark border rounded-pill px-3"><?= date('H:i', strtotime($form['waktu_penyajian'])) ?></span></td>
                    <td><?= esc($form['user_nama']) ?></td>
                    <td class="text-center text-nowrap">
                        <a href="<?= site_url('checklist-masakan/show/' . $form['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="bi bi-eye"></i> Detail</a>
                        <?php if (session()->get('role') === 'ahli_gizi'): ?>
                        <a href="<?= site_url('checklist-masakan/edit/' . $form['id']) ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3"><i class="bi bi-pencil"></i> Edit</a>
                        <?php endif; ?>
                        <?php if (session()->get('role') === 'admin'): ?>
                        <a href="<?= site_url('checklist-masakan/delete/' . $form['id']) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i> Hapus</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
