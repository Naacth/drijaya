<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="mb-4 animate-in">
    <a href="<?= site_url('monitoring-suhu-masak') ?>" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    <h4 class="mb-1" style="font-weight: 700;">Edit Form Monitoring Suhu</h4>
</div>
<form action="<?= site_url('monitoring-suhu-masak/update/' . $header['id']) ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" required value="<?= $header['tanggal'] ?>"></div>
                <div class="col-md-4"><label class="form-label">Nama Pelaksana (Cook)</label><input type="text" name="nama_pelaksana" class="form-control" required value="<?= $header['nama_pelaksana'] ?>"></div>
                <div class="col-md-4"><label class="form-label">Nama Pemeriksa (Ahli Gizi)</label><input type="text" name="nama_pemeriksa" class="form-control" required value="<?= $header['nama_pemeriksa'] ?>"></div>
            </div>
        </div>
    </div>
    <div class="data-card mt-4 animate-in" style="animation-delay: 0.2s;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6><i class="bi bi-list-check me-2"></i>Data Suhu Masakan</h6>
            <button type="button" class="btn btn-sm btn-outline-primary" id="add-row"><i class="bi bi-plus"></i> Tambah</button>
        </div>
        <div class="table-responsive">
            <table class="table table-premium mb-0" id="item-table">
                <thead><tr><th>Nama Makanan</th><th width="150">Suhu (°C)</th><th width="150">Jam Matang</th><th width="150">Jadwal Saji</th><th width="50"></th></tr></thead>
                <tbody>
                    <?php foreach ($items as $i => $item): ?>
                    <tr>
                        <td><input type="text" name="items[<?= $i ?>][nama_makanan]" class="form-control form-control-sm" required value="<?= $item['nama_makanan'] ?>"></td>
                        <td><input type="text" name="items[<?= $i ?>][suhu_pemasakan]" class="form-control form-control-sm" placeholder="Contoh: 75" value="<?= $item['suhu_pemasakan'] ?>"></td>
                        <td><input type="time" name="items[<?= $i ?>][jam_matang]" class="form-control form-control-sm" value="<?= $item['jam_matang'] ?>"></td>
                        <td><input type="time" name="items[<?= $i ?>][jadwal_penyajian]" class="form-control form-control-sm" value="<?= $item['jadwal_penyajian'] ?>"></td>
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
        tr.innerHTML = `<td><input type="text" name="items[${rowIdx}][nama_makanan]" class="form-control form-control-sm" required></td><td><input type="text" name="items[${rowIdx}][suhu_pemasakan]" class="form-control form-control-sm"></td><td><input type="time" name="items[${rowIdx}][jam_matang]" class="form-control form-control-sm"></td><td><input type="time" name="items[${rowIdx}][jadwal_penyajian]" class="form-control form-control-sm"></td><td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="bi bi-trash"></i></button></td>`;
        document.querySelector('#item-table tbody').appendChild(tr); rowIdx++; updateBtn();
    });
    document.querySelector('#item-table tbody').addEventListener('click', e => { if(e.target.closest('.remove-row')) { e.target.closest('tr').remove(); updateBtn(); } });
    function updateBtn() { const btns = document.querySelectorAll('.remove-row'); if(btns.length === 1) btns[0].disabled = true; else btns.forEach(b => b.disabled = false); }
    updateBtn();
});
</script>
<?= $this->endSection() ?>
