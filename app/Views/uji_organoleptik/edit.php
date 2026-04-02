<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="mb-4 animate-in">
    <a href="<?= site_url('uji-organoleptik/show/' . $header['id']) ?>" class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail
    </a>
    <h4 class="mb-1" style="font-weight: 700;">Ubah Checklist Uji Organoleptik</h4>
    <p class="text-muted small">Perbarui data header dan daftar menu.</p>
</div>

<form action="<?= site_url('uji-organoleptik/update/' . $header['id']) ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header">
            <h6><i class="bi bi-info-circle me-2"></i>Informasi Pemeriksaan</h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Pemeriksa</label>
                    <input type="text" name="nama_pemeriksa" class="form-control" required value="<?= esc($header['nama_pemeriksa']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tempat Pemeriksaan</label>
                    <input type="text" name="tempat_pemeriksaan" class="form-control" required value="<?= esc($header['tempat_pemeriksaan']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nama Tempat</label>
                    <input type="text" name="nama_tempat" class="form-control" required value="<?= esc($header['nama_tempat']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Pemeriksaan</label>
                    <input type="date" name="tanggal_pemeriksaan" class="form-control" required value="<?= esc($header['tanggal_pemeriksaan']) ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Waktu Pemeriksaan</label>
                    <input type="time" name="waktu_pemeriksaan" class="form-control" required value="<?= esc($header['waktu_pemeriksaan']) ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="data-card mt-4 animate-in" style="animation-delay: 0.15s;">
        <div class="card-header">
            <h6><i class="bi bi-pen me-2"></i>Tanda Tangan</h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nama Asisten Lapangan</label>
                    <input type="text" name="nama_aslap" class="form-control" required value="<?= esc($header['nama_aslap']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nama Pemeriksa PLOK / PIC Sekolah</label>
                    <input type="text" name="nama_pemeriksa_plok" class="form-control" value="<?= esc($header['nama_pemeriksa_plok'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nama Kepala SPPG</label>
                    <input type="text" name="nama_kepala_sppg" class="form-control" required value="<?= esc($header['nama_kepala_sppg']) ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="data-card mt-4 animate-in" style="animation-delay: 0.2s;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6><i class="bi bi-list-check me-2"></i>Daftar Menu Makanan</h6>
            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-item">
                <i class="bi bi-plus"></i> Tambah Baris
            </button>
        </div>
        <div class="card-body p-3 bg-light border-bottom">
            <small class="text-muted">
                <strong>Skor:</strong> Sangat Baik = <span class="badge bg-success">5</span> &nbsp;
                Baik = <span class="badge bg-primary">4</span> &nbsp;
                Cukup = <span class="badge bg-info text-dark">3</span> &nbsp;
                Kurang = <span class="badge bg-warning text-dark">2</span> &nbsp;
                Tidak Baik = <span class="badge bg-danger">1</span>
            </small>
        </div>
        <div class="table-responsive">
            <table class="table table-premium" id="items-table">
                <thead>
                    <tr>
                        <th>Nama Makan</th>
                        <th width="160">Waktu Uji</th>
                        <th width="100" class="text-center">Rasa</th>
                        <th width="100" class="text-center">Warna</th>
                        <th width="100" class="text-center">Aroma</th>
                        <th width="100" class="text-center">Tekstur</th>
                        <th width="180">Keterangan</th>
                        <th width="60" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $wuOpts = ['Sebelum Pengantaran', 'Saat Tiba di Lokasi', 'Sebelum Dikonsumsi'];
                    foreach ($items as $i => $it): ?>
                    <tr>
                        <td><input type="text" name="items[<?= $i ?>][nama_makan]" class="form-control form-control-sm" required value="<?= esc($it['nama_makan']) ?>"></td>
                        <td>
                            <select name="items[<?= $i ?>][waktu_uji]" class="form-select form-select-sm" required>
                                <?php foreach ($wuOpts as $o): ?>
                                <option value="<?= esc($o) ?>" <?= (($it['waktu_uji'] ?? 'Sebelum Pengantaran') === $o) ? 'selected' : '' ?>><?= esc($o) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <?php foreach (['skor_rasa', 'skor_warna', 'skor_aroma', 'skor_tekstur'] as $sf): ?>
                        <td>
                            <select name="items[<?= $i ?>][<?= $sf ?>]" class="form-select form-select-sm" required>
                                <?php foreach ([5, 4, 3, 2, 1] as $sc): ?>
                                <option value="<?= $sc ?>" <?= ((int) ($it[$sf] ?? 0) === $sc) ? 'selected' : '' ?>><?= $sc ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <?php endforeach; ?>
                        <td><input type="text" name="items[<?= $i ?>][keterangan]" class="form-control form-control-sm" value="<?= esc($it['keterangan'] ?? '') ?>"></td>
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

        const skorOptions = '<option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>';
        const waktuUjiOptions = '<option value="Sebelum Pengantaran">Sebelum Pengantaran</option><option value="Saat Tiba di Lokasi">Saat Tiba di Lokasi</option><option value="Sebelum Dikonsumsi">Sebelum Dikonsumsi</option>';

        btnAdd.addEventListener('click', function() {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><input type="text" name="items[${index}][nama_makan]" class="form-control form-control-sm" placeholder="Nama Menu Makanan" required></td>
                <td><select name="items[${index}][waktu_uji]" class="form-select form-select-sm" required>${waktuUjiOptions}</select></td>
                <td><select name="items[${index}][skor_rasa]" class="form-select form-select-sm" required>${skorOptions}</select></td>
                <td><select name="items[${index}][skor_warna]" class="form-select form-select-sm" required>${skorOptions}</select></td>
                <td><select name="items[${index}][skor_aroma]" class="form-select form-select-sm" required>${skorOptions}</select></td>
                <td><select name="items[${index}][skor_tekstur]" class="form-select form-select-sm" required>${skorOptions}</select></td>
                <td><input type="text" name="items[${index}][keterangan]" class="form-control form-control-sm" placeholder="Opsional"></td>
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
