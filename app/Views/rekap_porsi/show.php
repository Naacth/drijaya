<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php 
    $days = ['Sunday'=>'MINGGU','Monday'=>'SENIN','Tuesday'=>'SELASA','Wednesday'=>'RABU','Thursday'=>'KAMIS','Friday'=>'JUMAT','Saturday'=>'SABTU'];
    $months = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $hari = $days[date('l', strtotime($header['tanggal']))];
    $tgl = date('d', strtotime($header['tanggal'])) . ' ' . $months[(int)date('m', strtotime($header['tanggal']))] . ' ' . date('Y', strtotime($header['tanggal']));
?>

<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('rekap-porsi') ?>" class="text-decoration-none text-muted mb-2 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Rekap Jumlah Porsi</h4>
        <p class="text-muted small mb-0">Hari dan TGL: <?= $hari ?> <?= $tgl ?></p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <?php if (session()->get('role') === 'admin' || session()->get('role') === 'aslap'): ?>
        <a href="<?= site_url('rekap-porsi/edit/'.$header['id']) ?>" class="btn btn-primary">
            <i class="bi bi-pencil-square me-1"></i> Ubah
        </a>
        <?php endif; ?>
        <a href="<?= site_url('rekap-porsi/export-pdf/'.$header['id']) ?>" target="_blank" class="btn btn-outline-danger">
            <i class="bi bi-file-pdf me-1"></i> Cetak PDF
        </a>
        <a href="<?= site_url('rekap-porsi/export-excel/'.$header['id']) ?>" class="btn btn-outline-success">
            <i class="bi bi-file-excel me-1"></i> Export Excel
        </a>
    </div>
</div>

<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-header"><h6><i class="bi bi-list-ul me-2"></i>Daftar Porsi Distribusi</h6></div>
    <div class="table-responsive">
        <table class="table table-premium table-bordered mb-0 align-middle">
            <thead class="bg-light text-center">
                <tr>
                    <th width="40">No</th>
                    <th>TINGKATAN</th>
                    <th>SEKOLAH</th>
                    <th width="100">JUMLAH PM</th>
                    <th width="120">JUMLAH PM Ter DISTRIBUSI</th>
                    <th width="120">Jumlah PM tidak terdistribusi</th>
                    <th>Keterangan</th>
                    <th>Pengalihan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalPm = 0; $totalTerds = 0; $totalTdk = 0;
                foreach ($items as $i => $item): 
                    $totalPm += $item['jumlah_pm'];
                    $totalTerds += $item['jumlah_terdistribusi'];
                    $totalTdk += $item['jumlah_tidak_terdistribusi'];
                ?>
                <tr>
                    <td class="text-center text-muted"><?= $i + 1 ?></td>
                    <td><span class="badge bg-secondary rounded-pill"><?= esc($item['tingkatan']) ?></span></td>
                    <td class="fw-medium"><?= esc($item['sekolah']) ?></td>
                    <td class="text-center fw-bold"><?= $item['jumlah_pm'] ?></td>
                    <td class="text-center text-success fw-bold"><?= $item['jumlah_terdistribusi'] ?></td>
                    <td class="text-center text-danger fw-bold"><?= $item['jumlah_tidak_terdistribusi'] ?></td>
                    <td><?= esc($item['keterangan'] ?: '-') ?></td>
                    <td><?= esc($item['pengalihan'] ?: '-') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="bg-light fw-bold text-center">
                <tr>
                    <td colspan="3" class="text-end pe-3">TOTAL KESELURUHAN</td>
                    <td><?= $totalPm ?></td>
                    <td class="text-success"><?= $totalTerds ?></td>
                    <td class="text-danger"><?= $totalTdk ?></td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="card-body bg-light p-3">
        <small class="text-muted">Diinput oleh <strong><?= esc($header['user_nama']) ?></strong> pada <?= date('d/m/Y H:i', strtotime($header['created_at'])) ?></small>
    </div>
</div>

<?= $this->endSection() ?>
