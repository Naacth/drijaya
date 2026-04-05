<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Buku Kas Operasional</h4>
        <p class="text-muted small mb-0">Kelola catatan transaksi operasional harian</p>
    </div>
    <div class="d-flex gap-2">
        <?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'buku-kas/export-pdf-blank', 'printBlankRoles' => ['akuntan', 'admin', 'pic'], 'printBlankWrapperClass' => 'mb-0']) ?>
        <a href="<?= site_url('buku-kas/report') ?>" class="btn btn-outline-primary px-4 shadow-sm">
            <i class="bi bi-file-earmark-bar-graph me-2"></i>Laporan & Export
        </a>
        <a href="<?= site_url('buku-kas/create') ?>" class="btn btn-primary px-4 shadow-sm">
            <i class="bi bi-plus-circle me-2"></i>Tambah Entri
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm bg-primary text-white p-3">
            <div class="small opacity-75">Total Debet Bulan Ini</div>
            <div class="fs-3 fw-bold">Rp <?= number_format($summary['debet'] ?? 0, 0, ',', '.') ?></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm bg-danger text-white p-3">
            <div class="small opacity-75">Total Kredit Bulan Ini</div>
            <div class="fs-3 fw-bold">Rp <?= number_format($summary['kredit'] ?? 0, 0, ',', '.') ?></div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3" width="150">Tanggal</th>
                        <th class="py-3">Keterangan / Operasional</th>
                        <th class="py-3 text-end" width="150">Debet</th>
                        <th class="py-3 text-end" width="150">Kredit</th>
                        <th class="py-3 text-center" width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($entries)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted small">
                                Belum ada catatan operasional.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($entries as $e):
                            $role = session()->get('role');
                            $usppg = $user_sppg_id ?? null;
                            $showEdit = ($role === 'admin') || ($role === 'akuntan' && $usppg !== null && (int) ($e['sppg_id'] ?? 0) === (int) $usppg);
                            ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold"><?= date('d M Y', strtotime($e['tanggal'])) ?></div>
                                    <small class="text-muted"><?= date('l', strtotime($e['tanggal'])) ?></small>
                                </td>
                                <td><?= esc($e['keterangan']) ?></td>
                                <td class="text-end text-primary fw-medium">
                                    <?= $e['debet'] > 0 ? 'Rp '.number_format($e['debet'], 0, ',', '.') : '-' ?>
                                </td>
                                <td class="text-end text-danger fw-medium">
                                    <?= $e['kredit'] > 0 ? 'Rp '.number_format($e['kredit'], 0, ',', '.') : '-' ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1 flex-wrap justify-content-center">
                                        <?php if ($showEdit): ?>
                                        <a href="<?= site_url('buku-kas/edit/'.$e['id']) ?>" class="btn btn-sm btn-light text-primary border" title="Ubah">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php endif; ?>
                                        <?php if ($role === 'admin'): ?>
                                        <a href="<?= site_url('buku-kas/delete/'.$e['id']) ?>"
                                           class="btn btn-sm btn-light text-danger border"
                                           onclick="return confirm('Hapus entri ini?')"
                                           title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
