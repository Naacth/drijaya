<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <h4 class="mb-1" style="font-weight: 700;">Rekap Jumlah Porsi</h4>
        <p class="text-muted small mb-0">Riwayat rekap porsi yang terdistribusikan harian.</p>
    </div>
    <div class="text-end d-flex gap-2 align-items-center flex-wrap justify-content-end">
        <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'rekap-porsi/export-pdf-blank', 'printBlankRoles' => ['aslap', 'admin', 'pic'], 'printBlankWrapperClass' => 'mb-0']) ?>
    <?php if (session()->get('role') === 'aslap'): ?>
    <a href="<?= site_url('rekap-porsi/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Input Rekap Porsi
    </a>
    <?php endif; ?>
    </div>
</div>

<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-header">
        <h6><i class="bi bi-pie-chart me-2"></i>Riwayat Rekap Porsi</h6>
    </div>
    <div class="table-responsive">
        <table class="table table-premium table-hover">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Hari dan Tanggal</th>
                    <th>Dibuat Oleh</th>
                    <th>Waktu Input</th>
                    <th class="text-center" width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($forms)): ?>
                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data rekap porsi.</td></tr>
                <?php else: ?>
                    <?php 
                    $days = ['Sunday'=>'MINGGU','Monday'=>'SENIN','Tuesday'=>'SELASA','Wednesday'=>'RABU','Thursday'=>'KAMIS','Friday'=>'JUMAT','Saturday'=>'SABTU'];
                    $months = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                    foreach ($forms as $i => $form): 
                        $hari = $days[date('l', strtotime($form['tanggal']))];
                        $tgl = date('d', strtotime($form['tanggal'])) . ' ' . $months[(int)date('m', strtotime($form['tanggal']))] . ' ' . date('Y', strtotime($form['tanggal']));
                    ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td class="fw-medium text-dark"><?= $hari ?>, <?= $tgl ?></td>
                        <td><?= esc($form['user_nama']) ?></td>
                        <td><small class="text-muted"><?= date('d M Y, H:i', strtotime($form['created_at'])) ?></small></td>
                        <td class="text-center">
                            <a href="<?= site_url('rekap-porsi/show/' . $form['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            <?php if (session()->get('role') === 'admin' || session()->get('role') === 'aslap'): ?>
                            <a href="<?= site_url('rekap-porsi/edit/' . $form['id']) ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3" title="Ubah">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (session()->get('role') === 'admin'): ?>
                            <a href="<?= site_url('rekap-porsi/delete/' . $form['id']) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
