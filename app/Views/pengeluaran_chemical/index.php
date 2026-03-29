<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <h4 class="mb-1" style="font-weight: 700;"><?= esc($title) ?></h4>
        <p class="text-muted small mb-0">Inventarisasi pemakaian bahan kimia sanitasi.</p>
    </div>
    <?php if (session()->get('role') === 'ahli_gizi'): ?>
    <a href="<?= site_url('pengeluaran-chemical/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Buat Baru</a>
    <?php endif; ?>
</div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Chemical</th>
                            <th>Jumlah</th>
                            <th>Personil</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($forms as $f): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($f['tanggal'])) ?></td>
                            <td><span class="fw-bold"><?= esc($f['nama_chemical']) ?></span></td>
                            <td><?= $f['jumlah'] ?> <?= esc($f['unit']) ?></td>
                            <td><?= esc($f['nama_personil']) ?></td>
                            <td class="text-center text-nowrap">
                                <a href="<?= site_url('pengeluaran-chemical/show/' . $f['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="bi bi-eye"></i> Detail</a>
                                <?php if (session()->get('role') === 'ahli_gizi'): ?>
                                <a href="<?= site_url('pengeluaran-chemical/edit/' . $f['id']) ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3"><i class="bi bi-pencil"></i> Edit</a>
                                <?php endif; ?>
                                <?php if (session()->get('role') === 'admin'): ?>
                                <a href="<?= site_url('pengeluaran-chemical/delete/' . $f['id']) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i> Hapus</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($forms)): ?>
                        <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data chemical.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
