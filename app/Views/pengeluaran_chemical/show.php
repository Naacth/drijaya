<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('pengeluaran-chemical') ?>" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Pengeluaran Chemical</h4>
    </div>
    <div class="d-flex gap-2">
        <?php if (session()->get('role') === 'ahli_gizi'): ?>
        <a href="<?= site_url('pengeluaran-chemical/edit/' . $header['id']) ?>" class="btn btn-warning"><i class="bi bi-pencil me-1"></i> Edit</a>
        <?php endif; ?>
        <a href="<?= site_url('pengeluaran-chemical/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger"><i class="bi bi-file-pdf me-1"></i> Cetak PDF</a>
        <a href="<?= site_url('pengeluaran-chemical/export-excel/' . $header['id']) ?>" class="btn btn-outline-success"><i class="bi bi-file-excel me-1"></i> Export Excel</a>
    </div>
</div>

<div class="container-fluid px-0">
    <div class="card shadow-sm border-0 col-lg-12">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2 class="text-primary"><?= esc($header['nama_chemical']) ?></h2>
                <div class="badge bg-light text-dark border p-2 px-3 fs-5"><?= $header['jumlah'] ?> <?= esc($header['unit']) ?></div>
            </div>
            <div class="list-group list-group-flush border rounded">
                <div class="list-group-item d-flex justify-content-between"><span>Tanggal</span><strong><?= date('d M Y', strtotime($header['tanggal'])) ?></strong></div>
                <div class="list-group-item d-flex justify-content-between"><span>Penerima</span><strong><?= esc($header['nama_personil']) ?></strong></div>
                <div class="list-group-item d-flex justify-content-between"><span>Ahli Gizi</span><strong><?= esc($header['nama_gizi']) ?></strong></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
