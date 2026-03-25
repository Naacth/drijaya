<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('cek-bahan-baku') ?>" class="text-decoration-none text-muted mb-2 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
        </a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Form Pemeriksaan Bahan Makanan</h4>
        <p class="text-muted small mb-0">Rincian Laporan #<?= str_pad($header['id'], 5, '0', STR_PAD_LEFT) ?></p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('cek-bahan-baku/export-pdf/'.$header['id']) ?>" target="_blank" class="btn btn-outline-danger">
            <i class="bi bi-file-pdf me-1"></i> Cetak PDF
        </a>
        <a href="<?= site_url('cek-bahan-baku/export-excel/'.$header['id']) ?>" class="btn btn-outline-success">
            <i class="bi bi-file-excel me-1"></i> Export Excel
        </a>
    </div>
</div>

<div class="row g-4 animate-in" style="animation-delay: 0.1s;">
    <div class="col-md-4">
        <div class="data-card h-100">
            <div class="card-header">
                <h6><i class="bi bi-bank me-2"></i>Informasi SPPG</h6>
            </div>
            <div class="card-body p-4">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td class="text-muted" width="130">Tanggal Laporan</td>
                        <td class="fw-bold"><?= date('d F Y', strtotime($header['tanggal_laporan'])) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Nama SPPG</td>
                        <td class="fw-bold"><?= esc($header['nama_sppg']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Alamat SPPG</td>
                        <td><?= esc($header['alamat_sppg']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Kepala SPPG</td>
                        <td class="fw-bold"><?= esc($header['nama_kepala_sppg']) ?></td>
                    </tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr>
                        <td class="text-muted">Diinput Oleh</td>
                        <td><?= esc($header['user_nama']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Waktu Input</td>
                        <td><?= date('d/m/Y H:i', strtotime($header['created_at'])) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="data-card h-100">
            <div class="card-header">
                <h6><i class="bi bi-list-ul me-2"></i>Daftar Pemeriksaan Bahan Makanan</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-premium mb-0">
                    <thead>
                        <tr>
                            <th width="40">No</th>
                            <th width="100">Tgl Bahan</th>
                            <th>Jenis Bahan Makanan</th>
                            <th>Banyaknya</th>
                            <th>Satuan</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Kondisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($items as $i => $item): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= date('d M Y', strtotime($item['tgl_bahan'])) ?></td>
                            <td class="fw-medium text-dark"><?= esc($item['jenis_bahan']) ?></td>
                            <td><?= number_format($item['banyaknya'], 2) ?></td>
                            <td><?= esc($item['satuan']) ?></td>
                            <td class="text-center">
                                <?php if($item['jumlah_sesuai'] === 'Sesuai'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1"><i class="bi bi-check-circle me-1"></i>Sesuai</span>
                                <?php else: ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1"><i class="bi bi-x-circle me-1"></i>Tidak</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($item['kondisi_bahan'] === 'Baik'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1"><i class="bi bi-check-circle me-1"></i>Baik</span>
                                <?php else: ?>
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1"><i class="bi bi-exclamation-triangle me-1"></i>Rusak</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
