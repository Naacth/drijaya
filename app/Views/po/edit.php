<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid animate-in">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Edit Purchase Order</h4>
            <p class="text-muted small">Ubah detail dan item Purchase Order.</p>
        </div>
        <a href="<?= base_url('po') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="data-card">
        <div class="card-body p-4">
            <form action="<?= base_url('po/update/' . $po['id']) ?>" method="POST" id="poForm">
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Dari (Unit SPPG)</label>
                            <input type="text" name="dari" class="form-control bg-light" value="<?= esc(session()->get('sppg_nama') ?? '') ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Nama Supplier</label>
                            <input type="text" name="vendor" class="form-control" required placeholder="Pilih atau ketik nama supplier" value="<?= $po['vendor'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" required value="<?= $po['tanggal'] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Referensi AKG (Analisis Gizi)</label>
                            <select name="analisis_gizi_id" id="akgSelect" class="form-select">
                                <option value="">-- Tanpa Referensi --</option>
                                <?php foreach ($akgList as $akg): ?>
                                    <option value="<?= $akg['id'] ?>" <?= ($po['analisis_gizi_id'] == $akg['id']) ? 'selected' : '' ?>><?= $akg['nama_paket'] ?> (<?= date('d/m/Y', strtotime($akg['tanggal_sajian'])) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                            <div id="akgLoading" class="spinner-border spinner-border-sm text-primary mt-2 d-none" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-uppercase small ls-1">Menu Makanan / Kebutuhan (Opsional)</label>
                            <input type="text" name="menu" id="menuInput" class="form-control" placeholder="Contoh: Nugget Ayam, atau Operasional (Gas, dll)" value="<?= $po['menu'] ?>">
                        </div>
                    </div>
                </div>

                <div id="akgReferenceBox" class="d-none mb-4">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Referensi dari AKG</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless mb-0">
                                    <thead>
                                        <tr class="text-muted small text-uppercase">
                                            <th>Item Makanan</th>
                                            <th class="text-center">Gramasi</th>
                                            <th class="text-center">Protein</th>
                                            <th class="text-center">Kalori</th>
                                            <th class="text-center">Lemak</th>
                                        </tr>
                                    </thead>
                                    <tbody id="akgItemsBody">
                                        <!-- Loaded via JS -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2 small text-muted">
                                * Gunakan data di atas sebagai acuan untuk menentukan bahan baku yang perlu dibeli.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-uppercase small ls-1">Catatan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Keterangan tambahan jika ada..."><?= $po['keterangan'] ?></textarea>
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
                                <th width="40" class="text-center">No</th>
                                <th width="100">Banyaknya</th>
                                <th width="100">Satuan</th>
                                <th width="200">Nama Barang</th>
                                <th width="120">Harga Satuan</th>
                                <th width="100">Tambahan</th>
                                <th width="120">Jml Faktual</th>
                                <th width="150" class="text-end">Total</th>
                                <th>Catatan</th>
                                <th width="40"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $index => $item): ?>
                            <tr class="item-row">
                                <td class="row-number text-center"><?= $index + 1 ?></td>
                                <td><input type="number" step="0.01" name="items[<?= $index ?>][qty]" class="form-control form-control-sm qty-input" required value="<?= $item['qty'] + 0 ?>"></td>
                                <td><input type="text" name="items[<?= $index ?>][satuan]" class="form-control form-control-sm" required placeholder="Kg/Pcs" value="<?= $item['satuan'] ?>"></td>
                                <td><input type="text" name="items[<?= $index ?>][nama_barang]" class="form-control form-control-sm" required value="<?= $item['nama_barang'] ?>"></td>
                                <td><input type="number" step="0.01" name="items[<?= $index ?>][harga_satuan]" class="form-control form-control-sm harga-input" value="<?= $item['harga_satuan'] + 0 ?>"></td>
                                <td><input type="number" step="0.01" name="items[<?= $index ?>][tambahan]" class="form-control form-control-sm tambahan-input" value="<?= $item['tambahan'] + 0 ?>"></td>
                                <td><input type="number" step="0.01" name="items[<?= $index ?>][jumlah_faktual]" class="form-control form-control-sm faktual-input" value="<?= $item['jumlah_faktual'] + 0 ?>"></td>
                                <td><input type="text" class="form-control form-control-sm text-end row-total bg-light" value="Rp <?= number_format($item['total'], 0, ',', '.') ?>" readonly></td>
                                <td><input type="text" name="items[<?= $index ?>][catatan]" class="form-control form-control-sm" value="<?= $item['catatan'] ?>"></td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-link text-danger p-0 remove-item"><i class="bi bi-trash3"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-light fw-bold">
                                <td colspan="7" class="text-end">Grand Total</td>
                                <td class="text-end text-primary" id="grandTotal">Rp 0</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" name="action" value="draft" class="btn btn-light border px-4 h6 mb-0 py-2">
                        <i class="bi bi-save me-2"></i>Simpan Draft
                    </button>
                    <button type="submit" name="action" value="submit" class="btn btn-primary px-4 h6 mb-0 py-2">
                        <i class="bi bi-send-fill me-2"></i>Submit ke <?= (session()->get('role') == 'akuntan') ? 'PIC' : 'Akuntan' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let itemIndex = <?= count($items) ?>;
    
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
                <td><input type="number" step="0.01" name="items[${itemIndex}][qty]" class="form-control form-control-sm qty-input" required></td>
                <td><input type="text" name="items[${itemIndex}][satuan]" class="form-control form-control-sm" required placeholder="Kg/Pcs"></td>
                <td><input type="text" name="items[${itemIndex}][nama_barang]" class="form-control form-control-sm" required></td>
                <td><input type="number" step="0.01" name="items[${itemIndex}][harga_satuan]" class="form-control form-control-sm harga-input" value="0"></td>
                <td><input type="number" step="0.01" name="items[${itemIndex}][tambahan]" class="form-control form-control-sm tambahan-input" value="0"></td>
                <td><input type="number" step="0.01" name="items[${itemIndex}][jumlah_faktual]" class="form-control form-control-sm faktual-input" value="0"></td>
                <td><input type="text" class="form-control form-control-sm text-end row-total bg-light" value="Rp 0" readonly></td>
                <td><input type="text" name="items[${itemIndex}][catatan]" class="form-control form-control-sm"></td>
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
                calculateGrandTotal();
            } else {
                alert('Minimal harus ada satu barang.');
            }
        }
    });

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    }

    function calculateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const harga = parseFloat(row.querySelector('.harga-input').value) || 0;
            const faktual = parseFloat(row.querySelector('.faktual-input').value) || 0;
            const tambahan = parseFloat(row.querySelector('.tambahan-input').value) || 0;
            const total = (harga * faktual) + tambahan;
            
            row.querySelector('.row-total').value = formatRupiah(total);
            grandTotal += total;
        });
        document.getElementById('grandTotal').innerText = formatRupiah(grandTotal);
    }

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('qty-input')) {
            const row = e.target.closest('tr');
            const faktualInput = row.querySelector('.faktual-input');
            if (faktualInput.value == 0 || faktualInput.value == "") {
                faktualInput.value = e.target.value;
            }
        }
        
        if (e.target.classList.contains('harga-input') || 
            e.target.classList.contains('faktual-input') || 
            e.target.classList.contains('tambahan-input')) {
            calculateGrandTotal();
        }
    });

    // Initialize first row number
    updateRowNumbers();

    // AKG Selection AJAX
    const akgSelect = document.getElementById('akgSelect');
    const menuInput = document.getElementById('menuInput');
    const akgReferenceBox = document.getElementById('akgReferenceBox');
    const akgItemsBody = document.getElementById('akgItemsBody');
    const akgLoading = document.getElementById('akgLoading');

    akgSelect.addEventListener('change', function() {
        const akgId = this.value;
        if (!akgId) {
            akgReferenceBox.classList.add('d-none');
            return;
        }

        akgLoading.classList.remove('d-none');
        
        fetch(`<?= base_url('po/get-akg-details') ?>/${akgId}`)
            .then(response => response.json())
            .then(data => {
                akgLoading.classList.add('d-none');
                if (data.error) {
                    alert(data.error);
                    return;
                }

                // Fill menu input if empty
                if (!menuInput.value) {
                    menuInput.value = data.header.nama_paket;
                }

                // Fill reference box
                akgItemsBody.innerHTML = '';
                data.items.forEach(item => {
                    const row = `
                        <tr>
                            <td><span class="badge bg-white text-dark border fw-normal">${item.nama_item}</span></td>
                            <td class="text-center">${item.gramasi}g</td>
                            <td class="text-center">${item.protein}</td>
                            <td class="text-center">${item.kalori}</td>
                            <td class="text-center">${item.lemak}</td>
                        </tr>
                    `;
                    akgItemsBody.insertAdjacentHTML('beforeend', row);
                });

                akgReferenceBox.classList.remove('d-none');
            })
            .catch(error => {
                akgLoading.classList.add('d-none');
                console.error('Error:', error);
            });
    });
</script>

<style>
    .ls-1 { letter-spacing: 0.05em; }
    .opacity-10 { opacity: 0.1; }
</style>
<?= $this->endSection() ?>
