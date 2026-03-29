<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Managemen Relawan</h4>
        <p class="text-muted small mb-0">Kelola daftar nama relawan per divisi</p>
    </div>
    <a href="<?= site_url('relawan/create') ?>" class="btn btn-primary px-4 shadow-sm">
        <i class="bi bi-person-plus-fill me-2"></i>Tambah Relawan
    </a>
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
                        <th class="py-3">Nama Relawan</th>
                        <th class="py-3" width="200">Divisi</th>
                        <th class="py-3 text-end pe-4" width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($relawan)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted small">
                                Belum ada data relawan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($relawan as $index => $r): ?>
                            <tr>
                                <td class="ps-4 fw-medium"><?= $index + 1 ?></td>
                                <td>
                                    <div class="fw-bold text-dark"><?= esc($r['nama']) ?></div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-light text-dark px-3 py-2 border">
                                        <?= esc(ucwords($r['divisi'])) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="<?= site_url('relawan/edit/'.$r['id']) ?>" class="btn btn-sm btn-outline-primary border-0" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <?php if (session()->get('role') === 'admin'): ?>
                                    <a href="<?= site_url('relawan/delete/'.$r['id']) ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus relawan ini?')" title="Hapus">
                                        <i class="bi bi-trash3"></i>
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
