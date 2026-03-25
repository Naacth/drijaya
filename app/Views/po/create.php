<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid animate-in">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Buat Purchase Order Baru</h4>
            <p class="text-muted small">Tentukan menu, bahan, dan jumlah kebutuhan bahan.</p>
        </div>
        <a href="<?= base_url('po') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="data-card">
        <div class="card-body p-4">
            <form action="<?= base_url('po/store') ?>" method="POST" id="poForm">
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Dari (Unit SPPG)</label>
                            <input type="text" name="dari" class="form-control bg-light" value="Dapur SPPG Bunar, Kec. Balaraja" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Nama Supplier</label>
                            <input type="text" name="vendor" class="form-control" required placeholder="Pilih atau ketik nama supplier">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Menu Makanan</label>
                            <input type="text" name="menu" class="form-control" required placeholder="Contoh: Nugget Ayam, Burger, Buah Pisang">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-uppercase small ls-1">Catatan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Keterangan tambahan jika ada..."></textarea>
                </div>

                <hr class="my-4 opacity-10">

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0">Tabel Item (Detail Barang)</h6>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="addItem">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Barang
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-premium align-middle" id="itemTable">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th width="200">Nama Barang</th>
                                <th width="120">Banyaknya</th>
                                <th width="120">Satuan</th>
                                <th>Catatan</th>
                                <th width="60"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="item-row">
                                <td class="row-number text-center">1</td>
                                <td><input type="text" name="items[0][nama_barang]" class="form-control form-control-sm" required placeholder="Nama bahan"></td>
                                <td><input type="number" step="0.01" name="items[0][qty]" class="form-control form-control-sm" required placeholder="Jumlah"></td>
                                <td><input type="text" name="items[0][satuan]" class="form-control form-control-sm" required placeholder="Kg / Pcs"></td>
                                <td><input type="text" name="items[0][catatan]" class="form-control form-control-sm" placeholder="Keterangan"></td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-link text-danger p-0 remove-item"><i class="bi bi-trash3"></i></button>
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
                        <i class="bi bi-send-fill me-2"></i>Submit ke Akuntan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let itemIndex = 1;
    
    function updateRowNumbers() {
        document.querySelectorAll('.row-number').forEach((td, index) => {
            td.innerText = index + 1;
        });
    }

    document.getElementById('addItem').addEventListener('click', function() {
        const tableBody = document.querySelector('#itemTable tbody');
        const newRow = `
            <tr class="item-row">
                <td class="row-number text-center"></td>
                <td><input type="text" name="items[${itemIndex}][nama_barang]" class="form-control form-control-sm" required placeholder="Nama bahan"></td>
                <td><input type="number" step="0.01" name="items[${itemIndex}][qty]" class="form-control form-control-sm" required placeholder="Jumlah"></td>
                <td><input type="text" name="items[${itemIndex}][satuan]" class="form-control form-control-sm" required placeholder="Kg / Pcs"></td>
                <td><input type="text" name="items[${itemIndex}][catatan]" class="form-control form-control-sm" placeholder="Keterangan"></td>
                <td class="text-end">
                    <button type="button" class="btn btn-link text-danger p-0 remove-item"><i class="bi bi-trash3"></i></button>
                </td>
            </tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', newRow);
        itemIndex++;
        updateRowNumbers();
    });

    document.addEventListener('click', function(e) {
        if (e.target && e.target.closest('.remove-item')) {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                updateRowNumbers();
            } else {
                alert('Minimal harus ada satu barang.');
            }
        }
    });

    // Initialize first row number
    updateRowNumbers();
</script>

<style>
    .ls-1 { letter-spacing: 0.05em; }
    .opacity-10 { opacity: 0.1; }
</style>
<?= $this->endSection() ?>
