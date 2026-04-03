<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'absensi/export-pdf-blank']) ?>



<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <a href="<?= site_url('absensi') ?>" class="text-decoration-none small text-muted">
                <i class="bi bi-arrow-left"></i> Kembali h history
            </a>
            <h4 class="fw-bold mt-2">Input Absensi Relawan</h4>
            <p class="text-muted small mb-0">Silakan pilih status kehadiran untuk setiap relawan</p>
        </div>
        <div class="text-end">
            <span class="badge bg-light text-dark border px-3 py-2">
                <i class="bi bi-calendar-event me-2"></i><?= date('d F Y') ?>
            </span>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger mb-4 shadow-sm">
        <i class="bi bi-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<form action="<?= site_url('absensi/store') ?>" method="post">
    <input type="hidden" name="tanggal" value="<?= $today ?>">

    <?php if (empty($grouped)): ?>
        <div class="alert alert-warning text-center p-5">
            <i class="bi bi-people mb-3 d-block fs-1"></i>
            <h5>Belum ada data relawan!</h5>
            <p class="text-muted">Harap tambahkan data relawan terlebih dahulu di menu Managemen Relawan.</p>
            <a href="<?= site_url('relawan/create') ?>" class="btn btn-warning mt-2 px-4 shadow-sm">Tambah Relawan</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($grouped as $divisi => $relawans): ?>
                <div class="col-12">
                    <div class="card border-0 shadow-sm overflow-hidden">
                        <div class="card-header bg-dark text-white py-3">
                            <h6 class="mb-0 fw-bold text-uppercase"><i class="bi bi-collection me-2 text-warning"></i>Divisi: <?= esc(ucwords($divisi)) ?></h6>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light small">
                                    <tr>
                                        <th class="ps-4">No</th>
                                        <th width="40%">Nama Relawan</th>
                                        <th class="text-center">Status Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($relawans as $idx => $r): ?>
                                        <tr>
                                            <td class="ps-4 small text-muted"><?= $idx + 1 ?></td>
                                            <td class="fw-bold"><?= esc($r['nama']) ?></td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-4">
                                                    <div class="form-check custom-radio hadir">
                                                        <input class="form-check-input" type="radio" name="status[<?= $r['id'] ?>]" id="hadir_<?= $r['id'] ?>" value="Hadir" checked>
                                                        <label class="form-check-label fw-bold text-success" for="hadir_<?= $r['id'] ?>">Hadir</label>
                                                    </div>
                                                    <div class="form-check custom-radio tidak-hadir">
                                                        <input class="form-check-input" type="radio" name="status[<?= $r['id'] ?>]" id="tidak_<?= $r['id'] ?>" value="Tidak Hadir">
                                                        <label class="form-check-label fw-bold text-danger" for="tidak_<?= $r['id'] ?>">Tidak Hadir</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-5 mb-5">
            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 shadow-lg fw-bold">
                <i class="bi bi-check-circle-fill me-2"></i>Simpan Laporan Absensi Hari Ini
            </button>
        </div>
    <?php endif; ?>
</form>

<style>
    .custom-radio {
        padding: 5px 15px;
        border-radius: 8px;
        transition: all 0.2s;
        border: 1px solid #eee;
    }
    .custom-radio:hover {
        background: #f8fafc;
    }
    .custom-radio.hadir .form-check-input:checked {
        background-color: #10b981;
        border-color: #10b981;
    }
    .custom-radio.tidak-hadir .form-check-input:checked {
        background-color: #ef4444;
        border-color: #ef4444;
    }
</style>

<?= $this->endSection() ?>
