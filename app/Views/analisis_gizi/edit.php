<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="mb-4 animate-in">
    <a href="<?= site_url('analisis-gizi/show/' . $header['id']) ?>" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali ke Detail</a>
    <h4 class="mb-1" style="font-weight: 700;">Edit Analisis Kandungan Gizi</h4>
    <p class="text-muted small">Perbarui data nutrisi per item menu.</p>
</div>

<form action="<?= site_url('analisis-gizi/update/' . $header['id']) ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header"><h6><i class="bi bi-info-circle me-2"></i>Identitas Menu</h6></div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-muted small">Nama Paket Menu</label>
                    <input type="text" name="nama_paket" class="form-control" required value="<?= esc($header['nama_paket']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small">Tanggal Sajian</label>
                    <input type="date" name="tanggal_sajian" class="form-control" required value="<?= $header['tanggal_sajian'] ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="data-card mt-4 animate-in" style="animation-delay: 0.2s;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6><i class="bi bi-table me-2"></i>Tabel Komposisi Nutrisi</h6>
            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" id="btn-add-item"><i class="bi bi-plus-lg me-1"></i> Tambah Item</button>
        </div>
        <div class="table-responsive">
            <table class="table table-premium align-middle" id="items-table">
                <thead>
                    <tr class="text-center">
                        <th class="text-start">Nama Item</th>
                        <th width="100">Gram</th>
                        <th width="90">Kalori</th>
                        <th width="90">Protein</th>
                        <th width="90">Lemak</th>
                        <th width="90">KH</th>
                        <th width="90">Serat</th>
                        <th width="50">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $i => $item): ?>
                    <tr>
                        <td><input type="text" name="items[<?= $i ?>][nama_item]" class="form-control" required value="<?= esc($item['nama_item']) ?>"></td>
                        <td><input type="number" step="0.01" name="items[<?= $i ?>][gramasi]" class="form-control" value="<?= $item['gramasi'] ?>"></td>
                        <td><input type="number" step="0.01" name="items[<?= $i ?>][kalori]" class="form-control nut-input" value="<?= $item['kalori'] ?>"></td>
                        <td><input type="number" step="0.01" name="items[<?= $i ?>][protein]" class="form-control nut-input" value="<?= $item['protein'] ?>"></td>
                        <td><input type="number" step="0.01" name="items[<?= $i ?>][lemak]" class="form-control nut-input" value="<?= $item['lemak'] ?>"></td>
                        <td><input type="number" step="0.01" name="items[<?= $i ?>][karbohidrat]" class="form-control nut-input" value="<?= $item['karbohidrat'] ?>"></td>
                        <td><input type="number" step="0.01" name="items[<?= $i ?>][serat]" class="form-control nut-input" value="<?= $item['serat'] ?>"></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-light border text-danger btn-remove" <?= count($items) === 1 ? 'disabled' : '' ?>><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="bg-light fw-bold">
                    <tr class="text-center">
                        <td class="text-end">Total:</td>
                        <td id="total-gramasi">0</td>
                        <td id="total-kalori">0</td>
                        <td id="total-protein">0</td>
                        <td id="total-lemak">0</td>
                        <td id="total-kh">0</td>
                        <td id="total-serat">0</td>
                        <td></td>
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
    let index = <?= count($items) ?>;

    function calculateTotals() {
        let totals = { gramasi: 0, kalori: 0, protein: 0, lemak: 0, kh: 0, serat: 0 };
        document.querySelectorAll('tbody tr').forEach(row => {
            totals.gramasi += parseFloat(row.querySelector('input[name*="[gramasi]"]').value) || 0;
            totals.kalori += parseFloat(row.querySelector('input[name*="[kalori]"]').value) || 0;
            totals.protein += parseFloat(row.querySelector('input[name*="[protein]"]').value) || 0;
            totals.lemak += parseFloat(row.querySelector('input[name*="[lemak]"]').value) || 0;
            totals.kh += parseFloat(row.querySelector('input[name*="[karbohidrat]"]').value) || 0;
            totals.serat += parseFloat(row.querySelector('input[name*="[serat]"]').value) || 0;
        });

        document.getElementById('total-gramasi').innerText = totals.gramasi.toFixed(1);
        document.getElementById('total-kalori').innerText = totals.kalori.toFixed(1);
        document.getElementById('total-protein').innerText = totals.protein.toFixed(1);
        document.getElementById('total-lemak').innerText = totals.lemak.toFixed(1);
        document.getElementById('total-kh').innerText = totals.kh.toFixed(1);
        document.getElementById('total-serat').innerText = totals.serat.toFixed(1);
    }

    btnAdd.addEventListener('click', function() {
        const tr = document.createElement('tr');
        tr.className = 'animate-in';
        tr.innerHTML = `
            <td><input type="text" name="items[${index}][nama_item]" class="form-control" required></td>
            <td><input type="number" step="0.01" name="items[${index}][gramasi]" class="form-control" value="0"></td>
            <td><input type="number" step="0.01" name="items[${index}][kalori]" class="form-control nut-input" value="0"></td>
            <td><input type="number" step="0.01" name="items[${index}][protein]" class="form-control nut-input" value="0"></td>
            <td><input type="number" step="0.01" name="items[${index}][lemak]" class="form-control nut-input" value="0"></td>
            <td><input type="number" step="0.01" name="items[${index}][karbohidrat]" class="form-control nut-input" value="0"></td>
            <td><input type="number" step="0.01" name="items[${index}][serat]" class="form-control nut-input" value="0"></td>
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
            calculateTotals();
        }
    });

    tableBody.addEventListener('input', e => {
        if (e.target.tagName === 'INPUT' && e.target.type === 'number') {
            calculateTotals();
        }
    });

    function updateBtns() {
        const rows = tableBody.querySelectorAll('tr');
        const btns = tableBody.querySelectorAll('.btn-remove');
        if (rows.length === 1) btns[0].disabled = true;
        else btns.forEach(b => b.disabled = false);
    }

    calculateTotals();
});
</script>
<?= $this->endSection() ?>
