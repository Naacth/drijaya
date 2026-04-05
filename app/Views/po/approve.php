<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid animate-in">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Persetujuan Final Purchase Order</h4>
            <p class="text-muted small">Berikan persetujuan akhir untuk pembelian bahan makanan.</p>
        </div>
        <a href="<?= base_url('po') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="data-card mb-4 border-top border-4 border-success">
        <div class="card-header py-3 bg-light border-bottom">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0 fw-bold text-success">Permohonan Approval PO</h6>
                    <small class="text-muted">No: <?= $po['nomor_po'] ?> | Supplier: <?= $po['vendor'] ?></small>
                </div>
                <div class="col-auto text-end">
                    <small class="text-muted d-block text-uppercase ls-1">Total Pengajuan</small>
                    <h4 class="fw-bold text-success mb-0">Rp <?= number_format($po['total'], 0, ',', '.') ?></h4>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive mb-4">
                <table class="table table-premium align-middle">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th width="150" class="text-center">Banyaknya</th>
                            <th width="180" class="text-end">Harga Satuan</th>
                            <th width="200" class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td>
                                    <span class="fw-medium d-block"><?= $item['nama_barang'] ?></span>
                                    <small class="text-muted"><?= $item['catatan'] ?></small>
                                </td>
                                <td class="text-center"><?= ($item['jumlah_faktual'] ?? 0) + 0 ?> <?= $item['satuan'] ?></td>
                                <td class="text-end">Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                                <td class="text-end fw-bold">Rp <?= number_format($item['total'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <th colspan="3" class="text-end py-3">TOTAL PURCHASE ORDER</th>
                            <th class="text-end py-3 h5 fw-bold mb-0 text-success">Rp <?= number_format($po['total'], 0, ',', '.') ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <hr class="my-4 opacity-10">

            <form action="<?= base_url('po/do-approve/' . $po['id']) ?>" method="POST">
                <div class="mb-4">
                    <label class="form-label text-uppercase small ls-1 fw-bold">Catatan Approval / Evaluasi</label>
                    <textarea name="catatan" class="form-control" rows="3" placeholder="Tambahkan instruksi atau alasan..."></textarea>
                </div>
                <div class="row g-2">
                    <div class="col-md-4">
                        <button type="submit" name="status" value="rejected" class="btn btn-outline-danger w-100 py-2">
                            <i class="bi bi-x-circle me-2"></i>Tolak (Reject)
                        </button>
                    </div>
                    <div class="col-md-8">
                        <button type="submit" name="status" value="approved" class="btn btn-success w-100 py-2 shadow-sm">
                            <i class="bi bi-check2-all me-2"></i>Setujui Pembelian (Approve PO)
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
