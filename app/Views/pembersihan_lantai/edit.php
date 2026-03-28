<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="card shadow-sm border-0 col-lg-6 mx-auto">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Edit Form Pembersihan Lantai</h5>
        </div>
        <div class="card-body">
            <form action="<?= site_url('pembersihan-lantai/update/' . $header['id']) ?>" method="post">
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="<?= $header['tanggal'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jam</label>
                    <input type="time" name="jam" class="form-control" value="<?= $header['jam'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Personil</label>
                    <input type="text" name="nama_personil" class="form-control" value="<?= $header['nama_personil'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kondisi Setelah Dibersihkan</label>
                    <select name="kondisi" class="form-select">
                        <option value="Kering" <?= $header['kondisi'] == 'Kering' ? 'selected' : '' ?>>Kering & Bersih</option>
                        <option value="Lembab" <?= $header['kondisi'] == 'Lembab' ? 'selected' : '' ?>>Lembab</option>
                        <option value="Basah" <?= $header['kondisi'] == 'Basah' ? 'selected' : '' ?>>Masih Basah</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">Perbarui Laporan</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
