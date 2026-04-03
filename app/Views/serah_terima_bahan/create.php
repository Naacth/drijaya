<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'serah-terima-bahan/export-pdf-blank']) ?>


<div class="mb-4 animate-in">
    <a href="<?= site_url('serah-terima-bahan') ?>" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    <h4 class="mb-1" style="font-weight: 700;">Buat Form Serah Terima Bahan</h4>
</div>
<form action="<?= site_url('serah-terima-bahan/store') ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4"><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" required value="<?= date('Y-m-d') ?>"></div>
                <div class="col-md-4"><label class="form-label">Nama Pengirim</label><input type="text" name="nama_pengirim" class="form-control" required></div>
                <div class="col-md-4"><label class="form-label">Nama Penerima</label><input type="text" name="nama_penerima" class="form-control" required></div>
            </div>
        </div>
    </div>
    <div class="data-card mt-4 animate-in" style="animation-delay: 0.15s;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6><i class="bi bi-box-seam me-2"></i>Daftar Bahan</h6>
            <button type="button" class="btn btn-sm btn-outline-primary" id="add-row"><i class="bi bi-plus"></i></button>
        </div>
        <div class="table-responsive">
            <table class="table table-premium mb-0" id="item-table" style="min-width: 1000px;">
                <thead><tr><th>Jam</th><th>Nama Bahan</th><th>Tujuan</th><th width="90">Gram/Ps</th><th width="90">Jml Awal</th><th width="90">Tdk Layak</th><th>Tindak Lanjut</th><th width="90">Akhir</th><th width="50"></th></tr></thead>
                <tbody>
                    <tr>
                        <td><input type="time" name="items[0][jam]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="items[0][nama_bahan]" class="form-control form-control-sm" required></td>
                        <td><input type="text" name="items[0][tujuan_penggunaan]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="items[0][gramasi_per_porsi]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="items[0][jumlah_awal]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="items[0][jumlah_tidak_layak]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="items[0][tindak_lanjut]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="items[0][jumlah_akhir]" class="form-control form-control-sm"></td>
                        <td><button type="button" class="btn btn-sm btn-danger remove-row" disabled><i class="bi bi-trash"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-body bg-light border-top p-3 text-end"><button type="submit" class="btn btn-primary px-4">Simpan Form</button></div>
    </div>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowIdx = 1;
    document.getElementById('add-row').addEventListener('click', function() {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td><input type="time" name="items[${rowIdx}][jam]" class="form-control form-control-sm"></td><td><input type="text" name="items[${rowIdx}][nama_bahan]" class="form-control form-control-sm" required></td><td><input type="text" name="items[${rowIdx}][tujuan_penggunaan]" class="form-control form-control-sm"></td><td><input type="text" name="items[${rowIdx}][gramasi_per_porsi]" class="form-control form-control-sm"></td><td><input type="text" name="items[${rowIdx}][jumlah_awal]" class="form-control form-control-sm"></td><td><input type="text" name="items[${rowIdx}][jumlah_tidak_layak]" class="form-control form-control-sm"></td><td><input type="text" name="items[${rowIdx}][tindak_lanjut]" class="form-control form-control-sm"></td><td><input type="text" name="items[${rowIdx}][jumlah_akhir]" class="form-control form-control-sm"></td><td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="bi bi-trash"></i></button></td>`;
        document.querySelector('#item-table tbody').appendChild(tr); rowIdx++; updateBtn();
    });
    document.querySelector('#item-table tbody').addEventListener('click', e => { if(e.target.closest('.remove-row')) { e.target.closest('tr').remove(); updateBtn(); } });
    function updateBtn() { const btns = document.querySelectorAll('.remove-row'); if(btns.length === 1) btns[0].disabled = true; else btns.forEach(b => b.disabled = false); }
});
</script>
<?= $this->endSection() ?>
