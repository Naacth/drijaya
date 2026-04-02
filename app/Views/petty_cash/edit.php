<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="<?= site_url('petty-cash') ?>" class="text-decoration-none small text-muted">
        <i class="bi bi-arrow-left"></i> Kembali ke Petty Cash
    </a>
    <h4 class="fw-bold mt-2">Ubah Entri Petty Cash</h4>
    <p class="text-muted small">Perbarui tanggal, keterangan, pemasukkan, dan pengeluaran</p>
</div>

<form action="<?= site_url('petty-cash/update/'.$entry['id']) ?>" method="post">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="<?= esc($entry['tanggal']) ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" value="<?= esc($entry['keterangan']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Pemasukkan (Rp)</label>
                    <input type="number" name="pemasukkan" class="form-control text-end" value="<?= esc($entry['pemasukkan']) ?>" step="1" min="0">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Pengeluaran (Rp)</label>
                    <input type="number" name="pengeluaran" class="form-control text-end" value="<?= esc($entry['pengeluaran']) ?>" step="1" min="0">
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 text-end">
        <button type="submit" class="btn btn-primary px-5 py-2 shadow border-0 fw-bold">
            Simpan Perubahan
        </button>
    </div>
</form>

<?= $this->endSection() ?>
