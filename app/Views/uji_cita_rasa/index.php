<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <h4 class="mb-1" style="font-weight: 700;">Uji Cita Rasa (Tester)</h4>
        <p class="text-muted small mb-0">Validasi kualitas rasa dan kesesuaian porsi masakan.</p>
    </div>
    <div class="text-end d-flex gap-2 align-items-center flex-wrap justify-content-end">
        <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'uji-cita-rasa/export-pdf-blank', 'printBlankRoles' => ['ahli_gizi', 'admin', 'pic'], 'printBlankWrapperClass' => 'mb-0']) ?>
        <?php if (in_array(session()->get('role'), ['ahli_gizi'])): ?>
    <a href="<?= site_url('uji-cita-rasa/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Buat Baru</a>
    <?php endif; ?>
    </div>
</div>
<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-header"><h6><i class="bi bi-cup-straw me-2"></i>Riwayat Uji Cita Rasa</h6></div>
    <div class="table-responsive">
        <table class="table table-premium table-hover">
            <thead><tr><th width="50">No</th><th>Tanggal</th><th>Checker</th><th>Dibuat Oleh</th><th>Waktu Input</th><th class="text-center" width="150">Aksi</th></tr></thead>
            <tbody>
                <?php if (empty($forms)): ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data.</td></tr>
                <?php else: foreach ($forms as $i => $form): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= date('d M Y', strtotime($form['tanggal'])) ?></td>
                    <td><span class="fw-medium text-dark"><?= esc($form['nama_checker']) ?></span></td>
                    <td><?= esc($form['user_nama']) ?></td>
                    <td><small class="text-muted"><?= date('d M Y, H:i', strtotime($form['created_at'])) ?></small></td>
                    <td class="text-center text-nowrap">
                        <a href="<?= site_url('uji-cita-rasa/show/' . $form['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="bi bi-eye"></i> Detail</a>
                        <?php if (session()->get('role') === 'ahli_gizi'): ?>
                        <a href="<?= site_url('uji-cita-rasa/edit/' . $form['id']) ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3"><i class="bi bi-pencil"></i> Edit</a>
                        <?php endif; ?>
                        <?php if (session()->get('role') === 'admin'): ?>
                        <a href="<?= site_url('uji-cita-rasa/delete/' . $form['id']) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i> Hapus</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
