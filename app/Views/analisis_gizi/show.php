<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('analisis-gizi') ?>" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Analisis Kandungan Gizi (AKG)</h4>
    </div>
    <div class="d-flex gap-2">
        <?php if (session()->get('role') === 'ahli_gizi'): ?>
        <a href="<?= site_url('analisis-gizi/edit/' . $header['id']) ?>" class="btn btn-warning px-3 rounded-pill"><i class="bi bi-pencil me-1"></i> Edit</a>
        <?php endif; ?>
        <a href="<?= site_url('analisis-gizi/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger px-3 rounded-pill"><i class="bi bi-file-pdf me-1"></i> Cetak PDF</a>
        <a href="<?= site_url('analisis-gizi/export-excel/' . $header['id']) ?>" class="btn btn-outline-success px-3 rounded-pill"><i class="bi bi-file-excel me-1"></i> Export Excel</a>
    </div>
</div>

<div class="row g-4 animate-in" style="animation-delay: 0.1s;">
    <div class="col-md-3">
        <div class="data-card h-100">
            <div class="card-header"><h6><i class="bi bi-info-circle me-2"></i>Identitas</h6></div>
            <div class="card-body p-4 text-center">
                <div class="category-icon bg-primary shadow-sm mb-3 mx-auto" style="width:64px;height:64px;font-size:2rem;">
                    <i class="bi bi-pie-chart"></i>
                </div>
                <h5 class="fw-bold mb-1"><?= esc($header['nama_paket']) ?></h5>
                <p class="text-muted small mb-3"><?= date('d F Y', strtotime($header['tanggal_sajian'])) ?></p>
                <hr>
                <div class="text-start small mt-3">
                    <p class="mb-1 text-muted">Nutrisionis: <span class="text-dark fw-medium"><?= esc($header['user_nama']) ?></span></p>
                    <p class="mb-0 text-muted">ID Laporan: <span class="text-dark">#<?= str_pad($header['id'], 5, '0', STR_PAD_LEFT) ?></span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="data-card h-100">
            <div class="card-header"><h6><i class="bi bi-table me-2"></i>Komposisi Nutrisi Per Item</h6></div>
            <div class="table-responsive">
                <table class="table table-premium mb-0">
                    <thead>
                        <tr class="text-center">
                            <th class="text-start" width="40">No</th>
                            <th class="text-start">Nama Item</th>
                            <th width="90">Gram</th>
                            <th width="90">Kalori</th>
                            <th width="90">Protein</th>
                            <th width="90">Lemak</th>
                            <th width="90">KH</th>
                            <th width="90">Serat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $totals = ['gram'=>0,'kkal'=>0,'prot'=>0,'lemak'=>0,'kh'=>0,'serat'=>0];
                        foreach ($items as $i => $item): 
                            $totals['gram']  += $item['gramasi'];
                            $totals['kkal']  += $item['kalori'];
                            $totals['prot']  += $item['protein'];
                            $totals['lemak'] += $item['lemak'];
                            $totals['kh']    += $item['karbohidrat'];
                            $totals['serat'] += $item['serat'];
                        ?>
                        <tr class="text-center">
                            <td class="text-start"><?= $i + 1 ?></td>
                            <td class="text-start fw-medium"><?= esc($item['nama_item']) ?></td>
                            <td><?= number_format($item['gramasi'], 1) ?></td>
                            <td><?= number_format($item['kalori'], 1) ?></td>
                            <td><?= number_format($item['protein'], 1) ?>g</td>
                            <td><?= number_format($item['lemak'], 1) ?>g</td>
                            <td><?= number_format($item['karbohidrat'], 1) ?>g</td>
                            <td><?= number_format($item['serat'], 1) ?>g</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-primary text-white text-center fw-bold">
                        <tr>
                            <td colspan="2" class="text-end py-3">TOTAL KANDUNGAN GIZI</td>
                            <td><?= number_format($totals['gram'], 1) ?></td>
                            <td><?= number_format($totals['kkal'], 1) ?></td>
                            <td><?= number_format($totals['prot'], 1) ?>g</td>
                            <td><?= number_format($totals['lemak'], 1) ?>g</td>
                            <td><?= number_format($totals['kh'], 1) ?>g</td>
                            <td><?= number_format($totals['serat'], 1) ?>g</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
