<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'buku-kas/export-pdf-blank']) ?>



<div class="mb-4">
    <a href="<?= site_url('buku-kas') ?>" class="text-decoration-none small text-muted">
        <i class="bi bi-arrow-left"></i> Kembali ke Buku Kas
    </a>
    <h4 class="fw-bold mt-2">Input Operasional Harian</h4>
    <p class="text-muted small">Catat pengeluaran dan pemasukan operasional hari ini</p>
</div>

<form action="<?= site_url('buku-kas/store') ?>" method="post">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="<?= $today ?>" required>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0" id="table-items">
                <thead class="bg-light small text-uppercase">
                    <tr>
                        <th class="ps-3" width="50%">Operasional (Keterangan)</th>
                        <th width="20%">Debet (Rp)</th>
                        <th width="20%">Kredit (Rp)</th>
                        <th class="text-center" width="50"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-2">
                            <input type="text" name="keterangan[]" class="form-control form-control-sm border-0 bg-transparent" placeholder="Contoh: Beli Token Listrik" required>
                        </td>
                        <td class="p-2">
                            <input type="number" name="debet[]" class="form-control form-control-sm border-0 bg-transparent text-end" value="0" step="1">
                        </td>
                        <td class="p-2">
                            <input type="number" name="kredit[]" class="form-control form-control-sm border-0 bg-transparent text-end" value="0" step="1">
                        </td>
                        <td class="text-center align-middle">
                            <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeRow(this)"><i class="bi bi-x-circle"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addRow()">
                <i class="bi bi-plus-lg me-1"></i> Tambah Baris
            </button>
        </div>
    </div>

    <div class="mt-4 text-end">
        <button type="submit" class="btn btn-primary px-5 py-2 shadow border-0 fw-bold">
            Simpan Catatan Operasional
        </button>
    </div>
</form>

<script>
    function addRow() {
        const tbody = document.querySelector('#table-items tbody');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="p-2">
                <input type="text" name="keterangan[]" class="form-control form-control-sm border-0 bg-transparent" placeholder="Keterangan lainnya..." required>
            </td>
            <td class="p-2">
                <input type="number" name="debet[]" class="form-control form-control-sm border-0 bg-transparent text-end" value="0" step="1">
            </td>
            <td class="p-2">
                <input type="number" name="kredit[]" class="form-control form-control-sm border-0 bg-transparent text-end" value="0" step="1">
            </td>
            <td class="text-center align-middle">
                <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeRow(this)"><i class="bi bi-x-circle"></i></button>
            </td>
        `;
        tbody.appendChild(tr);
    }

    function removeRow(btn) {
        const rows = document.querySelectorAll('#table-items tbody tr');
        if (rows.length > 1) {
            btn.closest('tr').remove();
        }
    }
</script>

<?= $this->endSection() ?>
