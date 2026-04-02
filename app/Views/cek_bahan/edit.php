<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4 animate-in">
    <a href="<?= site_url('cek-bahan-baku/show/' . $header['id']) ?>" class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail
    </a>
    <h4 class="mb-1" style="font-weight: 700;">Ubah Formulir Pemeriksaan Bahan Makanan</h4>
    <p class="text-muted small">Perbarui header SPPG dan daftar bahan.</p>
</div>

<form action="<?= site_url('cek-bahan-baku/update/' . $header['id']) ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header">
            <h6><i class="bi bi-info-circle me-2"></i>Informasi SPPG</h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tanggal Laporan</label>
                    <input type="date" name="tanggal_laporan" class="form-control" required value="<?= esc($header['tanggal_laporan']) ?>">
                </div>
                <div class="col-md-9">
                    <label class="form-label">Nama SPPG (Yayasan)</label>
                    <input type="text" name="nama_sppg" class="form-control" required value="<?= esc($header['nama_sppg']) ?>">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Alamat Lengkap SPPG</label>
                    <input type="text" name="alamat_sppg" class="form-control" required value="<?= esc($header['alamat_sppg']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Kepala SPPG</label>
                    <input type="text" name="nama_kepala_sppg" class="form-control" required value="<?= esc($header['nama_kepala_sppg']) ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="data-card mt-4 animate-in" style="animation-delay: 0.2s;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6><i class="bi bi-list-check me-2"></i>Daftar Pemeriksaan Bahan Makanan</h6>
            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-item">
                <i class="bi bi-plus"></i> Tambah Baris
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-premium" id="items-table">
                <thead>
                    <tr>
                        <th width="120">Tgl Bahan</th>
                        <th>Jenis Bahan Makanan</th>
                        <th width="100">Banyaknya</th>
                        <th width="120">Satuan</th>
                        <th width="120">Jumlah</th>
                        <th width="120">Kondisi Bahan</th>
                        <th width="60" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $i => $it): ?>
                    <tr>
                        <td>
                            <input type="date" name="items[<?= $i ?>][tgl_bahan]" class="form-control form-control-sm" required value="<?= esc($it['tgl_bahan']) ?>">
                        </td>
                        <td>
                            <input type="text" name="items[<?= $i ?>][jenis_bahan]" class="form-control form-control-sm" required value="<?= esc($it['jenis_bahan']) ?>">
                        </td>
                        <td>
                            <input type="number" step="0.01" name="items[<?= $i ?>][banyaknya]" class="form-control form-control-sm" required value="<?= esc($it['banyaknya']) ?>">
                        </td>
                        <td>
                            <select name="items[<?= $i ?>][satuan]" class="form-select form-select-sm" required>
                                <?php foreach (['kg', 'Liter', 'Kantong', 'Ikat', 'Pcs', 'Karung', 'Lainnya'] as $su): ?>
                                <option value="<?= $su ?>" <?= ($it['satuan'] === $su) ? 'selected' : '' ?>><?= $su ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select name="items[<?= $i ?>][jumlah_sesuai]" class="form-select form-select-sm" required>
                                <option value="Sesuai" <?= (($it['jumlah_sesuai'] ?? '') === 'Sesuai') ? 'selected' : '' ?>>Sesuai</option>
                                <option value="Tidak" <?= (($it['jumlah_sesuai'] ?? '') === 'Tidak') ? 'selected' : '' ?>>Tidak</option>
                            </select>
                        </td>
                        <td>
                            <select name="items[<?= $i ?>][kondisi_bahan]" class="form-select form-select-sm" required>
                                <option value="Baik" <?= (($it['kondisi_bahan'] ?? '') === 'Baik') ? 'selected' : '' ?>>Baik</option>
                                <option value="Rusak" <?= (($it['kondisi_bahan'] ?? '') === 'Rusak') ? 'selected' : '' ?>>Rusak</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger btn-remove"><i class="bi bi-trash"></i></button>
                        </td>
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

        btnAdd.addEventListener('click', function() {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    <input type="date" name="items[${index}][tgl_bahan]" class="form-control form-control-sm" required value="<?= date('Y-m-d') ?>">
                </td>
                <td>
                    <input type="text" name="items[${index}][jenis_bahan]" class="form-control form-control-sm" placeholder="Jenis Bahan Makanan" required>
                </td>
                <td>
                    <input type="number" step="0.01" name="items[${index}][banyaknya]" class="form-control form-control-sm" placeholder="Angka" required>
                </td>
                <td>
                    <select name="items[${index}][satuan]" class="form-select form-select-sm" required>
                        <option value="kg">kg</option>
                        <option value="Liter">Liter</option>
                        <option value="Kantong">Kantong</option>
                        <option value="Ikat">Ikat</option>
                        <option value="Pcs">Pcs</option>
                        <option value="Karung">Karung</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </td>
                <td>
                    <select name="items[${index}][jumlah_sesuai]" class="form-select form-select-sm" required>
                        <option value="Sesuai">Sesuai</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </td>
                <td>
                    <select name="items[${index}][kondisi_bahan]" class="form-select form-select-sm" required>
                        <option value="Baik">Baik</option>
                        <option value="Rusak">Rusak</option>
                    </select>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger btn-remove"><i class="bi bi-trash"></i></button>
                </td>
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
