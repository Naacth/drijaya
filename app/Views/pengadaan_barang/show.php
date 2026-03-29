<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('pengadaan-barang') ?>" class="text-decoration-none text-muted mb-2 d-inline-block small"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1 fw-bold">Detail Pengadaan Barang</h4>
        <p class="text-muted small mb-0">Informasi lengkap pengajuan pengadaan barang</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= site_url('pengadaan-barang/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger btn-sm px-3 rounded-pill shadow-sm"><i class="bi bi-file-pdf me-1"></i> Cetak PDF</a>
        <a href="<?= site_url('pengadaan-barang/export-excel/' . $header['id']) ?>" class="btn btn-outline-success btn-sm px-3 rounded-pill shadow-sm"><i class="bi bi-file-excel me-1"></i> Export Excel</a>
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
                <p class="mb-0"><span class="badge bg-light text-dark border">#PB-<?= str_pad($header['id'], 5, '0', STR_PAD_LEFT) ?></span></p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="small text-muted mb-1 text-uppercase fw-bold">Estimasi Harga</label>
                <p class="mb-0 fw-bold text-success fs-5">Rp <?= number_format($header['estimasi_harga'], 0, ',', '.') ?></p>
            </div>
            <div class="col-md-8">
                <label class="small text-muted mb-1 text-uppercase fw-bold">Alasan Pengadaan</label>
                <p class="mb-0"><?= esc($header['alasan'] ?: '-') ?></p>
            </div>
        </div>
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
