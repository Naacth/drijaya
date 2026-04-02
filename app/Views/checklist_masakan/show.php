<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('checklist-masakan') ?>" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Checklist QC Masakan</h4>
    </div>
    <div class="d-flex gap-2">
        <?php if (session()->get('role') === 'ahli_gizi'): ?>
        <a href="<?= site_url('checklist-masakan/edit/' . $header['id']) ?>" class="btn btn-warning px-4 rounded-pill shadow-sm"><i class="bi bi-pencil me-1"></i> Edit</a>
        <?php endif; ?>
        <a href="<?= site_url('checklist-masakan/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger px-4 rounded-pill shadow-sm"><i class="bi bi-file-pdf me-1"></i> Cetak PDF</a>
        <a href="<?= site_url('checklist-masakan/export-excel/' . $header['id']) ?>" class="btn btn-outline-success px-4 rounded-pill shadow-sm"><i class="bi bi-file-excel me-1"></i> Export Excel</a>
    </div>
</div>

<div class="row g-4 animate-in" style="animation-delay: 0.1s;">
    <div class="col-md-12">
        <div class="data-card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                <i class="bi bi-info-circle-fill text-primary me-2 fs-5"></i>
                <h6 class="mb-0 fw-bold">Informasi Pemeriksaan</h6>
            </div>
            <div class="card-body p-4">
                <div class="row text-center text-md-start">
                    <div class="col-md-3 mb-3 mb-md-0 border-end">
                        <small class="text-muted d-block text-uppercase letter-spacing-1">Tanggal</small>
                        <span class="fw-bold fs-5"><?= date('d F Y', strtotime($header['tanggal'])) ?></span>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0 border-end">
                        <small class="text-muted d-block text-uppercase letter-spacing-1">Waktu Sajian</small>
                        <span class="fw-bold fs-5 text-primary"><i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($header['waktu_penyajian'])) ?> WIB</span>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0 border-end">
                        <small class="text-muted d-block text-uppercase letter-spacing-1">Petugas (QC)</small>
                        <span class="fw-bold fs-5"><?= esc($header['user_nama']) ?></span>
                    </div>
                    <div class="col-md-3">
                        <small class="text-muted d-block text-uppercase letter-spacing-1">Status Verifikasi</small>
                        <span class="badge bg-success rounded-pill px-3 py-2 mt-1 shadow-sm"><i class="bi bi-check-circle me-1"></i>Verified</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="data-card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold"><i class="bi bi-clipboard-data text-primary me-2"></i>Hasil Verifikasi Organoleptik & Gramasi</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-premium table-hover mb-0">
                    <thead class="bg-light">
                        <tr class="text-center align-middle">
                            <th width="40" class="text-start">No</th>
                            <th class="text-start">Nama Masakan</th>
                            <th width="120">Std Gram</th>
                            <th width="120">Real Gram</th>
                            <th width="130">Rasa</th>
                            <th width="130">Tekstur</th>
                            <th class="text-start">Catatan / Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $i => $item): ?>
                        <tr class="align-middle text-center">
                            <td class="text-start"><?= $i + 1 ?></td>
                            <td class="text-start fw-bold text-dark"><?= esc($item['nama_masakan']) ?></td>
                            <td><span class="badge bg-light text-muted border"><?= number_format($item['gramasi_standar'], 1) ?>g</span></td>
                            <td>
                                <span class="fw-bold <?= $item['gramasi_real'] < $item['gramasi_standar'] ? 'text-danger' : 'text-success' ?>">
                                    <?= number_format($item['gramasi_real'], 1) ?>g
                                </span>
                            </td>
                            <td>
                                <span class="badge <?= $item['rasa'] === 'Sesuai' ? 'bg-success' : 'bg-danger' ?> rounded-pill px-3">
                                    <?= esc($item['rasa']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?= $item['tekstur'] === 'Sesuai' ? 'bg-success' : 'bg-danger' ?> rounded-pill px-3">
                                    <?= esc($item['tekstur']) ?>
                                </span>
                            </td>
                            <td class="text-start italic text-muted small"><?= esc($item['keterangan'] ?: '-') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.letter-spacing-1 { letter-spacing: 0.5px; }
.italic { font-style: italic; }
</style>
<?= $this->endSection() ?>
