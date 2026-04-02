<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <a href="<?= site_url('absensi/show/' . $absensi['id']) ?>" class="text-decoration-none small text-muted">
                <i class="bi bi-arrow-left"></i> Kembali ke detail
            </a>
            <h4 class="fw-bold mt-2">Ubah Absensi Relawan</h4>
            <p class="text-muted small mb-0">Sesuaikan tanggal dan status kehadiran.</p>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger mb-4 shadow-sm">
        <i class="bi bi-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<form action="<?= site_url('absensi/update/' . $absensi['id']) ?>" method="post">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <label class="form-label fw-bold">Tanggal Absensi</label>
            <input type="date" name="tanggal" class="form-control" style="max-width:280px" required value="<?= esc($absensi['tanggal']) ?>">
        </div>
    </div>

    <?php if (empty($grouped)): ?>
        <div class="alert alert-warning text-center p-5">
            <p class="text-muted mb-0">Belum ada data relawan untuk SPPG ini.</p>
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
                                        <?php $st = $statusByRelawan[$r['id']] ?? 'Hadir'; ?>
                                        <tr>
                                            <td class="ps-4 small text-muted"><?= $idx + 1 ?></td>
                                            <td class="fw-bold"><?= esc($r['nama']) ?></td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-4">
                                                    <div class="form-check custom-radio hadir">
                                                        <input class="form-check-input" type="radio" name="status[<?= $r['id'] ?>]" id="hadir_<?= $r['id'] ?>" value="Hadir" <?= $st === 'Hadir' ? 'checked' : '' ?>>
                                                        <label class="form-check-label fw-bold text-success" for="hadir_<?= $r['id'] ?>">Hadir</label>
                                                    </div>
                                                    <div class="form-check custom-radio tidak-hadir">
                                                        <input class="form-check-input" type="radio" name="status[<?= $r['id'] ?>]" id="tidak_<?= $r['id'] ?>" value="Tidak Hadir" <?= $st === 'Tidak Hadir' ? 'checked' : '' ?>>
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
                <i class="bi bi-check-circle-fill me-2"></i>Simpan Perubahan Absensi
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
