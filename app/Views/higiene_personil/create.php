<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'higiene-personil/export-pdf-blank']) ?>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <form action="<?= site_url('higiene-personil/store') ?>" method="post">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0">Buat Laporan Pemeriksaan Higiene Personil</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Bulan</label>
                                <select name="bulan" class="form-select">
                                    <?php foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $m): 
                                        $selected = date('n') == (array_search($m, ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'])+1) ? 'selected' : '';
                                    ?>
                                    <option value="<?= $m ?>" <?= $selected ?>><?= $m ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun</label>
                                <input type="number" name="tahun" class="form-control" value="<?= date('Y') ?>" required>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle" id="dynamicTable">
                                <thead class="bg-light small fw-bold text-uppercase text-center">
                                    <tr>
                                        <th rowspan="2" width="50">No</th>
                                        <th rowspan="2" width="150">Tanggal</th>
                                        <th rowspan="2">Nama Personil</th>
                                        <th colspan="4">Parameter Pemeriksaan</th>
                                        <th rowspan="2">Paraf</th>
                                        <th rowspan="2">Keterangan</th>
                                        <th rowspan="2" width="50"></th>
                                    </tr>
                                    <tr>
                                        <th width="60">Kuku</th>
                                        <th width="60">Rambut</th>
                                        <th width="60">Pakaian</th>
                                        <th width="60">APD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center fw-bold">1</td>
                                        <td><input type="date" name="rekap[0][tanggal]" class="form-control form-control-sm" required></td>
                                        <td><input type="text" name="rekap[0][nama_personil]" class="form-control form-control-sm" required></td>
                                        <td class="text-center"><input type="checkbox" name="rekap[0][kuku]" value="OK" checked></td>
                                        <td class="text-center"><input type="checkbox" name="rekap[0][rambut]" value="OK" checked></td>
                                        <td class="text-center"><input type="checkbox" name="rekap[0][pakaian]" value="OK" checked></td>
                                        <td class="text-center"><input type="checkbox" name="rekap[0][apd]" value="OK" checked></td>
                                        <td><input type="text" name="rekap[0][paraf]" class="form-control form-control-sm" placeholder="Oleh..." required></td>
                                        <td><input type="text" name="rekap[0][keterangan]" class="form-control form-control-sm"></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2 rounded-pill shadow-sm px-3" onclick="addRow()">
                            <i class="fas fa-plus me-1"></i> Tambah Baris
                        </button>

                        <div class="row mt-4 pt-3 border-top">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Check By (Ahli Gizi)</label>
                                <input type="text" name="nama_gizi" class="form-control" placeholder="Nama Ahli Gizi" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ka.SPPG</label>
                                <input type="text" name="nama_kappg" class="form-control" placeholder="Nama Ka.SPPG" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-end py-3">
                        <a href="<?= site_url('higiene-personil') ?>" class="btn btn-link link-secondary me-3">Batal</a>
                        <button type="submit" class="btn btn-primary px-5 shadow-sm rounded-pill" onclick="this.disabled=true; this.form.submit();">Simpan Laporan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let rowCount = 1;
function addRow() {
    const table = document.getElementById('dynamicTable').getElementsByTagName('tbody')[0];
    const newRow = table.insertRow();
    newRow.innerHTML = `
        <td class="text-center fw-bold">${rowCount + 1}</td>
        <td><input type="date" name="rekap[${rowCount}][tanggal]" class="form-control form-control-sm" required></td>
        <td><input type="text" name="rekap[${rowCount}][nama_personil]" class="form-control form-control-sm" required></td>
        <td class="text-center"><input type="checkbox" name="rekap[${rowCount}][kuku]" value="OK" checked></td>
        <td class="text-center"><input type="checkbox" name="rekap[${rowCount}][rambut]" value="OK" checked></td>
        <td class="text-center"><input type="checkbox" name="rekap[${rowCount}][pakaian]" value="OK" checked></td>
        <td class="text-center"><input type="checkbox" name="rekap[${rowCount}][apd]" value="OK" checked></td>
        <td><input type="text" name="rekap[${rowCount}][paraf]" class="form-control form-control-sm" placeholder="Oleh..." required></td>
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
