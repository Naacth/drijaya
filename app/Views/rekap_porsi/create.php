<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4 animate-in">
    <a href="<?= site_url('rekap-porsi') ?>" class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
    </a>
    <h4 class="mb-1" style="font-weight: 700;">Input Rekap Jumlah Porsi</h4>
    <p class="text-muted small">Input data porsi PM yang terdistribusi dan tidak terdistribusi.</p>
</div>

<form action="<?= site_url('rekap-porsi/store') ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header">
            <h6><i class="bi bi-calendar me-2"></i>Pilih Tanggal</h6>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Laporan</label>
                    <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
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
                    <tr>
                        <td>
                            <select name="items[0][tingkatan]" class="form-select form-select-sm" required>
                                <option value="PAUD">PAUD</option>
                                <option value="TK">TK</option>
                                <option value="SD 1-3">SD 1-3</option>
                                <option value="SD 4-6">SD 4-6</option>
                                <option value="MI 1-3">MI 1-3</option>
                                <option value="MI 4-6">MI 4-6</option>
                                <option value="SMP">SMP</option>
                                <option value="MTS">MTS</option>
                                <option value="SMA">SMA</option>
                            </select>
                        </td>
                        <td><input type="text" name="items[0][sekolah]" class="form-control form-control-sm" required></td>
                        <td><input type="number" name="items[0][jumlah_pm]" class="form-control form-control-sm" value="0" min="0"></td>
                        <td><input type="number" name="items[0][jumlah_terdistribusi]" class="form-control form-control-sm" value="0" min="0"></td>
                        <td><input type="number" name="items[0][jumlah_tidak_terdistribusi]" class="form-control form-control-sm" value="0" min="0"></td>
                        <td><input type="text" name="items[0][keterangan]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="items[0][pengalihan]" class="form-control form-control-sm"></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-remove" disabled><i class="bi bi-trash"></i></button></td>
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
                <select name="items[${index}][tingkatan]" class="form-select form-select-sm" required>
                    <option value="PAUD">PAUD</option>
                    <option value="TK">TK</option>
                    <option value="SD 1-3">SD 1-3</option>
                    <option value="SD 4-6">SD 4-6</option>
                    <option value="MI 1-3">MI 1-3</option>
                    <option value="MI 4-6">MI 4-6</option>
                    <option value="SMP">SMP</option>
                    <option value="MTS">MTS</option>
                    <option value="SMA">SMA</option>
                </select>
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
        btns.forEach(btn => btn.disabled = rows.length === 1);
    }
});
</script>

<?= $this->endSection() ?>
