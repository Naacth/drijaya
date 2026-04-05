<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <h4 class="mb-1" style="font-weight: 700;">Estimasi Anggaran (Menu Kering)</h4>
        <p class="text-muted small mb-0">Rencana dan perhitungan estimasi biaya porsi harian.</p>
    </div>
    <div class="text-end d-flex gap-2 align-items-center flex-wrap justify-content-end">
        <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'estimasi-anggaran/export-pdf-blank', 'printBlankRoles' => ['ahli_gizi', 'admin', 'pic'], 'printBlankWrapperClass' => 'mb-0']) ?>
        <?php if (session()->get('role') === 'ahli_gizi'): ?>
    <a href="<?= site_url('estimasi-anggaran/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Buat Baru</a>
    <?php endif; ?>
    </div>
</div>

<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-header"><h6><i class="bi bi-calculator me-2"></i>Riwayat Estimasi Anggaran</h6></div>
    <div class="table-responsive">
        <table class="table table-premium table-hover">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Periode Tanggal</th>
                    <th>Kategori Porsi</th>
                    <th>Total Kalkulasi</th>
                    <th>Dibuat Oleh</th>
                    <th class="text-center" width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($forms)): ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data.</td></tr>
                <?php else: foreach ($forms as $i => $form): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><span class="fw-medium text-dark"><?= date('d/m/y', strtotime($form['tanggal_mulai'])) ?> - <?= date('d/m/y', strtotime($form['tanggal_selesai'])) ?></span></td>
                    <td><span class="badge <?= $form['kategori_porsi'] === 'Besar' ? 'bg-primary' : 'bg-info' ?> rounded-pill px-3"><?= esc($form['kategori_porsi']) ?></span></td>
                    <td><span class="fw-bold text-success text-nowrap">Rp <?= number_format($form['total_kalkulasi'], 0, ',', '.') ?></span></td>
                    <td><?= esc($form['user_nama']) ?></td>
                    <td class="text-center text-nowrap">
                        <a href="<?= site_url('estimasi-anggaran/show/' . $form['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="bi bi-eye"></i> Detail</a>
                        <?php if (session()->get('role') === 'ahli_gizi'): ?>
                        <a href="<?= site_url('estimasi-anggaran/edit/' . $form['id']) ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3"><i class="bi bi-pencil"></i> Edit</a>
                        <?php endif; ?>
                        <?php if (session()->get('role') === 'admin'): ?>
                        <a href="<?= site_url('estimasi-anggaran/delete/' . $form['id']) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i> Hapus</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
