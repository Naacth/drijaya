<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Edit Form Pembersihan Mingguan</h5>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('pembersihan-mingguan/update/' . $header['id']) ?>" method="post">
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Area Unit</label>
                                <input type="text" name="area_pencucian" class="form-control" placeholder="Contoh: Chiller Sayur" value="<?= $header['area_pencucian'] ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Minggu Ke-</label>
                                <select name="minggu_ke" class="form-select">
                                    <option value="1" <?= $header['minggu_ke'] == '1' ? 'selected' : '' ?>>Minggu 1</option>
                                    <option value="2" <?= $header['minggu_ke'] == '2' ? 'selected' : '' ?>>Minggu 2</option>
                                    <option value="3" <?= $header['minggu_ke'] == '3' ? 'selected' : '' ?>>Minggu 3</option>
                                    <option value="4" <?= $header['minggu_ke'] == '4' ? 'selected' : '' ?>>Minggu 4</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bulan</label>
                                <select name="bulan" class="form-select">
                                    <?php foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $m): 
                                        $selected = $header['bulan'] == $m ? 'selected' : '';
                                        echo "<option value='$m' $selected>$m</option>"; 
                                    endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <?php $checklist = $checklist ?? []; ?>

                        <h6 class="text-primary mb-3">Checklist Komponen Mesin & Bodi</h6>
                        <div class="row g-2">
                            <?php 
                            $items = ['Interior', 'Exterior', 'Gasket Pintu', 'Defrosting', 'Kondensor', 'Evaporator', 'Drainase', 'Control Switch'];
                            foreach ($items as $it): 
                                $k = strtolower(str_replace(' ', '_', $it));
                                $val = $checklist[$k] ?? 'OK';
                            ?>
                            <div class="col-md-3">
                                <div class="p-2 border rounded text-center">
                                    <label class="d-block mb-1 small fw-bold"><?= $it ?></label>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <input type="radio" class="btn-check" name="checklist[<?= $k ?>]" id="<?= $k ?>_ok" value="OK" <?= $val == 'OK' ? 'checked' : '' ?>>
                                        <label class="btn btn-outline-success" for="<?= $k ?>_ok">OK</label>
                                        <input type="radio" class="btn-check" name="checklist[<?= $k ?>]" id="<?= $k ?>_not" value="NOT" <?= $val == 'NOT' ? 'checked' : '' ?>>
                                        <label class="btn btn-outline-danger" for="<?= $k ?>_not">FAIL</label>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <label class="form-label fw-bold">Verifikator (Ahli Gizi)</label>
                            <input type="text" name="nama_verifikator" class="form-control" placeholder="Nama Verifikator" value="<?= $header['nama_verifikator'] ?>" required>
                        </div>
                        
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">Perbarui Laporan Mingguan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
