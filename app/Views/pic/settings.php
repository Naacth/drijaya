<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Pengaturan SPPG</h4>
        <p class="text-muted small mb-0">Atur profil dan informasi alamat dapur (SPPG)</p>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('pic/settings/update') ?>" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Nama SPPG</label>
                        <input type="text" name="nama_sppg" class="form-control" value="<?= esc($sppg['nama_sppg']) ?>">
                        <div class="form-text">Ubah nama ini akan memperbarui kop surat secara otomatis.</div>
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="form-label fw-medium">Alamat Lengkap Dapur</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="4" placeholder="Masukkan alamat lengkap dapur SPPG (misal: Jl. Raya Mauk No. 1, Desa Sepatan...)"><?= esc($sppg['alamat'] ?? '') ?></textarea>
                        <div class="form-text text-primary"><i class="bi bi-info-circle me-1"></i>Alamat ini akan otomatis dicetak di kop surat pada semua laporan PDF dan Excel (Buku Kas, BA Kehilangan, dll) untuk dapur ini.</div>
                    </div>

                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                    </button>
                    
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
