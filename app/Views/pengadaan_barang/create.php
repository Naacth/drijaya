<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'pengadaan-barang/export-pdf-blank']) ?>


<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('pengadaan-barang') ?>" class="text-decoration-none text-muted mb-2 d-inline-block small"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1 fw-bold"><?= $title ?></h4>
    </div>
</div>
<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-header"><h6><i class="bi bi-cart-plus me-2"></i>Form Pengadaan Barang</h6></div>
    <div class="card-body p-4">
        <form action="<?= site_url('pengadaan-barang/store') ?>" method="post">
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
                    <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Kompor Gas Industrial" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" name="jumlah" class="form-control" value="1" min="1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="pcs" placeholder="pcs/unit/buah">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Estimasi Harga (Rp)</label>
                    <input type="number" name="estimasi_harga" class="form-control" value="0" min="0" step="1000">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Alasan Pengadaan <span class="text-danger">*</span></label>
                    <textarea name="alasan" class="form-control" rows="3" placeholder="Jelaskan alasan mengapa barang ini perlu diadakan..." required></textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Simpan</button>
                <a href="<?= site_url('pengadaan-barang') ?>" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
