<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'checklist-masakan/export-pdf-blank']) ?>


<div class="mb-4 animate-in">
    <a href="<?= site_url('checklist-masakan') ?>" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    <h4 class="mb-1" style="font-weight: 700;">Buat Checklist Pemeriksaan Hasil Masakan</h4>
    <p class="text-muted small">Validasi realisasi gramasi dan kualitas organoleptik di lapangan.</p>
</div>

<form action="<?= site_url('checklist-masakan/store') ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header"><h6><i class="bi bi-info-circle me-2"></i>Header Informasi</h6></div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-muted small">Tanggal Pemeriksaan</label>
                    <input type="date" name="tanggal" class="form-control" required value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small">Waktu Penyajian</label>
                    <input type="time" name="waktu_penyajian" class="form-control" required value="<?= date('H:i') ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="data-card mt-4 animate-in" style="animation-delay: 0.2s;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6><i class="bi bi-patch-check me-2"></i>Tabel Verifikasi Menu</h6>
            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" id="btn-add-item"><i class="bi bi-plus-lg me-1"></i> Tambah Menu</button>
        </div>
        <div class="table-responsive">
            <table class="table table-premium align-middle" id="items-table">
                <thead>
                    <tr class="text-center">
                        <th class="text-start">Nama Masakan</th>
                        <th width="120">Std Gram</th>
                        <th width="120">Real Gram</th>
                        <th width="130">Rasa</th>
                        <th width="130">Tekstur</th>
                        <th>Keterangan</th>
                        <th width="50" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="items[0][nama_masakan]" class="form-control form-control-sm" placeholder="..." required></td>
                        <td><input type="number" step="0.01" name="items[0][gramasi_standar]" class="form-control form-control-sm" value="0"></td>
                        <td><input type="number" step="0.01" name="items[0][gramasi_real]" class="form-control form-control-sm" value="0"></td>
                        <td>
                            <select name="items[0][rasa]" class="form-select form-select-sm">
                                <option value="Sesuai">Sesuai</option>
                                <option value="Tidak Sesuai">Tidak Sesuai</option>
                            </select>
                        </td>
                        <td>
                            <select name="items[0][tekstur]" class="form-select form-select-sm">
                                <option value="Sesuai">Sesuai</option>
                                <option value="Tidak Sesuai">Tidak Sesuai</option>
                            </select>
                        </td>
                        <td><input type="text" name="items[0][keterangan]" class="form-control form-control-sm" placeholder="Catatan..."></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-light border text-danger btn-remove" disabled><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-body border-top p-4 text-end">
            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm"><i class="bi bi-save me-1"></i> Simpan Checklist</button>
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
        tr.className = 'animate-in';
        tr.innerHTML = `
            <td><input type="text" name="items[${index}][nama_masakan]" class="form-control form-control-sm" required></td>
            <td><input type="number" step="0.01" name="items[${index}][gramasi_standar]" class="form-control form-control-sm" value="0"></td>
            <td><input type="number" step="0.01" name="items[${index}][gramasi_real]" class="form-control form-control-sm" value="0"></td>
            <td>
                <select name="items[${index}][rasa]" class="form-select form-select-sm">
                    <option value="Sesuai">Sesuai</option>
                    <option value="Tidak Sesuai">Tidak Sesuai</option>
                </select>
            </td>
            <td>
                <select name="items[${index}][tekstur]" class="form-select form-select-sm">
                    <option value="Sesuai">Sesuai</option>
                    <option value="Tidak Sesuai">Tidak Sesuai</option>
                </select>
            </td>
            <td><input type="text" name="items[${index}][keterangan]" class="form-control form-control-sm"></td>
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
<?= $this->endSection() ?>
