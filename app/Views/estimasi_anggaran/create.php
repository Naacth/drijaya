<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="mb-4 animate-in">
    <a href="<?= site_url('estimasi-anggaran') ?>" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    <h4 class="mb-1" style="font-weight: 700;">Buat Estimasi Anggaran (Menu Kering)</h4>
    <p class="text-muted small">Input rencana biaya per porsi untuk periode tertentu.</p>
</div>

<form action="<?= site_url('estimasi-anggaran/store') ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header"><h6><i class="bi bi-calendar-event me-2"></i>Header Informasi</h6></div>
        <div class="card-body p-4">
            <div class="row g-4">
                <div class="col-md-3">
                    <label class="form-label text-muted small">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" required value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted small">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" required value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted small">Kategori Porsi</label>
                    <select name="kategori_porsi" class="form-select" required>
                        <option value="Besar">Porsi Besar</option>
                        <option value="Kecil">Porsi Kecil</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted highlight-label small">Total Kalkulasi (Rp)</label>
                    <input type="number" name="total_kalkulasi" id="total_kalkulasi" class="form-control fw-bold text-success bg-light" value="0" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="data-card mt-4 animate-in" style="animation-delay: 0.2s;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6><i class="bi bi-list-columns-reverse me-2"></i>Daftar Item Masakan & Bahan</h6>
            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" id="btn-add-item"><i class="bi bi-plus-lg me-1"></i> Tambah Item</button>
        </div>
        <div class="table-responsive">
            <table class="table table-premium align-middle" id="items-table">
                <thead>
                    <tr>
                        <th>Nama Bahan / Menu</th>
                        <th width="250">Harga Satuan (Rp)</th>
                        <th width="80" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="items[0][nama_item]" class="form-control" placeholder="Contoh: Roti manis isi keju / Susu UHT" required></td>
                        <td><input type="number" name="items[0][harga_satuan]" class="form-control harga-input" placeholder="0" required min="0"></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-light border text-danger btn-remove" disabled><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-body border-top p-4 text-end">
            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm"><i class="bi bi-check2-circle me-1"></i> Simpan Estimasi</button>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#items-table tbody');
    const btnAdd = document.getElementById('btn-add-item');
    const totalInput = document.getElementById('total_kalkulasi');
    let index = 1;

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.harga-input').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        totalInput.value = total;
    }

    btnAdd.addEventListener('click', function() {
        const tr = document.createElement('tr');
        tr.className = 'animate-in';
        tr.innerHTML = `
            <td><input type="text" name="items[${index}][nama_item]" class="form-control" placeholder="..." required></td>
            <td><input type="number" name="items[${index}][harga_satuan]" class="form-control harga-input" placeholder="0" required min="0"></td>
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

<style>
.highlight-label { color: var(--bs-primary) !important; font-weight: 600; }
</style>
<?= $this->endSection() ?>
