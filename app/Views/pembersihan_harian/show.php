<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('pembersihan-harian') ?>" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Pembersihan Harian (<?= ucfirst($header['unit_type']) ?>)</h4>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('pembersihan-harian/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger"><i class="bi bi-file-pdf me-1"></i> Cetak PDF</a>
        <a href="<?= site_url('pembersihan-harian/export-excel/' . $header['id']) ?>" class="btn btn-outline-success"><i class="bi bi-file-excel me-1"></i> Export Excel</a>
    </div>
</div>

<div class="container-fluid px-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <label class="text-muted d-block small">Tanggal</label>
                            <strong><?= date('d M Y', strtotime($header['tanggal'])) ?></strong>
                        </div>
                        <div class="col-sm-6 text-end">
                            <label class="text-muted d-block small">ID Form</label>
                            <span class="badge bg-secondary text-uppercase">#PH-<?= $header['id'] ?></span>
                        </div>
                    </div>

                    <h6 class="border-bottom pb-2 mb-3">Checklist Kebersihan</h6>
                    <div class="row g-2">
                        <?php 
                        $possibleItems = ['rak', 'kontainer', 'lampu', 'langit-langit', 'lantai', 'dinding', 'bodi_luar', 'gagang_pintu', 'bunga_es'];
                        foreach ($possibleItems as $it): 
                            if ($header['unit_type'] == 'freezer' && in_array($it, ['rak', 'kontainer', 'lampu', 'langit-langit'])) continue;
                            if ($header['unit_type'] == 'chiller' && $it == 'bunga_es') continue;
                            $status = isset($area[$it]) && $area[$it] == '1';
                        ?>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between p-2 border rounded bg-light mb-1">
                                <span class="text-capitalize"><?= str_replace('_', ' ', $it) ?></span>
                                <i class="bi <?= $status ? 'bi-check-circle-fill text-success' : 'bi-x-circle text-danger' ?>"></i>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="row mt-4 pt-3 border-top">
                        <div class="col-6">
                            <small class="text-muted d-block">Petugas</small>
                            <strong><?= esc($header['nama_petugas']) ?></strong>
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-muted d-block">Verifikator</small>
                            <strong><?= esc($header['nama_verifikator']) ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
