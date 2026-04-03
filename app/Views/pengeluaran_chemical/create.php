<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'pengeluaran-chemical/export-pdf-blank']) ?>


<div class="container-fluid">
    <div class="card shadow-sm border-0 col-lg-7 mx-auto">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Catat Pengeluaran Chemical</h5>
        </div>
        <div class="card-body">
            <form action="<?= site_url('pengeluaran-chemical/store') ?>" method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Chemical</label>
                        <input type="text" name="nama_chemical" class="form-control" placeholder="Contoh: Sabun Cuci Piring" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" step="0.01" name="jumlah" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Unit</label>
                        <select name="unit" class="form-select">
                            <option value="Liter">Liter</option>
                            <option value="Pcs">Pcs</option>
                            <option value="Botol">Botol</option>
                            <option value="Jerigen">Jerigen</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Personil Pengambil</label>
                        <input type="text" name="nama_personil" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ahli Gizi (Pemeriksa)</label>
                        <input type="text" name="nama_gizi" class="form-control" required>
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary px-5">Simpan Data Chemical</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
