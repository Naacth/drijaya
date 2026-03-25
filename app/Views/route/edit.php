<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid animate-in">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Edit Rute Pengiriman</h4>
            <p class="text-muted small">Perbarui rincian mobil, driver, dan jadwal pengantaran.</p>
        </div>
        <a href="<?= base_url('routes') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="data-card">
        <div class="card-body p-4">
            <form action="<?= base_url('routes/update/' . $header['id']) ?>" method="POST" id="routeForm">
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Tanggal Pengiriman</label>
                            <input type="date" name="tanggal" class="form-control" required value="<?= $header['tanggal'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Mobil Operasional</label>
                            <select name="mobil" class="form-select" required>
                                <option value="">Pilih Mobil...</option>
                                <option value="Mobil 1" <?= $header['mobil'] == 'Mobil 1' ? 'selected' : '' ?>>Mobil 1</option>
                                <option value="Mobil 2" <?= $header['mobil'] == 'Mobil 2' ? 'selected' : '' ?>>Mobil 2</option>
                                <option value="Mobil 3" <?= $header['mobil'] == 'Mobil 3' ? 'selected' : '' ?>>Mobil 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Nama Driver</label>
                            <input type="text" name="driver" class="form-control" required placeholder="Contoh: Pak Bustomi" value="<?= $header['driver'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Nama SPPG</label>
                            <input type="text" name="sppg" class="form-control" required value="<?= $header['sppg'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control" required placeholder="Contoh: Balaraja" value="<?= $header['kecamatan'] ?>">
                        </div>
                    </div>
                </div>

                <hr class="my-4 opacity-10">

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0">Sekolah & Jadwal Antar</h6>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="addItem">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Sekolah
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-premium align-middle" id="itemTable">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th width="200">Nama Sekolah</th>
                                <th width="100">P. Besar</th>
                                <th width="100">P. Kecil</th>
                                <th width="100">Jumlah</th>
                                <th width="120">Jam Antar</th>
                                <th width="120">Sesi</th>
                                <th width="50"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $index => $item): ?>
                            <tr class="item-row">
                                <td class="row-num text-center"><?= $index + 1 ?></td>
                                <td><input type="text" name="items[<?= $index ?>][nama_sekolah]" class="form-control form-control-sm" required placeholder="Nama Sekolah" value="<?= $item['nama_sekolah'] ?>"></td>
                                <td><input type="number" name="items[<?= $index ?>][porsi_besar]" class="form-control form-control-sm input-calc" required value="<?= $item['porsi_besar'] ?>"></td>
                                <td><input type="number" name="items[<?= $index ?>][porsi_kecil]" class="form-control form-control-sm input-calc" required value="<?= $item['porsi_kecil'] ?>"></td>
                                <td><input type="text" class="form-control form-control-sm bg-light fw-bold total-display" value="<?= $item['jumlah'] ?>" readonly></td>
                                <td><input type="time" name="items[<?= $index ?>][jam_antar]" class="form-control form-control-sm" required value="<?= $item['jam_antar'] ?>"></td>
                                <td>
                                    <select name="items[<?= $index ?>][sesi]" class="form-select form-select-sm" required>
                                        <option value="Pagi" <?= $item['sesi'] == 'Pagi' ? 'selected' : '' ?>>Pagi</option>
                                        <option value="Siang" <?= $item['sesi'] == 'Siang' ? 'selected' : '' ?>>Siang</option>
                                    </select>
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-link text-danger p-0 remove-item"><i class="bi bi-trash3"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="data-card bg-light border-0">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Total Porsi Mobil:</span>
                                    <span class="fw-bold h5 mb-0 text-primary" id="grandTotalPorsi"><?= number_format($header['total_porsi']) ?></span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-primary" id="porsiProgress" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-end align-self-center">
                        <button type="submit" name="action" value="draft" class="btn btn-light border px-4 h6 mb-0 py-2">
                            <i class="bi bi-save me-2"></i>Simpan Perubahan
                        </button>
                        <button type="submit" name="action" value="submit" class="btn btn-primary px-4 h6 mb-0 py-2">
                            <i class="bi bi-send-fill me-2"></i>Update & Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let itemIndex = <?= count($items) ?>;

    function calculateSums() {
        let grandTotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const besar = parseInt(row.querySelector('input[name*="[porsi_besar]"]').value) || 0;
            const kecil = parseInt(row.querySelector('input[name*="[porsi_kecil]"]').value) || 0;
            const total = besar + kecil;
            row.querySelector('.total-display').value = total;
            grandTotal += total;
        });
        document.getElementById('grandTotalPorsi').innerText = grandTotal.toLocaleString();
    }

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('input-calc')) {
            calculateSums();
        }
    });

    document.getElementById('addItem').addEventListener('click', function() {
        const tbody = document.querySelector('#itemTable tbody');
        const newRow = `
            <tr class="item-row">
                <td class="row-num text-center"></td>
                <td><input type="text" name="items[${itemIndex}][nama_sekolah]" class="form-control form-control-sm" required placeholder="Nama Sekolah"></td>
                <td><input type="number" name="items[${itemIndex}][porsi_besar]" class="form-control form-control-sm input-calc" required value="0"></td>
                <td><input type="number" name="items[${itemIndex}][porsi_kecil]" class="form-control form-control-sm input-calc" required value="0"></td>
                <td><input type="text" class="form-control form-control-sm bg-light fw-bold total-display" value="0" readonly></td>
                <td><input type="time" name="items[${itemIndex}][jam_antar]" class="form-control form-control-sm" required></td>
                <td>
                    <select name="items[${itemIndex}][sesi]" class="form-select form-select-sm" required>
                        <option value="Pagi">Pagi</option>
                        <option value="Siang">Siang</option>
                    </select>
                </td>
                <td class="text-end">
                    <button type="button" class="btn btn-link text-danger p-0 remove-item"><i class="bi bi-trash3"></i></button>
                </td>
            </tr>
        `;
        tbody.insertAdjacentHTML('beforeend', newRow);
        itemIndex++;
        updateRowNums();
    });

    function updateRowNums() {
        document.querySelectorAll('.row-num').forEach((td, i) => { td.innerText = i + 1; });
    }

    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item')) {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                updateRowNums();
                calculateSums();
            }
        }
    });

    // Initial calculation
    calculateSums();
</script>

<style>
    .ls-1 { letter-spacing: 0.05em; }
    .opacity-10 { opacity: 0.1; }
</style>
<?= $this->endSection() ?>
