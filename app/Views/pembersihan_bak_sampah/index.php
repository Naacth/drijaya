<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <h4 class="mb-1" style="font-weight: 700;"><?= esc($title) ?></h4>
        <p class="text-muted small mb-0">Monitoring kebersihan bak sampah harian.</p>
    </div>
    <?php if (session()->get('role') === 'ahli_gizi'): ?>
    <a href="<?= site_url('pembersihan-bak-sampah/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Buat Baru</a>
    <?php endif; ?>
</div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Personil</th>
                        <th>Keterangan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($forms as $f): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($f['tanggal'])) ?></td>
                        <td><?= esc($f['jam']) ?></td>
                        <td><?= esc($f['nama_personil']) ?></td>
                        <td><?= esc($f['keterangan']) ?></td>
                        <td class="text-center text-nowrap">
                             <a href="<?= site_url('pembersihan-bak-sampah/show/' . $f['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="bi bi-eye"></i> Detail</a>
                             <?php if (session()->get('role') === 'ahli_gizi'): ?>
                             <a href="<?= site_url('pembersihan-bak-sampah/edit/' . $f['id']) ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3"><i class="bi bi-pencil"></i> Edit</a>
                             <?php endif; ?>
                             <?php if (session()->get('role') === 'admin'): ?>
                             <a href="<?= site_url('pembersihan-bak-sampah/delete/' . $f['id']) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i> Hapus</a>
                             <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
