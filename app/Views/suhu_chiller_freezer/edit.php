<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="mb-4 animate-in">
    <a href="<?= site_url('suhu-chiller-freezer') ?>" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    <h4 class="mb-1" style="font-weight: 700;">Edit Suhu Chiller & Freezer</h4>
</div>
<form action="<?= site_url('suhu-chiller-freezer/update/' . $header['id']) ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" required value="<?= $header['tanggal'] ?>"></div>
                <div class="col-md-6"><label class="form-label">Nama Petugas</label><input type="text" name="nama_petugas" class="form-control" required value="<?= $header['nama_petugas'] ?>"></div>
            </div>
            <div class="row mt-4 g-4">
                <div class="col-md-6">
                    <div class="p-4 border rounded bg-light shadow-sm">
                        <h6 class="border-bottom pb-2 mb-3 text-primary"><i class="bi bi-thermometer-half me-2"></i>Unit Chiller (0°C s/d 4°C)</h6>
                        <div class="row g-2">
                            <div class="col-4"><label class="small">Pagi</label><input type="text" name="chiller_pagi" class="form-control form-control-sm" placeholder="°C" value="<?= $header['chiller_pagi'] ?>"></div>
                            <div class="col-4"><label class="small">Siang</label><input type="text" name="chiller_siang" class="form-control form-control-sm" placeholder="°C" value="<?= $header['chiller_siang'] ?>"></div>
                            <div class="col-4"><label class="small">Malam</label><input type="text" name="chiller_malam" class="form-control form-control-sm" placeholder="°C" value="<?= $header['chiller_malam'] ?>"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 border rounded bg-light shadow-sm">
                        <h6 class="border-bottom pb-2 mb-3 text-info"><i class="bi bi-thermometer-snow me-2"></i>Unit Freezer (< -18°C)</h6>
                        <div class="row g-2">
                            <div class="col-4"><label class="small">Pagi</label><input type="text" name="freezer_pagi" class="form-control form-control-sm" placeholder="°C" value="<?= $header['freezer_pagi'] ?>"></div>
                            <div class="col-4"><label class="small">Siang</label><input type="text" name="freezer_siang" class="form-control form-control-sm" placeholder="°C" value="<?= $header['freezer_siang'] ?>"></div>
                            <div class="col-4"><label class="small">Malam</label><input type="text" name="freezer_malam" class="form-control form-control-sm" placeholder="°C" value="<?= $header['freezer_malam'] ?>"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="p-3 border-start border-4 border-primary bg-light">
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Kebersihan Rak</label><input type="text" name="kebersihan_rak" class="form-control" placeholder="Bersih/Kotor" value="<?= $header['kebersihan_rak'] ?>"></div>
                            <div class="col-md-6"><label class="form-label">Verifikasi</label><input type="text" name="verifikasi" class="form-control" placeholder="Nama Ahli Gizi" value="<?= $header['verifikasi'] ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-end"><button type="submit" class="btn btn-primary px-5">Perbarui Data Suhu</button></div>
        </div>
    </div>
</form>
<?= $this->endSection() ?>
