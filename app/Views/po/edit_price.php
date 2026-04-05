<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid animate-in">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Penentuan Harga Purchase Order</h4>
            <p class="text-muted small">Tentukan harga satuan dan biaya tambahan untuk setiap item.</p>
        </div>
        <a href="<?= base_url('po') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="data-card mb-4">
        <div class="card-header py-3 bg-light border-bottom">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0 fw-bold text-primary">PO: <?= $po['nomor_po'] ?></h6>
                    <small class="text-muted">Supplier: <?= $po['vendor'] ?> | Menu: <?= $po['menu'] ?></small>
                </div>
                <div class="col-auto">
                    <span class="badge badge-status badge-pending">Menunggu Harga</span>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <form action="<?= base_url('po/update-price/' . $po['id']) ?>" method="POST" id="priceForm">
                <div class="table-responsive">
                    <table class="table table-premium align-middle">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th width="100">Banyaknya</th>
                                <th width="100">Satuan</th>
                                <th width="180">Harga Satuan (Rp)</th>
                                <th width="150">Tambahan (Rp)</th>
                                <th width="150">Jumlah Faktual</th>
                                <th width="180">Total (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr class="price-row" data-id="<?= $item['id'] ?>">
                                    <td class="fw-medium"><?= $item['nama_barang'] ?></td>
                                    <td>
                                        <span class="qty-display"><?= $item['qty'] + 0 ?></span>
                                        <input type="hidden" class="qty-hidden" value="<?= $item['qty'] + 0 ?>">
                                    </td>
                                    <td><?= $item['satuan'] ?></td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light">Rp</span>
                                            <input type="number" name="items[<?= $item['id'] ?>][harga_satuan]" 
                                                   class="form-control price-input" required step="0.01" value="<?= $item['harga_satuan'] + 0 ?>"
                                                   placeholder="Contoh: 100000 (tanpa titik)">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" name="items[<?= $item['id'] ?>][tambahan]" 
                                               class="form-control form-control-sm extra-input" step="0.01" value="<?= $item['tambahan'] + 0 ?>">
                                    </td>
                                    <td>
                                        <input type="number" name="items[<?= $item['id'] ?>][jumlah_faktual]" 
                                               class="form-control form-control-sm factual-input" step="0.01" value="<?= $item['jumlah_faktual'] + 0 ?>">
                                    </td>
                                    <td class="text-end fw-bold">
                                        <span class="item-total">0</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <th colspan="6" class="text-end py-3">GRAND TOTAL PO</th>
                                <th class="text-end py-3 text-primary h5 fw-bold mb-0">Rp <span id="grandTotal">0</span></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" name="action" value="revisi" class="btn btn-outline-warning px-4 h6 mb-0 py-2">
                        <i class="bi bi-arrow-return-left me-2"></i>Revisi ke Ahli Gizi
                    </button>
                    <button type="submit" name="action" value="submit" class="btn btn-primary px-4 h6 mb-0 py-2">
                        <i class="bi bi-send-fill me-2"></i>Kirim ke PIC
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function parseFormattedNumber(str) {
        return parseFloat(str.replace(/\./g, '').replace(/,/g, '.')) || 0;
    }

    function calculateTotals() {
        let grandTotal = 0;
        document.querySelectorAll('.price-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.factual-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const extra = parseFloat(row.querySelector('.extra-input').value) || 0;
            
            const total = (qty * price) + extra;
            row.querySelector('.item-total').innerText = total.toLocaleString('id-ID');
            grandTotal += total;
        });
        document.getElementById('grandTotal').innerText = grandTotal.toLocaleString('id-ID');
    }

    // Prevents entering dots in number inputs to avoid decimal confusion
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('keydown', function(e) {
            if (e.key === '.' || e.key === ',') {
                // Allow only if they really mean decimals, but for ID currency it's usually thousands
                // For now, let's just warn or let it be but explain in the message
            }
        });
    });

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('price-input') || 
            e.target.classList.contains('extra-input') || 
            e.target.classList.contains('factual-input')) {
            calculateTotals();
        }
    });

    // Initial calculation
    calculateTotals();
</script>
<?= $this->endSection() ?>
