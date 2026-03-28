<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="mb-4 animate-in">
    <a href="<?= site_url('pencucian-bahan') ?>" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    <h4 class="mb-1" style="font-weight: 700;">Edit Form Pencucian Bahan</h4>
</div>
<form action="<?= site_url('pencucian-bahan/update/' . $header['id']) ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" required value="<?= $header['tanggal'] ?>"></div>
                <div class="col-md-6"><label class="form-label">Nama Petugas</label><input type="text" name="nama_petugas" class="form-control" required value="<?= $header['nama_petugas'] ?>"></div>
            </div>
        </div>
    </div>
    <div class="data-card mt-4 animate-in" style="animation-delay: 0.2s;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6><i class="bi bi-list-check me-2"></i>Daftar Item Dicuci</h6>
            <button type="button" class="btn btn-sm btn-outline-primary" id="add-row"><i class="bi bi-plus"></i> Tambah</button>
        </div>
        <div class="table-responsive">
            <table class="table table-premium mb-0" id="item-table">
                <thead><tr><th>Nama Bahan</th><th width="120">Bahan Kimia</th><th>Benda Asing</th><th>Tindak Lanjut</th><th width="120">Jam Prdks</th><th width="50"></th></tr></thead>
                <tbody>
                    <?php foreach ($items as $i => $item): ?>
                    <tr>
                        <td><input type="text" name="items[<?= $i ?>][nama_bahan]" class="form-control form-control-sm" required value="<?= $item['nama_bahan'] ?>"></td>
                        <td><input type="text" name="items[<?= $i ?>][bahan_kimia]" class="form-control form-control-sm" placeholder="Contoh: ya/tidak" value="<?= $item['bahan_kimia'] ?>"></td>
                        <td><input type="text" name="items[<?= $i ?>][benda_asing]" class="form-control form-control-sm" placeholder="Contoh: ya/tidak" value="<?= $item['benda_asing'] ?>"></td>
                        <td><input type="text" name="items[<?= $i ?>][tindak_lanjut]" class="form-control form-control-sm" value="<?= $item['tindak_lanjut'] ?>"></td>
                        <td><input type="time" name="items[<?= $i ?>][jam_produksi]" class="form-control form-control-sm" value="<?= $item['jam_produksi'] ?>"></td>
                        <td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="bi bi-trash"></i></button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="card-body bg-light border-top p-3 text-end"><button type="submit" class="btn btn-primary px-4">Perbarui Laporan</button></div>
    </div>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowIdx = <?= count($items) ?>;
    document.getElementById('add-row').addEventListener('click', function() {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td><input type="text" name="items[${rowIdx}][nama_bahan]" class="form-control form-control-sm" required></td><td><input type="text" name="items[${rowIdx}][bahan_kimia]" class="form-control form-control-sm"></td><td><input type="text" name="items[${rowIdx}][benda_asing]" class="form-control form-control-sm"></td><td><input type="text" name="items[${rowIdx}][tindak_lanjut]" class="form-control form-control-sm"></td><td><input type="time" name="items[${rowIdx}][jam_produksi]" class="form-control form-control-sm"></td><td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="bi bi-trash"></i></button></td>`;
        document.querySelector('#item-table tbody').appendChild(tr); rowIdx++; updateBtn();
    });
    document.querySelector('#item-table tbody').addEventListener('click', e => { if(e.target.closest('.remove-row')) { e.target.closest('tr').remove(); updateBtn(); } });
    function updateBtn() { const btns = document.querySelectorAll('.remove-row'); if(btns.length === 1) btns[0].disabled = true; else btns.forEach(b => b.disabled = false); }
    updateBtn();
});
</script>
<?= $this->endSection() ?>
