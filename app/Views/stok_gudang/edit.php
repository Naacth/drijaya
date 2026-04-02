<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4 animate-in">
    <a href="<?= site_url('stok-gudang/show/' . $header['id']) ?>" class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail
    </a>
    <h4 class="mb-1" style="font-weight: 700;">Ubah Stok Barang Gudang</h4>
    <p class="text-muted small">Perbarui data stok di gudang.</p>
</div>

<form action="<?= site_url('stok-gudang/update/' . $header['id']) ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header">
            <h6><i class="bi bi-info-circle me-2"></i>Header Informasi</h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama SPPG</label>
                    <input type="text" name="nama_sppg" class="form-control" required value="<?= esc($header['nama_sppg']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required value="<?= esc($header['tanggal']) ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="data-card mt-4 animate-in" style="animation-delay: 0.15s;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6><i class="bi bi-list-ul me-2"></i>Daftar Produk</h6>
            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-item">
                <i class="bi bi-plus"></i> Tambah Baris
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-premium" id="items-table">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th width="130">Nama Penerima</th>
                        <th width="100">Stok Awal</th>
                        <th width="100">Barang Masuk</th>
                        <th width="100">Barang Keluar</th>
                        <th width="100">Stok Akhir</th>
                        <th width="50" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $i => $it): ?>
                    <tr>
                        <td><input type="text" name="items[<?= $i ?>][nama_produk]" class="form-control form-control-sm" required value="<?= esc($it['nama_produk']) ?>"></td>
                        <td><input type="text" name="items[<?= $i ?>][nama_penerima]" class="form-control form-control-sm" value="<?= esc($it['nama_penerima'] ?? '') ?>"></td>
                        <td><input type="text" name="items[<?= $i ?>][stok_awal]" class="form-control form-control-sm" value="<?= esc($it['stok_awal'] ?? '') ?>"></td>
                        <td><input type="text" name="items[<?= $i ?>][barang_masuk]" class="form-control form-control-sm" value="<?= esc($it['barang_masuk'] ?? '') ?>"></td>
                        <td><input type="text" name="items[<?= $i ?>][barang_keluar]" class="form-control form-control-sm" value="<?= esc($it['barang_keluar'] ?? '') ?>"></td>
                        <td><input type="text" name="items[<?= $i ?>][stok_akhir]" class="form-control form-control-sm" value="<?= esc($it['stok_akhir'] ?? '') ?>"></td>
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

    btnAdd.addEventListener('click', function() {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input type="text" name="items[${index}][nama_produk]" class="form-control form-control-sm" required></td>
            <td><input type="text" name="items[${index}][nama_penerima]" class="form-control form-control-sm"></td>
            <td><input type="text" name="items[${index}][stok_awal]" class="form-control form-control-sm"></td>
            <td><input type="text" name="items[${index}][barang_masuk]" class="form-control form-control-sm"></td>
            <td><input type="text" name="items[${index}][barang_keluar]" class="form-control form-control-sm"></td>
            <td><input type="text" name="items[${index}][stok_akhir]" class="form-control form-control-sm"></td>
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
