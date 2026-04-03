<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'monitoring-suhu-masak/export-pdf-blank']) ?>


<div class="mb-4 animate-in">
    <a href="<?= site_url('monitoring-suhu-masak') ?>" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    <h4 class="mb-1" style="font-weight: 700;">Buat Form Monitoring Suhu</h4>
</div>
<form action="<?= site_url('monitoring-suhu-masak/store') ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" required value="<?= date('Y-m-d') ?>"></div>
                <div class="col-md-4"><label class="form-label">Nama Pelaksana (Cook)</label><input type="text" name="nama_pelaksana" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">Nama Pemeriksa (Ahli Gizi)</label><input type="text" name="nama_pemeriksa" class="form-control" value="<?= session()->get('nama') ?>" required></div>
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
                    <tr>
                        <td><input type="text" name="items[0][nama_makanan]" class="form-control form-control-sm" required></td>
                        <td><input type="text" name="items[0][suhu_pemasakan]" class="form-control form-control-sm" placeholder="Contoh: 75"></td>
                        <td><input type="time" name="items[0][jam_matang]" class="form-control form-control-sm"></td>
                        <td><input type="time" name="items[0][jadwal_penyajian]" class="form-control form-control-sm"></td>
                        <td><button type="button" class="btn btn-sm btn-danger remove-row" disabled><i class="bi bi-trash"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-body bg-light border-top p-3 text-end"><button type="submit" class="btn btn-primary px-4">Simpan Laporan</button></div>
    </div>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowIdx = 1;
    document.getElementById('add-row').addEventListener('click', function() {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td><input type="text" name="items[${rowIdx}][nama_makanan]" class="form-control form-control-sm" required></td><td><input type="text" name="items[${rowIdx}][suhu_pemasakan]" class="form-control form-control-sm"></td><td><input type="time" name="items[${rowIdx}][jam_matang]" class="form-control form-control-sm"></td><td><input type="time" name="items[${rowIdx}][jadwal_penyajian]" class="form-control form-control-sm"></td><td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="bi bi-trash"></i></button></td>`;
        document.querySelector('#item-table tbody').appendChild(tr); rowIdx++; updateBtn();
    });
    document.querySelector('#item-table tbody').addEventListener('click', e => { if(e.target.closest('.remove-row')) { e.target.closest('tr').remove(); updateBtn(); } });
    function updateBtn() { const btns = document.querySelectorAll('.remove-row'); if(btns.length === 1) btns[0].disabled = true; else btns.forEach(b => b.disabled = false); }
});
</script>
<?= $this->endSection() ?>
