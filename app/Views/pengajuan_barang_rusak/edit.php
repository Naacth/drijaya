<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('pengajuan-barang-rusak') ?>" class="text-decoration-none text-muted mb-2 d-inline-block small"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1 fw-bold"><?= $title ?></h4>
    </div>
</div>
<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-header"><h6><i class="bi bi-pencil me-2"></i>Edit Pengajuan Barang Rusak</h6></div>
    <div class="card-body p-4">
        <form action="<?= site_url('pengajuan-barang-rusak/update/' . $header['id']) ?>" method="post" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" value="<?= $header['tanggal'] ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="draft" <?= $header['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="diajukan" <?= $header['status'] == 'diajukan' ? 'selected' : '' ?>>Diajukan</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                    <input type="text" name="nama_barang" class="form-control" value="<?= esc($header['nama_barang']) ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" name="jumlah" class="form-control" value="<?= $header['jumlah'] ?>" min="1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="<?= esc($header['satuan']) ?>">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Kondisi / Kerusakan <span class="text-danger">*</span></label>
                    <textarea name="kondisi" class="form-control" rows="3" required><?= esc($header['kondisi']) ?></textarea>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="2"><?= esc($header['keterangan']) ?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Foto Barang Rusak</label>
                    <?php if (!empty($header['foto'])): ?>
                        <div class="mb-2"><img src="<?= base_url($header['foto']) ?>" class="img-thumbnail" style="max-height: 100px;"></div>
                    <?php endif; ?>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Perbarui</button>
                <a href="<?= site_url('pengajuan-barang-rusak') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
