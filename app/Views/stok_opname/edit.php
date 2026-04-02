<?php
$satuanList = ['Kg', 'Liter', 'Pcs', 'Botol', 'Pack'];
$maxDay = 0;
foreach (array_keys($grouped_items ?? []) as $k) {
    $maxDay = max($maxDay, (int) $k);
}
?>
<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4 animate-in">
    <a href="<?= site_url('stok-opname/show/' . $header['id']) ?>" class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
    <h4 class="mb-1" style="font-weight: 700;">Ubah Stok Opname</h4>
    <p class="text-muted small">Periode dan entri multi-hari dapat diubah kapan saja.</p>
</div>

<form action="<?= site_url('stok-opname/update/' . $header['id']) ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header"><h6><i class="bi bi-info-circle me-2"></i>Informasi SPPG</h6></div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nama SPPG</label>
                    <input type="text" name="nama_sppg" class="form-control" required value="<?= esc($header['nama_sppg']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kelurahan/Desa</label>
                    <input type="text" name="kelurahan_desa" class="form-control" required value="<?= esc($header['kelurahan_desa']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-control" required value="<?= esc($header['kecamatan']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kabupaten/Kota</label>
                    <input type="text" name="kabupaten_kota" class="form-control" required value="<?= esc($header['kabupaten_kota']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Provinsi</label>
                    <input type="text" name="provinsi" class="form-control" required value="<?= esc($header['provinsi']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Periode Awal</label>
                    <input type="date" name="periode_awal" class="form-control" required value="<?= esc($header['periode_awal']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Periode Akhir</label>
                    <input type="date" name="periode_akhir" class="form-control" required value="<?= esc($header['periode_akhir']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Kepala SPPG</label>
                    <input type="text" name="nama_kepala_sppg" class="form-control" value="<?= esc($header['nama_kepala_sppg'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Akuntan SPPG</label>
                    <input type="text" name="nama_akuntan" class="form-control" value="<?= esc($header['nama_akuntan'] ?? '') ?>">
                </div>
            </div>
        </div>
    </div>

    <div id="days-container">
        <?php foreach ($grouped_items as $dayNum => $rows): ?>
            <?php $d = (int) $dayNum; ?>
        <div class="data-card mt-4 animate-in" id="day-card-<?= $d ?>">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6><i class="bi bi-calendar-day me-2"></i>HARI KE-<?= $d ?></h6>
                <div>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-add-row" data-day="<?= $d ?>"><i class="bi bi-plus"></i> Tambah Baris</button>
                    <?php if ($d > 1): ?>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-day ms-1" data-day="<?= $d ?>"><i class="bi bi-trash"></i></button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-premium mb-0" id="table-day-<?= $d ?>">
                    <thead>
                        <tr>
                            <th>Nama Bahan</th>
                            <th width="80">Satuan</th>
                            <th width="90">Stok Fisik</th>
                            <th width="90">Stok Kartu</th>
                            <th width="80">Selisih</th>
                            <th width="130">Keterangan</th>
                            <th width="50" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $idx => $row): ?>
                        <tr>
                            <td><input type="text" name="days[<?= $d ?>][<?= $idx ?>][nama_bahan]" class="form-control form-control-sm" required value="<?= esc($row['nama_bahan']) ?>"></td>
                            <td>
                                <select name="days[<?= $d ?>][<?= $idx ?>][satuan]" class="form-select form-select-sm">
                                    <?php foreach ($satuanList as $su): ?>
                                    <option value="<?= $su ?>" <?= (($row['satuan'] ?? '') === $su) ? 'selected' : '' ?>><?= $su ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td><input type="text" name="days[<?= $d ?>][<?= $idx ?>][stok_fisik]" class="form-control form-control-sm" value="<?= esc($row['stok_fisik'] ?? '') ?>"></td>
                            <td><input type="text" name="days[<?= $d ?>][<?= $idx ?>][stok_di_kartu]" class="form-control form-control-sm" value="<?= esc($row['stok_di_kartu'] ?? '') ?>"></td>
                            <td><input type="text" name="days[<?= $d ?>][<?= $idx ?>][selisih]" class="form-control form-control-sm" value="<?= esc($row['selisih'] ?? '') ?>"></td>
                            <td><input type="text" name="days[<?= $d ?>][<?= $idx ?>][keterangan]" class="form-control form-control-sm" value="<?= esc($row['keterangan'] ?? '') ?>"></td>
                            <td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-remove-row"><i class="bi bi-trash"></i></button></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-3 d-flex justify-content-between animate-in" style="animation-delay: 0.15s;">
        <button type="button" class="btn btn-outline-primary" id="btn-add-day">
            <i class="bi bi-plus-circle me-1"></i> Tambah Hari
        </button>
        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('days-container');
    const btnAddDay = document.getElementById('btn-add-day');
    let dayCount = <?= (int) $maxDay ?>;

    function addDay() {
        dayCount++;
        const card = document.createElement('div');
        card.className = 'data-card mt-4 animate-in';
        card.id = 'day-card-' + dayCount;
        card.innerHTML = `
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6><i class="bi bi-calendar-day me-2"></i>HARI KE-${dayCount}</h6>
                <div>
                    <button type="button" class="btn btn-sm btn-outline-primary btn-add-row" data-day="${dayCount}"><i class="bi bi-plus"></i> Tambah Baris</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-day ms-1" data-day="${dayCount}"><i class="bi bi-trash"></i></button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-premium mb-0" id="table-day-${dayCount}">
                    <thead>
                        <tr>
                            <th>Nama Bahan</th>
                            <th width="80">Satuan</th>
                            <th width="90">Stok Fisik</th>
                            <th width="90">Stok Kartu</th>
                            <th width="80">Selisih</th>
                            <th width="130">Keterangan</th>
                            <th width="50" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        `;
        container.appendChild(card);
        addRow(dayCount);
    }

    function addRow(dayNum) {
        const tbody = document.querySelector('#table-day-' + dayNum + ' tbody');
        const idx = tbody.querySelectorAll('tr').length;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="text" name="days[${dayNum}][${idx}][nama_bahan]" class="form-control form-control-sm" required></td>
            <td><select name="days[${dayNum}][${idx}][satuan]" class="form-select form-select-sm">
                <option value="Kg">Kg</option><option value="Liter">Liter</option><option value="Pcs">Pcs</option><option value="Botol">Botol</option><option value="Pack">Pack</option>
            </select></td>
            <td><input type="text" name="days[${dayNum}][${idx}][stok_fisik]" class="form-control form-control-sm"></td>
            <td><input type="text" name="days[${dayNum}][${idx}][stok_di_kartu]" class="form-control form-control-sm"></td>
            <td><input type="text" name="days[${dayNum}][${idx}][selisih]" class="form-control form-control-sm"></td>
            <td><input type="text" name="days[${dayNum}][${idx}][keterangan]" class="form-control form-control-sm"></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-remove-row"><i class="bi bi-trash"></i></button></td>
        `;
        tbody.appendChild(tr);
    }

    btnAddDay.addEventListener('click', addDay);

    container.addEventListener('click', function(e) {
        if (e.target.closest('.btn-add-row')) {
            addRow(e.target.closest('.btn-add-row').dataset.day);
        }
        if (e.target.closest('.btn-remove-row')) {
            e.target.closest('tr').remove();
        }
        if (e.target.closest('.btn-remove-day')) {
            document.getElementById('day-card-' + e.target.closest('.btn-remove-day').dataset.day).remove();
        }
    });
});
</script>

<?= $this->endSection() ?>
