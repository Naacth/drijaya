<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center animate-in">
    <div class="col-lg-8">
        <div class="data-card">
            <div class="card-header">
                <h6><i class="bi bi-person-gear me-2"></i>Edit User</h6>
            </div>
            <div class="card-body p-4">
                <form action="<?= site_url('admin/users/update/' . $user['id']) ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" value="<?= esc($user['username']) ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control" value="<?= esc(str_replace('_', ' ', $user['role'])) ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama User</label>
                        <input type="text" name="nama" class="form-control" value="<?= old('nama', $user['nama']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password Baru (opsional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti password">
                        <small class="text-muted">Minimal 6 karakter jika diisi.</small>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= site_url('admin/users') ?>" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
