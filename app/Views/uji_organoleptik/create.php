<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'uji-organoleptik/export-pdf-blank']) ?>



<div class="mb-4 animate-in">
    <a href="<?= site_url('uji-organoleptik') ?>" class="text-decoration-none text-muted mb-3 d-inline-block">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
    </a>
    <h4 class="mb-1" style="font-weight: 700;">Buat Checklist Uji Organoleptik</h4>
    <p class="text-muted small">Isi data header dan daftar menu makanan yang akan diuji.</p>
</div>

<form action="<?= site_url('uji-organoleptik/store') ?>" method="post">
    <div class="data-card animate-in" style="animation-delay: 0.1s;">
        <div class="card-header">
            <h6><i class="bi bi-info-circle me-2"></i>Informasi Pemeriksaan</h6>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Pemeriksa</label>
                    <input type="text" name="nama_pemeriksa" class="form-control" placeholder="Nama Pemeriksa" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tempat Pemeriksaan</label>
                    <input type="text" name="tempat_pemeriksaan" class="form-control" value="Satuan Pendidikan" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nama Tempat</label>
                    <input type="text" name="nama_tempat" class="form-control" placeholder="Contoh: KB Nurkholifah" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Pemeriksaan</label>
                    <input type="date" name="tanggal_pemeriksaan" class="form-control" required value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Waktu Pemeriksaan</label>
                    <input type="time" name="waktu_pemeriksaan" class="form-control" required value="<?= date('H:i') ?>">
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
                    <input type="text" name="nama_aslap" class="form-control" value="<?= session()->get('nama') ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nama Pemeriksa PLOK / PIC Sekolah</label>
                    <input type="text" name="nama_pemeriksa_plok" class="form-control" placeholder="Opsional">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nama Kepala SPPG</label>
                    <input type="text" name="nama_kepala_sppg" class="form-control" placeholder="Nama Kepala SPPG" required>
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
                    <tr>
                        <td><input type="text" name="items[0][nama_makan]" class="form-control form-control-sm" placeholder="Nama Menu Makanan" required></td>
                        <td>
                            <select name="items[0][waktu_uji]" class="form-select form-select-sm" required>
                                <option value="Sebelum Pengantaran">Sebelum Pengantaran</option>
                                <option value="Saat Tiba di Lokasi">Saat Tiba di Lokasi</option>
                                <option value="Sebelum Dikonsumsi">Sebelum Dikonsumsi</option>
                            </select>
                        </td>
                        <td>
                            <select name="items[0][skor_rasa]" class="form-select form-select-sm" required>
                                <option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>
                            </select>
                        </td>
                        <td>
                            <select name="items[0][skor_warna]" class="form-select form-select-sm" required>
                                <option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>
                            </select>
                        </td>
                        <td>
                            <select name="items[0][skor_aroma]" class="form-select form-select-sm" required>
                                <option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>
                            </select>
                        </td>
                        <td>
                            <select name="items[0][skor_tekstur]" class="form-select form-select-sm" required>
                                <option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>
                            </select>
                        </td>
                        <td><input type="text" name="items[0][keterangan]" class="form-control form-control-sm" placeholder="Opsional"></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-remove" disabled><i class="bi bi-trash"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-body bg-light border-top p-3 text-end">
            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Simpan Checklist</button>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.querySelector('#items-table tbody');
        const btnAdd = document.getElementById('btn-add-item');
        let index = 1;

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
    });
</script>

<?= $this->endSection() ?>
