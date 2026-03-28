<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="card shadow-sm border-0 col-lg-7 mx-auto">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Edit Pengeluaran Chemical</h5>
        </div>
        <div class="card-body">
            <form action="<?= site_url('pengeluaran-chemical/update/' . $header['id']) ?>" method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= $header['tanggal'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Chemical</label>
                        <input type="text" name="nama_chemical" class="form-control" placeholder="Contoh: Sabun Cuci Piring" value="<?= $header['nama_chemical'] ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" step="0.01" name="jumlah" class="form-control" value="<?= $header['jumlah'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Unit</label>
                        <select name="unit" class="form-select">
                            <option value="Liter" <?= $header['unit'] == 'Liter' ? 'selected' : '' ?>>Liter</option>
                            <option value="Pcs" <?= $header['unit'] == 'Pcs' ? 'selected' : '' ?>>Pcs</option>
                            <option value="Botol" <?= $header['unit'] == 'Botol' ? 'selected' : '' ?>>Botol</option>
                            <option value="Jerigen" <?= $header['unit'] == 'Jerigen' ? 'selected' : '' ?>>Jerigen</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Personil Pengambil</label>
                        <input type="text" name="nama_personil" class="form-control" value="<?= $header['nama_personil'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ahli Gizi (Pemeriksa)</label>
                        <input type="text" name="nama_gizi" class="form-control" value="<?= $header['nama_gizi'] ?>" required>
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary px-5">Perbarui Data Chemical</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
