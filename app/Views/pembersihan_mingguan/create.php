<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Form Pembersihan Mingguan</h5>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('pembersihan-mingguan/store') ?>" method="post">
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Area Unit</label>
                                <input type="text" name="area_pencucian" class="form-control" placeholder="Contoh: Chiller Sayur" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Minggu Ke-</label>
                                <select name="minggu_ke" class="form-select">
                                    <option value="1">Minggu 1</option>
                                    <option value="2">Minggu 2</option>
                                    <option value="3">Minggu 3</option>
                                    <option value="4">Minggu 4</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bulan</label>
                                <select name="bulan" class="form-select">
                                    <?php foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $m) echo "<option value='$m'>$m</option>"; ?>
                                </select>
                            </div>
                        </div>

                        <h6 class="text-primary mb-3">Checklist Komponen Mesin & Bodi</h6>
                        <div class="row g-2">
                            <?php 
                            $items = ['Interior', 'Exterior', 'Gasket Pintu', 'Defrosting', 'Kondensor', 'Evaporator', 'Drainase', 'Control Switch'];
                            foreach ($items as $it): 
                                $k = strtolower(str_replace(' ', '_', $it));
                            ?>
                            <div class="col-md-3">
                                <div class="p-2 border rounded text-center">
                                    <label class="d-block mb-1 small fw-bold"><?= $it ?></label>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <input type="radio" class="btn-check" name="checklist[<?= $k ?>]" id="<?= $k ?>_ok" value="OK" checked>
                                        <label class="btn btn-outline-success" for="<?= $k ?>_ok">OK</label>
                                        <input type="radio" class="btn-check" name="checklist[<?= $k ?>]" id="<?= $k ?>_not" value="NOT">
                                        <label class="btn btn-outline-danger" for="<?= $k ?>_not">FAIL</label>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <label class="form-label fw-bold">Verifikator (Ahli Gizi)</label>
                            <input type="text" name="nama_verifikator" class="form-control" placeholder="Nama Verifikator" required>
                        </div>
                        
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">Simpan Laporan Mingguan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
