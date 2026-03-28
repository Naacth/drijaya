<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<style>.grid-cell { width: 40px; text-align: center; padding: 4px !important; border: 1px solid #dee2e6; }</style>
<div class="container-fluid">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Edit Form Pembuangan Sampah Harian</h5>
        </div>
        <div class="card-body">
            <form action="<?= site_url('pembuangan-sampah/update/' . $header['id']) ?>" method="post">
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Bulan</label>
                        <select name="bulan" class="form-select">
                            <?php foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $m): 
                                $selected = $header['bulan'] == $m ? 'selected' : '';
                                echo "<option value='$m' $selected>$m</option>"; 
                            endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="number" name="tahun" class="form-control" value="<?= $header['tahun'] ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Mengetahui Ka.SPPG</label>
                        <input type="text" name="nama_kappg" class="form-control" placeholder="Nama Ka.SPPG" value="<?= $header['nama_kappg'] ?>" required>
                    </div>
                </div>

                <?php $rekap = $rekap ?? []; ?>

                <div class="table-responsive text-nowrap mb-4 shadow-sm border rounded">
                    <table class="table table-bordered mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th rowspan="2" class="text-center bg-white border-bottom-0" width="100">Waktu</th>
                                <th colspan="31" class="text-center small">Realisasi Tanggal (1 - 31)</th>
                            </tr>
                            <tr>
                                <?php for($i=1;$i<=31;$i++) echo "<th class='grid-cell small'>$i</th>"; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach(['07.00', '14.00', '22.00'] as $time): ?>
                            <tr>
                                <td class="fw-bold text-center"><?= $time ?></td>
                                <?php for($i=1;$i<=31;$i++): 
                                    $checked = isset($rekap[$time][$i]) && $rekap[$time][$i] == '1' ? 'checked' : '';
                                ?>
                                <td class="grid-cell p-0">
                                    <div class="form-check p-0 m-0 d-flex justify-content-center">
                                        <input class="form-check-input m-0" type="checkbox" name="rekap[<?= $time ?>][<?= $i ?>]" value="1" style="width:20px; height:20px;" <?= $checked ?>>
                                    </div>
                                </td>
                                <?php endfor; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-5 rounded-pill shadow">Perbarui Rekapitulasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
