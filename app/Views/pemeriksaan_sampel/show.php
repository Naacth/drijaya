<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4 animate-in">
    <div>
        <a href="<?= site_url('pemeriksaan-sampel') ?>" class="text-decoration-none text-muted mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
        <h4 class="mb-1" style="font-weight: 700;">Detail Pemeriksaan & Sampel</h4>
    </div>
    <div class="d-flex gap-2">
        <?php if (session()->get('role') === 'ahli_gizi'): ?>
        <a href="<?= site_url('pemeriksaan-sampel/edit/' . $header['id']) ?>" class="btn btn-warning"><i class="bi bi-pencil me-1"></i> Edit</a>
        <?php endif; ?>
        <a href="<?= site_url('pemeriksaan-sampel/export-pdf/' . $header['id']) ?>" target="_blank" class="btn btn-outline-danger"><i class="bi bi-file-pdf"></i></a>
        <a href="<?= site_url('pemeriksaan-sampel/export-excel/' . $header['id']) ?>" class="btn btn-outline-success"><i class="bi bi-file-excel"></i></a>
    </div>
</div>
<div class="data-card animate-in" style="animation-delay: 0.1s;">
    <div class="card-body p-4">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr><td width="180" class="text-muted">Tanggal</td><td>: <?= date('d F Y', strtotime($header['tanggal'])) ?></td></tr>
                    <tr><td class="text-muted">Jam Matang</td><td>: <?= esc($header['jam_matang'] ?: '-') ?></td></tr>
                    <tr><td class="text-muted">Jenis Produk</td><td class="fw-bold">: <?= esc($header['jenis_produk']) ?></td></tr>
                    <tr><td class="text-muted">Bahaya Fisik</td><td>: <?= esc($header['bahaya_fisik'] ?: 'Tidak ada') ?></td></tr>
                    <tr><td class="text-muted">Bahaya Biologi</td><td>: <?= esc($header['bahaya_biologi'] ?: 'Tidak ada') ?></td></tr>
                    <tr><td class="text-muted">Jam Penarikan</td><td>: <?= esc($header['jam_penarikan'] ?: '-') ?></td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr><td width="180" class="text-muted">Sampel Diambil</td><td>: <span class="badge <?= $header['sampel_diambil'] == 'ya' ? 'bg-success' : 'bg-warning' ?>"><?= strtoupper($header['sampel_diambil']) ?></span></td></tr>
                    <tr><td class="text-muted">Jumlah Sampel</td><td>: <?= esc($header['jumlah_sampel'] ?: '-') ?></td></tr>
                    <tr><td class="text-muted">Tempat Simpan</td><td>: <?= esc($header['tempat_penyimpanan'] ?: '-') ?></td></tr>
                    <tr><td class="text-muted">Tgl Pemusnahan</td><td>: <?= $header['tanggal_pemusnahan'] ? date('d/m/Y', strtotime($header['tanggal_pemusnahan'])) : '-' ?></td></tr>
                    <tr><td class="text-muted">Pemeriksa</td><td>: <?= esc($header['nama_pemeriksa']) ?></td></tr>
                    <tr><td class="text-muted">Waktu Input</td><td>: <?= date('d/m/Y H:i', strtotime($header['created_at'])) ?></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
