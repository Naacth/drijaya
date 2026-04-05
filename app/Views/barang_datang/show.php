<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('barang-datang') ?>" class="text-decoration-none text-muted mb-2 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
        </a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Formulir Barang Datang</h4>
        <p class="text-muted small mb-0">Rincian formulir #<?= str_pad($header['id'], 5, '0', STR_PAD_LEFT) ?></p>
    </div>
    <div class="d-flex gap-2 flex-wrap align-items-center">
        <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'barang-datang/export-pdf-blank', 'printBlankRoles' => ['aslap', 'admin', 'pic'], 'printBlankWrapperClass' => 'mb-0']) ?>
        <?php if (session()->get('role') === 'admin' || session()->get('role') === 'aslap'): ?>
        <a href="<?= site_url('barang-datang/edit/'.$header['id']) ?>" class="btn btn-primary">
            <i class="bi bi-pencil-square me-1"></i> Ubah
        </a>
        <?php endif; ?>
        <a href="<?= site_url('barang-datang/export-pdf/'.$header['id']) ?>" target="_blank" class="btn btn-outline-danger">
            <i class="bi bi-file-pdf me-1"></i> Cetak PDF
        </a>
        <a href="<?= site_url('barang-datang/export-excel/'.$header['id']) ?>" class="btn btn-outline-success">
            <i class="bi bi-file-excel me-1"></i> Export Excel
        </a>
    </div>
</div>

<div class="row g-4 animate-in" style="animation-delay: 0.1s;">
    <div class="col-md-4">
        <div class="data-card h-100">
            <div class="card-header">
                <h6><i class="bi bi-info-circle me-2"></i>Informasi Form</h6>
            </div>
            <div class="card-body p-4">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td class="text-muted" width="130">Tanggal</td>
                        <td class="fw-bold"><?= date('d F Y', strtotime($header['tanggal'])) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Penanggung Jawab</td>
                        <td class="fw-bold"><?= esc($header['penanggung_jawab']) ?></td>
                    </tr>
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
                <h6><i class="bi bi-list-ul me-2"></i>Daftar Barang</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-premium mb-0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Banyak Barang</th>
                            <th>Nama QC</th>
                            <th>Nama Pemasok</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($items as $i => $item): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td class="fw-medium text-dark"><?= esc($item['nama_barang']) ?></td>
                            <td><?= esc($item['satuan']) ?></td>
                            <td>
                                <?php
                                    $qty = (float) ($item['banyak_barang'] ?? 0);
                                    $out = ((int) $qty == $qty) ? (string) (int) $qty : rtrim(rtrim(number_format($qty, 2, '.', ''), '0'), '.');
                                    echo esc($out);
                                ?>
                            </td>
                            <td><?= esc($item['nama_qc'] ?: '-') ?></td>
                            <td><?= esc($item['nama_pemasok'] ?: '-') ?></td>
                            <td>
                                <?php if($item['keterangan'] === 'ada nota'): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1" style="font-size: 0.75rem;">Ada Nota</span>
                                <?php else: ?>
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1" style="font-size: 0.75rem;">Tidak Ada Nota</span>
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
