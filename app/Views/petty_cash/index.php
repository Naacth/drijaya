<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Petty Cash SPPG</h4>
        <p class="text-muted small mb-0">Kelola operasional dana kas kecil harian</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('petty-cash/report') ?>" class="btn btn-outline-primary px-4 shadow-sm">
            <i class="bi bi-file-earmark-bar-graph me-2"></i>Laporan & Export
        </a>
        <a href="<?= site_url('petty-cash/create') ?>" class="btn btn-primary px-4 shadow-sm">
            <i class="bi bi-plus-circle me-2"></i>Tambah Entri
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success text-white p-3">
            <div class="small opacity-75">Pemasukkan (Bulan Ini)</div>
            <div class="fs-4 fw-bold">Rp <?= number_format($summary['pemasukkan'] ?? 0, 0, ',', '.') ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-danger text-white p-3">
            <div class="small opacity-75">Pengeluaran (Bulan Ini)</div>
            <div class="fs-4 fw-bold">Rp <?= number_format($summary['pengeluaran'] ?? 0, 0, ',', '.') ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white p-3">
            <div class="small opacity-75">Saldo Saat Ini</div>
            <div class="fs-4 fw-bold">Rp <?= number_format($currentSaldo, 0, ',', '.') ?></div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3" width="150">Tanggal</th>
                        <th class="py-3">Keterangan</th>
                        <th class="py-3 text-end" width="150">Pemasukkan</th>
                        <th class="py-3 text-end" width="150">Pengeluaran</th>
                        <th class="py-3 text-center" width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($entries)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted small">
                                Belum ada catatan petty cash.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($entries as $e): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold"><?= date('d M Y', strtotime($e['tanggal'])) ?></div>
                                </td>
                                <td><?= esc($e['keterangan']) ?></td>
                                <td class="text-end text-success fw-medium">
                                    <?= $e['pemasukkan'] > 0 ? 'Rp '.number_format($e['pemasukkan'], 0, ',', '.') : '-' ?>
                                </td>
                                <td class="text-end text-danger fw-medium">
                                    <?= $e['pengeluaran'] > 0 ? 'Rp '.number_format($e['pengeluaran'], 0, ',', '.') : '-' ?>
                                </td>
                                <td class="text-center">
                                    <?php if (session()->get('role') === 'admin'): ?>
                                    <a href="<?= site_url('petty-cash/delete/'.$e['id']) ?>" 
                                       class="btn btn-sm btn-light text-danger border" 
                                       onclick="return confirm('Hapus entri ini?')">
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
