<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="mb-4 animate-in">
    <a href="<?= site_url('estimasi-anggaran/show/' . $header['id']) ?>" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali ke Detail</a>
    <h4 class="mb-1" style="font-weight: 700;">Edit Estimasi Anggaran</h4>
    <p class="text-muted small">Perbarui data periode, kategori, atau daftar item masakan.</p>
</div>

<form action="<?= site_url('estimasi-anggaran/update/' . $header['id']) ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header"><h6><i class="bi bi-info-circle me-2"></i>Informasi Umum</h6></div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label text-muted small">Mulai Periode</label>
                    <input type="date" name="tanggal_mulai" class="form-control" required value="<?= $header['tanggal_mulai'] ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted small">Selesai Periode</label>
                    <input type="date" name="tanggal_selesai" class="form-control" required value="<?= $header['tanggal_selesai'] ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small">Kategori Porsi</label>
                    <select name="kategori_porsi" class="form-select" required>
                        <option value="Besar" <?= $header['kategori_porsi'] === 'Besar' ? 'selected' : '' ?>>Porsi Besar</option>
                        <option value="Kecil" <?= $header['kategori_porsi'] === 'Kecil' ? 'selected' : '' ?>>Porsi Kecil</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="data-card mt-4 animate-in" style="animation-delay: 0.2s;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6><i class="bi bi-list-stars me-2"></i>Daftar Item & Estimasi Biaya</h6>
            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" id="btn-add-item"><i class="bi bi-plus-lg me-1"></i> Tambah Baris</button>
        </div>
        <div class="table-responsive">
            <table class="table table-premium align-middle" id="items-table">
                <thead>
                    <tr>
                        <th class="text-start">Nama Item Masakan / Bahan</th>
                        <th width="250" class="text-end">Harga Satuan (Rp)</th>
                        <th width="60" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $i => $item): ?>
                    <tr>
                        <td><input type="text" name="items[<?= $i ?>][nama_item]" class="form-control" required value="<?= esc($item['nama_item']) ?>"></td>
                        <td><input type="number" name="items[<?= $i ?>][harga_satuan]" class="form-control text-end harga-input" required value="<?= $item['harga_satuan'] ?>"></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-light border text-danger btn-remove" <?= count($items) === 1 ? 'disabled' : '' ?>><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="bg-light fw-bold">
                    <tr>
                        <td class="text-end">TOTAL ESTIMASI KALKULASI:</td>
                        <td class="text-end text-primary" id="display-total">Rp <?= number_format($header['total_kalkulasi'], 0, ',', '.') ?></td>
                        <td><input type="hidden" name="total_kalkulasi" id="total_kalkulasi" value="<?= $header['total_kalkulasi'] ?>"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-body border-top p-4 text-end">
            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#items-table tbody');
    const btnAdd = document.getElementById('btn-add-item');
    const displayTotal = document.getElementById('display-total');
    const hiddenTotal = document.getElementById('total_kalkulasi');
    let index = <?= count($items) ?>;

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.harga-input').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        displayTotal.innerText = 'Rp ' + total.toLocaleString('id-ID');
        hiddenTotal.value = total;
    }

    btnAdd.addEventListener('click', function() {
        const tr = document.createElement('tr');
        tr.className = 'animate-in';
        tr.innerHTML = `
            <td><input type="text" name="items[${index}][nama_item]" class="form-control" required></td>
            <td><input type="number" name="items[${index}][harga_satuan]" class="form-control text-end harga-input" required value="0"></td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-light border text-danger btn-remove"><i class="bi bi-trash"></i></button>
            </td>
        `;
        tableBody.appendChild(tr);
        index++;
        updateBtns();
    });

    tableBody.addEventListener('click', e => {
        if (e.target.closest('.btn-remove')) {
            e.target.closest('tr').remove();
            updateBtns();
            calculateTotal();
        }
    });

    tableBody.addEventListener('input', e => {
        if (e.target.classList.contains('harga-input')) {
            calculateTotal();
        }
    });

    function updateBtns() {
        const rows = tableBody.querySelectorAll('tr');
        const btns = tableBody.querySelectorAll('.btn-remove');
        if (rows.length === 1) btns[0].disabled = true;
        else btns.forEach(b => b.disabled = false);
    }
});
</script>
<?= $this->endSection() ?>
