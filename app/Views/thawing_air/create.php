<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'thawing-air/export-pdf-blank']) ?>


<div class="mb-4 animate-in">
    <a href="<?= site_url('thawing-air') ?>" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    <h4 class="mb-1" style="font-weight: 700;">Buat Checklist Thawing Air</h4>
</div>
<form action="<?= site_url('thawing-air/store') ?>" method="post">
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
            <h6><i class="bi bi-list-check me-2"></i>Daftar Bahan Thawing</h6>
            <button type="button" class="btn btn-sm btn-outline-primary" id="add-row"><i class="bi bi-plus"></i></button>
        </div>
        <div class="table-responsive">
            <table class="table table-premium mb-0" id="item-table">
                <thead><tr><th>Nama Bahan</th><th width="120">Jumlah</th><th width="120">Suhu Air (°C)</th><th>Waktu Thawing (Jam)</th><th width="100">Paraf</th><th width="50"></th></tr></thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="items[0][nama_bahan]" class="form-control form-control-sm" required></td>
                        <td><input type="text" name="items[0][jumlah]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="items[0][suhu_air]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="items[0][waktu_thawing]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="items[0][paraf]" class="form-control form-control-sm"></td>
                        <td><button type="button" class="btn btn-sm btn-danger remove-row" disabled><i class="bi bi-trash"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-body bg-light border-top p-3 text-end"><button type="submit" class="btn btn-primary px-4">Simpan Checklist</button></div>
    </div>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowIdx = 1;
    document.getElementById('add-row').addEventListener('click', function() {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td><input type="text" name="items[${rowIdx}][nama_bahan]" class="form-control form-control-sm" required></td><td><input type="text" name="items[${rowIdx}][jumlah]" class="form-control form-control-sm"></td><td><input type="text" name="items[${rowIdx}][suhu_air]" class="form-control form-control-sm"></td><td><input type="text" name="items[${rowIdx}][waktu_thawing]" class="form-control form-control-sm"></td><td><input type="text" name="items[${rowIdx}][paraf]" class="form-control form-control-sm"></td><td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="bi bi-trash"></i></button></td>`;
        document.querySelector('#item-table tbody').appendChild(tr); rowIdx++; updateBtn();
    });
    document.querySelector('#item-table tbody').addEventListener('click', e => { if(e.target.closest('.remove-row')) { e.target.closest('tr').remove(); updateBtn(); } });
    function updateBtn() { const btns = document.querySelectorAll('.remove-row'); if(btns.length === 1) btns[0].disabled = true; else btns.forEach(b => b.disabled = false); }
});
</script>
<?= $this->endSection() ?>
