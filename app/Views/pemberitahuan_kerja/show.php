<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('pemberitahuan-kerja') ?>" class="text-decoration-none text-muted mb-2 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
        </a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Form Pemberitahuan</h4>
        <p class="text-muted small mb-0">Surat No. <?= esc($header['no_surat']) ?></p>
    </div>
    <a href="<?= site_url('pemberitahuan-kerja/export-pdf/'.$header['id']) ?>" target="_blank" class="btn btn-outline-danger">
        <i class="bi bi-file-pdf me-1"></i> Cetak PDF
    </a>
</div>

<div class="row g-4 animate-in" style="animation-delay: 0.1s;">
    <div class="col-md-5">
        <div class="data-card h-100">
            <div class="card-header"><h6><i class="bi bi-info-circle me-2"></i>Informasi</h6></div>
            <div class="card-body p-4">
                <table class="table table-borderless table-sm mb-0">
                    <tr><td class="text-muted" width="170">No. Surat</td><td class="fw-bold"><?= esc($header['no_surat']) ?></td></tr>
                    <tr><td class="text-muted">Tanggal</td><td><?= date('d F Y', strtotime($header['tanggal'])) ?></td></tr>
                    <tr><td class="text-muted">Divisi</td><td><span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1"><?= esc($header['divisi']) ?></span></td></tr>
                    <tr><td class="text-muted">Nama PIC</td><td class="fw-bold"><?= esc($header['nama_pic']) ?></td></tr>
                    <tr><td class="text-muted">Jam Mulai</td><td><?= esc($header['jam_mulai']) ?></td></tr>
                    <tr><td class="text-muted">Jam Selesai</td><td><?= esc($header['jam_selesai']) ?></td></tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr><td class="text-muted">Ket. Jumlah Item</td><td><?= nl2br(esc($header['keterangan_jumlah_item'] ?: '-')) ?></td></tr>
                    <tr><td class="text-muted">Ket. Dikerjakan</td><td><?= nl2br(esc($header['keterangan_dikerjakan'] ?: '-')) ?></td></tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr><td class="text-muted">Diinput Oleh</td><td><?= esc($header['user_nama']) ?></td></tr>
                    <tr><td class="text-muted">Waktu Input</td><td><?= date('d/m/Y H:i', strtotime($header['created_at'])) ?></td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="data-card h-100">
            <div class="card-header"><h6><i class="bi bi-pen me-2"></i>Tanda Tangan</h6></div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6 text-center">
                        <p class="fw-bold mb-1">Mengetahui</p>
                        <p class="text-muted small mb-2"><?= esc($header['nama_anggota'] ?? '-') ?></p>
                        <?php if (!empty($header['ttd_anggota'])): ?>
                            <img src="<?= base_url($header['ttd_anggota']) ?>" alt="TTD Anggota" style="max-height: 120px; border: 1px solid #ddd; border-radius: 8px; padding: 8px;">
                        <?php else: ?>
                            <div class="bg-light rounded p-4 text-muted"><i class="bi bi-image fs-1"></i><br>Tidak ada TTD</div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 text-center">
                        <p class="fw-bold mb-1">Penanggung Jawab</p>
                        <p class="text-muted small mb-2"><?= esc($header['nama_pj'] ?? '-') ?></p>
                        <?php if (!empty($header['ttd_pj'])): ?>
                            <img src="<?= base_url($header['ttd_pj']) ?>" alt="TTD PJ" style="max-height: 120px; border: 1px solid #ddd; border-radius: 8px; padding: 8px;">
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
