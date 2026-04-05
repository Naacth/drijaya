<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('higiene-personil') ?>" class="text-decoration-none text-muted mb-2 d-inline-block small">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
        </a>
        <h4 class="mb-1 fw-bold text-gray-800">Detail Pemeriksaan Higiene Personil</h4>
        <p class="text-muted small mb-0">Informasi lengkap checklist pemeriksaan higiene petugas</p>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'higiene-personil/export-pdf-blank', 'printBlankRoles' => ['ahli_gizi', 'admin', 'pic'], 'printBlankWrapperClass' => 'mb-0']) ?>
        <?php if (session()->get('role') === 'ahli_gizi'): ?>
        <a href="<?= site_url('higiene-personil/edit/' . $header['id']) ?>" class="btn btn-warning btn-sm px-3 rounded-pill shadow-sm"><i class="fas fa-pencil-alt me-1"></i> Edit</a>
        <?php endif; ?>
        <a href="<?= site_url('higiene-personil/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger btn-sm px-3 rounded-pill shadow-sm">
            <i class="fas fa-file-pdf me-1"></i> Cetak PDF
        </a>
        <a href="<?= site_url('higiene-personil/export-excel/' . $header['id']) ?>" class="btn btn-outline-success btn-sm px-3 rounded-pill shadow-sm">
            <i class="fas fa-file-excel me-1"></i> Export Excel
        </a>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4 animate-in" style="animation-delay: 0.1s">
    <div class="card-body p-4">
        <div class="row mb-4 pb-3 border-bottom text-center text-md-start">
            <div class="col-md-6">
                <label class="small text-muted mb-1 text-uppercase fw-bold">Periode Laporan</label>
                <p class="mb-0 fw-bold fs-5 text-primary"><?= $header['bulan'] ?> <?= $header['tahun'] ?></p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <label class="small text-muted mb-1 text-uppercase fw-bold">ID Laporan</label>
                <p class="mb-0"><span class="badge bg-light text-dark border">#HP-<?= str_pad($header['id'], 5, '0', STR_PAD_LEFT) ?></span></p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="bg-light small fw-bold text-uppercase text-center">
                    <tr>
                        <th rowspan="2" class="align-middle py-3">No</th>
                        <th rowspan="2" class="align-middle">Tanggal</th>
                        <th rowspan="2" class="align-middle text-start">Nama Personil</th>
                        <th colspan="4" class="py-2 bg-white">Parameter Pemeriksaan</th>
                        <th rowspan="2" class="align-middle">Paraf</th>
                        <th rowspan="2" class="align-middle text-start">Keterangan</th>
                    </tr>
                    <tr class="bg-white">
                        <th width="60">Kuku</th>
                        <th width="60">Rambut</th>
                        <th width="60">Pakaian</th>
                        <th width="60">APD</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rekap as $i => $row): ?>
                    <tr>
                        <td class="text-center fw-bold text-muted"><?= $i + 1 ?></td>
                        <td class="text-center"><span class="badge bg-light text-dark border fw-normal"><?= date('d M Y', strtotime($row['tanggal'])) ?></span></td>
                        <td class="fw-bold"><?= $row['nama_personil'] ?></td>
                        <td class="text-center">
                            <i class="fas <?= isset($row['kuku']) ? 'fa-check-circle text-success' : 'fa-times-circle text-light' ?>"></i>
                        </td>
                        <td class="text-center">
                            <i class="fas <?= isset($row['rambut']) ? 'fa-check-circle text-success' : 'fa-times-circle text-light' ?>"></i>
                        </td>
                        <td class="text-center">
                            <i class="fas <?= isset($row['pakaian']) ? 'fa-check-circle text-success' : 'fa-times-circle text-light' ?>"></i>
                        </td>
                        <td class="text-center">
                            <i class="fas <?= isset($row['apd']) ? 'fa-check-circle text-success' : 'fa-times-circle text-light' ?>"></i>
                        </td>
                        <td class="text-center"><?= $row['paraf'] ?></td>
                        <td class="text-muted small"><?= $row['keterangan'] ?: '-' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="row mt-5 pt-4 border-top">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="p-3 bg-light rounded-3 text-center border">
                    <label class="small text-muted mb-3 d-block text-uppercase fw-bold">Check By (Ahli Gizi)</label>
                    <div style="height: 60px" class="d-flex align-items-center justify-content-center">
                        <span class="text-muted italic small">[ Tanda Tangan ]</span>
                    </div>
                    <p class="mb-0 fw-bold border-top pt-2 mx-auto w-75"><?= $header['nama_gizi'] ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3 text-center border">
                    <label class="small text-muted mb-3 d-block text-uppercase fw-bold">Ka.SPPG</label>
                    <div style="height: 60px" class="d-flex align-items-center justify-content-center">
                        <span class="text-muted italic small">[ Tanda Tangan ]</span>
                    </div>
                    <p class="mb-0 fw-bold border-top pt-2 mx-auto w-75"><?= $header['nama_kappg'] ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
