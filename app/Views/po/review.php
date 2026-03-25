<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid animate-in">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Review Purchase Order</h4>
            <p class="text-muted small">Pastikan barang, jumlah, dan harga sudah sesuai kebutuhan operasional.</p>
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
                <div class="col-auto text-end">
                    <small class="text-muted d-block">Grand Total</small>
                    <h5 class="fw-bold text-dark mb-0">Rp <?= number_format($po['total'], 0, ',', '.') ?></h5>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <h6 class="fw-bold mb-3 border-start border-primary border-4 ps-2">Rincian Barang & Harga</h6>
            <div class="table-responsive mb-4">
                <table class="table table-premium align-middle">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th width="150" class="text-center">Banyaknya</th>
                            <th width="180" class="text-end">Harga Satuan</th>
                            <th width="120" class="text-center">Faktual</th>
                            <th width="180" class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= $item['nama_barang'] ?> <br> <small class="text-muted"><?= $item['catatan'] ?></small></td>
                                <td class="text-center"><?= $item['qty'] ?> <?= $item['satuan'] ?></td>
                                <td class="text-end">Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                                <td class="text-center"><?= $item['jumlah_faktual'] ?> <?= $item['satuan'] ?></td>
                                <td class="text-end fw-bold">Rp <?= number_format($item['total'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <hr class="my-4 opacity-10">

            <form action="<?= base_url('po/do-review/' . $po['id']) ?>" method="POST">
                <div class="mb-4">
                    <label class="form-label text-uppercase small ls-1 fw-bold">Review Catatan</label>
                    <textarea name="catatan" class="form-control" rows="3" placeholder="Masukkan catatan review atau alasan revisi/penolakan..."></textarea>
                </div>
                
                <div class="row g-2">
                    <div class="col-md-3">
                        <button type="submit" name="status" value="revisi_ahli_gizi" class="btn btn-outline-danger w-100 py-2 btn-sm">
                            <i class="bi bi-person-exclamation me-2"></i>Ke Ahli Gizi
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" name="status" value="revisi_akuntan" class="btn btn-outline-warning w-100 py-2 btn-sm">
                            <i class="bi bi-wallet2 me-2"></i>Ke Akuntan
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" name="status" value="approve" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-check2-circle me-2"></i>Setujui & Kirim ke Kepala SPPG
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .ls-1 { letter-spacing: 0.05em; }
    .opacity-10 { opacity: 0.1; }
</style>
<?= $this->endSection() ?>
