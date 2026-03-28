<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="mb-4 animate-in">
    <a href="<?= site_url('thawing-chiller') ?>" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    <h4 class="mb-1" style="font-weight: 700;">Buat Form Thawing Chiller</h4>
</div>
<form action="<?= site_url('thawing-chiller/store') ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" required value="<?= date('Y-m-d') ?>"></div>
                <div class="col-md-6"><label class="form-label">Nama Petugas</label><input type="text" name="nama_petugas" class="form-control" required value="<?= session()->get('nama') ?>"></div>
            </div>
        </div>
    </div>
    <div class="data-card mt-4 animate-in" style="animation-delay: 0.2s;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6><i class="bi bi-list-check me-2"></i>Daftar Thawing</h6>
            <button type="button" class="btn btn-sm btn-outline-primary" id="add-row"><i class="bi bi-plus"></i></button>
        </div>
        <div class="table-responsive">
            <table class="table table-premium mb-0" id="item-table" style="min-width: 1000px;">
                <thead><tr><th>Nama Bahan</th><th width="100">Jml</th><th>Keluar Freezer</th><th>Selesai Thawing</th><th>Waktu Masak</th><th width="80">Paraf</th><th width="50"></th></tr></thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="items[0][nama_bahan]" class="form-control form-control-sm" required></td>
                        <td><input type="text" name="items[0][jumlah]" class="form-control form-control-sm"></td>
                        <td><input type="datetime-local" name="items[0][tgl_jam_keluar_freezer]" class="form-control form-control-sm"></td>
                        <td><input type="datetime-local" name="items[0][tgl_jam_selesai_thawing]" class="form-control form-control-sm"></td>
                        <td><input type="datetime-local" name="items[0][tgl_jam_pemasakan]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="items[0][paraf]" class="form-control form-control-sm"></td>
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
        tr.innerHTML = `<td><input type="text" name="items[${rowIdx}][nama_bahan]" class="form-control form-control-sm" required></td><td><input type="text" name="items[${rowIdx}][jumlah]" class="form-control form-control-sm"></td><td><input type="datetime-local" name="items[${rowIdx}][tgl_jam_keluar_freezer]" class="form-control form-control-sm"></td><td><input type="datetime-local" name="items[${rowIdx}][tgl_jam_selesai_thawing]" class="form-control form-control-sm"></td><td><input type="datetime-local" name="items[${rowIdx}][tgl_jam_pemasakan]" class="form-control form-control-sm"></td><td><input type="text" name="items[${rowIdx}][paraf]" class="form-control form-control-sm"></td><td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="bi bi-trash"></i></button></td>`;
        document.querySelector('#item-table tbody').appendChild(tr); rowIdx++; updateBtn();
    });
    document.querySelector('#item-table tbody').addEventListener('click', e => { if(e.target.closest('.remove-row')) { e.target.closest('tr').remove(); updateBtn(); } });
    function updateBtn() { const btns = document.querySelectorAll('.remove-row'); if(btns.length === 1) btns[0].disabled = true; else btns.forEach(b => b.disabled = false); }
});
</script>
<?= $this->endSection() ?>
