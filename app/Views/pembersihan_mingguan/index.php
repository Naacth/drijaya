<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 animate-in">
        <div>
            <h4 class="mb-1" style="font-weight: 700;"><?= esc($title) ?></h4>
            <p class="text-muted small mb-0">Laporan mingguan kebersihan unit pendingin.</p>
        </div>
        <div class="text-end d-flex gap-2 align-items-center flex-wrap justify-content-end">
            <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'pembersihan-mingguan/export-pdf-blank', 'printBlankRoles' => ['ahli_gizi', 'admin', 'pic'], 'printBlankWrapperClass' => 'mb-0']) ?>
            <?php if (session()->get('role') === 'ahli_gizi'): ?>
        <a href="<?= site_url('pembersihan-mingguan/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Buat Baru</a>
        <?php endif; ?>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Area</th>
                            <th>Minggu Ke-</th>
                            <th>Bulan</th>
                            <th>Verifikator</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($forms as $f): ?>
                        <tr>
                            <td><strong><?= esc($f['area_pencucian']) ?></strong></td>
                            <td>Minggu <?= esc($f['minggu_ke']) ?></td>
                            <td><?= esc($f['bulan']) ?></td>
                            <td><?= esc($f['nama_verifikator']) ?></td>
                            <td class="text-center text-nowrap">
                                <a href="<?= site_url('pembersihan-mingguan/show/' . $f['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="bi bi-eye"></i> Detail</a>
                                <?php if (session()->get('role') === 'ahli_gizi'): ?>
                                <a href="<?= site_url('pembersihan-mingguan/edit/' . $f['id']) ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3"><i class="bi bi-pencil"></i> Edit</a>
                                <?php endif; ?>
                                <?php if (session()->get('role') === 'admin'): ?>
                                <a href="<?= site_url('pembersihan-mingguan/delete/' . $f['id']) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i> Hapus</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($forms)): ?>
                        <tr><td colspan="5" class="text-center py-4 text-muted small">Belum ada data mingguan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
