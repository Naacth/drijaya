<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="<?= site_url('absensi') ?>" class="text-decoration-none small text-muted">
        <i class="bi bi-arrow-left"></i> Kembali ke riwayat
    </a>
    <div class="d-flex justify-content-between align-items-end mt-2">
        <div>
            <h4 class="fw-bold mb-0">Detail Absensi Relawan</h4>
            <p class="text-muted small mb-0">Laporan tanggal: <strong><?= date('d F Y', strtotime($absensi['tanggal'])) ?></strong></p>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'absensi/export-pdf-blank', 'printBlankRoles' => ['aslap', 'admin', 'pic'], 'printBlankWrapperClass' => 'mb-0']) ?>
            <?php if (session()->get('role') === 'aslap' && (int)($absensi['created_by'] ?? 0) === (int)session()->get('user_id')): ?>
            <a href="<?= site_url('absensi/edit/'.$absensi['id']) ?>" class="btn btn-primary px-4 shadow-sm">
                <i class="bi bi-pencil-square me-2"></i>Ubah
            </a>
            <?php endif; ?>
            <a href="<?= site_url('absensi/export-pdf/'.$absensi['id']) ?>" target="_blank" class="btn btn-danger px-4 shadow-sm">
                <i class="bi bi-file-earmark-pdf me-2"></i>Cetak PDF
            </a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3" width="60">No</th>
                        <th class="py-3">Nama Relawan</th>
                        <th class="py-3">Divisi</th>
                        <th class="py-3 text-center" width="150">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $index => $item): ?>
                        <tr>
                            <td class="ps-4 text-muted"><?= $index + 1 ?></td>
                            <td class="fw-bold text-dark"><?= esc($item['nama']) ?></td>
                            <td>
                                <span class="badge bg-light text-dark border text-uppercase" style="font-size: 0.7rem;">
                                    <?= esc($item['divisi']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if ($item['status'] == 'Hadir'): ?>
                                    <span class="text-success fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Hadir</span>
                                <?php else: ?>
                                    <span class="text-danger fw-bold"><i class="bi bi-x-circle-fill me-1"></i> Tidak Hadir</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
