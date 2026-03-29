<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <h4 class="mb-1" style="font-weight: 700;">Pengadaan Barang</h4>
        <p class="text-muted small mb-0">Daftar pengajuan pengadaan barang baru.</p>
    </div>
    <?php if (session()->get('role') === 'pic'): ?>
    <a href="<?= site_url('pengadaan-barang/create') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Buat Pengajuan</a>
    <?php endif; ?>
</div>

<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-header"><h6><i class="bi bi-cart-plus me-2"></i>Riwayat Pengadaan Barang</h6></div>
    <div class="table-responsive">
        <table class="table table-premium table-hover">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Estimasi Harga</th>
                    <th>Status</th>
                    <th>Dibuat Oleh</th>
                    <th class="text-center" width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($forms)): ?>
                    <tr><td colspan="8" class="text-center py-4 text-muted"><i class="bi bi-inbox fs-3 d-block mb-2"></i>Belum ada pengajuan pengadaan barang.</td></tr>
                <?php else: ?>
                    <?php foreach ($forms as $i => $form): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= date('d M Y', strtotime($form['tanggal'])) ?></td>
                        <td><span class="fw-medium text-dark"><?= esc($form['nama_barang']) ?></span></td>
                        <td><?= $form['jumlah'] ?> <?= esc($form['satuan']) ?></td>
                        <td>Rp <?= number_format($form['estimasi_harga'], 0, ',', '.') ?></td>
                        <td><span class="badge-status badge-<?= $form['status'] ?>"><?= ucfirst($form['status']) ?></span></td>
                        <td><?= esc($form['user_nama']) ?></td>
                        <td class="text-center text-nowrap">
                            <a href="<?= site_url('pengadaan-barang/show/' . $form['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3" title="Detail"><i class="bi bi-eye"></i></a>
                            
                            <?php if (session()->get('role') === 'pic' && ($form['status'] === 'draft' || $form['status'] === 'ditolak')): ?>
                            <a href="<?= site_url('pengadaan-barang/edit/' . $form['id']) ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3" title="Edit"><i class="bi bi-pencil"></i></a>
                            <?php endif; ?>

                            <?php if (session()->get('role') === 'admin'): ?>
                                <?php if ($form['status'] === 'diajukan'): ?>
                                <form action="<?= site_url('pengadaan-barang/approve/' . $form['id']) ?>" method="post" class="d-inline">
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3" onclick="return confirm('Setujui pengadaan ini?')"><i class="bi bi-check-lg"></i></button>
                                </form>
                                <form action="<?= site_url('pengadaan-barang/reject/' . $form['id']) ?>" method="post" class="d-inline">
                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3" onclick="return confirm('Tolak pengadaan ini?')"><i class="bi bi-x-lg"></i></button>
                                </form>
                                <?php endif; ?>
                                <a href="<?= site_url('pengadaan-barang/delete/' . $form['id']) ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Yakin hapus data ini?')" title="Hapus"><i class="bi bi-trash"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
