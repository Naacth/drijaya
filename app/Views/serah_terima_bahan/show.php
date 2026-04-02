<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('serah-terima-bahan') ?>" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Serah Terima Bahan</h4>
    </div>
    <div class="d-flex gap-2">
        <?php if (session()->get('role') === 'ahli_gizi'): ?>
        <a href="<?= site_url('serah-terima-bahan/edit/' . $header['id']) ?>" class="btn btn-warning"><i class="bi bi-pencil me-1"></i> Edit</a>
        <?php endif; ?>
        <a href="<?= site_url('serah-terima-bahan/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger"><i class="bi bi-file-pdf"></i></a>
        <a href="<?= site_url('serah-terima-bahan/export-excel/' . $header['id']) ?>" class="btn btn-outline-success"><i class="bi bi-file-excel"></i></a>
    </div>
</div>
<div class="row g-4 animate-in" style="animation-delay: 0.1s;">
    <div class="col-md-4">
        <div class="data-card h-100"><div class="card-header"><h6><i class="bi bi-info-circle me-2"></i>Informasi</h6></div>
            <div class="card-body p-4">
                <table class="table table-borderless table-sm mb-0">
                    <tr><td class="text-muted" width="130">Tanggal</td><td>: <?= date('d/m/Y', strtotime($header['tanggal'])) ?></td></tr>
                    <tr><td class="text-muted">Pengirim</td><td class="fw-bold">: <?= esc($header['nama_pengirim']) ?></td></tr>
                    <tr><td class="text-muted">Penerima</td><td class="fw-bold">: <?= esc($header['nama_penerima']) ?></td></tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr><td class="text-muted">Diinput Oleh</td><td>: <?= esc($header['user_nama']) ?></td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="data-card h-100"><div class="card-header"><h6><i class="bi bi-list-ul me-2"></i>Daftar Item Bahan Baku</h6></div>
            <div class="table-responsive">
                <table class="table table-premium mb-0">
                    <thead><tr><th width="40">No</th><th>Jam</th><th>Nama Bahan</th><th>Tujuan</th><th width="80">Gram</th><th width="80">Awal</th><th width="80">Akhir</th></tr></thead>
                    <tbody>
                        <?php foreach ($items as $i => $item): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($item['jam'] ?: '-') ?></td>
                            <td class="fw-medium"><?= esc($item['nama_bahan']) ?></td>
                            <td><?= esc($item['tujuan_penggunaan']) ?></td>
                            <td><?= esc($item['gramasi_per_porsi']) ?></td>
                            <td><?= esc($item['jumlah_awal']) ?></td>
                            <td><span class="fw-bold"><?= esc($item['jumlah_akhir']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
