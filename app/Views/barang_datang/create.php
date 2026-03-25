<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4 animate-in">
    <a href="<?= site_url('barang-datang') ?>" class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
    </a>
    <h4 class="mb-1" style="font-weight: 700;">Buat Formulir Barang Datang</h4>
    <p class="text-muted small">Isi data pada form di bawah ini.</p>
</div>

<form action="<?= site_url('barang-datang/store') ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header">
            <h6><i class="bi bi-info-circle me-2"></i>Informasi Umum</h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Penanggung Jawab</label>
                    <input type="text" name="penanggung_jawab" class="form-control" placeholder="Nama Penanggung Jawab" required value="<?= session()->get('nama') ?>">
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
                    <tr>
                        <td>
                            <input type="text" name="items[0][nama_barang]" class="form-control form-control-sm" placeholder="Contoh: Beras" required>
                        </td>
                        <td>
                            <input type="text" name="items[0][satuan]" class="form-control form-control-sm" placeholder="Contoh: Kg" required>
                        </td>
                        <td>
                            <input type="number" step="0.01" name="items[0][banyak_barang]" class="form-control form-control-sm" placeholder="Oty" required>
                        </td>
                        <td>
                            <input type="text" name="items[0][nama_qc]" class="form-control form-control-sm" placeholder="Nama QC">
                        </td>
                        <td>
                            <input type="text" name="items[0][nama_pemasok]" class="form-control form-control-sm" placeholder="Nama Pemasok">
                        </td>
                        <td>
                            <select name="items[0][keterangan]" class="form-select form-select-sm">
                                <option value="ada nota">Ada Nota</option>
                                <option value="tidak ada nota">Tidak Ada Nota</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger btn-remove" disabled><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-body bg-light border-top p-3 text-end">
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan Laporan</button>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.querySelector('#items-table tbody');
        const btnAdd = document.getElementById('btn-add-item');
        let index = 1;

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
    });
</script>

<?= $this->endSection() ?>
