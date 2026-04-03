<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?= $this->include('layout/print_blank_button', ['printBlankUrl' => 'penerima-manfaat/export-pdf-blank']) ?>


<div class="container-fluid animate-in">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Input Data Penerima Manfaat</h4>
            <p class="text-muted small">Kelola data sekolah dan jumlah porsi makanan harian.</p>
        </div>
        <a href="<?= base_url('penerima-manfaat') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="data-card">
        <div class="card-body p-4">
            <form action="<?= base_url('penerima-manfaat/store') ?>" method="POST" id="beneficiaryForm">
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Tanggal Distribusi</label>
                            <input type="date" name="tanggal" class="form-control" required value="<?= date('Y-m-d') ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Nama SPPG</label>
                            <input type="text" name="sppg" class="form-control" required placeholder="Contoh: SPPG Balaraja" value="Dapur SPPG Bunar">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" required placeholder="Contoh: Balaraja">
                        </div>
                    </div>
                </div>

                <hr class="my-4 opacity-10">

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0">Daftar Sekolah & Porsi</h6>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="addSchool">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Sekolah
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-premium align-middle" id="schoolTable">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th width="200">Nama Sekolah</th>
                                <th width="100">Jml Siswa</th>
                                <th width="100">P. Kecil</th>
                                <th width="100">P. Besar</th>
                                <th width="80">Guru</th>
                                <th width="80">Staf</th>
                                <th width="120">Total Porsi</th>
                                <th width="50"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="school-row">
                                <td class="row-num text-center">1</td>
                                <td><input type="text" name="items[0][nama_sekolah]" class="form-control form-control-sm" required placeholder="Nama Sekolah"></td>
                                <td><input type="number" name="items[0][jumlah_siswa]" class="form-control form-control-sm input-calc" required value="0"></td>
                                <td><input type="number" name="items[0][porsi_kecil]" class="form-control form-control-sm input-calc" required value="0"></td>
                                <td><input type="number" name="items[0][porsi_besar]" class="form-control form-control-sm input-calc" required value="0"></td>
                                <td><input type="number" name="items[0][pendidik]" class="form-control form-control-sm input-calc" required value="0"></td>
                                <td><input type="number" name="items[0][non_pendidik]" class="form-control form-control-sm input-calc" required value="0"></td>
                                <td>
                                    <input type="text" class="form-control form-control-sm bg-light fw-bold total-display" value="0" readonly>
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-link text-danger p-0 remove-school"><i class="bi bi-trash3"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" name="action" value="draft" class="btn btn-light border px-4 h6 mb-0 py-2">
                        <i class="bi bi-save me-2"></i>Simpan Draft
                    </button>
                    <button type="submit" name="action" value="submit" class="btn btn-primary px-4 h6 mb-0 py-2">
                        <i class="bi bi-send-fill me-2"></i>Submit ke Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let schoolIndex = 1;

    function calculateRow(row) {
        const pKecil = parseInt(row.querySelector('input[name*="[porsi_kecil]"]').value) || 0;
        const pBesar = parseInt(row.querySelector('input[name*="[porsi_besar]"]').value) || 0;
        const guru = parseInt(row.querySelector('input[name*="[pendidik]"]').value) || 0;
        const staf = parseInt(row.querySelector('input[name*="[non_pendidik]"]').value) || 0;
        
        // Logic: Total Porsi = pKecil + (pBesar + guru + staf)
        const total = pKecil + pBesar + guru + staf;
        row.querySelector('.total-display').value = total;
    }

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('input-calc')) {
            calculateRow(e.target.closest('tr'));
        }
    });

    document.getElementById('addSchool').addEventListener('click', function() {
        const tbody = document.querySelector('#schoolTable tbody');
        const newRow = `
            <tr class="school-row">
                <td class="row-num text-center"></td>
                <td><input type="text" name="items[${schoolIndex}][nama_sekolah]" class="form-control form-control-sm" required placeholder="Nama Sekolah"></td>
                <td><input type="number" name="items[${schoolIndex}][jumlah_siswa]" class="form-control form-control-sm input-calc" required value="0"></td>
                <td><input type="number" name="items[${schoolIndex}][porsi_kecil]" class="form-control form-control-sm input-calc" required value="0"></td>
                <td><input type="number" name="items[${schoolIndex}][porsi_besar]" class="form-control form-control-sm input-calc" required value="0"></td>
                <td><input type="number" name="items[${schoolIndex}][pendidik]" class="form-control form-control-sm input-calc" required value="0"></td>
                <td><input type="number" name="items[${schoolIndex}][non_pendidik]" class="form-control form-control-sm input-calc" required value="0"></td>
                <td>
                    <input type="text" class="form-control form-control-sm bg-light fw-bold total-display" value="0" readonly>
                </td>
                <td class="text-end">
                    <button type="button" class="btn btn-link text-danger p-0 remove-school"><i class="bi bi-trash3"></i></button>
                </td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', newRow);
        schoolIndex++;
        updateRowNums();
    });

    function updateRowNums() {
        document.querySelectorAll('.row-num').forEach((td, i) => { td.innerText = i + 1; });
    }

    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-school')) {
            const rows = document.querySelectorAll('.school-row');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                updateRowNums();
            }
        }
    });
</script>

<style>
    .ls-1 { letter-spacing: 0.05em; }
    .opacity-10 { opacity: 0.1; }
</style>
<?= $this->endSection() ?>
