<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('estimasi-anggaran') ?>" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Estimasi Anggaran</h4>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('estimasi-anggaran/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger px-3 rounded-pill"><i class="bi bi-file-pdf me-1"></i> Cetak PDF</a>
        <a href="<?= site_url('estimasi-anggaran/export-excel/' . $header['id']) ?>" class="btn btn-outline-success px-3 rounded-pill"><i class="bi bi-file-excel me-1"></i> Export Excel</a>
    </div>
</div>

<div class="row g-4 animate-in" style="animation-delay: 0.1s;">
    <div class="col-md-4">
        <div class="data-card h-100">
            <div class="card-header"><h6><i class="bi bi-info-circle me-2"></i>Header Info</h6></div>
            <div class="card-body p-4">
                <table class="table table-borderless table-sm mb-0">
                    <tr><td class="text-muted" width="130">Periode</td><td class="fw-bold"><?= date('d/m/Y', strtotime($header['tanggal_mulai'])) ?> - <?= date('d/m/Y', strtotime($header['tanggal_selesai'])) ?></td></tr>
                    <tr><td class="text-muted">Kategori</td><td><span class="badge <?= $header['kategori_porsi'] === 'Besar' ? 'bg-primary' : 'bg-info' ?> rounded-pill px-3"><?= esc($header['kategori_porsi']) ?></span></td></tr>
                    <tr><td class="text-muted">Total Estimasi</td><td class="text-success fw-bold">Rp <?= number_format($header['total_kalkulasi'], 0, ',', '.') ?></td></tr>
                    <tr><td colspan="2"><hr class="my-3"></td></tr>
                    <tr><td class="text-muted small">Diinput Oleh</td><td class="small"><?= esc($header['user_nama']) ?></td></tr>
                    <tr><td class="text-muted small">Waktu Input</td><td class="small"><?= date('d M Y, H:i', strtotime($header['created_at'])) ?></td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="data-card h-100">
            <div class="card-header"><h6><i class="bi bi-list-columns-reverse me-2"></i>Rincian Item & Biaya</h6></div>
            <div class="table-responsive">
                <table class="table table-premium mb-0">
                    <thead>
                        <tr>
                            <th width="40">No</th>
                            <th>Nama Item Masakan / Bahan</th>
                            <th class="text-end" width="200">Harga Satuan (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $i => $item): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td class="fw-medium font-inter"><?= esc($item['nama_item']) ?></td>
                            <td class="text-end font-inter">Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-light fw-bold border-top">
                        <tr>
                            <td colspan="2" class="text-end py-3">GRAND TOTAL ESTIMASI</td>
                            <td class="text-end py-3 text-success">Rp <?= number_format($header['total_kalkulasi'], 0, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.font-inter { font-family: 'Inter', sans-serif; }
</style>
<?= $this->endSection() ?>
