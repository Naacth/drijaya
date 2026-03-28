<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form action="<?= site_url('pembersihan-harian/store') ?>" method="post">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0">Form Pembersihan Freezer & Chiller Harian</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipe Unit</label>
                                <select name="unit_type" id="unit_type" class="form-select" onchange="toggleItems()">
                                    <option value="chiller">Chiller</option>
                                    <option value="freezer">Freezer</option>
                                </select>
                            </div>
                        </div>

                        <div id="chiller-items">
                            <h6 class="text-primary mb-3">Checklist Chiller</h6>
                            <div class="row g-2">
                                <?php foreach(['Rak', 'Kontainer', 'Lampu', 'Langit-langit', 'Lantai', 'Dinding', 'Bodi Luar', 'Gagang Pintu'] as $item): ?>
                                <div class="col-md-4">
                                    <div class="form-check p-2 border rounded">
                                        <input class="form-check-input ms-0 me-2" type="checkbox" name="area[<?= strtolower(str_replace(' ', '_', $item)) ?>]" value="1">
                                        <label class="form-check-label"><?= $item ?></label>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div id="freezer-items" style="display:none;">
                            <h6 class="text-info mb-3">Checklist Freezer</h6>
                            <div class="row g-2">
                                <?php foreach(['Lantai', 'Dinding', 'Bodi Luar', 'Gagang Pintu', 'Bunga Es'] as $item): ?>
                                <div class="col-md-4">
                                    <div class="form-check p-2 border rounded">
                                        <input class="form-check-input ms-0 me-2" type="checkbox" name="area[<?= strtolower(str_replace(' ', '_', $item)) ?>]" value="1">
                                        <label class="form-check-label"><?= $item ?></label>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Petugas</label>
                                <input type="text" name="nama_petugas" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Verifikator</label>
                                <input type="text" name="nama_verifikator" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-end py-3">
                        <a href="<?= site_url('pembersihan-harian') ?>" class="btn btn-link link-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-5 shadow-sm">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleItems() {
    const type = document.getElementById('unit_type').value;
    document.getElementById('chiller-items').style.display = type === 'chiller' ? 'block' : 'none';
    document.getElementById('freezer-items').style.display = type === 'freezer' ? 'block' : 'none';
}
</script>
<?= $this->endSection() ?>
