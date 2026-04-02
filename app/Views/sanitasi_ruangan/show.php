<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('sanitasi-ruangan') ?>" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Sanitasi</h4>
    </div>
    <div class="d-flex gap-2">
        <?php if (session()->get('role') === 'ahli_gizi'): ?>
        <a href="<?= site_url('sanitasi-ruangan/edit/' . $header['id']) ?>" class="btn btn-warning"><i class="bi bi-pencil me-1"></i> Edit</a>
        <?php endif; ?>
        <a href="<?= site_url('sanitasi-ruangan/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger"><i class="bi bi-file-pdf me-1"></i> Cetak PDF</a>
        <a href="<?= site_url('sanitasi-ruangan/export-excel/' . $header['id']) ?>" class="btn btn-outline-success"><i class="bi bi-file-excel me-1"></i> Export Excel</a>
    </div>
</div>

<div class="container-fluid px-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-4 text-muted">Tanggal</div>
                        <div class="col-sm-8 text-dark fw-bold"><?= date('l, d F Y', strtotime($header['tanggal'])) ?></div>
                    </div>
                    
                    <h6 class="mb-3 text-primary">Status Fasilitas & Peralatan</h6>
                    <div class="list-group list-group-flush border rounded mb-4">
                        <?php 
                        $items = ['Lantai', 'Dinding', 'Meja Persiapan', 'Steamer', 'Chopper', 'Blender', 'Talenan', 'Pisau', 'Kompor', 'Rak Alat', 'Sink'];
                        foreach ($items as $item): 
                            $key = strtolower(str_replace(' ', '_', $item));
                            $isClean = isset($fasilitas[$key]) && $fasilitas[$key] == '1';
                        ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?= $item ?></span>
                            <span class="badge rounded-pill <?= $isClean ? 'bg-success' : 'bg-danger' ?>">
                                <i class="bi <?= $isClean ? 'bi-check-circle' : 'bi-x-circle' ?> me-1"></i>
                                <?= $isClean ? 'Bersih' : 'Kotor' ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded text-center">
                                <small class="text-muted d-block mb-2">Pelaksana</small>
                                <strong><?= esc($header['nama_pelaksana']) ?></strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded text-center">
                                <small class="text-muted d-block mb-2">Pemeriksa</small>
                                <strong><?= esc($header['nama_pemeriksa']) ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
