<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('pengajuan-barang-rusak') ?>" class="text-decoration-none text-muted mb-2 d-inline-block small"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1 fw-bold"><?= $title ?></h4>
    </div>
</div>
<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-header"><h6><i class="bi bi-tools me-2"></i>Form Pengajuan Barang Rusak</h6></div>
    <div class="card-body p-4">
        <form action="<?= site_url('pengajuan-barang-rusak/store') ?>" method="post" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="draft">Draft</option>
                        <option value="diajukan">Diajukan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Trolly Makanan" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" name="jumlah" class="form-control" value="1" min="1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="pcs" placeholder="pcs/unit/buah">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Kondisi / Kerusakan <span class="text-danger">*</span></label>
                    <textarea name="kondisi" class="form-control" rows="3" placeholder="Jelaskan kondisi kerusakan barang..." required></textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Keterangan tambahan (opsional)"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Foto Barang Rusak</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG. Maks 2MB.</small>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Simpan</button>
                <a href="<?= site_url('pengajuan-barang-rusak') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
