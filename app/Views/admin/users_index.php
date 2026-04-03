<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="data-card animate-in">
    <div class="card-header">
        <h6><i class="bi bi-people me-2"></i>Manajemen User</h6>
        <span class="badge bg-primary rounded-pill"><?= count($users ?? []) ?></span>
    </div>
    <div class="table-responsive">
        <table class="table table-premium">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Belum ada user.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($users as $i => $u): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><strong><?= esc($u['nama']) ?></strong></td>
                        <td><?= esc($u['username']) ?></td>
                        <td><span class="badge bg-light text-dark"><?= esc(str_replace('_', ' ', $u['role'])) ?></span></td>
                        <td>
                            <a href="<?= site_url('admin/users/edit/' . $u['id']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square me-1"></i>Edit
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
