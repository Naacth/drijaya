<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <h4 class="mb-1" style="font-weight: 700;">Pencucian Bahan Makanan</h4>
        <p class="text-muted small mb-0">Kontrol kebersihan bahan baku menggunakan bahan kimia (food grade) dan pembersihan fisik.</p>
    </div>
    <?php if (session()->get('role') === 'ahli_gizi'): ?>
    <a href="<?= site_url('pencucian-bahan/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Buat Baru</a>
    <?php endif; ?>
</div>
<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-header"><h6><i class="bi bi-droplet me-2"></i>Riwayat Pencucian Bahan</h6></div>
    <div class="table-responsive">
        <table class="table table-premium table-hover">
            <thead><tr><th>No</th><th>Tanggal</th><th>Petugas</th><th>Waktu Input</th><th class="text-center">Aksi</th></tr></thead>
            <tbody>
                <?php if (empty($forms)): ?>
                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data.</td></tr>
                <?php else: foreach ($forms as $i => $form): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= date('d M Y', strtotime($form['tanggal'])) ?></td>
                    <td><span class="fw-medium text-dark"><?= esc($form['nama_petugas']) ?></span></td>
                    <td><small class="text-muted"><?= date('d/m/Y H:i', strtotime($form['created_at'])) ?></small></td>
                    <td class="text-center text-nowrap">
                        <a href="<?= site_url('pencucian-bahan/show/' . $form['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="bi bi-eye"></i> Detail</a>
                        <?php if (session()->get('role') === 'ahli_gizi'): ?>
                        <a href="<?= site_url('pencucian-bahan/edit/' . $form['id']) ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3"><i class="bi bi-pencil"></i> Edit</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
