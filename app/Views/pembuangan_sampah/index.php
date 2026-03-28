<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <h4 class="mb-1" style="font-weight: 700;"><?= esc($title) ?></h4>
        <p class="text-muted small mb-0">Pencatatan realisasi pembuangan sampah 3 kali sehari.</p>
    </div>
    <?php if (session()->get('role') === 'ahli_gizi'): ?>
    <a href="<?= site_url('pembuangan-sampah/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Buat Baru</a>
    <?php endif; ?>
</div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Bulan & Tahun</th>
                            <th>Ka.SPPG</th>
                            <th>Admin/Input</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($forms as $f): ?>
                        <tr>
                            <td><strong><?= esc($f['bulan']) ?> <?= $f['tahun'] ?></strong></td>
                            <td><?= esc($f['nama_kappg']) ?></td>
                            <td><?= esc($f['user_nama']) ?></td>
                            <td class="text-center text-nowrap">
                                <a href="<?= site_url('pembuangan-sampah/show/' . $f['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="bi bi-eye"></i> Detail</a>
                                <?php if (session()->get('role') === 'ahli_gizi'): ?>
                                <a href="<?= site_url('pembuangan-sampah/edit/' . $f['id']) ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3"><i class="bi bi-pencil"></i> Edit</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($forms)): ?>
                        <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada rekap bulanan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
