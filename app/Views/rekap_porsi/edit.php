<?php
$tingOpts = ['PAUD', 'TK', 'SD 1-3', 'SD 4-6', 'MI 1-3', 'MI 4-6', 'SMP', 'MTS', 'SMA'];
?>
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4 animate-in">
    <a href="<?= site_url('rekap-porsi/show/' . $header['id']) ?>" class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail
    </a>
    <h4 class="mb-1" style="font-weight: 700;">Ubah Rekap Jumlah Porsi</h4>
    <p class="text-muted small">Perbarui tanggal dan daftar sekolah.</p>
</div>

<form action="<?= site_url('rekap-porsi/update/' . $header['id']) ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header">
            <h6><i class="bi bi-calendar me-2"></i>Tanggal</h6>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Laporan</label>
                    <input type="date" name="tanggal" class="form-control" required value="<?= esc($header['tanggal']) ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="data-card mt-4 animate-in" style="animation-delay: 0.15s;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6><i class="bi bi-list-ol me-2"></i>Daftar Sekolah & Porsi</h6>
            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-item">
                <i class="bi bi-plus"></i> Tambah Baris
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-premium" id="items-table">
                <thead>
                    <tr>
                        <th width="150">Tingkatan</th>
                        <th width="250">Sekolah</th>
                        <th width="100">Jml PM</th>
                        <th width="110">Jml Terdistribusi</th>
                        <th width="110">Jml Tdk Terdst</th>
                        <th>Keterangan</th>
                        <th>Pengalihan</th>
                        <th width="50" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $i => $it): ?>
                    <tr>
                        <td>
                            <select name="items[<?= $i ?>][tingkatan]" class="form-select form-select-sm" required>
                                <?php foreach ($tingOpts as $to): ?>
                                <option value="<?= $to ?>" <?= (($it['tingkatan'] ?? '') === $to) ? 'selected' : '' ?>><?= $to ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="text" name="items[<?= $i ?>][sekolah]" class="form-control form-control-sm" required value="<?= esc($it['sekolah']) ?>"></td>
                        <td><input type="number" name="items[<?= $i ?>][jumlah_pm]" class="form-control form-control-sm" value="<?= (int) ($it['jumlah_pm'] ?? 0) ?>" min="0"></td>
                        <td><input type="number" name="items[<?= $i ?>][jumlah_terdistribusi]" class="form-control form-control-sm" value="<?= (int) ($it['jumlah_terdistribusi'] ?? 0) ?>" min="0"></td>
                        <td><input type="number" name="items[<?= $i ?>][jumlah_tidak_terdistribusi]" class="form-control form-control-sm" value="<?= (int) ($it['jumlah_tidak_terdistribusi'] ?? 0) ?>" min="0"></td>
                        <td><input type="text" name="items[<?= $i ?>][keterangan]" class="form-control form-control-sm" value="<?= esc($it['keterangan'] ?? '') ?>"></td>
                        <td><input type="text" name="items[<?= $i ?>][pengalihan]" class="form-control form-control-sm" value="<?= esc($it['pengalihan'] ?? '') ?>"></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-remove"><i class="bi bi-trash"></i></button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="card-body bg-light border-top p-3 text-end">
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#items-table tbody');
    const btnAdd = document.getElementById('btn-add-item');
    let index = <?= max(count($items), 1) ?>;

    const tingOpts = `<?php foreach ($tingOpts as $to): ?><option value="<?= $to ?>"><?= $to ?></option><?php endforeach; ?>`;

    btnAdd.addEventListener('click', function() {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <select name="items[${index}][tingkatan]" class="form-select form-select-sm" required>${tingOpts}</select>
            </td>
            <td><input type="text" name="items[${index}][sekolah]" class="form-control form-control-sm" required></td>
            <td><input type="number" name="items[${index}][jumlah_pm]" class="form-control form-control-sm" value="0" min="0"></td>
            <td><input type="number" name="items[${index}][jumlah_terdistribusi]" class="form-control form-control-sm" value="0" min="0"></td>
            <td><input type="number" name="items[${index}][jumlah_tidak_terdistribusi]" class="form-control form-control-sm" value="0" min="0"></td>
            <td><input type="text" name="items[${index}][keterangan]" class="form-control form-control-sm"></td>
            <td><input type="text" name="items[${index}][pengalihan]" class="form-control form-control-sm"></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-remove"><i class="bi bi-trash"></i></button></td>
        `;
        tableBody.appendChild(tr);
        index++;
        updateRemoveButtons();
    });

    tableBody.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove')) {
            e.target.closest('tr').remove();
            updateRemoveButtons();
        }
    });

    function updateRemoveButtons() {
        const rows = tableBody.querySelectorAll('tr');
        const btns = tableBody.querySelectorAll('.btn-remove');
        if (rows.length === 1) {
            btns[0].disabled = true;
        } else {
            btns.forEach(btn => btn.disabled = false);
        }
    }
    updateRemoveButtons();
});
</script>

<?= $this->endSection() ?>
