<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid animate-in">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Detail Rute Pengiriman</h4>
            <p class="text-muted small">Rincian alur pengiriman dan status monitoring.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('routes/surat-jalan/' . $header['id']) ?>" target="_blank" class="btn btn-primary btn-sm">
                <i class="bi bi-printer me-1"></i> Cetak Surat Jalan
            </a>
            <a href="<?= base_url('routes/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-file-pdf me-1"></i> Export PDF
            </a>
            <a href="<?= base_url('routes') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-9">
            <div class="data-card h-100">
                <div class="card-header py-3 bg-light border-bottom">
                    <h6 class="m-0 fw-bold text-uppercase ls-1 small"><i class="bi bi-info-circle me-2"></i>Informasi Pengiriman</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <label class="text-muted small text-uppercase ls-1 d-block mb-1">Tanggal</label>
                            <span class="fw-bold h5 mb-0"><?= date('d F Y', strtotime($header['tanggal'])) ?></span>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="text-muted small text-uppercase ls-1 d-block mb-1">Mobil</label>
                            <span class="fw-bold h5 mb-0 text-primary"><?= $header['mobil'] ?></span>
                        </div>
                        <div class="col-md-3 mb-4">
                            <label class="text-muted small text-uppercase ls-1 d-block mb-1">Driver</label>
                            <span class="fw-bold h5 mb-0"><?= $header['driver'] ?></span>
                        </div>
                        <div class="col-md-3 mb-4 text-end">
                            <label class="text-muted small text-uppercase ls-1 d-block mb-1">Status</label>
                            <span class="badge badge-status badge-<?= ($header['status'] == 'approved' ? 'disetujui' : ($header['status'] == 'rejected' ? 'ditolak' : 'pending')) ?>">
                                <?= ucwords($header['status']) ?>
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small text-uppercase ls-1 d-block mb-1">Unit SPPG</label>
                            <span class="fw-bold"><?= $header['sppg'] ?></span>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small text-uppercase ls-1 d-block mb-1">Kecamatan</label>
                            <span class="fw-bold"><?= $header['kecamatan'] ?></span>
                        </div>
                        <div class="col-md-4 text-end">
                            <label class="text-muted small text-uppercase ls-1 d-block mb-1">Total Porsi Mobil</label>
                            <span class="fw-bold text-primary h5 mb-0"><?= number_format($header['total_porsi']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
             <div class="data-card h-100 text-center">
                <div class="card-body p-4">
                    <div class="avatar avatar-lg bg-soft-primary text-primary mb-3 mx-auto">
                        <i class="bi bi-file-earmark-check fs-2"></i>
                    </div>
                    <h6 class="fw-bold mb-1"><?= $header['pembuat'] ?></h6>
                    <p class="text-muted small mb-0">Asisten Lapangan</p>
                    <hr class="my-3 opacity-10">
                    <p class="small text-muted mb-0 font-monospace">Dibuat: <?= date('d/m/Y H:i', strtotime($header['created_at'])) ?></p>
                </div>
             </div>
        </div>
    </div>

    <div class="data-card mb-4">
        <div class="table-responsive">
            <table class="table table-premium align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Sekolah Tujuan</th>
                        <th class="text-center">Sesi</th>
                        <th class="text-center">Jam Antar</th>
                        <th class="text-center">P. Besar</th>
                        <th class="text-center">P. Kecil</th>
                        <th class="text-end">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $index => $item): ?>
                        <tr>
                            <td class="text-center text-muted small"><?= $index + 1 ?></td>
                            <td class="fw-bold text-dark"><?= $item['nama_sekolah'] ?></td>
                            <td class="text-center">
                                <span class="badge bg-soft-info text-info rounded-pill px-3">
                                    <?= $item['sesi'] ?>
                                </span>
                            </td>
                            <td class="text-center fw-medium"><?= date('H:i', strtotime($item['jam_antar'])) ?></td>
                            <td class="text-center"><?= number_format($item['porsi_besar']) ?></td>
                            <td class="text-center"><?= number_format($item['porsi_kecil']) ?></td>
                            <td class="text-end fw-bold text-primary"><?= number_format($item['jumlah']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="bg-light fw-bold">
                    <tr>
                        <td colspan="4" class="text-end py-3">TOTAL SELURUH RUTE</td>
                        <td class="text-center"><?= number_format(array_sum(array_column($items, 'porsi_besar'))) ?></td>
                        <td class="text-center"><?= number_format(array_sum(array_column($items, 'porsi_kecil'))) ?></td>
                        <td class="text-end text-primary h6 mb-0"><?= number_format($header['total_porsi']) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <?php if (session()->get('role') == 'admin' && $header['status'] == 'submitted'): ?>
        <div class="data-card border-warning">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="fw-bold mb-1">Monitoring & Persetujuan Rute</h6>
                        <p class="text-muted small mb-0">Pastikan rute dan jadwal sudah efisien sebelum disetujui.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <form action="<?= base_url('routes/reject/' . $header['id']) ?>" method="POST">
                            <button type="submit" class="btn btn-outline-danger px-4">Tolak Rute</button>
                        </form>
                        <form action="<?= base_url('routes/approve/' . $header['id']) ?>" method="POST">
                            <button type="submit" class="btn btn-success px-4 shadow-sm">Setujui Rute</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
