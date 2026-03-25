<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold mb-0">Rekap Absensi Relawan</h4>
            <p class="text-muted small mb-0">Ringkasan kehadiran relawan dalam rentang waktu tertentu</p>
        </div>
        <form action="" method="get" class="d-flex gap-2">
            <input type="date" name="start" class="form-control form-control-sm" value="<?= $start ?>">
            <span class="align-self-center text-muted">s/d</span>
            <input type="date" name="end" class="form-control form-control-sm" value="<?= $end ?>">
            <button type="submit" class="btn btn-sm btn-dark"><i class="bi bi-filter"></i></button>
            <a href="<?= site_url('absensi/rekap-pdf?start='.$start.'&end='.$end) ?>" target="_blank" class="btn btn-sm btn-danger px-4 shadow-sm">
                <i class="bi bi-file-earmark-pdf me-2"></i>Cetak Rekap
            </a>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0 text-center" style="font-size: 0.85rem;">
                <thead class="bg-light text-dark">
                    <tr>
                        <th rowspan="2" class="align-middle" width="50">No</th>
                        <th rowspan="2" class="align-middle text-start ps-4" width="200">Nama Relawan / Divisi</th>
                        <th colspan="<?= count($sessions) ?>" class="py-2">Tanggal Kehadiran</th>
                        <th rowspan="2" class="align-middle" width="100">Total Hadir</th>
                    </tr>
                    <tr>
                        <?php if (empty($sessions)): ?>
                            <th class="py-1">Belum ada data</th>
                        <?php else: ?>
                            <?php foreach ($sessions as $s): ?>
                                <th class="py-1 px-1" style="min-width: 40px;">
                                    <?= date('d', strtotime($s['tanggal'])) ?><br>
                                    <small class="text-muted"><?= date('M', strtotime($s['tanggal'])) ?></small>
                                </th>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($relawan)): ?>
                        <tr>
                            <td colspan="<?= count($sessions) + 3 ?>" class="py-5 text-muted">
                                Tidak ada data relawan ditemukan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($relawan as $idx => $r): ?>
                            <tr>
                                <td class="text-muted"><?= $idx + 1 ?></td>
                                <td class="text-start ps-4">
                                    <div class="fw-bold text-dark"><?= esc($r['nama']) ?></div>
                                    <small class="text-muted text-uppercase"><?= esc($r['divisi']) ?></small>
                                </td>
                                <?php 
                                    $countHadir = 0;
                                    foreach ($sessions as $s): 
                                        $status = $matrix[$r['id']][$s['tanggal']] ?? '-';
                                        if ($status == 'Hadir') $countHadir++;
                                ?>
                                    <td class="p-0">
                                        <?php if ($status == 'Hadir'): ?>
                                            <div class="bg-success-soft text-success py-2"><i class="bi bi-check-lg"></i></div>
                                        <?php elseif ($status == 'Tidak Hadir'): ?>
                                            <div class="bg-danger-soft text-danger py-2"><i class="bi bi-x-lg"></i></div>
                                        <?php else: ?>
                                            <div class="text-muted py-2">-</div>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                                <td class="fw-bold text-primary"><?= $countHadir ?> / <?= count($sessions) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background-color: rgba(16, 185, 129, 0.1); }
    .bg-danger-soft { background-color: rgba(239, 68, 68, 0.1); }
</style>

<?= $this->endSection() ?>
