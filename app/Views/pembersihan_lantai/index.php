<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <h4 class="mb-1" style="font-weight: 700;"><?= esc($title) ?></h4>
        <p class="text-muted small mb-0">Monitoring rutinitas pembersihan lantai area produksi.</p>
    </div>
    <?php if (session()->get('role') === 'ahli_gizi'): ?>
    <a href="<?= site_url('pembersihan-lantai/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Buat Baru</a>
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
                        <th>Kondisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($forms as $f): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($f['tanggal'])) ?></td>
                        <td><?= esc($f['jam']) ?></td>
                        <td><?= esc($f['nama_personil']) ?></td>
                        <td>
                            <span class="badge <?= strtolower($f['kondisi']) == 'kering' ? 'bg-success' : 'bg-warning text-dark' ?>">
                                <?= esc($f['kondisi']) ?>
                            </span>
                        </td>
                        <td class="text-center text-nowrap">
                            <a href="<?= site_url('pembersihan-lantai/show/' . $f['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="bi bi-eye"></i> Detail</a>
                            <?php if (session()->get('role') === 'ahli_gizi'): ?>
                            <a href="<?= site_url('pembersihan-lantai/edit/' . $f['id']) ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3"><i class="bi bi-pencil"></i> Edit</a>
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
