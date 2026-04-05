<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid animate-in">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Management Data Penerima Manfaat</h4>
            <p class="text-muted small">Daftar sekolah dan rekapan porsi makanan harian.</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'penerima-manfaat/export-pdf-blank', 'printBlankRoles' => ['aslap', 'admin', 'pic'], 'printBlankWrapperClass' => 'mb-0']) ?>
        <?php if (session()->get('role') == 'aslap'): ?>
            <a href="<?= base_url('penerima-manfaat/create') ?>" class="btn btn-primary btn-sm shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Input Data Baru
            </a>
        <?php endif; ?>
        </div>
    </div>

    <div class="row g-3 mb-4 animate-in">
        <div class="col-md-10">
            <form action="" method="GET" class="row g-2">
                <div class="col-md-3">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="draft" <?= ($filter['status'] ?? '') == 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="submitted" <?= ($filter['status'] ?? '') == 'submitted' ? 'selected' : '' ?>>Submitted</option>
                        <option value="approved" <?= ($filter['status'] ?? '') == 'approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="rejected" <?= ($filter['status'] ?? '') == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Cari SPPG atau Kecamatan..." value="<?= esc($filter['search'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-light btn-sm w-100 border">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                </div>
                <?php if (!empty($filter['status']) || !empty($filter['search'])): ?>
                    <div class="col-md-2">
                        <a href="<?= base_url('penerima-manfaat') ?>" class="btn btn-link btn-sm text-decoration-none">Reset</a>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="data-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-premium align-middle mb-0">
                    <thead>
                        <tr>
                            <th width="150">Tanggal</th>
                            <th>SPPG / Kecamatan</th>
                            <th>Pembuat</th>
                            <th class="text-center">Status</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($items)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                    Belum ada data penerima manfaat.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td class="fw-bold"><?= date('d/m/Y', strtotime($item['tanggal'])) ?></td>
                                    <td>
                                        <span class="fw-medium d-block text-dark"><?= $item['sppg'] ?></span>
                                        <small class="text-muted"><?= $item['kecamatan'] ?></small>
                                    </td>
                                    <td>
                                        <span class="small text-muted"><?= $item['pembuat'] ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $badge = 'secondary';
                                        switch ($item['status']) {
                                            case 'draft': $badge = 'draft'; break;
                                            case 'submitted': $badge = 'pending'; break;
                                            case 'approved': $badge = 'disetujui'; break;
                                            case 'rejected': $badge = 'ditolak'; break;
                                        }
                                        ?>
                                        <span class="badge badge-status badge-<?= $badge ?>">
                                            <?= ucwords($item['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('penerima-manfaat/show/' . $item['id']) ?>" class="btn btn-light border" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <?php if (session()->get('role') === 'aslap'): ?>
                                            <a href="<?= base_url('penerima-manfaat/edit/' . $item['id']) ?>" class="btn btn-light border" title="Ubah">
                                                <i class="bi bi-pencil-square text-primary"></i>
                                            </a>
                                            <?php endif; ?>
                                            <a href="<?= base_url('penerima-manfaat/export-excel/' . $item['id']) ?>" class="btn btn-light border" title="Export Excel">
                                                <i class="bi bi-file-earmark-excel text-success"></i>
                                            </a>
                                            <a href="<?= base_url('penerima-manfaat/export-pdf/' . $item['id']) ?>" target="_blank" class="btn btn-light border" title="Export PDF">
                                                <i class="bi bi-file-pdf text-danger"></i>
                                            </a>
                                            <?php if (session()->get('role') === 'admin'): ?>
                                            <a href="<?= base_url('penerima-manfaat/delete/' . $item['id']) ?>" class="btn btn-light border text-danger" title="Hapus" onclick="return confirm('Yakin hapus data ini?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if (!empty($items)): ?>
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Menampilkan <?= count($items) ?> data di halaman ini
                    </div>
                    <div>
                        <?= $pager->links('beneficiaries', 'bootstrap_full') ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
