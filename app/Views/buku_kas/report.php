<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-0">Laporan Operasional</h4>
            <p class="text-muted small mb-0">Filter dan export laporan buku kas</p>
        </div>
        <form action="" method="get" class="d-flex gap-2">
            <div>
                <label class="small text-muted mb-1 d-block">Mulai</label>
                <input type="date" name="start" class="form-control form-control-sm" value="<?= $start ?>">
            </div>
            <div>
                <label class="small text-muted mb-1 d-block">Sampai</label>
                <input type="date" name="end" class="form-control form-control-sm" value="<?= $end ?>">
            </div>
            <div class="align-self-end">
                <button type="submit" class="btn btn-sm btn-dark px-3"><i class="bi bi-filter me-1"></i>Tampilkan</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm p-3 border-start border-primary border-4">
            <div class="small text-muted">Total Debet</div>
            <div class="h5 fw-bold mb-0">Rp <?= number_format($summary['debet'] ?? 0, 0, ',', '.') ?></div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm p-3 border-start border-danger border-4">
            <div class="small text-muted">Total Kredit</div>
            <div class="h5 fw-bold mb-0">Rp <?= number_format($summary['kredit'] ?? 0, 0, ',', '.') ?></div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm p-3 border-start border-success border-4">
            <div class="small text-muted">Sisa Saldo</div>
            <div class="h5 fw-bold mb-0">Rp <?= number_format(($summary['debet'] ?? 0) - ($summary['kredit'] ?? 0), 0, ',', '.') ?></div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 d-flex gap-2 align-items-center justify-content-end">
        <a href="<?= site_url('buku-kas/export-pdf?start='.$start.'&end='.$end) ?>" target="_blank" class="btn btn-danger btn-sm px-3 shadow-sm">
            <i class="bi bi-file-earmark-pdf me-1"></i>PDF
        </a>
        <a href="<?= site_url('buku-kas/export-excel?start='.$start.'&end='.$end) ?>" class="btn btn-success btn-sm px-3 shadow-sm">
            <i class="bi bi-file-earmark-spreadsheet me-1"></i>Excel
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0 text-center">
                <thead class="bg-light text-dark small text-uppercase fw-bold">
                    <tr>
                        <th width="120">TANGGAL</th>
                        <th class="text-start ps-4">OPERASIONAL (KETERANGAN)</th>
                        <th width="180">DEBET</th>
                        <th width="180">KREDIT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($entries)): ?>
                        <tr>
                            <td colspan="4" class="py-5 text-muted">Tidak ada data untuk periode ini.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($entries as $e): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($e['tanggal'])) ?></td>
                                <td class="text-start ps-4"><?= esc($e['keterangan']) ?></td>
                                <td class="text-end pe-4"><?= $e['debet'] > 0 ? number_format($e['debet'], 0, ',', '.') : '-' ?></td>
                                <td class="text-end pe-4"><?= $e['kredit'] > 0 ? number_format($e['kredit'], 0, ',', '.') : '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="bg-light fw-bold">
                            <td colspan="2" class="text-end pe-4">TOTAL</td>
                            <td class="text-end pe-4">Rp <?= number_format($summary['debet'] ?? 0, 0, ',', '.') ?></td>
                            <td class="text-end pe-4">Rp <?= number_format($summary['kredit'] ?? 0, 0, ',', '.') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
