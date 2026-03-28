<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="mb-4 animate-in">
    <a href="<?= site_url('pemeriksaan-sampel') ?>" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    <h4 class="mb-1" style="font-weight: 700;">Buat Form Pemeriksaan & Sampel</h4>
</div>
<form action="<?= site_url('pemeriksaan-sampel/store') ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header"><h6><i class="bi bi-info-circle me-2"></i>Detail Pemeriksaan</h6></div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-3"><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" required value="<?= date('Y-m-d') ?>"></div>
                <div class="col-md-3"><label class="form-label">Jam Matang</label><input type="time" name="jam_matang" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Jenis Produk</label><input type="text" name="jenis_produk" class="form-control" placeholder="Contoh: Nasi, Ayam Goreng, Sayur Sop" required></div>
                <div class="col-md-6"><label class="form-label">Pengamatan Bahaya Fisik</label><textarea name="bahaya_fisik" class="form-control" rows="2" placeholder="Kerikil, rambut, plastik, dll"></textarea></div>
                <div class="col-md-6"><label class="form-label">Pengamatan Bahaya Biologi</label><textarea name="bahaya_biologi" class="form-control" rows="2" placeholder="Lendir, bau tidak sedap, dll"></textarea></div>
                <div class="col-md-3"><label class="form-label">Jam Penarikan</label><input type="time" name="jam_penarikan" class="form-control"></div>
                <div class="col-md-9"><label class="form-label">Tindak Lanjut</label><input type="text" name="tindak_lanjut" class="form-control" placeholder="Tindakan jika ditemukan bahaya"></div>
            </div>
        </div>
    </div>
    <div class="data-card mt-4 animate-in" style="animation-delay: 0.15s;">
        <div class="card-header"><h6><i class="bi bi-archive me-2"></i>Data Sampel (Archiving)</h6></div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-3"><label class="form-label">Sampel Diambil?</label><select name="sampel_diambil" class="form-select"><option value="ya">Ya</option><option value="tidak">Tidak</option></select></div>
                <div class="col-md-3"><label class="form-label">Jumlah Sampel</label><input type="text" name="jumlah_sampel" class="form-control" placeholder="Contoh: 100gr"></div>
                <div class="col-md-3"><label class="form-label">Tempat Simpan</label><input type="text" name="tempat_penyimpanan" class="form-control" placeholder="Contoh: Chiller Sampel"></div>
                <div class="col-md-3"><label class="form-label">Tgl Pemusnahan</label><input type="date" name="tanggal_pemusnahan" class="form-control"></div>
                <div class="col-md-6"><label class="form-label">Nama Pemeriksa</label><input type="text" name="nama_pemeriksa" class="form-control" value="<?= session()->get('nama') ?>" required></div>
            </div>
        </div>
        <div class="card-body bg-light border-top p-3 text-end"><button type="submit" class="btn btn-primary px-4">Simpan Data</button></div>
    </div>
</form>
<?= $this->endSection() ?>
