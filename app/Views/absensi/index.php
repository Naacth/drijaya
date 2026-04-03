<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Riwayat Absensi Relawan</h4>
        <p class="text-muted small mb-0">Daftar kehadiran harian relawan SPPG</p>
    </div>
    <div class="d-flex gap-2">
        <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'absensi/export-pdf-blank', 'printBlankRoles' => ['aslap', 'admin'], 'printBlankWrapperClass' => 'mb-0']) ?>
        <a href="<?= site_url('absensi/rekap') ?>" class="btn btn-outline-primary px-4 shadow-sm">
            <i class="bi bi-calendar-range me-2"></i>Rekap 2 Minggu
        </a>
        <a href="<?= site_url('absensi/create') ?>" class="btn btn-primary px-4 shadow-sm">
            <i class="bi bi-calendar-check me-2"></i>Absen Hari Ini
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3" width="60">No</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Total Relawan</th>
                        <th class="py-3 text-end pe-4" width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($absensi)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted small">
                                Belum ada data absensi.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($absensi as $index => $a): ?>
                            <tr>
                                <td class="ps-4 fw-medium"><?= $index + 1 ?></td>
                                <td>
                                    <div class="fw-bold text-dark"><?= date('d F Y', strtotime($a['tanggal'])) ?></div>
                                    <small class="text-muted"><?= date('l', strtotime($a['tanggal'])) ?></small>
                                </td>
                                <td>
                                    <?php
                                        $db = \Config\Database::connect();
                                        $total = $db->table('absensi_items')->where('absensi_id', $a['id'])->where('status', 'Hadir')->countAllResults();
                                    ?>
                                    <span class="badge bg-success-soft text-success px-2 py-1">
                                        <?= $total ?> Relawan Hadir
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="<?= site_url('absensi/show/'.$a['id']) ?>" class="btn btn-sm btn-light border" title="Lihat">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    <?php if (session()->get('role') === 'aslap' && (int)($a['created_by'] ?? 0) === (int)session()->get('user_id')): ?>
                                    <a href="<?= site_url('absensi/edit/'.$a['id']) ?>" class="btn btn-sm btn-outline-primary border" title="Ubah">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <?php endif; ?>
                                    <a href="<?= site_url('absensi/export-pdf/'.$a['id']) ?>" target="_blank" class="btn btn-sm btn-outline-danger border" title="Export PDF">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                    <?php if (session()->get('role') === 'admin'): ?>
                                    <a href="<?= site_url('absensi/delete/'.$a['id']) ?>" class="btn btn-sm btn-outline-danger border" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
</div>

<?= $this->endSection() ?>
