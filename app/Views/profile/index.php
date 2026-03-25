<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                        <i class="bi bi-person-gear fs-3"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Pengaturan Profil</h5>
                        <p class="text-muted small mb-0">Ubah informasi akun dan kata sandi Anda.</p>
                    </div>
                </div>

                <form action="<?= site_url('profile/update') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Username</label>
                        <input type="text" class="form-control bg-light" value="<?= esc($user['username']) ?>" readonly>
                        <div class="form-text">Username tidak dapat diubah.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= esc($user['nama']) ?>" required>
                    </div>

                    <hr class="my-4">

                    <div class="alert alert-info border-0 shadow-none py-2 px-3 mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <span class="small">Kosongkan jika tidak ingin mengubah password.</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Konfirmasi Password Baru</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password baru">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2 fw-bold">
                            <i class="bi bi-check-lg me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
