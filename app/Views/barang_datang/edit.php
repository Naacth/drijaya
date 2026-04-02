<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4 animate-in">
    <a href="<?= site_url('barang-datang/show/' . $header['id']) ?>" class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail
    </a>
    <h4 class="mb-1" style="font-weight: 700;">Ubah Formulir Barang Datang</h4>
    <p class="text-muted small">Perbarui data pada form di bawah ini.</p>
</div>

<form action="<?= site_url('barang-datang/update/' . $header['id']) ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header">
            <h6><i class="bi bi-info-circle me-2"></i>Informasi Umum</h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required value="<?= esc($header['tanggal']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Penanggung Jawab</label>
                    <input type="text" name="penanggung_jawab" class="form-control" placeholder="Nama Penanggung Jawab" required value="<?= esc($header['penanggung_jawab']) ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="data-card mt-4 animate-in" style="animation-delay: 0.2s;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6><i class="bi bi-list-check me-2"></i>Daftar Barang</h6>
            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-item">
                <i class="bi bi-plus"></i> Tambah Baris
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-premium" id="items-table">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th width="150">Satuan</th>
                        <th width="150">Banyak Barang</th>
                        <th width="150">Nama QC (Opsional)</th>
                        <th width="150">Nama Pemasok (Opsional)</th>
                        <th width="200">Keterangan</th>
                        <th width="80" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $i => $it): ?>
                    <tr>
                        <td>
                            <input type="text" name="items[<?= $i ?>][nama_barang]" class="form-control form-control-sm" placeholder="Contoh: Beras" required value="<?= esc($it['nama_barang']) ?>">
                        </td>
                        <td>
                            <input type="text" name="items[<?= $i ?>][satuan]" class="form-control form-control-sm" placeholder="Contoh: Kg" required value="<?= esc($it['satuan']) ?>">
                        </td>
                        <td>
                            <input type="number" step="0.01" name="items[<?= $i ?>][banyak_barang]" class="form-control form-control-sm" placeholder="Qty" required value="<?= esc($it['banyak_barang']) ?>">
                        </td>
                        <td>
                            <input type="text" name="items[<?= $i ?>][nama_qc]" class="form-control form-control-sm" placeholder="Nama QC" value="<?= esc($it['nama_qc'] ?? '') ?>">
                        </td>
                        <td>
                            <input type="text" name="items[<?= $i ?>][nama_pemasok]" class="form-control form-control-sm" placeholder="Nama Pemasok" value="<?= esc($it['nama_pemasok'] ?? '') ?>">
                        </td>
                        <td>
                            <select name="items[<?= $i ?>][keterangan]" class="form-select form-select-sm">
                                <option value="ada nota" <?= (($it['keterangan'] ?? '') === 'ada nota') ? 'selected' : '' ?>>Ada Nota</option>
                                <option value="tidak ada nota" <?= (($it['keterangan'] ?? '') === 'tidak ada nota') ? 'selected' : '' ?>>Tidak Ada Nota</option>
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
                    <input type="text" name="items[${index}][nama_barang]" class="form-control form-control-sm" placeholder="Nama Barang" required>
                </td>
                <td>
                    <input type="text" name="items[${index}][satuan]" class="form-control form-control-sm" placeholder="Satuan" required>
                </td>
                <td>
                    <input type="number" step="0.01" name="items[${index}][banyak_barang]" class="form-control form-control-sm" placeholder="Qty" required>
                </td>
                <td>
                    <input type="text" name="items[${index}][nama_qc]" class="form-control form-control-sm" placeholder="Nama QC">
                </td>
                <td>
                    <input type="text" name="items[${index}][nama_pemasok]" class="form-control form-control-sm" placeholder="Nama Pemasok">
                </td>
                <td>
                    <select name="items[${index}][keterangan]" class="form-select form-select-sm">
                        <option value="ada nota">Ada Nota</option>
                        <option value="tidak ada nota">Tidak Ada Nota</option>
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
