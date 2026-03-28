<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-gray-800"><?= $title ?></h4>
        <?php if(session()->get('role') == 'ahli_gizi'): ?>
        <a href="<?= site_url('pembersihan-trolly/create') ?>" class="btn btn-primary btn-sm px-3 shadow-sm rounded-pill">
            <i class="fas fa-plus me-1"></i> Buat Baru
        </a>
        <?php endif; ?>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4 py-3">Bulan / Tahun</th>
                            <th class="py-3">Dibuat Oleh</th>
                            <th class="py-3 text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($forms as $f): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark"><?= $f['bulan'] ?></div>
                                <small class="text-muted"><?= $f['tahun'] ?></small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border"><?= $f['user_nama'] ?></span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="<?= site_url('pembersihan-trolly/show/' . $f['id']) ?>" class="btn btn-outline-primary btn-sm px-3 rounded-pill">
                                    Detail
                                </a>
                                <?php if(session()->get('role') == 'ahli_gizi'): ?>
                                <a href="<?= site_url('pembersihan-trolly/edit/' . $f['id']) ?>" class="btn btn-outline-secondary btn-sm px-3 rounded-pill ms-1">
                                    Edit
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($forms)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <i class="fas fa-info-circle me-1"></i> Belum ada data laporan.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
