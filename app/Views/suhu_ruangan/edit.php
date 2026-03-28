<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="mb-4 animate-in">
    <a href="<?= site_url('suhu-ruangan') ?>" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    <h4 class="mb-1" style="font-weight: 700;">Edit Suhu & Kelembapan Ruangan</h4>
</div>
<form action="<?= site_url('suhu-ruangan/update/' . $header['id']) ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" required value="<?= $header['tanggal'] ?>"></div>
                <div class="col-md-6"><label class="form-label">Nama Petugas</label><input type="text" name="nama_petugas" class="form-control" required value="<?= $header['nama_petugas'] ?>"></div>
            </div>
            <div class="row mt-4 g-4">
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light shadow-sm">
                        <h6 class="border-bottom pb-2 mb-3">PAGI</h6>
                        <div class="mb-2"><label class="small">Jam</label><input type="time" name="pagi_jam" class="form-control form-control-sm" value="<?= $header['pagi_jam'] ?>"></div>
                        <div class="mb-2"><label class="small">Suhu (°C)</label><input type="text" name="pagi_suhu" class="form-control form-control-sm" value="<?= $header['pagi_suhu'] ?>"></div>
                        <div class="mb-2"><label class="small">Kelembapan (%)</label><input type="text" name="pagi_kelembapan" class="form-control form-control-sm" value="<?= $header['pagi_kelembapan'] ?>"></div>
                        <div><label class="small">Keterangan</label><input type="text" name="pagi_keterangan" class="form-control form-control-sm" value="<?= $header['pagi_keterangan'] ?>"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light shadow-sm">
                        <h6 class="border-bottom pb-2 mb-3">SIANG</h6>
                        <div class="mb-2"><label class="small">Jam</label><input type="time" name="siang_jam" class="form-control form-control-sm" value="<?= $header['siang_jam'] ?>"></div>
                        <div class="mb-2"><label class="small">Suhu (°C)</label><input type="text" name="siang_suhu" class="form-control form-control-sm" value="<?= $header['siang_suhu'] ?>"></div>
                        <div class="mb-2"><label class="small">Kelembapan (%)</label><input type="text" name="siang_kelembapan" class="form-control form-control-sm" value="<?= $header['siang_kelembapan'] ?>"></div>
                        <div><label class="small">Keterangan</label><input type="text" name="siang_keterangan" class="form-control form-control-sm" value="<?= $header['siang_keterangan'] ?>"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light shadow-sm">
                        <h6 class="border-bottom pb-2 mb-3">SORE</h6>
                        <div class="mb-2"><label class="small">Jam</label><input type="time" name="sore_jam" class="form-control form-control-sm" value="<?= $header['sore_jam'] ?>"></div>
                        <div class="mb-2"><label class="small">Suhu (°C)</label><input type="text" name="sore_suhu" class="form-control form-control-sm" value="<?= $header['sore_suhu'] ?>"></div>
                        <div class="mb-2"><label class="small">Kelembapan (%)</label><input type="text" name="sore_kelembapan" class="form-control form-control-sm" value="<?= $header['sore_kelembapan'] ?>"></div>
                        <div><label class="small">Keterangan</label><input type="text" name="sore_keterangan" class="form-control form-control-sm" value="<?= $header['sore_keterangan'] ?>"></div>
                    </div>
                </div>
            </div>
            <div class="mt-4 text-end"><button type="submit" class="btn btn-primary px-5">Perbarui Catatan</button></div>
        </div>
    </div>
</form>
<?= $this->endSection() ?>
