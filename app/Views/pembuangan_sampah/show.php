<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<style>.grid-cell-view { width: 35px; text-align: center; border: 1px solid #eee; padding: 4px !important; }</style>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('pembuangan-sampah') ?>" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Pembuangan Sampah</h4>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('pembuangan-sampah/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger"><i class="bi bi-file-pdf me-1"></i> Cetak PDF</a>
        <a href="<?= site_url('pembuangan-sampah/export-excel/' . $header['id']) ?>" class="btn btn-outline-success"><i class="bi bi-file-excel me-1"></i> Export Excel</a>
    </div>
</div>

<div class="container-fluid px-0">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr class="bg-light">
                            <th class="text-center">Waktu</th>
                            <?php for($i=1;$i<=31;$i++) echo "<th class='grid-cell-view small'>$i</th>"; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach(['07.00', '14.00', '22.00'] as $time): ?>
                        <tr>
                            <td class="fw-bold text-center bg-light small"><?= $time ?></td>
                            <?php for($i=1;$i<=31;$i++): ?>
                            <td class="grid-cell-view">
                                <?php if(isset($rekap[$time][$i]) && $rekap[$time][$i] == '1'): ?>
                                    <i class="bi bi-check-lg text-success fw-bold"></i>
                                <?php else: ?>
                                    <span class="text-muted opacity-25">-</span>
                                <?php endif; ?>
                            </td>
                            <?php endfor; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-end text-muted small">
                Mengetahui Ka.SPPG: <strong><?= esc($header['nama_kappg']) ?></strong>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
