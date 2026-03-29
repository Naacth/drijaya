<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('pengajuan-barang-rusak') ?>" class="text-decoration-none text-muted mb-2 d-inline-block small"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1 fw-bold">Detail Pengajuan Barang Rusak</h4>
        <p class="text-muted small mb-0">Informasi lengkap pengajuan barang rusak</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('pengajuan-barang-rusak/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger btn-sm px-3 rounded-pill shadow-sm"><i class="bi bi-file-pdf me-1"></i> Cetak PDF</a>
        <a href="<?= site_url('pengajuan-barang-rusak/export-excel/' . $header['id']) ?>" class="btn btn-outline-success btn-sm px-3 rounded-pill shadow-sm"><i class="bi bi-file-excel me-1"></i> Export Excel</a>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4 animate-in" style="animation-delay: 0.1s">
    <div class="card-body p-4">
        <div class="row mb-4 pb-3 border-bottom">
            <div class="col-md-3">
                <label class="small text-muted mb-1 text-uppercase fw-bold">Tanggal</label>
                <p class="mb-0 fw-bold fs-5 text-primary"><?= date('d M Y', strtotime($header['tanggal'])) ?></p>
            </div>
            <div class="col-md-3">
                <label class="small text-muted mb-1 text-uppercase fw-bold">Nama Barang</label>
                <p class="mb-0 fw-bold fs-5"><?= esc($header['nama_barang']) ?></p>
            </div>
            <div class="col-md-2">
                <label class="small text-muted mb-1 text-uppercase fw-bold">Jumlah</label>
                <p class="mb-0 fw-bold fs-5"><?= $header['jumlah'] ?> <?= esc($header['satuan']) ?></p>
            </div>
            <div class="col-md-2">
                <label class="small text-muted mb-1 text-uppercase fw-bold">Status</label>
                <p class="mb-0"><span class="badge-status badge-<?= $header['status'] ?>"><?= ucfirst($header['status']) ?></span></p>
            </div>
            <div class="col-md-2 text-end">
                <label class="small text-muted mb-1 text-uppercase fw-bold">ID</label>
                <p class="mb-0"><span class="badge bg-light text-dark border">#BR-<?= str_pad($header['id'], 5, '0', STR_PAD_LEFT) ?></span></p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="small text-muted mb-1 text-uppercase fw-bold">Kondisi / Kerusakan</label>
                <p class="mb-0"><?= esc($header['kondisi'] ?: '-') ?></p>
            </div>
            <div class="col-md-6">
                <label class="small text-muted mb-1 text-uppercase fw-bold">Keterangan</label>
                <p class="mb-0"><?= esc($header['keterangan'] ?: '-') ?></p>
            </div>
        </div>
        <?php if (!empty($header['foto'])): ?>
        <div class="mb-3">
            <label class="small text-muted mb-1 text-uppercase fw-bold">Foto Barang</label>
            <div><img src="<?= base_url($header['foto']) ?>" class="img-fluid rounded" style="max-height: 300px;"></div>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6">
                <label class="small text-muted mb-1 text-uppercase fw-bold">Dibuat Oleh</label>
                <p class="mb-0"><?= esc($header['user_nama']) ?></p>
            </div>
            <div class="col-md-6">
                <label class="small text-muted mb-1 text-uppercase fw-bold">Dibuat Pada</label>
                <p class="mb-0"><?= date('d M Y H:i', strtotime($header['created_at'])) ?></p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
