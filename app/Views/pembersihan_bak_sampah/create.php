<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'pembersihan-bak-sampah/export-pdf-blank']) ?>


<div class="container-fluid">
    <div class="card shadow-sm border-0 col-lg-6 mx-auto">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Form Pembersihan Bak Sampah</h5>
        </div>
        <div class="card-body">
            <form action="<?= site_url('pembersihan-bak-sampah/store') ?>" method="post">
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jam Pelaksanaan</label>
                    <input type="time" name="jam" class="form-control" value="<?= date('H:i') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Personil</label>
                    <input type="text" name="nama_personil" class="form-control" placeholder="Nama petugas kebersihan" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Udah dicuci pake sabun & disinfektan"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Simpan Log</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
