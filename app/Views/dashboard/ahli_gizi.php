<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <!-- Upload Form -->
    <div class="col-lg-5 animate-in">
        <div class="data-card">
            <div class="card-header">
                <h6><i class="bi bi-egg-fried me-2"></i>Upload Menu Makanan</h6>
            </div>
            <div class="card-body p-4">
                <form action="<?= site_url('ahli-gizi/upload') ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Judul Menu</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Menu Harian 8 Maret 2026">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File Dokumen <span class="text-danger">*</span></label>
                        <div class="upload-zone" id="uploadZone" onclick="document.getElementById('fileInput').click()">
                            <i class="bi bi-cloud-arrow-up d-block"></i>
                            <p class="mb-1 fw-semibold" style="font-size:0.9rem;">Klik atau drag file ke sini</p>
                            <small class="text-muted">PDF, Word, Excel (Maks. 10MB)</small>
                            <input type="file" name="file" id="fileInput" class="d-none"
                                   accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                        </div>
                        <div id="fileName" class="mt-2 small text-muted"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan tambahan (opsional)"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-send-fill me-1"></i> Kirim ke Admin
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- History -->
    <div class="col-lg-7 animate-in">
        <div class="data-card">
            <div class="card-header">
                <h6><i class="bi bi-clock-history me-2"></i>Riwayat Upload</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-premium">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>File</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($reports)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Belum ada menu dikirim
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($reports as $r): ?>
                        <tr>
                            <td><?= esc($r['judul']) ?></td>
                            <td><span class="badge bg-light text-dark"><i class="bi bi-file-earmark me-1"></i><?= esc($r['file_name']) ?></span></td>
                            <td><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                            <td><span class="badge-status badge-<?= $r['status'] ?>"><?= ucfirst($r['status']) ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('fileInput').addEventListener('change', function() {
        const zone = document.getElementById('uploadZone');
        const nameEl = document.getElementById('fileName');
        if (this.files.length) {
            nameEl.innerHTML = '<i class="bi bi-file-earmark-check text-success me-1"></i><strong>' + this.files[0].name + '</strong>';
            zone.style.borderColor = '#6366f1';
        }
    });
</script>

<?= $this->endSection() ?>
