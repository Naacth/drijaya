<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <h4 class="mb-1" style="font-weight: 700;">Penanganan Makanan Lebih</h4>
        <p class="text-muted small mb-0">Inventarisasi dan tindak lanjut sisa makanan berlebih.</p>
    </div>
    <?php if (session()->get('role') === 'ahli_gizi'): ?>
    <a href="<?= site_url('makanan-lebih/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Buat Baru</a>
    <?php endif; ?>
</div>
<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-header"><h6><i class="bi bi-box-seam me-2"></i>Riwayat Food Surplus</h6></div>
    <div class="table-responsive">
        <table class="table table-premium table-hover">
            <thead><tr><th>No</th><th>Tanggal</th><th>Cook</th><th>Chef</th><th>Ahli Gizi</th><th class="text-center">Aksi</th></tr></thead>
            <tbody>
                <?php if (empty($forms)): ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data.</td></tr>
                <?php else: foreach ($forms as $i => $form): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= date('d M Y', strtotime($form['tanggal'])) ?></td>
                    <td><?= esc($form['nama_cook']) ?></td>
                    <td><?= esc($form['nama_chef'] ?: '-') ?></td>
                    <td><?= esc($form['nama_ahli_gizi'] ?: '-') ?></td>
                    <td class="text-center text-nowrap">
                        <a href="<?= site_url('makanan-lebih/show/' . $form['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="bi bi-eye"></i> Detail</a>
                        <?php if (session()->get('role') === 'ahli_gizi'): ?>
                        <a href="<?= site_url('makanan-lebih/edit/' . $form['id']) ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3"><i class="bi bi-pencil"></i> Edit</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
