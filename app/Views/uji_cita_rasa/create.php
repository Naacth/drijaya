<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'uji-cita-rasa/export-pdf-blank']) ?>


<div class="mb-4 animate-in">
    <a href="<?= site_url('uji-cita-rasa') ?>" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    <h4 class="mb-1" style="font-weight: 700;">Buat Form Uji Cita Rasa</h4>
    <p class="text-muted small">Isi data checker dan daftar masakan yang akan diuji.</p>
</div>
<form action="<?= site_url('uji-cita-rasa/store') ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header"><h6><i class="bi bi-info-circle me-2"></i>Informasi</h6></div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-3"><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" required value="<?= date('Y-m-d') ?>"></div>
                <div class="col-md-3"><label class="form-label">Nama Checker</label><input type="text" name="nama_checker" class="form-control" required></div>
                <div class="col-md-3"><label class="form-label">Nama Chef</label><input type="text" name="nama_chef" class="form-control"></div>
                <div class="col-md-3"><label class="form-label">Nama Ahli Gizi</label><input type="text" name="nama_ahli_gizi" class="form-control" value="<?= session()->get('nama') ?>"></div>
            </div>
        </div>
    </div>
    <div class="data-card mt-4 animate-in" style="animation-delay: 0.15s;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6><i class="bi bi-list-check me-2"></i>Daftar Masakan</h6>
            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-item"><i class="bi bi-plus"></i> Tambah</button>
        </div>
        <div class="table-responsive">
            <table class="table table-premium" id="items-table">
                <thead><tr><th>Nama Masakan</th><th width="120">Gramasi Standar</th><th width="120">Gramasi Real</th><th>Masalah</th><th>Penyelesaian</th><th width="60" class="text-center">Aksi</th></tr></thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="items[0][nama_masakan]" class="form-control form-control-sm" required></td>
                        <td><input type="text" name="items[0][gramasi_standar]" class="form-control form-control-sm" placeholder="gram"></td>
                        <td><input type="text" name="items[0][gramasi_real]" class="form-control form-control-sm" placeholder="gram"></td>
                        <td><input type="text" name="items[0][masalah]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="items[0][penyelesaian]" class="form-control form-control-sm"></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-remove" disabled><i class="bi bi-trash"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-body bg-light border-top p-3 text-end">
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan</button>
        </div>
    </div>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#items-table tbody');
    const btnAdd = document.getElementById('btn-add-item');
    let index = 1;
    btnAdd.addEventListener('click', function() {
        const tr = document.createElement('tr');
        tr.innerHTML = `<td><input type="text" name="items[${index}][nama_masakan]" class="form-control form-control-sm" required></td><td><input type="text" name="items[${index}][gramasi_standar]" class="form-control form-control-sm"></td><td><input type="text" name="items[${index}][gramasi_real]" class="form-control form-control-sm"></td><td><input type="text" name="items[${index}][masalah]" class="form-control form-control-sm"></td><td><input type="text" name="items[${index}][penyelesaian]" class="form-control form-control-sm"></td><td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-remove"><i class="bi bi-trash"></i></button></td>`;
        tableBody.appendChild(tr); index++; updateBtns();
    });
    tableBody.addEventListener('click', e => { if (e.target.closest('.btn-remove')) { e.target.closest('tr').remove(); updateBtns(); } });
    function updateBtns() { const rows = tableBody.querySelectorAll('tr'); const btns = tableBody.querySelectorAll('.btn-remove'); if (rows.length === 1) btns[0].disabled = true; else btns.forEach(b => b.disabled = false); }
});
</script>
<?= $this->endSection() ?>
