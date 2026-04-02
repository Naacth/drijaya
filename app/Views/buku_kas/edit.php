<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="<?= site_url('buku-kas') ?>" class="text-decoration-none small text-muted">
        <i class="bi bi-arrow-left"></i> Kembali ke Buku Kas
    </a>
    <h4 class="fw-bold mt-2">Ubah Entri Operasional</h4>
    <p class="text-muted small">Perbarui keterangan, tanggal, debet, dan kredit</p>
</div>

<form action="<?= site_url('buku-kas/update/'.$entry['id']) ?>" method="post">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="<?= esc($entry['tanggal']) ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Operasional (Keterangan)</label>
                    <input type="text" name="keterangan" class="form-control" value="<?= esc($entry['keterangan']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Debet (Rp)</label>
                    <input type="number" name="debet" class="form-control text-end" value="<?= esc($entry['debet']) ?>" step="1" min="0">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Kredit (Rp)</label>
                    <input type="number" name="kredit" class="form-control text-end" value="<?= esc($entry['kredit']) ?>" step="1" min="0">
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
