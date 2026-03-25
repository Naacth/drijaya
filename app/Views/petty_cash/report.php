<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-0">Laporan Petty Cash</h4>
            <p class="text-muted small mb-0">Rekapitulasi pemasukkan, pengeluaran, dan saldo kas kecil</p>
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
                <button type="submit" class="btn btn-sm btn-dark px-3"><i class="bi bi-filter me-1"></i>Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-center">
            <div class="col-md-3">
                <div class="small text-muted">Saldo Awal</div>
                <div class="h5 fw-bold mb-0 text-secondary">Rp <?= number_format($saldoAwal, 0, ',', '.') ?></div>
            </div>
            <div class="col-md-3">
                <div class="small text-muted">Pemasukkan</div>
                <div class="h5 fw-bold mb-0 text-success">Rp <?= number_format($summary['pemasukkan'] ?? 0, 0, ',', '.') ?></div>
            </div>
            <div class="col-md-3">
                <div class="small text-muted">Pengeluaran</div>
                <div class="h5 fw-bold mb-0 text-danger">Rp <?= number_format($summary['pengeluaran'] ?? 0, 0, ',', '.') ?></div>
            </div>
            <div class="col-md-3 border-start">
                <div class="small text-muted">Saldo Akhir</div>
                <?php $saldoAkhir = $saldoAwal + ($summary['pemasukkan'] ?? 0) - ($summary['pengeluaran'] ?? 0); ?>
                <div class="h5 fw-bold mb-0 text-primary">Rp <?= number_format($saldoAkhir, 0, ',', '.') ?></div>
            </div>
        </div>
    </div>
</div>

<div class="mb-3 text-end">
    <a href="<?= site_url('petty-cash/export-pdf?start='.$start.'&end='.$end) ?>" target="_blank" class="btn btn-danger btn-sm px-3 shadow-sm">
        <i class="bi bi-file-earmark-pdf me-1"></i>Export PDF
    </a>
    <a href="<?= site_url('petty-cash/export-excel?start='.$start.'&end='.$end) ?>" class="btn btn-success btn-sm px-3 shadow-sm">
        <i class="bi bi-file-earmark-spreadsheet me-1"></i>Export Excel
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0 text-center">
                <thead class="bg-light text-dark small text-uppercase fw-bold">
                    <tr>
                        <th width="120">TANGGAL</th>
                        <th class="text-start ps-3">KETERANGAN</th>
                        <th width="150">PEMASUKKAN</th>
                        <th width="150">PENGELUARAN</th>
                        <th width="150">SALDO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>-</td>
                        <td class="text-start ps-3 italic">SALDO AWAL (SEBELUM <?= date('d/m/Y', strtotime($start)) ?>)</td>
                        <td>-</td>
                        <td>-</td>
                        <td class="text-end pe-3 fw-bold">Rp <?= number_format($saldoAwal, 0, ',', '.') ?></td>
                    </tr>
                    <?php if (empty($entries)): ?>
                        <tr>
                            <td colspan="5" class="py-4 text-muted small">Tidak ada transaksi pada periode ini.</td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        $runningSaldo = $saldoAwal;
                        foreach ($entries as $e): 
                            $runningSaldo += $e['pemasukkan'] - $e['pengeluaran'];
                        ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($e['tanggal'])) ?></td>
                                <td class="text-start ps-3 small"><?= esc($e['keterangan']) ?></td>
                                <td class="text-end pe-3 <?= $e['pemasukkan'] > 0 ? 'text-success' : '' ?>">
                                    <?= $e['pemasukkan'] > 0 ? number_format($e['pemasukkan'], 0, ',', '.') : '-' ?>
                                </td>
                                <td class="text-end pe-3 <?= $e['pengeluaran'] > 0 ? 'text-danger' : '' ?>">
                                    <?= $e['pengeluaran'] > 0 ? number_format($e['pengeluaran'], 0, ',', '.') : '-' ?>
                                </td>
                                <td class="text-end pe-3 fw-medium">
                                    Rp <?= number_format($runningSaldo, 0, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="bg-light fw-bold">
                            <td colspan="2" class="text-end pe-3">TOTAL & SALDO AKHIR</td>
                            <td class="text-end pe-3">Rp <?= number_format($summary['pemasukkan'] ?? 0, 0, ',', '.') ?></td>
                            <td class="text-end pe-3">Rp <?= number_format($summary['pengeluaran'] ?? 0, 0, ',', '.') ?></td>
                            <td class="text-end pe-3">Rp <?= number_format($runningSaldo, 0, ',', '.') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
