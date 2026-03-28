<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <form action="<?= site_url('pembersihan-transportasi/update/' . $header['id']) ?>" method="post">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0">Edit Laporan Pembersihan Alat Transportasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nama Alat Transportasi / Kendaraan</label>
                                <input type="text" name="nama_kendaraan" class="form-control" value="<?= $header['nama_kendaraan'] ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bulan</label>
                                <select name="bulan" class="form-select">
                                    <?php foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $m): ?>
                                    <option value="<?= $m ?>" <?= $header['bulan'] == $m ? 'selected' : '' ?>><?= $m ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tahun</label>
                                <input type="number" name="tahun" class="form-control" value="<?= $header['tahun'] ?>" required>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle" id="dynamicTable">
                                <thead class="bg-light small fw-bold text-uppercase">
                                    <tr>
                                        <th width="50">No</th>
                                        <th width="150">Tanggal</th>
                                        <th>Nama Personil</th>
                                        <th width="120">Jam</th>
                                        <th>Paraf</th>
                                        <th>Keterangan</th>
                                        <th width="50"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rekap as $i => $row): ?>
                                    <tr>
                                        <td class="text-center fw-bold"><?= $i + 1 ?></td>
                                        <td><input type="date" name="rekap[<?= $i ?>][tanggal]" class="form-control form-control-sm" value="<?= $row['tanggal'] ?>" required></td>
                                        <td><input type="text" name="rekap[<?= $i ?>][nama_personil]" class="form-control form-control-sm" value="<?= $row['nama_personil'] ?>" required></td>
                                        <td><input type="time" name="rekap[<?= $i ?>][jam]" class="form-control form-control-sm" value="<?= $row['jam'] ?>" required></td>
                                        <td><input type="text" name="rekap[<?= $i ?>][paraf]" class="form-control form-control-sm" value="<?= $row['paraf'] ?>" required></td>
                                        <td><input type="text" name="rekap[<?= $i ?>][keterangan]" class="form-control form-control-sm" value="<?= $row['keterangan'] ?>"></td>
                                        <td class="text-center">
                                            <?php if ($i > 0): ?>
                                            <button type="button" class="btn btn-link text-danger p-0" onclick="removeRow(this)"><i class="fas fa-times"></i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2 rounded-pill shadow-sm px-3" onclick="addRow()">
                            <i class="fas fa-plus me-1"></i> Tambah Baris
                        </button>

                        <div class="row mt-4 pt-3 border-top">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Check By (Ahli Gizi)</label>
                                <input type="text" name="nama_gizi" class="form-control" value="<?= $header['nama_gizi'] ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ka.SPPG</label>
                                <input type="text" name="nama_kappg" class="form-control" value="<?= $header['nama_kappg'] ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-end py-3">
                        <a href="<?= site_url('pembersihan-transportasi') ?>" class="btn btn-link link-secondary me-3">Batal</a>
                        <button type="submit" class="btn btn-primary px-5 shadow-sm rounded-pill" onclick="this.disabled=true; this.form.submit();">Perbarui Laporan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let rowCount = <?= count($rekap) ?>;
function addRow() {
    const table = document.getElementById('dynamicTable').getElementsByTagName('tbody')[0];
    const newRow = table.insertRow();
    newRow.innerHTML = `
        <td class="text-center fw-bold">${rowCount + 1}</td>
        <td><input type="date" name="rekap[${rowCount}][tanggal]" class="form-control form-control-sm" required></td>
        <td><input type="text" name="rekap[${rowCount}][nama_personil]" class="form-control form-control-sm" required></td>
        <td><input type="time" name="rekap[${rowCount}][jam]" class="form-control form-control-sm" required></td>
        <td><input type="text" name="rekap[${rowCount}][paraf]" class="form-control form-control-sm" required></td>
        <td><input type="text" name="rekap[${rowCount}][keterangan]" class="form-control form-control-sm"></td>
        <td class="text-center"><button type="button" class="btn btn-link text-danger p-0" onclick="removeRow(this)"><i class="fas fa-times"></i></button></td>
    `;
    rowCount++;
}
function removeRow(btn) {
    btn.closest('tr').remove();
    // Update numbering
    const rows = document.getElementById('dynamicTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    for(let i=0; i<rows.length; i++) {
        rows[i].cells[0].innerText = i + 1;
    }
}
</script>
<?= $this->endSection() ?>
