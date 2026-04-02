<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('uji-organoleptik') ?>" class="text-decoration-none text-muted mb-2 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
        </a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Uji Organoleptik</h4>
        <p class="text-muted small mb-0">Laporan #<?= str_pad($header['id'], 5, '0', STR_PAD_LEFT) ?></p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <?php if (session()->get('role') === 'admin' || session()->get('role') === 'aslap'): ?>
        <a href="<?= site_url('uji-organoleptik/edit/'.$header['id']) ?>" class="btn btn-primary">
            <i class="bi bi-pencil-square me-1"></i> Ubah
        </a>
        <?php endif; ?>
        <a href="<?= site_url('uji-organoleptik/export-pdf/'.$header['id']) ?>" target="_blank" class="btn btn-outline-danger">
            <i class="bi bi-file-pdf me-1"></i> Cetak PDF
        </a>
        <a href="<?= site_url('uji-organoleptik/export-excel/'.$header['id']) ?>" class="btn btn-outline-success">
            <i class="bi bi-file-excel me-1"></i> Export Excel
        </a>
    </div>
</div>

<div class="row g-4 animate-in" style="animation-delay: 0.1s;">
    <div class="col-md-4">
        <div class="data-card h-100">
            <div class="card-header">
                <h6><i class="bi bi-info-circle me-2"></i>Info Pemeriksaan</h6>
            </div>
            <div class="card-body p-4">
                <table class="table table-borderless table-sm mb-0">
                    <tr><td class="text-muted" width="140">Nama Pemeriksa</td><td class="fw-bold"><?= esc($header['nama_pemeriksa']) ?></td></tr>
                    <tr><td class="text-muted">Tempat</td><td><?= esc($header['tempat_pemeriksaan']) ?></td></tr>
                    <tr><td class="text-muted">Nama Tempat</td><td class="fw-bold"><?= esc($header['nama_tempat']) ?></td></tr>
                    <tr><td class="text-muted">Tanggal</td><td><?= date('d F Y', strtotime($header['tanggal_pemeriksaan'])) ?></td></tr>
                    <tr><td class="text-muted">Waktu</td><td><?= esc($header['waktu_pemeriksaan']) ?></td></tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr><td class="text-muted">Aslap</td><td><?= esc($header['nama_aslap']) ?></td></tr>
                    <tr><td class="text-muted">PLOK/PIC</td><td><?= esc($header['nama_pemeriksa_plok'] ?: '-') ?></td></tr>
                    <tr><td class="text-muted">Kepala SPPG</td><td><?= esc($header['nama_kepala_sppg']) ?></td></tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr><td class="text-muted">Diinput Oleh</td><td><?= esc($header['user_nama']) ?></td></tr>
                    <tr><td class="text-muted">Waktu Input</td><td><?= date('d/m/Y H:i', strtotime($header['created_at'])) ?></td></tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="data-card h-100">
            <div class="card-header">
                <h6><i class="bi bi-list-ul me-2"></i>Hasil Pemeriksaan (Skor 1-5)</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-premium mb-0">
                    <thead>
                        <tr>
                            <th width="40">No</th>
                            <th>Nama Makan</th>
                            <th class="text-center" width="70">Rasa</th>
                            <th class="text-center" width="70">Warna</th>
                            <th class="text-center" width="70">Aroma</th>
                            <th class="text-center" width="70">Tekstur</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $skorLabel = function($s) {
                            return match((int)$s) {
                                5 => '<span class="badge bg-success rounded-pill">5</span>',
                                4 => '<span class="badge bg-primary rounded-pill">4</span>',
                                3 => '<span class="badge bg-info text-dark rounded-pill">3</span>',
                                2 => '<span class="badge bg-warning text-dark rounded-pill">2</span>',
                                1 => '<span class="badge bg-danger rounded-pill">1</span>',
                                default => $s,
                            };
                        };
                        foreach($items as $i => $item): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td class="fw-medium text-dark"><?= esc($item['nama_makan']) ?></td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1 small"><?= esc($item['waktu_uji'] ?? 'Sebelum Pengantaran') ?></span></td>
                            <td class="text-center"><?= $skorLabel($item['skor_rasa']) ?></td>
                            <td class="text-center"><?= $skorLabel($item['skor_warna']) ?></td>
                            <td class="text-center"><?= $skorLabel($item['skor_aroma']) ?></td>
                            <td class="text-center"><?= $skorLabel($item['skor_tekstur']) ?></td>
                            <td><?= esc($item['keterangan'] ?: '-') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
