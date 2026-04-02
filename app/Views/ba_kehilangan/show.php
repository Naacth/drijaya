<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('ba-kehilangan') ?>" class="text-decoration-none text-muted mb-2 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
        </a>
        <h4 class="mb-1" style="font-weight: 700;">Detail BA Kehilangan Ompreng</h4>
        <p class="text-muted small mb-0">Surat No. <?= esc($header['no_surat']) ?></p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <?php if (session()->get('role') === 'admin' || session()->get('role') === 'aslap'): ?>
        <a href="<?= site_url('ba-kehilangan/edit/'.$header['id']) ?>" class="btn btn-primary">
            <i class="bi bi-pencil-square me-1"></i> Ubah
        </a>
        <?php endif; ?>
        <a href="<?= site_url('ba-kehilangan/export-pdf/'.$header['id']) ?>" target="_blank" class="btn btn-outline-danger">
            <i class="bi bi-file-pdf me-1"></i> Cetak PDF
        </a>
    </div>
</div>

<div class="row g-4 animate-in" style="animation-delay: 0.1s;">
    <div class="col-md-5">
        <div class="data-card h-100">
            <div class="card-header">
                <h6><i class="bi bi-info-circle me-2"></i>Informasi Berita Acara</h6>
            </div>
            <div class="card-body p-4">
                <table class="table table-borderless table-sm mb-0">
                    <tr><td class="text-muted" width="170">No. Surat</td><td class="fw-bold"><?= esc($header['no_surat']) ?></td></tr>
                    <tr><td class="text-muted">Tanggal Kejadian</td><td class="fw-bold"><?= date('d F Y', strtotime($header['tanggal_kejadian'])) ?></td></tr>
                    <tr><td class="text-muted">Nama Sekolah</td><td class="fw-bold"><?= esc($header['nama_sekolah']) ?></td></tr>
                    <tr><td class="text-muted">PJ Sekolah</td><td><?= esc($header['nama_pj_sekolah']) ?></td></tr>
                    <tr><td class="text-muted">Jam Kehilangan</td><td><?= esc($header['jam_kehilangan']) ?></td></tr>
                    <tr><td class="text-muted">Jam Distribusi</td><td><?= esc($header['jam_distribusi']) ?></td></tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr>
                        <td class="text-muted">Jumlah Hilang</td>
                        <td><span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1"><?= $header['jumlah_ompreng_hilang'] ?> Pcs</span></td>
                    </tr>
                    <tr><td class="text-muted">Jumlah Awal</td><td><?= $header['jumlah_awal'] ?> Pcs</td></tr>
                    <tr><td class="text-muted">Jumlah Akhir</td><td><?= $header['jumlah_akhir'] ?> Pcs</td></tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr><td class="text-muted">Diinput Oleh</td><td><?= esc($header['user_nama']) ?></td></tr>
                    <tr><td class="text-muted">Waktu Input</td><td><?= date('d/m/Y H:i', strtotime($header['created_at'])) ?></td></tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-7">
        <div class="data-card h-100">
            <div class="card-header">
                <h6><i class="bi bi-pen me-2"></i>Tanda Tangan</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6 text-center">
                        <p class="fw-bold mb-2">Supir SPPG</p>
                        <p class="text-muted small"><?= esc($header['nama_supir'] ?? '-') ?></p>
                        <?php if (!empty($header['ttd_supir'])): ?>
                            <img src="<?= base_url($header['ttd_supir']) ?>" alt="TTD Supir" style="max-height: 120px; border: 1px solid #ddd; border-radius: 8px; padding: 8px;">
                        <?php else: ?>
                            <div class="bg-light rounded p-4 text-muted"><i class="bi bi-image fs-1"></i><br>Tidak ada TTD</div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 text-center">
                        <p class="fw-bold mb-2">PJ Sekolah</p>
                        <p class="text-muted small"><?= esc($header['nama_pj_sekolah']) ?></p>
                        <?php if (!empty($header['ttd_pj_sekolah'])): ?>
                            <img src="<?= base_url($header['ttd_pj_sekolah']) ?>" alt="TTD PJ Sekolah" style="max-height: 120px; border: 1px solid #ddd; border-radius: 8px; padding: 8px;">
                        <?php else: ?>
                            <div class="bg-light rounded p-4 text-muted"><i class="bi bi-image fs-1"></i><br>Tidak ada TTD</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
