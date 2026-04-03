<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 animate-in">
        <div>
            <h4 class="mb-1" style="font-weight: 700;"><?= esc($title) ?></h4>
            <p class="text-muted small mb-0">Kontrol kebersihan harian unit pendingin Freezer & Chiller.</p>
        </div>
        <div class="text-end d-flex gap-2 align-items-center flex-wrap justify-content-end">
            <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'pembersihan-harian/export-pdf-blank', 'printBlankRoles' => ['ahli_gizi', 'admin'], 'printBlankWrapperClass' => 'mb-0']) ?>
            <?php if (session()->get('role') === 'ahli_gizi'): ?>
        <a href="<?= site_url('pembersihan-harian/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Buat Baru</a>
        <?php endif; ?>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Tanggal</th>
                            <th>Unit</th>
                            <th>Petugas</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($forms as $f): ?>
                        <tr>
                            <td class="ps-4"><strong><?= date('d/m/Y', strtotime($f['tanggal'])) ?></strong></td>
                            <td>
                                <span class="badge <?= $f['unit_type'] == 'freezer' ? 'bg-info' : 'bg-primary' ?> text-capitalize">
                                    <i class="bi <?= $f['unit_type'] == 'freezer' ? 'bi-snow' : 'bi-thermometer-snow' ?> me-1"></i>
                                    <?= esc($f['unit_type']) ?>
                                </span>
                            </td>
                            <td><?= esc($f['nama_petugas']) ?></td>
                            <td class="text-center text-nowrap">
                                <a href="<?= site_url('pembersihan-harian/show/' . $f['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="bi bi-eye"></i> Detail</a>
                                <?php if (session()->get('role') === 'ahli_gizi'): ?>
                                <a href="<?= site_url('pembersihan-harian/edit/' . $f['id']) ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3"><i class="bi bi-pencil"></i> Edit</a>
                                <?php endif; ?>
                                <?php if (session()->get('role') === 'admin'): ?>
                                <a href="<?= site_url('pembersihan-harian/delete/' . $f['id']) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i> Hapus</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
