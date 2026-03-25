<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="<?= site_url('relawan') ?>" class="text-decoration-none small text-muted">
        <i class="bi bi-arrow-left"></i> Kembali ke daftar
    </a>
    <h4 class="fw-bold mt-2">Edit Data Relawan</h4>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="<?= site_url('relawan/update/'.$relawan['id']) ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Relawan</label>
                        <input type="text" name="nama" class="form-control" value="<?= esc($relawan['nama']) ?>" required autocomplete="off">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Divisi</label>
                        <select name="divisi" class="form-select" required>
                            <option value="" disabled>Pilih Divisi</option>
                            <?php foreach ($divisions as $div): ?>
                                <option value="<?= $div ?>" <?= $relawan['divisi'] == $div ? 'selected' : '' ?>><?= ucwords($div) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 shadow-sm">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
