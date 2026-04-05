<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid animate-in">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Detail Data Penerima Manfaat</h4>
            <p class="text-muted small">Informasi porsi per sekolah dan status verifikasi.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'penerima-manfaat/export-pdf-blank', 'printBlankRoles' => ['aslap', 'admin', 'pic'], 'printBlankWrapperClass' => 'mb-0']) ?>
            <?php if (session()->get('role') === 'aslap'): ?>
            <a href="<?= base_url('penerima-manfaat/edit/' . $header['id']) ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil-square me-1"></i> Ubah
            </a>
            <?php endif; ?>
            <a href="<?= base_url('penerima-manfaat/export-excel/' . $header['id']) ?>" class="btn btn-outline-success btn-sm">
                <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
            </a>
            <a href="<?= base_url('penerima-manfaat/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-file-pdf me-1"></i> Export PDF
            </a>
            <a href="<?= base_url('penerima-manfaat') ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="data-card h-100">
                <div class="card-header py-3 bg-light border-bottom">
                    <h6 class="m-0 fw-bold border-start border-primary border-4 ps-2 text-uppercase ls-1 small">Data Distribusi</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase ls-1 d-block mb-1">Tanggal</label>
                            <span class="fw-bold h5"><?= date('d F Y', strtotime($header['tanggal'])) ?></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small text-uppercase ls-1 d-block mb-1">Status</label>
                            <span class="badge badge-status badge-<?= ($header['status'] == 'approved' ? 'disetujui' : ($header['status'] == 'rejected' ? 'ditolak' : 'pending')) ?>">
                                <?= ucwords($header['status']) ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase ls-1 d-block mb-1">Unit SPPG</label>
                            <span class="fw-bold"><?= $header['sppg'] ?></span>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase ls-1 d-block mb-1">Kecamatan</label>
                            <span class="fw-bold"><?= $header['kecamatan'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
             <div class="data-card h-100">
                <div class="card-header py-3 bg-light border-bottom">
                    <h6 class="m-0 fw-bold text-uppercase ls-1 small text-muted">Penginput</h6>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="avatar avatar-lg bg-soft-primary text-primary mb-3 mx-auto">
                        <i class="bi bi-person-badge fs-2"></i>
                    </div>
                    <h6 class="fw-bold mb-1"><?= $header['pembuat'] ?></h6>
                    <p class="text-muted small mb-0">Role: Asisten Lapangan</p>
                    <hr class="my-3 opacity-10">
                    <p class="small text-muted mb-0 font-monospace">Dibuat pada: <?= date('d/m/Y H:i', strtotime($header['created_at'])) ?></p>
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
                        <th>Nama Sekolah</th>
                        <th class="text-center">Jml Siswa</th>
                        <th class="text-center">P. Kecil</th>
                        <th class="text-center">P. Besar</th>
                        <th class="text-center">Guru</th>
                        <th class="text-center">Staf</th>
                        <th class="text-end">Total Porsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $totalSiswa = 0; $totalKecil = 0; $totalBesar = 0; $totalGuru = 0; $totalStaf = 0; $totalPorsi = 0;
                    foreach ($items as $index => $item): 
                        $totalSiswa += $item['jumlah_siswa'];
                        $totalKecil += $item['porsi_kecil'];
                        $totalBesar += $item['porsi_besar'];
                        $totalGuru += $item['pendidik'];
                        $totalStaf += $item['non_pendidik'];
                        $totalPorsi += $item['total_porsi'];
                    ?>
                        <tr>
                            <td class="text-center text-muted small"><?= $index + 1 ?></td>
                            <td class="fw-bold text-dark"><?= $item['nama_sekolah'] ?></td>
                            <td class="text-center"><?= number_format($item['jumlah_siswa']) ?></td>
                            <td class="text-center"><?= number_format($item['porsi_kecil']) ?></td>
                            <td class="text-center"><?= number_format($item['porsi_besar']) ?></td>
                            <td class="text-center"><?= number_format($item['pendidik']) ?></td>
                            <td class="text-center"><?= number_format($item['non_pendidik']) ?></td>
                            <td class="text-end fw-bold text-primary"><?= number_format($item['total_porsi']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="bg-light fw-bold">
                    <tr>
                        <td colspan="2" class="text-end py-3">GRAND TOTAL PERIODE</td>
                        <td class="text-center"><?= number_format($totalSiswa) ?></td>
                        <td class="text-center"><?= number_format($totalKecil) ?></td>
                        <td class="text-center"><?= number_format($totalBesar) ?></td>
                        <td class="text-center"><?= number_format($totalGuru) ?></td>
                        <td class="text-center"><?= number_format($totalStaf) ?></td>
                        <td class="text-end text-primary h6 mb-0"><?= number_format($totalPorsi) ?></td>
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
                        <h6 class="fw-bold mb-1">Konfirmasi Persetujuan</h6>
                        <p class="text-muted small mb-0">Periksa kembali data sebelum melakukan persetujuan atau penolakan.</p>
                    </div>
                    <div class="d-flex gap-2">
                        <form action="<?= base_url('penerima-manfaat/reject/' . $header['id']) ?>" method="POST">
                            <button type="submit" class="btn btn-outline-danger px-4">Tolak Data</button>
                        </form>
                        <form action="<?= base_url('penerima-manfaat/approve/' . $header['id']) ?>" method="POST">
                            <button type="submit" class="btn btn-success px-4 shadow-sm">Setujui Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
