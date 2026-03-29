<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="mb-4 animate-in">
    <a href="<?= site_url('checklist-masakan/show/' . $header['id']) ?>" class="text-decoration-none text-muted mb-3 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali ke Detail</a>
    <h4 class="mb-1" style="font-weight: 700;">Edit Checklist QC Masakan</h4>
    <p class="text-muted small">Perbarui data verifikasi masakan di lapangan.</p>
</div>

<form action="<?= site_url('checklist-masakan/update/' . $header['id']) ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header"><h6><i class="bi bi-info-circle me-2"></i>Header Informasi</h6></div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-muted small">Tanggal Pemeriksaan</label>
                    <input type="date" name="tanggal" class="form-control" required value="<?= $header['tanggal'] ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small">Waktu Penyajian</label>
                    <input type="time" name="waktu_penyajian" class="form-control" required value="<?= date('H:i', strtotime($header['waktu_penyajian'])) ?>">
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
                    <?php foreach ($items as $i => $item): ?>
                    <tr>
                        <td><input type="text" name="items[<?= $i ?>][nama_masakan]" class="form-control form-control-sm" required value="<?= esc($item['nama_masakan']) ?>"></td>
                        <td><input type="number" step="0.01" name="items[<?= $i ?>][gramasi_standar]" class="form-control form-control-sm" value="<?= $item['gramasi_standar'] ?>"></td>
                        <td><input type="number" step="0.01" name="items[<?= $i ?>][gramasi_real]" class="form-control form-control-sm" value="<?= $item['gramasi_real'] ?>"></td>
                        <td>
                            <select name="items[<?= $i ?>][rasa]" class="form-select form-select-sm">
                                <option value="Sesuai" <?= $item['rasa'] === 'Sesuai' ? 'selected' : '' ?>>Sesuai</option>
                                <option value="Tidak Sesuai" <?= $item['rasa'] === 'Tidak Sesuai' ? 'selected' : '' ?>>Tidak Sesuai</option>
                            </select>
                        </td>
                        <td>
                            <select name="items[<?= $i ?>][tekstur]" class="form-select form-select-sm">
                                <option value="Sesuai" <?= $item['tekstur'] === 'Sesuai' ? 'selected' : '' ?>>Sesuai</option>
                                <option value="Tidak Sesuai" <?= $item['tekstur'] === 'Tidak Sesuai' ? 'selected' : '' ?>>Tidak Sesuai</option>
                            </select>
                        </td>
                        <td><input type="text" name="items[<?= $i ?>][keterangan]" class="form-control form-control-sm" value="<?= esc($item['keterangan']) ?>"></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-light border text-danger btn-remove" <?= count($items) === 1 ? 'disabled' : '' ?>><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
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
